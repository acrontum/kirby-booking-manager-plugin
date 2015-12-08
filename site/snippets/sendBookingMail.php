<?php
	$bookingData = array(
		'bookingMail'	=>	$page->bookingMail()->yaml(),
		'confirmationText'	=>	$page->confirmationMail()->yaml()
	);
	$bookingManager = bookingManager($bookingData);
?>