@extends('layouts.admin')

{{-- config 1 --}}
@section('title', 'Daftar Nilai | Daftar Nilai')
@section('title-2', 'Daftar Nilai')
@section('title-3', 'Daftar Nilai')

@section('describ')
    Ini adalah halaman Daftar Nilai untuk admin
@endsection

@section('icon-l', 'fa fa-medal')
@section('icon-r', 'icon-home')

@section('link')
    {{ route('admin.daftar-nilai') }}
@endsection

{{-- main content --}}

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="card-block">
                        <h6>Filter</h6>
                        <form id="form-daftar-nilai" action="{{route('admin.daftar-nilai')}}" method="GET">
                            <input type="hidden" name="req" value="table">
                            <div class="row">
                                <div class="col-xl-2">
                                    <select name="kelas_id" id="pilih" class="form-control form-control-sm" required>
                                        <option value="">-- Kelas --</option>
                                        @foreach($kelas as $obj)
                                            <option value="{{$obj->id}}" {{ request()->kelas_id == $obj->id ? 'selected' : '' }}>{{$obj->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xl-2">
                                    <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="form-control form-control-sm">
                                            <option value="">-- Pelajaran --</option>
                                            @foreach($pelajaran as $obj)
                                            <option value="{{$obj->id}}">{{$obj->name}}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="col-xl-2">
                                    <select name="tahun_ajaran" id="tahun_ajaran" class="form-control form-control-sm">
                                        <option value="">-- Tahun Ajaran --</option>
                                        <option value="2019/2020">2019/2020</option>
                                        <option value="2020/2021">2020/2021</option>
                                    </select>
                                </div>
                                <div class="col-xl-2">
                                    <select name="semester_id" id="semester" class="form-control form-control-sm">
                                        <option value="">-- Semester --</option>
                                        @foreach($semester as $sms)
                                            <option value="{{$sms->id}}">{{$sms->name}}</option>
                                            @endforeach
                                    </select>
                                </div>
                                <div class="col-xl-2">
                                    <select name="kategori_nilai" id="kategori_nilai" class="form-control form-control-sm">
                                        <option value="">-- Kategori Nilai --</option>
                                        <option value="UH">UH</option>
                                        <option value="UTS">UTS</option>
                                        <option value="UAS">UAS</option>
                                        <option value="Tugas">Tugas Harian</option>
                                        <option value="Praktek">Praktek</option>
                                    </select>
                                </div>
                                <div class="col-xl-2">
                                    <input type="submit" value="Pilih" class="btn btn-block btn-sm btn-primary shadow-sm">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <table id="order-table" class="table table-striped table-bordered nowrap shadow-sm">
                                <thead class="text-left">
                                    <tr class="tr1">
                                        <th style="vertical-align: middle">Nama Siswa</th>
                                        <th style="vertical-align: middle">Pelajaran</th>
                                        <th style="vertical-align: middle">Guru</th>
                                        @for ($i = 1; $i <= $jumlah_data; $i++)
                                            @if ($i == 1)
                                            <th style="width: 15%; vertical-align: middle">{{ request()->kategori_nilai }} {{ $i }}
                                                <button id="addNilai" class="btn btn-outline-primary btn-sm shadow-sm"><i class="fa fa-plus"></i></button>
                                            </th>
                                            @else
                                            <th style="width: 15%; vertical-align: middle">{{ request()->kategori_nilai }} {{ $i }}
                                                @if ($i == $jumlah_data)
                                                <button class="btn btn-outline-danger btn-sm btn-sm shadow-sm" onclick="remove_cells('<?php echo $i; ?>');"><i class="fa fa-times"></i></button>
                                                @endif
                                            </th>
                                            @endif
                                        @endfor
                                        <th style="width: 15%; vertical-align: middle">NR</th>
                                        <th style="vertical-align: middle">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-left">
                                    @foreach($data as $obj)
                                    <form class="form-daftar-nilai" method="post" action="{{ route('admin.daftar-nilai.store') }}">
                                        @method('POST')
                                        @csrf
                                        <input type="hidden" name="siswa_id" value="{{$obj->id}}">
                                        <input type="hidden" name="kelas_id" value="{{ request()->kelas_id }}">
                                        <input type="hidden" name="tahun_ajaran" value="{{ request()->tahun_ajaran }}">
                                        <input type="hidden" name="kategori_nilai" value="{{ request()->kategori_nilai }}">
                                        <input type="hidden" name="mata_pelajaran_id" value="{{ request()->mata_pelajaran_id }}">
                                        <input type="hidden" name="semester_id" value="{{ request()->semester_id }}">
                                        <tr>
                                            {{-- {{ dd($nilai[0][0]) }} --}}
                                            <td>{{ $obj->nama_lengkap}}</td>
                                            @foreach ($pelajaran as $pl)
                                            <td class="text-center">{{ $pl->name ?? ''}}</td>
                                            <td class="text-center">{{ $pl->nama_guru ?? ''}}</td>
                                            @endforeach
                                            @for ($i = 0; $i < $jumlah_data; $i++)
                                                @for ($a = 0; $a < $jumlah_data; $a++)
                                                <td><input type="number" id="nilai{{$obj->id}}" name="nilai[]" class="form-control form-control-sm" onchange="nilai_changed('{{ $obj->id }}')" value="{{$nilai[$i][$a]->nilai}}"></td>
                                                @endfor
                                            @endfor
                                            <td><input type="text" id="nilai_rata" name="nilai_rata" class="form-control form-control-sm" disabled></td>
                                            <td id="submit_{{$obj->id}}" class="text-center">
                                                @if($obj->nilai)
                                                APPROVE
                                                @else
                                                <input type="hidden" id="action" val="add">
                                                <input type="submit" class="btn btn-success" value="approve">
                                                @endif
                                            </td>
                                        </tr>
                                    </form>
                                    @endforeach
                                </tbody>
                                <input type="hidden" id="total_form" name="total_form" value="{{ $jumlah_data }}">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
        var tr = document.querySelector('.tr1');
        var newTH = document.createElement('th');
        newTH.innerHTML = 'Tes';
        function addNilai(){
            tr.appendChild(newTH);
        }
        $(document).ready(function () {

            function nilai_changed() {
              var x = document.getElementById("nilai").value;
              document.getElementById("nilai_rata").value = x;
            }


            var number = $("#total_form").val();
            $("#btnTambahNilai").click(function(){
                if($("#total_form").val() != number){
                    number = $("#total_form").val();
                }
                number++;
                add_cells(number);
                // console.log(number);
            });

        });

    </script>
@endpush