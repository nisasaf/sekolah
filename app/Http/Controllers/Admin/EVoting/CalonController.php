<?php

namespace App\Http\Controllers\Admin\EVoting;

use App\User;
use Validator;
use App\Models\Siswa;
use App\Models\Admin\Calon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class CalonController extends Controller
{
    public function index(Request $request) {
<<<<<<< HEAD
        $namaSiswa = Siswa::join('kelas', 'siswas.kelas_id', 'kelas.id')
            ->where('kelas.user_id', Auth::id())
            ->get('siswas.*');
=======
        $namaSiswa = Siswa::join('users', 'users.name', 'siswas.nama_lengkap')->where('id_sekolah', auth()->user()->id_sekolah)->get();
        // dd($namaSiswa);
>>>>>>> 2a5400e2499f2e564fd2785a5f444803f054d9d0
        if ($request->ajax()) {
            $data = Calon::where('sekolah_id', auth()->user()->id_sekolah)->get();
            // dd($data);
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    // $button = '<button type="button" id="'.$data->id.'" class="edit btn btn-mini btn-info shadow-sm">Edit</button>';
                    $button = '&nbsp;&nbsp;&nbsp;<button type="button" id="'.$data->id.'" class="delete btn btn-mini btn-danger shadow-sm">Delete</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
<<<<<<< HEAD
        // return($namaSiswa);
=======

        
>>>>>>> 2a5400e2499f2e564fd2785a5f444803f054d9d0
        return view('admin.e-voting.calon', ['namaSiswa' => $namaSiswa, 'mySekolah' => User::sekolah()]);
    }

    public function store(Request $request) {
        $data = $request->all();

        $idSekolah = auth()->user()->id_sekolah;
        // dd($idSekolah);exit();

        // validasi
        $rules = [
            'nama_calon'  => 'required|max:50',
        ];

        $message = [
            'nama_calon.required' => 'Kolom ini tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()
                ->json([
                    'errors' => $validator->errors()->all()
                ]);
        }

        $status = Calon::create([
            'name'  => $request->input('nama_calon'),
            'sekolah_id' => $idSekolah,
        ]);

        return response()
            ->json([
                'success' => 'Data Added.',
            ]);
    }

    public function edit($id) {
        $calon_id = Calon::find($id);

        return response()
            ->json([
                'calon_id'  => $calon_id
            ]);
    }

    public function update(Request $request) {
        $idSekolah = auth()->user()->id_sekolah;
        // validasi
        $rules = [
            'calon_id'  => 'required|max:50',
        ];

        $message = [
            'calon_id.required' => 'Kolom ini tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()
                ->json([
                    'errors' => $validator->errors()->all()
                ]);
        }

        $status = Calon::whereId($request->input('hidden_id'))->update([
            'name'  => $request->input('nama_calon'),
            'sekolah_id' => $idSekolah,
        ]);

        return response()
            ->json([
                'success' => 'Data Updated.',
            ]);
    }

    public function destroy($id) {
        $tingkat = Calon::find($id);
        $tingkat->delete();
    }

}
