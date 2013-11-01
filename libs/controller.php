<?php

require_once (dirname(__FILE__)) . '/DBUtils.php';
require_once (dirname(__FILE__)) . '/Contact.php';

if(!isset($_GET['a']) && ($_GET['a'] != '')){
	Utils::log(ERROR, 'action not set. redirecting to contacts page...', __FILE__, __FUNCTION__, __LINE__);
	Utils::setSessionMessage('danger', 'An error occurred. Please try again.');
	header('Location: '.ROOT_URL.'contacts.php');
	exit();
}

Utils::log(DEBUG, 'request sent here: '.json_encode($_REQUEST));

$actionType = $_GET['a'];

switch ($actionType){
	case 'new':
		$contact = new Contact($_POST);
		$contact->validate();
		if(!$contact->isValid()){
			//contact failed validation
			Utils::log(ERROR, 'contact failed validation. reason(s): '.json_encode($contact->getMessageBag()));
			$fullMessage = '';
			foreach ($contact->getMessageBag() as $key) {
				$fullMessage .= '<li>'.$key['message'].'</li>';
			}
			$fullMessage = '<ul>'.$fullMessage.'</li>';
			Utils::setSessionMessage('danger', $fullMessage);
			header('Location: '.ROOT_URL.'new.php');
		}
		//everything's good so far. save this record
		$saveResponse = $contact->save();
		if($saveResponse['STAT_TYPE'] != SC_SUCCESS_CODE){
			Utils::setSessionMessage('danger', $saveResponse['STAT_DESCRIPTION']);
			header('Location: '.ROOT_URL.'new.php');
		}
		else{
			Utils::setSessionMessage('success', $saveResponse['STAT_DESCRIPTION']);
			header('Location: '.ROOT_URL.'contacts.php');
		}
		break;
	default:
		Utils::log(ERROR, 'unknown action: '.$actionType.' given. redirecting to contacts page...', __FILE__, __FUNCTION__, __LINE__);
		Utils::setSessionMessage('danger', 'An error occurred. Please try again.');
		header('Location: '.ROOT_URL.'contacts.php');
		break;
}