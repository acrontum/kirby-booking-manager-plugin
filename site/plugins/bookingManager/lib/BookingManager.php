<?php

/**
* A Kirby 2 Plugin to handle booking requests
*/
class BookingManager {


	private $bookingMail;
	private $confirmationText;
	private $successText;
	private $originId;

	static private $instance = null;

	public static function getInstance() {
		if (null === self::$instance) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	function __construct() {}

	function setBookingData($uid) {
		$formPage = page($uid);
		$this->originId = $uid;

		if(!empty($formPage)) {
			$this->bookingMail = $formPage->bookingMail()->value();
			$this->confirmationText = $formPage->confirmationText()->value();
			$this->successText = $formPage->successText()->value();
		} else {
			false;
		}
	}

	public function getBookingMail() {
		return $this->bookingMail;
	}

	public function getConfirmationText() {
		return $this->confirmationText;
	}

	public function getSuccessText() {
		return $this->successText;
	}

	public function getOriginId() {
		return $this->originId;
	}

	static public function seoUrl($string) {
	    $string = strtolower($string);
	    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
	    $string = preg_replace("/[\s-]+/", " ", $string);
	    $string = preg_replace("/[\s_]/", "-", $string);
	    return $string;
	}

	private function buildMailText($mailText, $parameters) {
		foreach($parameters as $key => $value) {
			$mailText = str_replace('##'.$key.'##', $value, $mailText);
		}
		return $mailText;
	}
	
	private function createBookingApprovalLink($contact, $product, $date) {
		return "\r\n\r\n".site()->url()."/bookingManagerApprove"."?booker=".urlencode($contact)."&originId=".urlencode($this->originId);
	}

	public function sendBookingConfirmation() {

		$responseMessages = array();
		$fault = false;
		
		if(!v::required('email', get())){
			$responseMessages[] = array('type' => 'error', 'message' => 'No email given, cheating ass bitch!');
			$fault = true;
		} else if(!v::email(get('email'))){
			$responseMessages[] = array('type' => 'error', 'message' => 'No email given, cheating ass bitch!');
			$fault = true;
		}
		if(!v::required('productSelect', get())){
			$responseMessages[] = array('type' => 'error', 'message' => 'No product given, cheating ass bitch!');
			$fault = true;
		}
		if(!v::required('date', get())){
			$responseMessages[] = array('type' => 'error', 'message' => 'No date given, cheating ass bitch!');
			$fault = true;
		} else if(!v::date(get('date'))){
			$responseMessages[] = array('type' => 'error', 'message' => 'No valid Date, son of a bitch!');
			$fault = true;
		}
		if(!v::required('name', get())){		
			$responseMessages[] = array('type' => 'error', 'message' => 'No name given, cheating ass bitch!');
			$fault = true;
		} else if(!v::min(get('name'),3)){
			$responseMessages[] = array('type' => 'error', 'message' => 'At least 3 characters for a name, bitchass!');
			$fault = true;
		}
		
		if($fault) {
			s::set('response', $responseMessages);
			go($this->getOriginId());
		}

		$confirmationBody = self::buildMailText($this->getConfirmationText(), get());
		$ownerConfirmation = $confirmationBody.self::createBookingApprovalLink(get('email'), array(), array());
		$from = site()->contactmail()->value();

		// Send To Owner
		$confirmationMail = new Email(array(
			'to'		=>	self::getBookingMail(),
			'from'		=>	$from,
			'subject'	=>	'Hey, some new booking',
			'body'		=>	$ownerConfirmation
		));

		// Send to User
		$userConfirmationMail = new Email(array(
			'to'		=>	get('email'),
			'from'		=>	$from,
			'subject'	=>	'Hey, some new booking',
			'body'		=>	$confirmationBody
		));

		if($userConfirmationMail->send() && $confirmationMail->send()) {
			$responseMessages[] = array('type' => 'success', 'message' => 'Successfully send a booking request.');
		  	s::set('response', $responseMessages);
		} else {
			go('error');
		}

		go($this->getOriginId());
	}

	public function sendBookingSuccess() {
		$successBody = self::buildMailText($this->getSuccessText(), get());
		$from = site()->contactmail()->value();
		
		// Send to User
		$successMail = new Email(array(
			'to'		=>	get('booker'),
			'from'		=>	$from,
			'subject'	=>	'Hey, some new booking',
			'body'		=>	$successBody
		));	
		$responseMessages = array();
		if($successMail->send()) {
		  	$responseMessages[] = array('type' => 'success', 'message' => 'E-Mail sent successfully!');
		  	s::set('response', $responseMessages);
		} else {
			go('error');
		}

		go('home');
	}

}