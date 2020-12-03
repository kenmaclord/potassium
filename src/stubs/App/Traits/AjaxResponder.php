<?php

namespace App\Traits;

use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

trait AjaxResponder
{

	/**
	 * @var Int
	 */
	protected $statusCode = ResponseCode::HTTP_OK;

	/**
	 * @param mixed $statusCode
	 */
	public function  getStatusCode()
	{
		return $this->statusCode;
	}

		/**
	 * @param mixed $statusCode
	 *
	 * @return $this
	 */
	public function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;

		return $this;
	}

	/*
	|--------------------------------------------------------------------------
	| 														REPONSES DE SUCCÈS
	|--------------------------------------------------------------------------
	*/

	/**
	 * Réponse JSON générique en cas de succès
	 *
	 * @param Integer $code Code du statut HTTP de succès, généralement 200
	 * @param Array $data Les données transformées
	 *
	 * @return Json
	 */
	public function respondData($data)
	{
		return Response::json(["data"=>$data],$this->getStatusCode());
	}

	/**
	 * Réponse JSON générique en cas de succès
	 *
	 * @param Integer $code Code du statut HTTP de succès, généralement 200
	 * @param Array $data Les données transformées
	 *
	 * @return Json
	 */
	public function respond($message,$extraData=null)
	{
		return Response::json([
			"status"    => "success",
			"message"   => $message,
			"extraData" => $extraData
		],$this->getStatusCode());
	}

	/**
	 * Réponse JSON si la resource a correctement été modifiée
	 *
	 * @param String $message Message de succès
	 *
	 * @return Json
	 */
	public function respondUpdated($message)
	{
		return $this->setStatusCode(ResponseCode::HTTP_OK)->respond($message);
	}

	/**
	 * Réponse JSON si la resource a correctement été crée
	 *
	 * @param String $message Message de succès
	 *
	 * @return Json
	 */
	public function respondCreated($message)
	{
		return $this->setStatusCode(ResponseCode::HTTP_CREATED)->respond($message);
	}

	/**
	 * Réponse JSON si la resource a correctement été supprimée
	 *
	 * @param String $message Message de succès
	 *
	 * @return Json
	 */
	public function respondDeleted($message)
	{
		return $this->setStatusCode(ResponseCode::HTTP_OK)->respond($message);
	}

	/*
	|--------------------------------------------------------------------------
	| 														REPONSES D'ERREUR
	|--------------------------------------------------------------------------
	*/


	/**
	 * Réponse JSON générique en cas d'erreur AJAX
	 *
	 * @param String $message message de l'erreur
	 * @param Integer $code Code de l'erreur
	 * @param String $message Message d'erreur
	 *
	 * @return Json
	 */
	public function respondError($message,$statusCode=null, $extraData=null){

		$response = [
			"status" => "error",
			"message"=> $message,
		];

		// Si des données supplémentaires sont passées, ont les fusionne avec la réponse courante
		if($extraData) $response = array_merge($response, $extraData);

		return Response::json($response,$statusCode ?:$this->getStatusCode());
	}

	/**
	 * Réponse JSON générique en cas d'erreur AJAX pour simuler la structure données 
	 * des erreurs de validation
	 *
	 * @param String $message message de l'erreur
	 * @param Integer $code Code de l'erreur
	 * @param String $message Message d'erreur
	 *
	 * @return Json
	 */
	public function respondErrorBag($message,$statusCode=null, $extraData=null){

		$response = [
			'errors' => [
				"message"=> [$message],
			]
		];

		// Si des données supplémentaires sont passées, ont les fusionne avec la réponse courante
		if($extraData) $response = array_merge($response, $extraData);

		return Response::json($response,$statusCode ?:$this->getStatusCode());
	}	

	/**
	 * Réponse JSON générique pour l'API en cas d'erreur
	 *
	 * @param Integer $code Code de l'erreur
	 * @param String $message Message d'erreur
	 *
	 * @return Json
	 */
	public function respondWithErrors($message,$headers=[]){
		return Response::json([
			"error"  =>[
				"status"  => "error",
				"message" => $message,
			]
		],$this->getStatusCode(),$headers);
	}

	/**
	 * Réponse si la resource n'est pas trouvée
	 *
	 * @param String $message Message d'erreur
	 *
	 * @return Json
	 */
	public function respondNotFound($message="Ressource inexistante"){
		return $this->setStatusCode(ResponseCode::HTTP_NOT_FOUND)->respondWithErrors($message);
	}

	/**
	 * Réponse s'il y a eu une erreur sur le serveur
	 *
	 * @param String $message Message d'erreur
	 *
	 * @return Json
	 */
	public function respondInternalServerError($message="Erreur sur le serveur"){
		return $this->setStatusCode(ResponseCode::HTTP_INTERNAL_SERVER_ERROR)->respondWithErrors($message);
	}

	/**
	 * Réponse si les arguments POST n'ont pas passé la validation
	 *
	 * @param String $message Message d'erreur
	 *
	 * @return Json
	 */
	public function respondValidationFail($message="Les arguments n'ont pas été validés"){
		return $this->setStatusCode(ResponseCode::HTTP_UNPROCESSABLE_ENTITY)->respondWithErrors($message);
	}


}
