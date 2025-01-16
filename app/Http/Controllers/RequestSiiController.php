<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RequestSiiController extends Controller {

	protected $client;

	public function __construct(){
		$this->client = new Client();
	}
    
  public function fetchSiiData() {

		$captcha = $this->fetchCaptcha();
		if (!$captcha)
			return $this->sendRequestMsg('error', 'Error obteniendo Captcha', []);

		return $this->sendRequestMsg('success', 'Datos obtenidos', $captcha);
    
  }

	private function fetchCaptcha() {
    try {

      $response = $this->client->post(
        'https://zeus.sii.cl/cvc_cgi/stc/CViewCaptcha.cgi',[
            'form_params' => ['oper' => 0]
        ]
      );

      $json = json_decode($response->getBody()->getContents(), true);

      // Verificar si los datos esperados están presentes
      if (!isset($json["txtCaptcha"])) return null;

      $code = substr(base64_decode($json["txtCaptcha"]), 36, 4);
      $captcha = $json["txtCaptcha"];

      return [$code, $captcha];

    } catch (\GuzzleHttp\Exception\RequestException $e) {
        // Registrar el error relacionado con la solicitud HTTP
        Log::error("Error al realizar la solicitud: " . $e->getMessage(), [
            'exception' => $e
        ]);
        return null;
    } catch (\Exception $e) {
        // Registrar cualquier otro tipo de error
        Log::error("Ocurrió un error al procesar el captcha: " . $e->getMessage(), [
            'exception' => $e
        ]);
        return null;
    }
	}

	private function sendRequestMsg($status, $message, $data) {
		return response()->json([
			'status' => $status,
			'message' => $message,
			'data' => $data,
		]);
	}


}
