<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\PostView;

class PostController extends Controller
{

    protected $types = [1 => 'Scholarships', 2 => 'Grants / Fellowships', 3 => 'Guides', 4 => 'Work'];
    protected $levels = [1 => 'Degree', 2 => 'Masters', 3 => 'Doctorate', 4 => 'Diploma', 5 => 'General'];
    protected $funding = [1 => 'Fully Funded', 2 => 'Partially Funded'];

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get a validator for posts.
     *
     * @param  array  $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $request)
    {
        return Validator::make($request, [
            'title' => ['required', 'string', 'max:500'],
            'details' => ['required', 'string'],
            'type' => ['required', 'numeric'],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->user()->authorizeRoles(['superadmin', 'admin'])){
            return redirect()->route('home')->with('error', 'Sorry You\'re Unauthorized to Access the Page!');
        }
        if($request['q']){
            $keyword = $request['q'];
            $posts = Post::where('title','LIKE','%'.$keyword.'%')->paginate(50);
        }
        else{
            $posts = Post::orderBy('created_at', 'desc')->paginate(50);
        }
        return view('post.index', ["posts" => $posts]);
    }

    public function posts(Request $request)
    {
        if(!$request->user()->authorizeRoles(['superadmin', 'admin','subscriber'])){
            return redirect()->route('home')->with('error', 'Sorry You\'re Unauthorized to Access the Page!');
        }
        if($request['q']){
            $redirectUrl = '/search/?q='.$request['q'];
            
            return \Redirect($redirectUrl);
        }

        $posts = Post::where('status', 1)->orderBy('created_at', 'desc')->paginate(15);

        return view('post.list', ["posts" => $posts, "types" => $this->types, "levels" => $this->levels]);
    }



    public function list(Request $request, $type)
    {
        if(!$request->user()->authorizeRoles(['superadmin', 'admin','subscriber'])){
            return redirect()->route('home')->with('error', 'Sorry You\'re Unauthorized to Access the Page!');
        }
        
        if($request['q']){
            $redirectUrl = '/search/?q='.$request['q'];
            return \Redirect($redirectUrl);
        }

        $type = $this->getType($type);

        $posts = Post::where('status', 1)->where('type', $type)->orderBy('created_at', 'desc')->paginate(15);

        return view('post.types', ["posts" => $posts, "types" => $this->types, "levels" => $this->levels, "type" => $type]);
    }


    /**
     * Search Post.
     *
     * @param  string $title
     * @return string
     */
    public function search(Request $request)
    {
        if(!$request->user()->authorizeRoles(['superadmin', 'admin','subscriber'])){
            return redirect()->route('home')->with('error', 'Sorry You\'re Unauthorized to Access the Page!');
        }
        if($request['q']){

            $keyword = $request['q'];

        $posts = Post::where('title','LIKE','%'.$keyword.'%')->paginate(15);


        return view('post.search', ["posts" => $posts, "types" => $this->types, "levels" => $this->levels]);
        }
        \Redirect::back();
    }




    public function getType($no){

        switch($no){
        case "scholarships":
            return 1;
            break;
        case "grants":
            return 2;
            break;
        case "guides":
            return 3;
            break;
        case "jobs":
            return 4;
            break;

        default:
            return 1;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(!$request->user()->authorizeRoles(['superadmin', 'admin'])){
            return redirect()->route('home')->with('error', 'Sorry You\'re Unauthorized to Access the Page!');
        }

        $countries = \DB::table('countries')->get();

        return view('post.create', compact('countries', $countries));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->user()->authorizeRoles(['superadmin', 'admin'])){
            return redirect()->route('home')->with('error', 'Sorry You\'re Unauthorized to Access the Page!');
        }

        $validator = $this->validator($request->all());
        if($validator->fails()) {
            return \Redirect::back()->withErrors($validator)->withInput($request->all());
        }
        


        $slug = $this->generatePostSlug($request['title']);
        //dd($slug);exit();
        $userid = $request->user()->id;
        //$deadline = \DateTime::createFromFormat('Y-m-d H:i:s', $request['deadline'])->format('Y-m-d H:i:s');

        if($request['deadline'] == ''){
             $deadline = Carbon::now()->addYears(3)->format('Y-m-d H:i:s');
        }else{
        $deadline = Carbon::parse($request['deadline'])->format('Y-m-d H:i:s');
    }
        try{
        $post = Post::create([
            'title' => $request['title'],
            'slug' => $slug,
            'details' => $request['details'],
            'deadline' => $deadline,
            'url' => $request['url'],
            'type' => $request['type'],
            'level' => $request['level'],
            'status' => $request['status'],
            'user_id' => $userid,
            'funding' => $request['funding'],
            'country_id' => $request['country_id'],

        ]);
        $redirectUrl = '/post/'.$post->id.'/edit';
        return \Redirect($redirectUrl)->with('message', 'Post Successful!');
        }

        catch(\Exception $e){
            return \Redirect::back()->withInput()->with('error',$e->getMessage());
        }
    }


        /**
     * Create a conversation slug.
     *
     * @param  string $title
     * @return string
     */
    public function generatePostSlug($title)
    {
        $slug = \Str::slug($title);

        $count = Post::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();


        return $count ? "{$slug}-{$count}" : $slug;
    }

     
    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Post $post)
    {
        if(!$request->user()->authorizeRoles(['superadmin', 'admin'])){
            return redirect()->route('home')->with('error', 'Sorry You\'re Unauthorized to Access the Page!');
        }

        $post = Post::where('id', $post->id)->first();

        return view('post.show', ["post" => $post, "types" => $this->types, "levels" => $this->levels]);
    }


     /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request,$slug)
    {
        if(!$request->user()->authorizeRoles(['superadmin', 'admin','subscriber'])){
            return redirect()->route('home')->with('error', 'Sorry You\'re Unauthorized to Access the Page!');
        }

        $post = Post::where('slug', $slug)->first();

        PostView::createViewLog($post);

        $country = \DB::table('countries')->where('id', $post->country_id)->first();

        return view('post.view', ["post" => $post, "types" => $this->types, "levels" => $this->levels, "funding" => $this->funding, "country" => $country]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Post $post)
    {
        if(!$request->user()->authorizeRoles(['superadmin', 'admin'])){
            return redirect()->route('home')->with('error', 'Sorry You\'re Unauthorized to Access the Page!');
        }
        $countries = \DB::table('countries')->get();

        return view("post.edit", compact("post", "countries"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        if(!$request->user()->authorizeRoles(['superadmin', 'admin'])){
            return redirect()->route('home')->with('error', 'Sorry You\'re Unauthorized to Access the Page!');
        }

        $validator = $this->validator($request->all());
        if($validator->fails()) {
            return \Redirect::back()->withErrors($validator)->withInput($request->all());
        }

        $deadline = Carbon::parse($request['deadline'])->format('Y-m-d H:i:s');

        $data = [
            'title' => $request['title'],
            'details' => $request['details'],
            'deadline' => $deadline,
            'url' => $request['url'],
            'type' => $request['type'],
            'level' => $request['level'],
            'status' => $request['status'],
            'funding' => $request['funding'],
            'country_id' => $request['country_id'],
            ];
            //dd($data);

        Post::where('id', $post->id)->update($data);

        \Session::flash('message', 'Successfully updated post!');
        $redirectUrl = '/post/'.$post->id.'/edit';

        return \Redirect::to($redirectUrl);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
