<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //creo los alumnos y las guardo de 5 en 5
        $alumnos = Alumno::orderBy('nombre')->paginate(5);
         //redireccionamos a la vista
        //llamamos a la vista pasando los datos del objeto
        return view('alumnos.index', compact('alumnos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //redireccionamos a la vista
        //llamamos a la vista pasando los datos del objeto
        return view('alumnos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //action create
        $request->validate([
            'nombre'=>['required'],
            'apellidos'=>['required'],
            'mail'=>['required'],
            'telefono'=>['nullable']
        ]);
        //--------------------
        //si algo falla
        //buscar en la documentacion de laravel
        //creo el objeto para poder manipularlo
        $alumno = new Alumno();
        //poner en mayuscaula la primera letra a la vez que gusrdamos la info
        $alumno->nombre=ucwords($request->nombre);
        $alumno->apellidos=ucwords($request->apellidos);
        $alumno->mail=$request->mail;

        //le ponemos el telefono si le ha llegado
        if($request->has('telefono')) $alumno->telefono=$request->telefono;

        //vamos con la imagen, NO es un campo ubligatorio
        //1.- comprobamos si hemos subido imagen
        if($request->has('foto')){
            //si he subido imagen
            //valido que sea un fichero de imagen
            $request->validate([
                'foto'=>['image']
            ]);
            //si es un fichero de imagen
            $fileImagen=$request->file('foto');
            //le ponemos un id unico
            $nombre="img/alumno/".uniqid()."_".$fileImagen->getClientOriginalName();
            //un die tuneado, funcion de laravel
            //dd($nombre);
            //almaceno el fichero en el disco
            Storage::Disk("public")->put($nombre, File::get($fileImagen));
            $alumno->foto="storage/".$nombre;
        }
        //se guarda en la base de datos
        $alumno->save();
         //redireccionamos a la vista principal
        return redirect()->route('alumnos.index')->with('mensaje', 'Alumno guardado correctamente');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function show(Alumno $alumno)
    {
        return view('alumnos.show', compact('alumno'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function edit(Alumno $alumno)
    {
        return view('alumnos.edit', compact('alumno'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alumno $alumno)
    {
         //action del editar
         $request->validate([
            'nombre'=>['required'],
            'apellidos'=>['required'],
            'mail'=>['required'],
            'telefono'=>['nullable']
        ]);
        $alumno->update([
        'nombre'=>ucwords($request->nombre),
        'apellidos'=>ucwords($request->apellidos),
        'mail'=>$request->mail,
        'telefono'=>$request->telefono
        ]);
        if($request->has('foto')){
            $request->validate([
                'foto'=>['image']
            ]);
            $fileImagen=$request->file('foto');
            $nombre="img/alumnos/".uniqid()."_".$fileImagen->getClientOriginalName();
            if(basename($alumno->foto)!='default.png'){
                unlink($alumno->foto);
            }
            Storage::Disk("public")->put($nombre, File::get($fileImagen));
            $alumno->update(['foto'=>"storage/".$nombre]);
        }
        return redirect()->route('alumnos.index')->with('mensaje', 'Registro actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alumno $alumno)
    {
        $fotoAlumno = basename($alumno->logo);
        if($fotoAlumno!='default.png'){
            unlink($alumno->foto);
        }
        $alumno->delete();
        return redirect()->route('alumnos.index')->with("mensaje", "Alumno Borrado Correctamente");

    }
}
