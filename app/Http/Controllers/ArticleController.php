<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ArticleRequest;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;


class ArticleController extends Controller
{
    //proteger las rutas
    public function __construct()
    {
            $this ->middleware('can:articles.index')->only('index');
            $this->middleware('can:articles.create')->only('create','store');
            $this->middleware('can:articles.edit')->only('edit','update');
            $this->middleware('can:articles.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       //Mostrar los artículos en el admin
       $user = Auth::user();
       $articles = Article::where('user_id', $user->id)
                   ->orderBy('id', 'desc')
                   ->simplePaginate(10);

       return view('admin.articles.index', compact('articles'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //obtener categorias publicas
        $categories =Category::select(['id','name'])
                    ->where('status','1')
                        ->get();

        return view('admin.articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        /*
        Formulario
        1. titulo ="articulo 1 "
        2. slug ="articulo-1"
        3. introduction="este es el primer articulo"
        4. image="foto.png"
        5. body ="primer articulo del curso"
        6. status= 3
        8. category_id =3        
        */

        $request->merge([
             'user_id'=> Auth::user()->id,                       
        ]);

        //guardo la solicitud en una variable
        $article = $request->all();

        //validar si hay un archivo en el request
        if($request->hasFile('image')){
            $article['image']=$request->file('image')->store('articles');
        }

           Article::create($article);

        return redirect()->action([ArticleController::class,'index'])
                            ->with('succes-create','Articulo creado con exito ');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $this->authorize('published', $article);

        $comments = $article->comments()->simplePaginate(5);

        return view('subscriber.articles.show',compact('article','comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {

        $this->authorize('view', $article );


        //obtener categorias publicas
        $categories =Category::select(['id','name'])
                    ->where('status','1')
                        ->get();

        return view('admin.articles.edit', compact('categories','article'));
    

        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        //si el usuario sube una nueva imagen
        if($request->hasFile('image')){
            //eliminar la imagen anterior
            File::delete(public_path('storage/'.$article->image));
            //asigna la nueva imagen
            $article['image']=$request->file('image')->store('articles');

        }


        //actualizar datos
        $article->update([
                'title'=> $request->title,
                'slug'=> $request->slug,
                'introduction' => $request->introduction,
                'body' =>$request->body,
                'user_id'=>Auth::user()->id,
                'category_id'=>$request->category_id,
                'status' => $request->status,

        ]);


        return redirect()->action([ArticleController::class,'index'])
                            ->with('succes-update','Articulo modificado con exito ');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {

        $this->authorize('delete', $article );


        //eliminar imagen del articulo
        if($article->image){
            File::delete(public_path('storage/' . $article->image));
        }

        //eliminar articulo
        $article->delete();
        
        

        return redirect()->action([ArticleController::class,'index'])
                            ->with('succes-delete','Articulo eliminado con exito ');

    }
}
