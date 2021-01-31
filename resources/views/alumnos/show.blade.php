@extends('plantillas.plantilla1')
@section('titulo')
Detalle Alumno
@endsection
@section('cabecera')
Detalle Alumno nº{{$alumno->id}}
@endsection
@section('contenido')
<div class="card text-white bg-dark mb-3 m-auto" style="max-width: 100rem;">
    <div class="card-header text-center p-2">
        <img src="{{asset($alumno->foto)}}" class="img-thunbnail" width="190rem" height="180rem"></div>
    <div class="card-body">
      <h4 class="card-title">{{$alumno->nombre}}</h4>
      <h5 class="card-text">{{$alumno->apellidos}}</h5><br>
      <p class="card-text"><b>Mail: </b>{{$alumno->mail}}</p>
      <p class="card-text"><b>Telefono: </b>{{$alumno->telefono}}</p>
      <p class="card-text"><b>Registro creado: </b>{{$alumno->created_at}}</p>
      <p class="card-text"><b>Registro actualizado: </b>{{$alumno->updated_at}}</p>
      <a href="{{route('alumnos.index')}}" class="btn btn-primary mt-2"><i class="fa fa-house-user"></i> Inicio</a>
    </div>
  </div>
@endsection
