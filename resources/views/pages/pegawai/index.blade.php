@extends('adminlte::page')

@section('title', 'Pegawai')
@section('plugins.Datatables', true)

@section('content_header')
    <h1>Pegawai</h1>
@stop

@php
    $heads = [
        'NIP',
        'Nama Pegawai',
        'Jenis Kelamin',
        'Tempat, Tanggal lahir',
        'Alamat',
        'Username',
        ['label' => 'Actions', 'no-export' => true, 'width' => 5],
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
        'columns' => [null, null, null, null, null, null, ['orderable' => false]],
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
    <x-adminlte-button label="Primary" theme="primary" label="Tambah Pegawai" icon="fa fa-fw fa-plus-circle" data-toggle="modal" data-target="#addPegawai"/>
    <br>
    <x-adminlte-datatable id="table1" :heads="$heads" head-theme="dark" :config="$config" striped hoverable bordered compressed>
        @foreach($pegawai as $row)
            <tr>
                <td>{{$row->nip}}</td>
                <td>{{$row->nama_pegawai}}</td>
                <td>{{$row->jenis_kelamin == 1 ? 'Laki-Laki' : 'Perempuan'}}</td>
                <td>{{$row->tempat_lahir}}, {{$row->tanggal_lahir}}</td>
                <td>{{$row->alamat}}</td>
                <td>{{$row->username}}</td>
                <td><nobr>
                        <button class="btn btn-xs btn-default text-primary mx-1 shadow edit-pegawai" data-id="{{$row->id_pegawai}}" title="Edit" data-toggle="modal" data-target="#editPegawai">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </button>
                        <button class="btn btn-xs btn-default text-danger mx-1 shadow delete-pegawai" data-id="{{$row->id_pegawai}}" title="Delete" data-toggle="modal" data-target="#deletePegawai">
                            <i class="fa fa-lg fa-fw fa-trash"></i>
                        </button>
                    </nobr>
                </td>
            </tr>
        @endforeach
    </x-adminlte-datatable>

    {{-- Modal Tambah --}}
    <x-adminlte-modal id="addPegawai" title="Tambah Pegawai">
        <form id="add_pegawai" action="{{route('pegawai.store')}}" method="post">
            {{ csrf_field() }}
            <x-adminlte-input name="nip" type="number" label="NIP" required placeholder="NIP" value="{{old('nip')}}" label-class="text-lightblue">
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-id-card text-lightblue"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
            <x-adminlte-input name="nama_pegawai" label="Nama Pegawai" required value="{{old('nama_pegawai')}}" placeholder="Nama Pegawai" label-class="text-lightblue">
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-user-circle text-lightblue"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
            <x-adminlte-select name="jenis_kelamin" label="Jenis Kelamin" required label-class="text-lightblue">
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-venus-mars text-lightblue"></i>
                    </div>
                </x-slot>
                <option>-Pilih Jenis Kelamin-</option>
                <option value="1" @if(old('jenis_kelamin') == 1) selected @endif>Laki-Laki</option>
                <option value="2" @if(old('jenis_kelamin') == 2) selected @endif>Perempuan</option>
            </x-adminlte-select>
            <x-adminlte-input name="tempat_lahir" label="Tempat Lahir" value="{{old('tempat_lahir')}}" required placeholder="Tempat Lahir" label-class="text-lightblue">
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-city text-lightblue"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
            @php
                $config = ['format' => 'YYYY-MM-DD'];
            @endphp
            <x-adminlte-input-date name="tanggal_lahir" :config="$config" required placeholder="Pilih tanggal lahir"
                                   label="Tanggal Lahir" value="{{old('tanggal_lahir')}}" label-class="text-lightblue">
                <x-slot name="appendSlot">
                    <x-adminlte-button theme="outline-primary" icon="fas fa-lg fa-birthday-cake text-lightblue"
                                       title="Set to Birthday" />
                </x-slot>
            </x-adminlte-input-date>
            <x-adminlte-textarea name="alamat" label="Alamat" required rows=5 label-class="text-lightblue"
                                 igroup-size="sm" placeholder="Alamat">{{old('alamat')}}
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-lg fa-home text-lightblue"></i>
                    </div>
                </x-slot>
            </x-adminlte-textarea>
            <x-adminlte-input name="username" label="Username" value="{{old('username')}}" required placeholder="Username" label-class="text-lightblue">
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-user text-lightblue"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
            <x-adminlte-input name="password" type="password" required label="Password" value="" placeholder="Password" label-class="text-lightblue">
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-key text-lightblue"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
            <x-adminlte-button label="Submit" type="submit" theme="primary" icon="fa fa-fw fa-paper-plane"/>
        </form>
    </x-adminlte-modal>

{{--    Modal Edit--}}
    <x-adminlte-modal id="editPegawai" title="Edit Pegawai">
        <form id="edit_pegawai" action="{{route('pegawai.store')}}" method="post">
            <input type="hidden" name="id_pegawai" id="id_pegawai">
            {{ csrf_field() }}
            <x-adminlte-input name="edit_nip" type="number" label="NIP" required placeholder="NIP" value="{{old('nip')}}" label-class="text-lightblue">
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-id-card text-lightblue"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
            <x-adminlte-input name="edit_nama_pegawai" label="Nama Pegawai" required value="{{old('nama_pegawai')}}" placeholder="Nama Pegawai" label-class="text-lightblue">
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-user-circle text-lightblue"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
            <x-adminlte-select name="edit_jenis_kelamin" label="Jenis Kelamin" required label-class="text-lightblue">
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-venus-mars text-lightblue"></i>
                    </div>
                </x-slot>
                <option>-Pilih Jenis Kelamin-</option>
                <option value="1" @if(old('jenis_kelamin') == 1) selected @endif>Laki-Laki</option>
                <option value="2" @if(old('jenis_kelamin') == 2) selected @endif>Perempuan</option>
            </x-adminlte-select>
            <x-adminlte-input name="edit_tempat_lahir"  label="Tempat Lahir" value="{{old('tempat_lahir')}}" required placeholder="Tempat Lahir" label-class="text-lightblue">
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-city text-lightblue"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
            @php
                $config = ['format' => 'YYYY-MM-DD'];
            @endphp
            <x-adminlte-input-date name="edit_tanggal_lahir"  :config="$config" required placeholder="Pilih tanggal lahir"
                                   label="Tanggal Lahir" value="{{old('tanggal_lahir')}}" label-class="text-lightblue">
                <x-slot name="appendSlot">
                    <x-adminlte-button theme="outline-primary" icon="fas fa-lg fa-birthday-cake text-lightblue"
                                       title="Set to Birthday" />
                </x-slot>
            </x-adminlte-input-date>
            <x-adminlte-textarea name="edit_alamat" label="Alamat" required rows=5 label-class="text-lightblue"
                                 igroup-size="sm" placeholder="Alamat">{{old('alamat')}}
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-lg fa-home text-lightblue"></i>
                    </div>
                </x-slot>
            </x-adminlte-textarea>
            <x-adminlte-input name="edit_username" label="Username" value="{{old('username')}}" required placeholder="Username" label-class="text-lightblue">
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-user text-lightblue"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
            <x-adminlte-input name="edit_password" type="password" label="Password" value="{{old('password')}}" placeholder="Password" label-class="text-lightblue">
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-key text-lightblue"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
            <x-adminlte-button label="Submit" type="submit" theme="primary" icon="fa fa-fw fa-paper-plane"/>
        </form>
    </x-adminlte-modal>

{{--    Modal Delete--}}
    <x-adminlte-modal id="deletePegawai" title="Hapus Pegawai" >
        <div>Apakah Yakin Menghapus data pegawai?</div>

        <x-slot name="footerSlot">
            <form id="delete_pegawai" action="{{route('pegawai.store')}}" method="post">
                {{ csrf_field() }}
                <x-adminlte-button type="submit" class="mr-auto" theme="success" label="Ya"/>
                <x-adminlte-button theme="danger" label="Tidak" data-dismiss="modal"/>
            </form>
        </x-slot>
    </x-adminlte-modal>
@stop

@section('css')
{{--    <link rel="stylesheet" href="{{asset('vendor/css/admin_custom.css')}}">--}}
@stop

@section('js')
    <script>
        $('.edit-pegawai').click(function () {
            $('#edit_pegawai').attr('action', window.location+'/update/'+$(this).data('id'));
            $.ajax({
                method: 'get',
                url: window.location+'/edit/'+$(this).data('id'),
                success: function (response) {
                    var data = response.data;
                    console.log(data);
                    $("#edit_nip").val(data.nip);
                    $("#edit_nama_pegawai").val(data.nama_pegawai);
                    $("#edit_tempat_lahir").val(data.tempat_lahir);
                    $("#edit_tanggal_lahir").val(data.tanggal_lahir);
                    $("#edit_jenis_kelamin").val(data.jenis_kelamin);
                    $("#edit_alamat").text(data.alamat);
                    $("#edit_username").val(data.username);
                    $("#password").val(data.password);
                    $('#id_pegawai').val(data.id_pegawai);
                }
            })
        });

        $('.delete-pegawai').click(function (){
            $('#delete_pegawai').attr('action', window.location+'/delete/'+$(this).data('id'));
        })
       ///asas
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
