<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \Exception;

define('FIREBASE_API_KEY', 'AAAA2bP7DTc:APA91bFHwPr2HzTM7iGy_HX_VFwqt0orG3lH0vGHJqPOKUe8lxoE8utdo08Cl0Y1dtoX-7_mJXeYDyEPrPq-qnDS1ZmVdZAMQeVYkVm6aPoDietX9WzsUvYuP8cSoYeWNirl_X-gfxVN');

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

        $sumPin = 0;

        $allLoc = DB::table('daerahrawan')->select('lat_daerah','lng_daerah','waktu')->get();
        foreach ($allLoc as $row){
            $distance = $this->getDistance($latNow, $lngNow, $row->lat_daerah, $row->lng_daerah);
            $timeDecay = $this->getDecay($row->waktu);
            if($distance < 50 && $timeDecay) $sumPin++;
        }
        if ($sumPin <= 5) return "aman";
        else if ($sumPin > 5 && $sumPin <= 10) return "sedang";
        else if ($sumPin > 10) return "rawan";
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


    /**
    * Fungsi untuk mencari jarak waktu kejadian pada database dan waktu pengguna aplikasi
    * @param $currentTime = waktu pengguna saat ini
    * @param $dbTime = waktu kejadian pada database
    * @return boolean apakah selisih waktu +/- 3jam
    */
    public function getDecay($dbTime) {
        date_default_timezone_set('Asia/Bangkok');
        $currentTime = date("Y-m-d H:i:s");
        $selisih = abs(strtotime($dbTime) - strtotime($currentTime))/3600;
        if ($selisih <= 3) return true;
        else return false;
    }

    /**
    * Fungsi untuk mencari semua pin
    * @return array of json of all pin location and time
    */
    public function getAllPin() {
        try {
            $allPin = DB::table('daerahrawan')->select('lat_daerah','lng_daerah','waktu','deskripsi_daerah')->get();
            $dangerPin = array();
            foreach ($allPin as $pin){
                if (($this->getDecay($pin->waktu))){
                  array_push($dangerPin, array('lat_daerah' => $pin->lat_daerah, 'lng_daerah' => $pin->lng_daerah, 'waktu' => $pin->waktu, 'deskripsi_daerah' => $pin->deskripsi_daerah));
                }
            }
            //$pengguna = new PenggunaController;
            //return $pengguna->httpResponse('200', $dangerPin);
            return ($dangerPin);
            
        } catch (Exception $e){
            echo $e;
            $pengguna = new PenggunaController;
            return $pengguna->httpResponse('500', 'Gagal mendapatkan pin. Coba lagi');
        }
    }

    /**
    * Fungsi untuk membuat token emergency
    */
    public function token(request $request){
        $token = $request->token;
        $long = $request->longitude;
        $lat = $request->latitude;

        $msg = array
        (
            'message'   => 'here is a message. message',
            'title'     => 'Amann',
            'subtitle'  => 'This is a subtitle. subtitle',
            'vibrate'   => 1,
            'sound'     => 1,
            'body'      => 'Teman anda sedang dalam bahaya di koordinat' .$lat. ', ' .$long

        );

        $query = DB::table('helper')->get();
        $send = "";
        foreach ($query as $row){

            if($row->token_helper){

                $token = $row->token_helper;

                $token = array($token);

                $fields = array(
                        'registration_ids' => $token,
                        'notification' => $msg,
                        'priority' => 10
                    );

                    $headers = array(
                        'Authorization: key=' . FIREBASE_API_KEY,
                        'Content-Type: application/json'
                    );
                    //print_r($headers);

                    $ch = curl_init();
                    curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
                    curl_setopt( $ch,CURLOPT_POST, true );
                    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
                    $result = curl_exec($ch );
                    curl_close( $ch );
                    $flag = 1;
            } else {
                $hp = $row->nohp_helper;

                $send = $send . $hp;
                $send .= "=";

            }
        }

        if ($send == ""){
            $send = "Notification Sent!";
            //echo $send;
            $pengguna = new PenggunaController;
            return $pengguna->httpResponse('200', $send);
        } else {
            $pengguna = new PenggunaController;
            return $pengguna->httpResponse('500', $send);
            //echo $send;
        }


    }

}
