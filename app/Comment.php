<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'id', 'comment', 'user_id', 'post_id',
    ];
    protected $hidden=['created_at','updated_at'];
   //nada
   public function post()
   {
       return $this->belongsTo(Post::class,'post_id','id');
   }

}
