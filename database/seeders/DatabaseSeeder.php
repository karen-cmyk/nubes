<?php

namespace Database\Seeders;

 use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Category;
 use Illuminate\Database\Seeder;
 use Database\Seeders\RoleSeeder;
 use Illuminate\Support\Facades\Storage;
 use League\Flysystem\Filesystem;
 //use League\Flysystem\Adapter\Local;
 use League\Flysystem\Adapter\Local;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      
     /*   
    $adapter = new Local('public/storage/categories');
    $filesystem = new Filesystem($adapter);
    
    $filesystem->createDir('categories');*/
    //Eliminar carpeta articles
    Storage::deleteDirectory('articles');
    Storage::deleteDirectory('categories');

    //Crear carpeta donde se almacenaran las imagenes
    


    
    Storage::makeDirectory('articles');
    Storage::makeDirectory('categories');

    //llamar al seeder
    $this->call(RoleSeeder::class,PostSeeder::class,);
    $this->call(UserSeeder::class,PostSeeder::class,);


    //Factories
    Category::factory(8)->create();
    Article::factory(20)->create();
    Comment::factory(20)->create();

    }



}
