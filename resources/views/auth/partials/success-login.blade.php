@extends('layouts.app')

@section('content')
<!--Se incluye el componente modal para indicar un login exitoso-->
    <launch-modal
        type="success"
        external_route="{{route('home')}}"
        title="Bienvenido,"
        content="Se ha logueado con éxito a la plataforma"
    >
    </launch-modal>
@endsection
