@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="col-12">
        <div class="row">
            <x-adminlte-info-box title="424" text="Views" icon="fas fa-eye text-dark"
                                  theme="teal" url="#" url-text="View details" class="col-sm-3 mr-1"/>

            <x-adminlte-info-box title="Downloads" text="1205" icon="fas fa-download text-white"
                                  theme="purple" class="col-sm-3 mr-1"/>

            <x-adminlte-info-box title="528" text="User Registrations" icon="fas fa-user-plus text-teal"
                                  theme="primary" url="#" url-text="View all users" class="col-sm-3"/>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
