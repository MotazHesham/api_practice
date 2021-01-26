<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'description', 'image', 'author_id'
    ];

    protected $hidden=['created_at','updated_at'];

    //each post has many comments belongs to many users
    public function users()
    {
        return $this->belongsToMany(User::class,'comments')->withpivot('comment');
    }
    ///////ندا 
    public function comment()
    {
        return $this->hasMany(Comment::class,'post_id','id');
    }

    //each post belongs to one author
    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }
}
