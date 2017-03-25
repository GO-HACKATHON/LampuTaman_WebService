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
        date_default_timezone_set('Asia/Bangkok');

        $email_pengguna = $request->email_pengguna;
        $nama_daerah = $request->nama_daerah;
        $deskripsi_daerah = $request->deskripsi_daerah;
        $gambar_daerah = null;
        $lat_daerah = $request->lat_daerah;
        $lng_daerah = $request->lng_daerah;
        $waktu = date("Y-m-d H:i:s");
        $waktu = null;
        $kantor_polisi = $this->getDistance($lat_daerah, $lng_daerah, -6.244508, 106.800628);

        try {
            $insertPin = DB::table('daerahrawan')->insert([
                'email_pengguna' => $email_pengguna,
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
    
    
    /**
    * Fungsi untuk mendapatkan status keamanan
    * @param \Illuminate\Http\Request $request
    * @return kondisi dalam bentuk string melambangkan statusnya (aman, sedang, atau rawan)
    */
    public function getPin(request $request){
        $latNow = $request->lat;
        $lngNow = $request->lng;
        $sumDistance = 0;
        //$dump = array();
        
        $allLoc = DB::table('daerahrawan')->select('lat_daerah','lng_daerah')->get();
        foreach ($allLoc as $row){
            $distance = $this->getDistance($latNow, $lngNow, $row->lat_daerah, $row->lng_daerah);
            array_push($dump, $distance);
            if($distance < 50) $sumDistance++;
            
        }
        
        //return $dump;
        if ($sumDistance <= 5) return "aman";
        else if ($sumDistance > 5 && $sumDistance <= 10) return "sedang";
        else if ($sumDistance > 10) return "rawan";
    }
    
    /**
    * Fungsi untuk mencari jarak antara dua koordinat latitude dan longitude
    * @param logitude lokasi 1
    * @param latitude lokasi 1
    * @param logitude lokasi 2
    * @param latitude lokasi 2
    * @return jarak antara kedua koordinat
    */
    public function getDistance($lat1, $lng1, $lat2, $lng2){ 
        $r= 6371000; 
        $currLat1 = deg2rad($lat1); 
        $currLat2 = deg2rad($lat2); 
        $deltaLat = deg2rad($lat2-$lat1); 
        $deltaLng = deg2rad($lng2-$lng1); 
 
        $a = (sin($deltaLat/2) * sin($deltaLat/2)) + 
                (cos($currLat1) * cos($currLat2) * sin($deltaLng) * sin($deltaLng));
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $d = $r * $c;
 
        return $d; 
    }
    
    
}
