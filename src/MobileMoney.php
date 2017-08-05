<?php 
	
namespace Ngambmicheal\MobileMoney;

/**
*	Laravel 5 Cameroon Mobile Money Package;
*
*	@copyright Copyright (c) 2017 Ngambmicheal
*	@version 1.0.1
*	@author Ngambmicheal
*	@website ngambmicheal@gmail.com
*	@date 2017-06-30
*	@license http://www.opensource.org/licenses/mit-license.php The MIT License
*/


use Exception;
use Ngambmicheal\MobileMoney\Models\MomoTransaction as momo;



/**
* Class MobileMoney
* @package Ngambmicheal/MobileMoney
*
*/

class MobileMoney { 

	/**
	* @var string Client Key */

	protected $client_key;

	/**
	* @var string Secret Key */

	protected $secret_key;

	/**
	* @var integer Price of the Transaction */

	public $price; 

	/**
	* @var string Mobile Money phone Doing the Transaction */

	public $phone; 

	/**
	* Is MTN Mobile Money Enabled? Default true 
	* @var bool 
	*/

	protected $mtn_mobile_money = true;

	/**
	* @var bool is Orange Mobile Enabled? Default true
	*/

	protected $orange_money = true; 

	/**
	* Do you want to save transactions in the database ? Default true
	* @var bool  
	*/

	protected $save_to_database = true; 

	/**
	* @var Int transaction_id */

	protected $transaction_id; 

	/**
	* Transaction Status
	* @var string status
	*/ 

	protected $status;

	/**
	* Transaction Message
	* @var string message
	*/

	protected $message;

	/**
	* Transaction state
	* @var bool state
	*/

	protected $state;

	/**
	* Data
	* @var array data
	*/

	protected $data = []; 


	/* Int  */


	__construct($phone, $price){
		$this->phone = $phone;
		$this->price = $price;
		$this->configure();
	}

	private function configure(){
		$this->client_key = config('mobilemoney.webshinobis_client_key');
		$this->secret_key = config('mobilemoney.webshinobis_secret_key');
	}

	/** 
	* 	Set Phone phone
	* 	@param $phone;
	* 	@return void;   
	*/
	public function setPhone($phone){
		$this->phone = $phone;
	}

	/**
	* Get Phone phone
	* @return string $phone
	*/
	public function getPhone(){
		return $this->phone;
	}

	/**
	*  Set Price
	*  @param $price;
	*  @return void;
	*/

	public function setPrice($price){
		$this->price = $price;
	}

	/** 
	* Get Price
	* @return string $price
	*/
	public function getPrice(){
		return $this->price;
	}

	/**
	* Set Secret Key
	* @param $secret_key
	*/
	public function setSecretKey($secret_key){
		$this->secret_key = $secret_key;
	}

	/**
	* Get Secret Key
	* @return string $secret_key
	*/
	public function getSecretKey(){
		return $this->secret_key;
	}

	/**
	* Set Client Key
	* @param $client_key
	*/
	public function setClientKey($client_key){
		$this->client_key = $client_key;
	}

	/**
	* Get Client Key
	* @return string $client_key
	*/
	public function getClientKey(){
		return $this->client_key;
	}


	/**
	* MTN Mobile Money Transaction
	* @return (Object) $this->getData()
	*/

	public function doMTNTransaction(){

		try {
				  $post = [

		                'email' => $this->client_key;
		                'password' => $this->secret_key;
		                'amount' => $this->price;
		                'phone'  => $this->phone;
		          
		          		];

		          $ch = curl_init('http://api.webshinobis.com/api/v1/momo/checkout');
		          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		          curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

		          // execute!
		          $response = json_decode(curl_exec($ch));

		           //Get Response Data

		          $this->getResponse($response);

		           //return data;
		          return $this->getData();

		         // close the connection, release resources used
		         curl_close($ch);
		}
		catch (Exception $e){

			//Get the Exception and close transaction
			$this->getException($e);
			return $this->getData();
		}
		

	}

	public function doOrangeTransaction(){

	}

	/**
	* Save Transaction to Database
	* @return void
	*/
	private function saveToDatabase(){

		if($this->save_to_database){
			$transaction = new momo;
			$transaction->transaction_id = $this->transaction_id;
			$transaction->phone 		 = $this->phone;
			$transaction->price		 = $this->price;
			$transaction->model_id 		 = $this->model_id;
			$transaction->model 		 = $this->model;
			$transaction->save();
		}
		
	}

	/**
	* Get Instances of the response
	* @param $response
	* @return void
	*/

	private function getResponse($response){

		$this->status 	 	  = $response->status;
		$this->message 		  = $response->message;

		if($response->transaction_id){
			$this->transaction_id = $response->transaction_id;			
			$this->state 		  = true;
			$this->saveToDatabase();
		}

		else {
		    $this->state 		  = false;		    
		}

	}

	/**
	* @param Exception e
	* @return void
	*/

	private function getException($e){
		$this->message 	= $e->message;
		$this->state  	= false;
	}

	/**
	* @return Object $data
	*/
	private function getData(){

		$this->data['transaction_id'] 	= $this->transaction_id,
		$this->data['status']			= $this->status,
		$this->data['state']			= $this->state,
		$this->data['phone']			= $this->phone,
		$this->data['price']			= $this->price,
		$this->data['message']			= $this->message

		return (object) $data;
	}

	/**
	* @param string $service
	* @return void
	*/
	private function allowSevices($service){

		switch ($service) {
			case 'mtn':
				$this->mtn_mobile_money = true;
				break;
			case 'orange':
				$this->orange_money 	= true;
			
			default:
				# code...
				break;
		}
	}


}


