<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
   /* public function index()
    {
        #obtener los articulos publicos
            $articles = Article::where('status','1')
                         ->orderBy('id','desc')
                         ->simplePaginate(10);//este es para que si son muchos se cree otra pagina que diga next


        #obtener las categorias con estado publico(1)y destacadas(1)
        $navbar = Category::where([
            ['status','1'],
            ['is_featured','1'],

        ])->paginate(3);//esto es para que si son 3 despues diga next y pase a otra pagina  de 3 y asi sucesivamente


        return view('home.index',compact ('articles','navbar'));
    }*/
    public function index()
    {
        #Obtener los artículos públicos (1)
        $articles = Article::where('status', '1')
                    ->orderBy('id', 'desc')
                    ->simplePaginate(10);
        
        #Obtener las categorías con estado público (1) y destacadas (1)
        $navbar = Category::where([
            ['status', '1'],
            ['is_featured', '1'],
        ])->paginate(3);            

        return view('home.index', compact('articles', 'navbar'));
    }

            //Todas lacategorias 
            public function all(){

             $categories= Category::where('status','1')
                              ->simplePaginate(20);



        #obtener las categorias con estado publico(1)y destacadas(1)

            $navbar = Category::where([
                        ['status','1'],
                        ['is_featured','1'],

            ])->paginate(3);//esto es para que si son 3 despues diga next y pase a otra pagina  de 3 y asi sucesivamente


            return view('home.all-categories',compact('categories','navbar'));

}

}
