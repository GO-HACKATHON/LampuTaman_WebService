<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \Exception;

class MapController extends Controller {

    /**
    * Fungsi untuk menandai daerah sebagai daerah yang berbahaya sengan menyimpan latitude, longitude, deskripsi, dan atribut penunjang lainnya
    * @param \Illuminate\Http\Request $request
    * @return code 200 jika penandaan daerah berhasil
    * @return code 500 jika penandaan daerah gagal
    */
    public function insertPin(request $request){
        $email_pengguna = $request->email_pengguna;
        $nama_daerah = $request->nama_daerah;
        $deskripsi_daerah = $request->deskripsi_daerah;
        $gambar_daerah = null;
        $lat_daerah = $request->lat_daerah;
        $lng_daerah = $request->lng_daerah;
        $waktu = null;
        $kantor_polisi = $request->kantor_polisi;

        try {
            $insertPin = DB::table('daerahrawan')->insert([
                'email_pengguna' => $nohp_pengguna,
                'nama_daerah' => $nama_daerah,
                'deskripsi_daerah' => $deskripsi_daerah,
                'gambar_daerah' => $gambar_daerah,
                'lat_daerah' => $lat_daerah,
                'lng_daerah' => $lng_daerah,
                'waktu' => $waktu,
                'kantor_polisi' => $kantor_polisi
            ]);
        } catch(Exception $e){
            echo $e;
            $pengguna = new PenggunaController;
            return $pengguna->httpResponse('500', 'Gagal menandai daerah. Coba lagi');
        }
        $pengguna = new PenggunaController;
        return $pengguna->httpResponse('200', 'Penandaan daerah berhasil.');
    }
}
