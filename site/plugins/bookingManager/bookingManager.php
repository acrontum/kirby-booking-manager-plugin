<?php

/** 
* A Kirby 2 Plugin to handle booking requests
*/
if(!class_exists('BookingManager')) {
	require_once(__DIR__ . DS . 'lib' . DS . 'BookingManager.php');
}


// build some routes for bookingManager
kirby()->routes(
	array(
		array(
			'pattern'	=>	'bookingManagerSend',
			'action'	=>	function(){
				$origin = get('originId');
				$bookingManager = BookingManager::getInstance();
				$bookingManager->setBookingData($origin);
				$bookingManager->sendBookingConfirmation();
			},
			'method'	=> 'POST'
		),
		array(
			'pattern'	=>	'bookingManagerApprove',
			'action'	=>	function(){
				$origin = get('originId');
				$bookingManager = BookingManager::getInstance();
				$bookingManager->setBookingData($origin);
				$bookingManager->sendBookingSuccess();
			},
			'method'	=> 'GET'
		)
	)
);

// open lib for bookingManager
function bookingManager($bookingData = array()) {
	try {
		$bookingManager = BookingManager::getInstance();
		$bookingManager->setBookingData($bookingData);
		return $bookingManager;
	} catch (Exception $e) {
		print "<strong>The BookingManager plugin threw an error</strong><br>" .
			$e->getMessage();
	}
}