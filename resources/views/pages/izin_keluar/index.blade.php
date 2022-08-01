@extends('adminlte::page')

@section('title', 'Izin Keluar')
@section('plugins.Datatables', true)

@section('content_header')
    <h1>Izin Keluar</h1>
@stop

@php
    $heads = [
        'NIP',
        'Nama Pegawai',
        'Keterangan',
        'Jam Izin',
        ['label' => 'Actions', 'no-export' => true, 'width' => 15],
    ];

    $btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                    <i class="fa fa-lg fa-fw fa-pen"></i>
                </button>';
    $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                      <i class="fa fa-lg fa-fw fa-trash"></i>
                  </button>';
    $btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                       <i class="fa fa-lg fa-fw fa-eye"></i>
                   </button>';

    $config = [
        'order' => [[1, 'asc']],
        'columns' => [null, null, null, null, ['orderable' => false]],
        'format' => 'YYYY-MM-DD'
    ];


@endphp

@section('content')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <x-adminlte-alert theme="danger" title="Error">
                <p>{{ $error }}</p>
            </x-adminlte-alert>
        @endforeach
    @endif
    @if (session('status'))
        <x-adminlte-alert theme="success" title="Success">
            {{session('status')}}
        </x-adminlte-alert>
    @endif
    <x-adminlte-datatable id="table1" :heads="$heads" head-theme="dark" :config="$config" striped hoverable bordered compressed>
        @foreach($data_izin as $row)
            <tr>
                <td>{{$row->nip}}</td>
                <td>{{$row->nama_pegawai}}</td>
                <td>{{$row->keterangan}}</td>
                <td>{{$row->jam_izin}}</td>
                <td>
                    @if($row->status_izin == 0)
                    <button class="btn btn-xs btn-default text-primary mx-1 shadow updateStatus" data-id="{{$row->id_izin_keluar}}" data-status="1" title="Setujui">
                        <i class="fa fa-lg fa-fw fa-check"></i>
                    </button>
                        <button class="btn btn-xs btn-default text-danger mx-1 shadow updateStatus" data-id="{{$row->id_izin_keluar}}" data-status="2" title="Batalkan">
                            <i class="fa fa-lg fa-fw fa-ban"></i>
                        </button>
                    @elseif($row->status_izin == 2)
                        <span class="badge badge-danger">Dibatalkan</span>
                    @else
                        <span class="badge badge-success">Disetujui</span>
                    @endif
                </td>
            </tr>

        @endforeach
    </x-adminlte-datatable>
@stop

@section('css')
    {{--    <link rel="stylesheet" href="{{asset('vendor/css/admin_custom.css')}}">--}}
@stop

@section('js')
    <script>
        $('.updateStatus').click(function () {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "post",
                url: "{{route('izinkeluar.update')}}",
                data:{
                    id: $(this).data('id'),
                    status: $(this).data('status')
                },
                success: function (response) {
                    location.reload();
                }
            })
        })
    </script>
@stop
@section('js')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        Echo.channel('izin')
            .listen('NotificationIzin', (e) => {
                console.log(e.izin);
            })
    </script>
@stop
