<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \Exception;

class PenggunaController extends Controller {
  /**
  * Fungsi untuk pemeriksaan ketika login
  * @param \Illuminate\Http\Request $request
  * Jika login berhasil @return code 200
  * Jika gagal @return code 401
  */
  public function loginCheck(Request $request){
    $email_pengguna = $request->email_pengguna;
    $password_pengguna = $request->password_pengguna;
   $token = $request->token;
    if(!isset($email_pengguna) || !isset($password_pengguna)){
      return $this->httpResponse('400', 'Bad Request');
    }
    $insert = DB::table('pengguna')->insert([
      'token_pengguna' => $token
    ]);
    $find = DB::table('pengguna')
              ->where([
                ['email_pengguna', '=', $email_pengguna],
                ['password_pengguna', '=', $password_pengguna]
              ])
              ->get();
    if(count($find) > 0){
      return $this->httpResponse('200', 'Login Success');
    } else {
      return $this->httpResponse('405', 'False email or password');
    }
  }

  /**
  * Fungsi untuk memasukkan data pada saat pengguna baru mendaftar
  * helper_x adalah
  * @param \Illuminate\Http\Request $request
  * @return code 200 jika pendaftaran berhasil
  * @return code 500 jika pendaftaran gagal
  */
  public function register(Request $request){
    $email = $request->email_pengguna;
    $name = $request->nama_pengguna;
    $password = $request->password_pengguna;
    $nohp = $request->nohp_pengguna;
    $tgl_lahir = $request->tgl_lahir;
    $sex = $request->sex;

    $nohp_helper = array();
    $nohp_helper [] = $request->nohp_helper_1;
    $nohp_helper [] = $request->nohp_helper_2;
    $nohp_helper [] = $request->nohp_helper_3;
    $nohp_helper [] = $request->nohp_helper_4;
    $nohp_helper [] = $request->nohp_helper_5;
    $nohp_helper [] = $request->nohp_helper_6;

    $last_id = DB::table('pengguna')->max('id_pengguna');
    $last_id++;

    try{
      $register = DB::table('pengguna')->insert([
        'id_pengguna' => $last_id,
        'nama_pengguna' => $name,
        'token_pengguna' => 'null',
        'email_pengguna' => $email,
        'password_pengguna' => $password,
        'nohp_pengguna' => $nohp,
        'tgl_lahir' => $tgl_lahir,
        'sex' => $sex
      ]);
    } catch(Exception $e){
      echo $e;
      return $this->httpResponse('500', 'Gagal mendaftar. Coba lagi');
    }

    try{
      $last_id_helper = DB::table('helper')->max('id_helper');
      for ($i=0; $i<count($nohp_helper); $i++){
        $last_id_helper++;
        $token_helper = DB::table('pengguna')
                          ->where('nohp_pengguna', '=', $nohp_helper[$i])
                          ->get();
        if(count($token_helper) == 0){
          $token_helper = null;
        } else {
          $token_helper = $token_helper[0]->token_pengguna;
        }
        $insert_helper = DB::table('helper')->insert([
          'id_helper' => $last_id_helper,
          'nohp_helper' => $nohp_helper[$i],
          'id_pengguna' => $last_id,
          'token_helper' => $token_helper
        ]);
      }
    } catch(Exception $e){
      DB::table('helper')->where('id_pengguna', '=', $last_id)->delete();
      DB::table('pengguna')->where('id_pengguna', '=', $last_id)->delete();
      echo $e;
      return $this->httpResponse('500', 'Gagal mendaftar. Coba lagi');
    }
    return $this->httpResponse('200', 'Pendaftaran Berhasil!');
  }

  /**
  * Fungsi untuk mengembalikan http request
  * @param $code : berisi nilai kode http request yang dikembalikan
  * @param $message : berisi pesan yang mengiri kode response
  * @return $response adalah array
  */
  public function httpResponse($code, $message){
    $response = [
      'response' => $code,
      'message' => $message
    ];
    return $response;
  }
}
