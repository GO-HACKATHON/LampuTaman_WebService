<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
    if(!isset($email_pengguna) || !isset($password_pengguna)){
      return $this->httpResponse('400', 'Bad Request');
    }
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
