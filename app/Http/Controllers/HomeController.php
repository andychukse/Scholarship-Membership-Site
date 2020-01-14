<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Role;
use App\Subscription;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{

    protected $types = [1 => 'Scholarship', 2 => 'Grant / Fellowship', 3 => 'Guide', 4 => 'Work'];
    protected $levels = [1 => 'Degree', 2 => 'Masters', 3 => 'Doctorate', 4 => 'Diploma', 5 => 'General'];
    protected $funding = [1 => 'Fully Funded', 2 => 'Partially Funded'];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.\Auth::user()->id],
            'phone' => ['required', 'regex:/^\+?\(?\d{2,4}\)?[\d\s-]{3,}$/', 'min:8'],
        ]);
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        //$posts = Post::where('status', 1)->orderBy('created_at', 'desc')->paginate(10);

        $posts = \DB::table('posts')
        ->select('posts.id', 'posts.title', 'posts.deadline', 'posts.type', 'posts.level', 'posts.created_at', 'posts.funding', 'posts.slug', 'countries.name')
        ->join('countries', 'countries.id', '=', 'posts.country_id')
        ->where('posts.type', '!=', 3)->orderBy('created_at', 'desc')->paginate(10);

    
        if($request->user()->authorizeRoles(['superadmin', 'admin'])){

             $total['scholarships'] = Post::where(['type' => 1])->count();
             $total['grants'] = Post::where(['type' => 2])->count();
             $total['guides'] = Post::where(['type' => 3])->count();
             $total['subscriptions'] = Subscription::where(['status' => 1])->count();
             $total['users'] = User::count();
            return view('admin', ["posts" => $posts, "types" => $this->types, "levels" => $this->levels, "funding" => $this->funding, "total" => $total]);
        }
        
            return view('home', ["posts" => $posts, "types" => $this->types, "levels" => $this->levels, "funding" => $this->funding]);

    }


    /**
     * Display a listing of users.
     *
     * @return \Illuminate\Http\Response
     */
    public function users(Request $request)
    {
        if(!$request->user()->authorizeRoles(['superadmin', 'admin'])){
            return redirect()->route('home')->with('error', 'Sorry You\'re Unauthorized to Access the Page!');
        }
        
        if($request['q']){

            $keyword = $request['q'];

                $users = User::where(function($query) use($keyword) {
                    $query->where('users.firstname', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('users.lastname', 'LIKE', '%'.$keyword.'%');})
                ->orderBy('created_at', 'desc')
                ->paginate(50);
            }
            else{
                $users = User::orderBy('created_at')->paginate(50);
            }
        return view('user.index', ["users" => $users]);
    }

    public function profile()
    {
        $user = User::where('id', \Auth::user()->id)->first();
        return view('user.profile', compact('user', $user));
    }


    public function edit(Request $request, $id)
    {
        if(!$request->user()->authorizeRoles(['superadmin'])){
            return redirect()->route('home')->with('error', 'Sorry You\'re Unauthorized to Access the Page!');
        }

        $user = User::where('id', $id)->first();
        /*$role = DB::table('roles')->select('roles.id','roles.name')
                ->join('plans', 'plans.id', '=', 'subscriptions.plan_id')
                ->where(function($query) use ($id){
                $query->where('subscriptions.id', '=', $id);})
                ->first();*/
        $role = $user->roles()->first();

        return view('user.edit', compact('user', 'role'));
    }

    public function updateRole(Request $request, User $user)
    {
        if(!$request->user()->authorizeRoles(['superadmin'])){
            return redirect()->route('home')->with('error', 'Sorry You\'re Unauthorized to Access the Page!');
        }
        $role = $request['role'];
        $oldRole = $request['old_role'];

        //$user = User::where('id', $user)->first();

        if($oldRole!=''){
            $user->roles()->detach(Role::where('name', $oldRole)->first());
        }
        if($role!=''){
        $user->roles()->attach(Role::where('name', $role)->first());
        }

        \Session::flash('message', 'Successfully role!');
        $redirectUrl = '/user/'.$user->id.'/edit';

        return \Redirect::to($redirectUrl);
    }

    public function update(Request $request, User $user)
    {
        $validator = $this->validator($request->all());
        if($validator->fails()){
            dd($validator);
            return \Redirect::back()->withErrors($validator)->withInput($request->all());
        }

        $data = [
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            ];

        User::where('id', $user->id)->update($data);

        \Session::flash('message', 'Successfully updated profile!');
        return \Redirect::to('/profile');
    }
}
