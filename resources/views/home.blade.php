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

            <x-adminlte-info-box text="{{$total_izin}}" id="izin-keluar" title="Permintaan Izin" icon="fas fa-user-plus text-teal"
                                  theme="primary"  class="col-sm-3" url="{{route('izinkeluar.index')}}"/>
        </div>
    </div>
    {{-- Custom --}}
    <x-adminlte-modal id="UpdateStatus" title="Izin">
        <form id="edit_pegawai" action="{{route('izinkeluar.update')}}" method="post">
            <input type="hidden" name="id" id="id_izin">
            {{ csrf_field() }}
            <x-adminlte-input id="nama_pegawai" label="Nama Pegawai" name="nama" disabled="" label-class="text-lightblue">
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-user-circle text-lightblue"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
            <x-adminlte-textarea label="Keterangan" id="keterangan_izin" name="keterangan" rows=5 label-class="text-lightblue"
                                 igroup-size="sm" disabled="">
            </x-adminlte-textarea>
            <x-adminlte-select name="status" label="Status" required label-class="text-lightblue">
                <option value="">Status</option>
                <option value="1">Setujui</option>
                <option value="2">Tolak</option>
            </x-adminlte-select>
            <x-adminlte-button label="Submit" type="submit" theme="primary" icon="fa fa-fw fa-paper-plane"/>
        </form>
    </x-adminlte-modal>
@stop

@section('css')
{{--    <link rel="stylesheet" href="/css/admin_custom.css">--}}
@stop

@section('js')
    <script>
        $('#izin-keluar').click(function () {
            location.replace($(this).attr('url'))
        })
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        Echo.channel('izin')
            .listen('NotificationIzin', (e) => {
                console.log(e);
                $('#id_izin').val(e.result.id_izin_keluar);
                $('#keterangan_izin').text(e.result.keterangan)
                $('#nama_pegawai').val(e.result.nama_pegawai);
                $('#UpdateStatus').modal('toggle');
            })
    </script>
@stop
