<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $guarded =['id','created_at','updated_at'];

    //relacion uno a muchos inversa(article-user)
    public function user(){
        return$this->belongsTo(User::class);
    }

    //relacion de uno a muchos (article-comments)
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    //relacion de uno a muchos inversa(category - articles)
    public function category(){
        return $this->belongsTo(Category::Class);
    }


    #utilizar slug en lugar de id

    public function getRouteKeyName(){


        return 'slug';
    }

}
