@extends('layouts.app')
<?php
    use Carbon\Carbon;
    $fin = Carbon::now('America/Bogota');
    $duracion = Carbon::parse((string)$inicio)->diffForHumans($fin)
?>
@section('content')
<!--Se incluye el componente modal para indicar un login exitoso-->
    <launch-modal
        type="success"
        external_route="{{route('login')}}"
        title="Gracias,"
        content="Su sesión con una duración de {{$duracion}} ha terminado, Hora de inicio: {{$inicio}} - Hora Finalización: {{$fin}}"
    >
    </launch-modal>
@endsection
