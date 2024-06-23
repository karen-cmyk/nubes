<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Models\Article;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{


        //proteger las rutas
        public function __construct()
        {
            $this->middleware('can:categories.create')->only('create','store');
            $this->middleware('can:categories.edit')->only('edit','update');
            $this->middleware('can:categories.destroy')->only('destroy');
            $this ->middleware('can:categories.index')->only('index');
        }
    


        
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         //mostrar los categorias en  el admin
         $categories =Category::orderBy('id','desc')
                     ->simplePaginate(8);
 
         return view('admin.categories.index', compact('categories'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {

    
        //
        $category = $request->all();

        //Validar si hay un archivo
        if($request->hasFile('image')){

            $category['image'] = Cloudinary::upload($request->file('image')
            ->getRealPath(),[
                'folder' => 'Categories',
            ])->getSecurePath();
        }
/*
echo '<pre>';
var_dump($category);
echo '</pre>';
exit;*/

        //Guardar información
        Category::create($category);

        return redirect()->action([CategoryController::class, 'index'])
            ->with('success-create', 'Categoría creada con éxito');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
        $current_image = $category->image;
        $split_url = explode('/', $current_image);
        $public_id = explode('.', $split_url[sizeof($split_url)-1]);

        if($request->hasFile('image')){
            //Eliminar imagen anterior
            Cloudinary::destroy('Categories/'.$public_id[0]);

            //Asignar nueva imagen
            $category['image'] = Cloudinary::upload($request->file('image')
            ->getRealPath(),[
                'folder' => 'Categories',
            ])->getSecurePath();
        }

        //Actualizar datos
        $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
            'is_featured' => $request->is_featured,
        ]);

        return redirect()->action([CategoryController::class, 'index'], compact('category'))
            ->with('success-update', 'Categoría modificada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        $current_image = $category->image;
        $split_url = explode('/', $current_image);
        $public_id = explode('.', $split_url[sizeof($split_url)-1]);

        //Eliminar imagen de la categoría
        if($category->image){
            Cloudinary::destroy('Categories/'.$public_id[0]);
        }

        $category->delete();

        return redirect()->action([CategoryController::class, 'index'], compact('category'))
            ->with('success-delete', 'Categoría eliminada con éxito');
    }


//filtrar articulos por categorias
public function detail(Category $category){

$this->authorize('published',$category);

    $articles = Article::where([
            ['category_id', $category->id],
            ['status','1']

    ])

    ->orderBy('id','desc')
    ->simplePaginate(5);

    $navbar = Category::where([

        ['status','1'],
        ['is_featured','1'],
    ])->paginate(3);

    return view('subscriber.categories.detail',compact('articles','category','navbar'));

}

}
