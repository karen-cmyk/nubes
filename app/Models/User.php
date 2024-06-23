<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

//Crear un perfil cuando se crea un usuario

protected static function boot(){
parent:: boot();
//asignar perfil al registar el usuario
static::created(function($user){
    $user->profile()->create();

});


}


    //relacion de uno a uno (user-profile)

    public function profile(){
        return $this->hasOne(Profile::class);
    }

    //relacion de uno a muchos (user-article)
    public function articles(){
        return $this->hasMany(Article::class);
    }

//relacion unos a muchos (user-comment)
public function comments(){
    return $this->hasMAny(Comment::Class);
}

public function adminlte_image(){

return asset('storage/'. Auth::user()->profile->photo);

}



}
