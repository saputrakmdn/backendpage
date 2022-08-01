@extends('adminlte::page')

@section('title', 'Presensi')
@section('plugins.Datatables', true)

@section('content_header')
    <h1>Presensi</h1>
@stop

@php
    $heads = [
        'NIP',
        'Nama Pegawai',
        'Tanggal',
        'Jam Masuk',
        'Jam Pulang',
        'Keterangan'
    ];


    $config = [
        'order' => [[1, 'asc']],
        'columns' => [null, null, null, null, null, null],
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
{{--    <x-adminlte-button label="Primary" theme="primary" label="Tambah Pegawai" icon="fa fa-fw fa-plus-circle" data-toggle="modal" data-target="#addPegawai"/>--}}
    {{-- Disabled with predefined config --}}
    @php
        $configDate = [
            "timePicker" => true,
            "startDate" => "js:moment().subtract(6, 'days')",
            "endDate" => "js:moment()",
            "locale" => ["format" => "YYYY-MM-DD"],
        ];
    @endphp

    <div class="row">
        <div style="width: 27%;">
            <x-adminlte-date-range name="drCustomRanges" :config="$configDate" enable-default-ranges="Today">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-info">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </x-slot>
            </x-adminlte-date-range>
        </div>
    </div>

    <br>
    <x-adminlte-datatable id="table1" :heads="$heads" head-theme="dark" :config="$config" striped hoverable bordered compressed with-buttons>

    </x-adminlte-datatable>

@stop

@section('css')
    {{--    <link rel="stylesheet" href="{{asset('vendor/css/admin_custom.css')}}">--}}
@stop

@section('js')
    <script>

        $('#drCustomRanges').change(function () {
            console.log($(this).val())
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                method: "get",
                url: location.origin+"/presensi/list",
                data:{
                    date: $(this).val()
                },
                success: function (response) {
                    console.log(response);
                    var htmlAppend = '';
                    if(response.data.length > 0){
                        $('#table1').DataTable().clear().destroy();
                        $.each(response.data, function (index, value){
                            console.log(value);
                            htmlAppend += '<tr><td>'+value.nip+'</td><td>'+value.nama_pegawai+'</td><td>'+value.tanggal+'</td><td>'+value.jam_masuk+'</td><td>'+value.jam_pulang+'</td><td>'+value.keterangan+'</td></tr>';
                        });
                        $('#table1 tbody').html(htmlAppend);
                        $('#table1').DataTable( {"order":[[1,"asc"]],"columns":[null,null,null,null,null,null],"format":"YYYY-MM-DD","dom":"\u003C\u0022row\u0022 \u003C\u0022col-md-8\u0022 B\u003E \u003C\u0022col-md-4\u0022 f\u003E \u003E\n                \u003C\u0022row\u0022 \u003C\u0022col-12\u0022 tr\u003E \u003E\n                \u003C\u0022row\u0022 \u003C\u0022col-md-5\u0022 i\u003E \u003C\u0022col-md-7\u0022 p\u003E \u003E","buttons":{"dom":{"button":{"className":"btn"}},"buttons":[{"extend":"pageLength","className":"btn-default"},{"extend":"print","className":"btn-default","text":"\u003Ci class=\u0022fas fa-fw fa-lg fa-print\u0022\u003E\u003C\/i\u003E","titleAttr":"Print","exportOptions":{"columns":":not([dt-no-export])"}},{"extend":"csv","className":"btn-default","text":"\u003Ci class=\u0022fas fa-fw fa-lg fa-file-csv text-primary\u0022\u003E\u003C\/i\u003E","titleAttr":"Export to CSV","exportOptions":{"columns":":not([dt-no-export])"}},{"extend":"excel","className":"btn-default","text":"\u003Ci class=\u0022fas fa-fw fa-lg fa-file-excel text-success\u0022\u003E\u003C\/i\u003E","titleAttr":"Export to Excel","exportOptions":{"columns":":not([dt-no-export])"}},{"extend":"pdf","className":"btn-default","text":"\u003Ci class=\u0022fas fa-fw fa-lg fa-file-pdf text-danger\u0022\u003E\u003C\/i\u003E","titleAttr":"Export to PDF","exportOptions":{"columns":":not([dt-no-export])"}}]}} );
                    }

                }
            })
        })
    </script>
@stop
