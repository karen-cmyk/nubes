<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




//principal
//Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home.index');
//Route::get('/', 'HomeController@index')->name('home.index');
//Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/all', [HomeController::class, 'all'])->name('home.all');
//Route::get('/all',[HomeController::class,'all'])->name('home.all');

//Administrador
Route::get('/admin', [AdminController::class,'index'])
                ->middleware('can:admin.index')             
                ->name('admin.index');
Route::get('/admin.all', [AdminController::class,'index'])->name('admin.all');


//Rutas del admin

Route::namespace('App\Http\Controllers')->prefix('admin')->group(function(){

    //Articulos
    Route::resource('articles','ArticleController')
                    ->except(('show'))
                    ->names('articles');
    //categorias
    Route::resource('categories', 'CategoryController')
                    ->except('show')
                    ->names('categories');


    //comentarios
    Route::resource('comments', 'CommentController')
                    ->only('index','destroy')
                    ->names('comments');

   //Usuarios
    Route::resource('users','UserController')
            ->except('create','store','show')
            ->names('users');

      //Roles
      Route::resource('roles','RoleController')
      ->except('show')
      ->names('roles');


});


//Articulos

Route::resource('articles', ArticleController::class)
            ->except('show')
            ->names('articles');

 //categorias
Route::resource('categories', CategoryController::class)
            ->except('show')
            ->names('categories');


//comentarios
Route::resource('comments', CommentController::class)
            ->only('index','destroy')
            ->names('comments');
//perfiles
Route::resource('profiles', ProfileController::class)
                ->only('edit','update')
                ->names('profiles');
 //ver articulos
Route::get('article/{article}',[ArticleController::class,'show'])->name('articles.show');

//ver articulos por categorias
Route::get('category/{category}',[CategoryController::class,'detail'])->name('categories.detail');

//guardar comentarios
Route::post('/comment',[CommentController::Class, 'store'])->name('comments.store');

//Ver artículos por categorías
//Route::get('category/{category}', [CategoryController::class, 'detail'])->name('categories.detail');

Auth::routes();

//Route::put('/articles/{article}',[ArticleController::class,'update'])->name('articles.update');

/*
Route::get('/articles', [ArticleController::class,'index'] )->name('articles.index');
Route::get('/articles/create', [ArticleController::class,'create'])->name('articles.create');
Route::post('/articles',[ArticleController::class,'store'])->name('articles.store');


Route::get('/articles/{article}/edit',[ArticleController::class,'edit'])->name('articles.edit');
Route::put('/articles/{article}',[ArticleController::class,'update'])->name('articles.update');
Route::delete('/articles/{article}',[ArticleController::class,'destroy'])->name('articles.destroy');
*/



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
