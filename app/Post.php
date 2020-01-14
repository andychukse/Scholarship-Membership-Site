<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'details', 'level', 'status', 'url', 'type', 'deadline', 'user_id', 'funding', 'country_id'
    ];

    public function users()
	{
  		return $this->belongsTo(User::class);
	}
}
