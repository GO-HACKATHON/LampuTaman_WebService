<?php

namespace App\Http\Middleware;

use Closure;

class ApiAuth
{
    /**
     * Handle an incoming request.
     * Fungsi ini digunakan untuk memeriksa apakah metode yang digunakan adalah POST
     * Jika bukan, @return error 403
     * Jika iya, @return pada halaman yang dituju
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
      if(!$request->isMethod('POST')){
        $response = [
          'response' => '405',
          'message' => 'Method not allowed for this request'
        ];
        return $response;
      }
      if(!isset($request->key) || $request->key != 'mantapancing'){
        $response = [
          'response' => '403',
          'message' => 'You are not authorized for this API'
        ];
        return json_encode($response);
      } else return $next($request);
    }
}
