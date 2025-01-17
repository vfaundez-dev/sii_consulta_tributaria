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
    
  public function fetchSiiData(Request $request) {

		$data = $request->only(['rut', 'dv']);

		$captcha = $this->fetchCaptcha();
		if (!$captcha) return $this->sendRequestMsg('error', 'Error obteniendo Captcha', []);

		$dataSii = $this->fetchData($data['rut'], $data['dv'], $captcha);
		$parsedData = $this->parseDataHtml($dataSii);

		return $this->sendRequestMsg('success', 'Proceso completado', $parsedData);
    
  }

	private function fetchCaptcha() {
    try {

      $response = $this->client->post( 'https://zeus.sii.cl/cvc_cgi/stc/CViewCaptcha.cgi', [
          'form_params' => ['oper' => 0]
        ]
      );

      $json = json_decode($response->getBody()->getContents(), true);

      if (!isset($json["txtCaptcha"])) return null;

      $code = substr(base64_decode($json["txtCaptcha"]), 36, 4);
      $captcha = $json["txtCaptcha"];

      return [$code, $captcha];

    } catch (\GuzzleHttp\Exception\RequestException $e) {
      // Registrar el error relacionado con la solicitud HTTP
      Log::error("Error al realizar la solicitud: " . $e->getMessage(), [ 'exception' => $e ]);
      return null;
    } catch (\Exception $e) {
      // Registrar cualquier otro tipo de error
      Log::error("Ocurrió un error al procesar el captcha: " . $e->getMessage(), [ 'exception' => $e ]);
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

	private function fetchData($rut, $dv, $captcha) {
		try {

			$postData = [
				'RUT' => $rut,
				'DV'  => $dv,
				'PRG' => 'STC',
				'OPC' => 'NOR',
				'txt_code' => $captcha[0],
				'txt_captcha' => $captcha[1]
			];

			$response = $this->client->post( 'https://zeus.sii.cl/cvc_cgi/stc/getstc', [
          'form_params' => $postData
        ]
      );

			$content = $response->getBody()->getContents();
			return $content;

		} catch (\GuzzleHttp\Exception\RequestException $e) {
      // Registrar el error relacionado con la solicitud HTTP
      Log::error("Error al realizar la solicitud: " . $e->getMessage(), [ 'exception' => $e ]);
      return null;
    } catch (\Exception $e) {
      // Registrar cualquier otro tipo de error
      Log::error("Ocurrió un error al procesar el captcha: " . $e->getMessage(), [ 'exception' => $e ]);
      return null;
    }
	}

	private function parseDataHtml($html) {
		try {

			$razonSocial = '';
			$actividades = [];
			$timbrados = [];

			$documento = \phpQuery::newDocument($html);

			// Extrae razón social
			$razonSocialNode = $documento->find('body > div > div:nth-child(4)');
			$razonSocial = $razonSocialNode->length > 0 
					? ucwords(strtolower(trim($razonSocialNode->text())))
					: null;

			// Recorre las filas de la tabla actividades
			$strongActividades = $documento->find('strong:contains("Actividades")');
			if ($strongActividades->length > 0) {
				$actividadRows = $strongActividades->nextAll('table.tabla')->eq(0)->find('tr');
				foreach ($actividadRows as $i => $row) {
					if ($i > 0) { // Ignora la cabecera
						$rowNode = pq($row);
						$actividades[] = [
							'giro'      => trim($rowNode->find('td:nth-child(1) font')->text()),
							'codigo'    => (int)trim($rowNode->find('td:nth-child(2) font')->text()),
							'categoria' => trim($rowNode->find('td:nth-child(3) font')->text()),
							'afecta'    => trim($rowNode->find('td:nth-child(4) font')->text()),
							'fecha'     => trim($rowNode->find('td:nth-child(5) font')->text()),
						];
					}
				}
			}

			// Recorre las filas de la tabla Documentos Timbrados
			$strongTimbrados = $documento->find('strong:contains("Timbrados")');
			if ($strongTimbrados->length > 0) {
				$timbradoRows = $strongTimbrados->nextAll('table.tabla')->eq(0)->find('tr');
				foreach ($timbradoRows as $i => $row) {
					if ($i > 0) { // Ignora la cabecera
						$rowNode = pq($row);
						$timbrados[] = [
							'documento'             => trim($rowNode->find('td:nth-child(1) font')->text()),
							'anio ultimo timbraje'  => (int)trim($rowNode->find('td:nth-child(2) font')->text()),
						];
					}
				}
			}

			return [
					'razonSocial' => $razonSocial,
					'actividades' => $actividades,
					'documentos timbrados' => $timbrados,
			];

		} catch (\Exception $e) {
			Log::error('Error al procesar el HTML de respuesta', [
				'error' => $e->getMessage(),
				'trace' => $e->getTraceAsString()
			]);

			return null;
		}
	}

}
