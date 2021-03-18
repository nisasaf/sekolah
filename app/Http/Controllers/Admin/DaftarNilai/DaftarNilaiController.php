<?php

namespace App\Http\Controllers\Admin\DaftarNilai;

use App\User;
use App\Models\Siswa;
use App\Models\Semester;
use App\Models\Admin\Kelas;
use App\Models\Admin\DaftarNilai;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use App\Models\TingkatanKelas;
use App\Http\Controllers\Controller;
use App\Utils\CRUDResponse;
use Illuminate\Support\Facades\Auth;

class DaftarNilaiController extends Controller
{
    public function index(Request $request) {
        $a=0;
    	$nilai = [];
    	$data = [];
        $def_uni =1;
        $jumlah_data = 1;
        $kelas = Kelas::where('user_id', auth()->id())->get();
        $semester = Semester::where('user_id', auth()->user()->id)->get();

        $pelajaran = MataPelajaran::join('gurus', 'gurus.id', 'guru_id')
                                    ->join('pegawais', 'pegawais.id', 'gurus.pegawai_id')
                                    ->where('sekolah_id', auth()->user()->id_sekolah)
                                    ->selectRaw('mata_pelajarans.id, concat(nama_pelajaran, " | ", name) as name')->get();

        if($request->req == 'table') {
        $jumlah_data = DaftarNilai::selectRaw('urutan_nilai')->count();
            if ($jumlah_data < 1) {
                $jumlah_data = 1;
            }
        $def_uni = 1;
        // dd($jumlah_data);

        $data = Siswa::with(['kelas'])
                         ->where('kelas_id', $request->kelas_id)
                         ->orderBy('nama_lengkap')
                         ->get();
            // return response()->json($data);
        foreach ($data as $dt) {
            $nilai[] = DaftarNilai::where('siswa_id', $dt->id)->get();
        }
        // dd($nilai[0][0]);

        $semester = Semester::whereId('user_id', auth()->user()->id)->orderBy('name')->get();


        $pelajaran = MataPelajaran::join('gurus', 'gurus.id', 'guru_id')
                                    ->join('pegawais', 'pegawais.id', 'gurus.pegawai_id')
                                    ->where('sekolah_id', auth()->user()->id_sekolah)
                                    ->selectRaw('mata_pelajarans.guru_id, concat(name) as nama_guru')
                                    ->selectRaw('mata_pelajarans.id, concat(nama_pelajaran) as name')->get();
        }

        return view('admin.daftar-nilai',
        	compact('a',
                    'nilai',
                    'def_uni',
                    'jumlah_data',
        			'pelajaran',
        			'kelas',
        			'data',
        			'semester',
        		),[
        		'mySekolah' => User::sekolah()
        	]);
    }

    public function store(Request $request) {
        $data = $request->all();

        $no_urut = 1;

        foreach ($request->input('nilai') as $nilai) {
            $status = DaftarNilai::create([
                'kelas_id'  => $request->input('kelas_id'),
                'siswa_id'  => $request->input('siswa_id'),
                'mata_pelajaran_id'  => $request->input('mata_pelajaran_id'),
                'semester_id'  => $request->input('semester_id'),
                'tahun_ajaran'  => $request->input('tahun_ajaran'),
                'kategori_nilai'  => $request->input('kategori_nilai'),
                'nilai'  => $nilai,
                'urutan_nilai'  => $no_urut,
            ]);
        }


        return redirect()->route('admin.daftar-nilai')->with(CRUDResponse::successUpdate("Nilai"));
    }
}
