<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Models\Admin\Kalender;
use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use App\Utils\ApiResponse;
use DateTime;
use Illuminate\Http\Request;

class KalenderController extends Controller
{
    public function index($id, Request $request)
    {
        $d    = new DateTime($request->tanggal);
        $day = $d->format('l');
        if ($day == "Sunday") {
            $day = "Minggu";
        } else if ($day == "Monday") {
            $day = "senin";
        } else if ($day == "Tuesday") {
            $day = "selasa";
        } else if ($day == "Wednesday") {
            $day = "rabu";
        } else if ($day == "Thursday") {
            $day = "kamis";
        } else if ($day == "Friday") {
            $day = "jumat";
        } else if ($day == "Saturday") {
            $day = "sabtu";
        }

        $data = JadwalPelajaran::join('mata_pelajarans', 'jadwal_pelajarans.mata_pelajaran_id', 'mata_pelajarans.id')->where('tahun_ajaran', $request->tahun_ajaran)
            ->where('kelas_id', $request->kelas_id)
            ->where('semester', $request->semester)
            ->where('mata_pelajarans.sekolah_id', $id)
            ->orderBy('jam_pelajaran')
            ->get();

        $data = $data->groupBy('hari');

        $kalender = Kalender::where('sekolah_id', "=", $id)->where('start_date', '=', $request->tanggal)->get();
        if ($data->count() <= 0) {
            $message = 'Data not found !';
        } else {
            $message = 'Success get Data';
        }

        return response()->json(ApiResponse::success([
            'Kalender' => $kalender ?? [],
            'Pelajaran' => $data[$day] ?? [],
        ], $message));
    }
}
