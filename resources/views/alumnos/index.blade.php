@extends('plantillas.plantilla1')
@section('titulo')
Alumnos
@endsection
@section('cabecera')
Alumnos de la Academia
@endsection
@section('contenido')
{{-- Mensaje --}}
@if($text=Session::get("mensaje"))
   <p class="bg-secondary text-white p-2 my-3">{{$text}}</p>
@endif
<a href="{{route("alumnos.create")}}" class="btn btn-success mb-3"><i class="fa fa-plus"> Crear Alumno</i> </a>
{{-- tablas --}}
<table class="table table-striped table-primary">
    <thead>
      <tr>
        <th scope="col">Detalle</th>
        <th scope="col">Nombre</th>
        <th scope="col">Apellidos</th>
        <th scope="col">Email</th>
        <th scope="col">Telefono</th>
        <th scope="col">Foto</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($alumnos as $item)
      <tr style="vertical-align: middle">
        <th scope="row">
            <a href="{{route('alumnos.show', $item)}}" class="btn btn-info btn-lg">
                <i class="fa fa-info"></i> Detalles</a>
        </th>
        <td>{{$item->nombre}}</td>
        <td>{{$item->apellidos}}</td>
        <td>{{$item->mail}}</td>
        <td>{{$item->telefono}}</td>
        <td><img src="{{asset($item->foto)}}" width="95rem" height="90rem" class="figure-img img-fluid rounded"></td>
        <td>
            <form name="a" action="{{route('alumnos.destroy', $item)}}" method="POST" class="form-inline">
                @csrf
                @method("DELETE")
                <a href="{{route('alumnos.edit', $item)}}" class="btn btn-primary btn-lg"><i class="fa fa-edit"> Editar</i></a>
                <button type="submit" class="btn btn-danger btn-lg" onclick="return confirm('¿Borrar Alumno?')">
                    <i class="fa fa-trash-alt"></i> Borrar</button>
            </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  {{$alumnos->links()}}
@endsection
