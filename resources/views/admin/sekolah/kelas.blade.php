@extends('layouts.admin')

{{-- config 1 --}}
@section('title', 'Sekolah | Kelas')
@section('title-2', 'Kelas')
@section('title-3', 'Kelas')

@section('describ')
    Ini adalah halaman kelas untuk admin
@endsection

@section('icon-l', 'fa fa-list-alt')
@section('icon-r', 'icon-home')

@section('link')
    {{ route('admin.sekolah.kelas') }}
@endsection

{{-- main content --}}
@section('content')
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="card-block">
                        <form id="form-kelas">
                            @csrf
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="name">Nama Kelas</label>
                                        <input type="text" name="name" id="name" class="form-control form-control-sm" placeholder="Nama Kelas">
                                        <span id="form_result" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="tingkat">Tingkat</label>
                                        <select name="tingkat" id="tingkat" class="form-control form-control-sm">
                                            <option value="">-- Tingkat --</option>
                                            @foreach($tingkat as $obj)
                                            <option value="{{$obj->id}}">{{$obj->name}}</option>
                                            @endforeach
                                        </select>
                                        <span id="form_result" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label for="wali_kelas">Wali Kelas</label>
                                        <select name="wali_kelas" id="wali_kelas" class="form-control form-control-sm">
                                            <option value="">-- Wali Kelas --</option>
                                            @foreach($gurus as $guru)
                                            <option value="{{$guru->pegawai_id}}">{{$guru->pegawai->name}}</option>
                                            @endforeach
                                        </select>
                                        <span id="form_result" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="jurusan">Jurusan</label>
                                        <select name="jurusan" id="jurusan" class="form-control form-control-sm">
                                            <option value="">-- Jurusan --</option>
                                            @foreach($jurusan as $obj)
                                            <option value="{{$obj->id}}">{{$obj->name}}</option>
                                            @endforeach
                                        </select>
                                        <span id="form_result" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="kapasitas">Kapasitas</label>
                                        <input type="number" name="kapasitas" id="kapasitas" class="form-control form-control-sm" placeholder="Kapasitas">
                                        <span id="form_result" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <textarea id="keterangan" name="keterangan" class="form-control form-control-sm"></textarea>
                                        <span id="form_result" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="hidden" name="hidden_id" id="hidden_id">
                                    <input type="hidden" id="action" val="add">
                                    <input type="submit" class="btn btn-sm btn-outline-success" value="Simpan" id="btn">
                                    <button type="reset" class="btn btn-sm btn-danger">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <table id="order-table" class="table table-striped table-bordered nowrap shadow-sm">
                                <thead class="text-left">
                                    <tr>
                                        <th>ID Kelas</th>
                                        <th>Kelas</th>
                                        <th>ID Kelas</th>
                                        <th>Wali Kelas</th>
                                        <th>Kapasitas</th>
                                        <th>Jurusan</th>
                                        <th>Keterangan</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-left">
                                    {{-- @forelse($data ?? '' as $kelas)
                                        <tr>
                                            <td>{{ $kelas->name }}</td>
                                            <td>{{ $kelas->wali_kelas }}</td>
                                            <td>{{ $kelas->kapasitas }}</td>
                                            <td>{{ $kelas->jurusan }}</td>
                                            <td>{{ $kelas->keterangan }}</td>
                                            <td>
                                                <button type="button" data-id="{{$kelas->id}}" class="edit btn btn-mini btn-info shadow-sm">Edit</button>
                                                &nbsp;&nbsp;
                                                <button type="button" data-id="{{$kelas->id}}" class="delete btn btn-mini btn-danger shadow-sm">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-center">Tidak ada data</td></tr>
                                    @endforelse --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Konfirmasi</h4>
                </div>
                <div class="modal-body">
                    <h5 align="center" id="confirm">Apakah anda yakin ingin menghapus data ini?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-sm btn-outline-danger">Hapus</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- addons css --}}
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/pages/data-table/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastr.css') }}">
    <style>
        .btn i {
            margin-right: 0px;
        }
    </style>
@endpush

{{-- addons js --}}
@push('js')
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function () {

            $('#order-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.sekolah.kelas') }}",
                },
                columns: [
                    {data: 'name'},
                    {data: 'id'},
                    {data: 'wali_kelas'},
                    {data: 'kapasitas'},
                    {data: 'jurusan'},
                    {data: 'keterangan'},
                    {data: 'action'},
                ]
            });

            $('#form-kelas').on('submit', function (event) {
                event.preventDefault();
                var url = '';

                if ($('#action').val() == 'add') {
                    url = "{{ route('admin.sekolah.kelas') }}";
                    text = "Data sukses ditambahkan";
                }

                if ($('#action').val() == 'edit') {
                    url = "{{ route('admin.sekolah.kelas-update') }}";
                    text = "Data sukses diupdate";
                }

                $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'JSON',
                    data: $(this).serialize(),
                    success: function (data) {
                        var html = '';
                        if (data.errors) {
                            // for (var count = 0; count <= data.errors.length; count++) {
                            html = data.errors[0];
                            // }
                            $('#name').addClass('is-invalid');
                            $('#tingkat').addClass('is-invalid');
                            $('#jurusan').addClass('is-invalid');
                            toastr.error(html);
                        }

                        if (data.success) {
                            toastr.success('Data sukses ditambahkan');
                            $('#name').removeClass('is-invalid');
                            $('#tingkat').removeClass('is-invalid');
                            $('#jurusan').removeClass('is-invalid');
                            $('#form-kelas')[0].reset();
                            $('#action').val('add');
                            $('#btn')
                                .removeClass('btn-outline-info')
                                .addClass('btn-outline-success')
                                .val('Simpan');
                            $('#order-table').DataTable().ajax.reload();
                        }
                        $('#form_result').html(html);
                    }
                });
            });

            $(document).on('click', '.edit', function () {
                var id = $(this).attr('data-id');
                $.ajax({
                    url: '/admin/sekolah/kelas/'+id,
                    dataType: 'JSON',
                    success: function (data) {
                        console.log(data.kelas);
                        $('#name').val(data.kelas.name);
                        $('#tingkat').val(data.kelas.tingkatan_kelas_id);
                        $('#wali_kelas').val(data.kelas.pegawai_id);
                        $('#jurusan').val(data.kelas.jurusan_id);
                        $('#kapasitas').val(data.kelas.kapasitas);
                        $('#keterangan').val(data.kelas.keterangan);
                        $('#hidden_id').val(data.kelas.id);
                        $('#action').val('edit');
                        $('#btn')
                            .removeClass('btn-outline-success')
                            .addClass('btn-outline-info')
                            .val('Update');
                    }
                });
            });

            var user_id;
            $(document).on('click', '.delete', function () {
                user_id = $(this).attr('data-id');
                $('#ok_button').text('Hapus');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function () {
                $.ajax({
                    url: '/admin/sekolah/kelas/hapus/'+user_id,
                    beforeSend: function () {
                        $('#ok_button').text('Menghapus...');
                    }, success: function (data) {
                        setTimeout(function () {
                            $('#confirmModal').modal('hide');
                            $('#order-table').DataTable().ajax.reload();
                            toastr.success('Data berhasil dihapus');
                        }, 1000);
                    }
                });
            });
        });
    </script>
@endpush
