<?php

namespace App\Http\Controllers;

use App\Models\IndicadorFinanciero;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class WebServiceSolutoriaController extends Controller
{


  public function getToken()
  {
    $client = new Client();
    $headers = [
      'accept' => '*/*',
      'Content-Type' => 'application/json-patch+json'
    ];
    $body = '{
      "userName": "marcosjaviermarinorevilla9_cn3@indeedemail.com",
      "flagJson": true
    }';
    $request = new Request('POST', env('API_ENDPOINT').'/acceso', $headers, $body);

    $res = $client->sendAsync($request)->wait();
    $result = json_decode((string) $res->getBody(), true);

    return $result['token'];
  }
  public function getConnectionSolutoria()
  {

    $token = $this->getToken();
    $client = new Client();
    $headers = [
      'Authorization' => "Bearer $token"
    ];

    $request = new Request('GET', env('API_ENDPOINT').'/indicadores', $headers);
    $res = $client->sendAsync($request)->wait();
    $results = json_decode((string) $res->getBody(), true);
    foreach ($results as $result) {
      IndicadorFinanciero::firstOrCreate($result);
    }
    $max = DB::table('indicador_financieros')->max('id') + 1;
    DB::statement("SELECT setval('public.indicadorfinanciero_id_seq', $max, true);");

    return Response::json([
      'success' => true,
      'message' => 'Sincronizacion realizada con éxito',
  ], 200);
  }
}
