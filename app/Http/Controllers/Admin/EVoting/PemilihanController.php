<?php

namespace App\Http\Controllers\Admin\EVoting;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Admin\Pemilihan;
use App\Models\Admin\Calon;
use App\Models\Admin\Posisi;
use App\Utils\CRUDResponse;

class PemilihanController extends Controller
{
    public function index(Request $request) {
        // if ($request->ajax()) {
        //     $data = Pemilihan::latest()->get();
        //     return DataTables::of($data)
        //         ->editColumn('name', function ($data_pemilihan){
        //             foreach($dt->calons as $nk){
        //                 $nama = '<li>{{ $nk->name }}</li>';
        //             }
        //         })
        //         ->addColumn('action', function ($data) {
        //             $button = '<button type="button" id="'.$data->id.'" class="edit btn btn-mini btn-info shadow-sm">Edit</button>';
        //             $button .= '&nbsp;&nbsp;&nbsp;<button type="button" id="'.$data->id.'" class="delete btn btn-mini btn-danger shadow-sm">Delete</button>';
        //             return $button;
        //         })
        //         ->rawColumns(['action'])
        //         ->addIndexColumn()
        //         ->make(true);
        // }
        $data_pemilihan = Pemilihan::orderBy('start_date')->where('sekolah_id', auth()->user()->id_sekolah)->get();
        $ck = Calon::where('sekolah_id', auth()->user()->id_sekolah)->get();
        // dd($ck);
        // dd(auth()->user()->id_sekolah);
        $ps = Posisi::all();
        return view('admin.e-voting.pemilihan', [
            'ck' => $ck,
            'ps' => $ps,
            'data_pemilihan' => $data_pemilihan,
            'mySekolah' => User::sekolah()
        ]);
    }



    public function store(Request $request) {
        $data = $request->all();
        // validasi
        $rules = [
            'nama_calon'  => 'required|max:50',
        ];

        $message = [
            'nama_calon.required' => 'Kolom ini tidak boleh kosong',
        ];

        $validator = Validator::make($data, $rules, $message);

        if ($validator->fails()) {
            return response()
                ->json([
                    'errors' => $validator->errors()->all()
                ]);
        }
        
        $sekolah_id = auth()->user()->id_sekolah;

        // dd(auth()->user()->id_sekolah);
        // exit;

        $tglMulai = explode("-", $data['tanggal_mulai']);
        $tglSelesai = explode("-", $data['tanggal_selesai']);
        $newTglMulai = $tglMulai[2] . "-" . $tglMulai[1] . "-" . $tglMulai[0];
        $newTglSelesai = $tglSelesai[2] . "-" . $tglSelesai[1] . "-" . $tglSelesai[0];
        $pemilihan= Pemilihan::create([
            'posisi'        => $data['posisi'],
            'sekolah_id'    => $sekolah_id,
            'start_date'    => $newTglMulai,
            'end_date'      => $newTglSelesai
        ]);

        foreach ($request->input('nama_calon') as $nama_calon) {
            $pemilihan->calons()->attach($nama_calon);
        }

        return response()
            ->json([
                'success' => 'Data Added.',
            ]);

    }

    public function edit($id) {
        $data = Pemilihan::find($id);
        $nama_calon = [];
        $nama_calon = Pemilihan::find($id)->calons;
        return response()
            ->json([
                'name'          => $nama_calon,
                'pemilihan_id'  => $data->id,
                'posisi'        => $data->posisi,
                'sekolah_id'    => $data->sekolah_id,
                'start_date'    => $data->start_date,
                'end_date'      => $data->end_date
            ]);
    }

    public function update(Request $request) {
        $data = $request->all();
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

        $sekolah_id = auth()->user()->id_sekolah;

        $tglMulai = explode("-", $data['tanggal_mulai']);
        $tglSelesai = explode("-", $data['tanggal_selesai']);
        $newTglMulai = $tglMulai[2] . "-" . $tglMulai[1] . "-" . $tglMulai[0];
        $newTglSelesai = $tglSelesai[2] . "-" . $tglSelesai[1] . "-" . $tglSelesai[0];

        $status = Pemilihan::whereId($request->input('hidden_id'))->update([
            'posisi'        => $data['posisi'],
            'sekolah_id'    => $sekolah_id,
            'start_date'    => $newTglMulai,
            'end_date'      => $newTglSelesai
        ]);

        $pemilihan = Pemilihan::whereId($request->input('hidden_id'))->first();
        // dd($pemilihan);

        $pemilihan->calons()->detach();

        foreach ($request->input('nama_calon') as $nama_calon) {
            $pemilihan->calons()->attach($nama_calon);
        }

        return response()
            ->json([
                'success' => 'Data Updated.',
            ]);
    }

    public function destroy($id) {
        $pemilihan = Pemilihan::find($id);
        // dd($pemilihan);
        $pemilihan->calons()->detach();
        $pemilihan->delete();
        return response()
            ->json([
                'danger' => 'Data Deleted.',
            ]);
    }

}