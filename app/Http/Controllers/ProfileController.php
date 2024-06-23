<?php

namespace App\Http\Controllers;

use App\Models\profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
//use Illuminate\Http\Request\ProfileRequest;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    

    
        //proteger las rutas
        public function __construct()
        {


            $this->middleware('auth');
         
        }
    

    public function index()
    {
        //
    }

 
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    
    public function show(profile $profile)
    {
        //
    }

    public function edit(profile $profile)
    
    {
        $this->authorize('view', $profile);

        return view('subscriber.profiles.edit',compact('profile'));
        //
    }

   
    public function update(ProfileRequest $request, profile $profile)
    {
            $this->authorize('update', $profile);
           

            $user = Auth::user();

            if($request->hasFile('photo')){
            //eliminar foto anterior
            File::delete(public_path('storage/' . $profile->photo));
            //asignar nueva foto
            $photo = $request['photo']->store('profiles');


            }else{
                //sino que deje la foto que se encuentra
                $photo = $user->profile->photo;

            }
            //asignar nombre y correo
            $user->full_name=$request->full_name;
            $user->email = $request->email;
            //asignar la foto
            $user->profile->photo = $photo;

            //guardar campos de usuario
            $user->save();
            //guardar campos de perfil
            $user->profile->save();

            return redirect()->route('profiles.edit',$user->profile->id);



        //
    }

/*
public function update(ProfileRequest $request, Profile $profile)
{
    $this->authorize('update', $profile);

    $user = Auth::user();
    $current_image = $user->profile->photo;
    $split_url = explode('/', $current_image);
    $public_id = explode('.', $split_url[sizeof($split_url)-1]); 

    if($request->hasFile('photo')){
        //Eliminar foto anterior
        Cloudinary::destroy('Profiles/'.$public_id[0]);
        //Asignar nueva foto
        $photo = Cloudinary::upload($request['photo']->getRealPath(),[
            'folder' => 'Profiles',
        ])->getSecurePath();

    }else{
        $photo = $user->profile->photo;
    }

    //Asignar nombre y correo
    $user->full_name = $request->full_name;
    $user->email = $request->email;
    //Asignar foto
    $user->profile->photo = $photo;

    //Guardar campos de usuario
    $user->save();
    //Guardar campos de perfil
    $user->profile->save();

    return redirect()->route('profiles.edit', $user->profile->id);
}
  */
    public function destroy(profile $profile)
    {
        //
    }
}
