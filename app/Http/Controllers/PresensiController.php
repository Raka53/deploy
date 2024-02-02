<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    public function create()
    {
        $hariini = date("Y-m-d");
        $nik = Auth::user()->hrd_id;
        $cek = DB::table('absens')->where('tgl_presensi', $hariini)->where('hrd_id', $nik)->count();
        return view('absengps.create', compact('cek'));
    }

    public function store(Request $request)
    {
        $nik = Auth::user()->hrd_id;
        $nama = Auth::user()->hrd->name;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        $lokasi = $request->lokasi;
        $image = $request->image;
        $folderPath = "/absensi/";
        $formatName = $nama . "-" .uniqid()."-". $tgl_presensi;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $folderPath.$formatName . ".png";


        // Simpan file ke Google Cloud Storage
        Storage::disk('google')->put($fileName, $image_base64);

        $cek = DB::table('absens')->where('tgl_presensi', $tgl_presensi)->where('hrd_id', $nik)->count();

        if ($cek) {
            $data_pulang = [
                'jam_out' => $jam,
                'foto_out' => $fileName,
                'lokasi_out' => $lokasi
            ];

            $update = DB::table('absens')->where('tgl_presensi', $tgl_presensi)->where('hrd_id', $nik)->update($data_pulang);

            if ($update) {
                echo "success|Terimakasih|Ok";
            } else {
                echo "error|maaf absensi gagal|out";
            }
        } else {
            $data = [
                'hrd_id' => $nik,
                'tgl_presensi' => $tgl_presensi,
                'jam_in' => $jam,
                'foto_in' => $fileName,
                'lokasi_in' => $lokasi
            ];

            $simpan = DB::table('absens')->insert($data);

            if ($simpan) {
                echo "success|Terimakasih sip";
            } else {
              echo "error|maaf absensi gagal|out";
            }
        }
    }
}
