<?php

class Contact{
	private $name;
	private $phoneNumber;
	private $emailAddress;
	private $isValid;
	private $messageBag;

	public function __construct($contactDetails){
		$this->name = (isset($contactDetails['name'])) ? $contactDetails['name'] : null;
		$this->phoneNumber = (isset($contactDetails['phoneNumber'])) ? $contactDetails['phoneNumber'] : null;
		$this->emailAddress = (isset($contactDetails['email'])) ? $contactDetails['email'] : null;
	}

	public function validate(){
		$messageBag = array();
		$this->setIsValid(true);
		if($this->name == null || $this->name == ''){
			Utils::log(ERROR, 'name is null or empty', __CLASS__, __FUNCTION__, __LINE__);
			$messageBag['name']['message'] = 'Please enter a name.';
			$this->setIsValid(false);
		}
		if($this->phoneNumber == null ){
			// Utils::log(ERROR, 'phoneNumber is null or empty', __CLASS__, __FUNCTION__, __LINE__);
			// $messageBag['phoneNumber']['message'] = 'Please enter a Phone Number.';
			// $this->setIsValid(false);
		}
		$this->setMessageBag($messageBag);
		Utils::log(INFO, 'validation complete | message bag: '.json_encode($messageBag), __CLASS__, __FUNCTION__, __LINE__);
		return;
	}

	public function save(){
		$insertSQL = 'insert into contacts (name, phoneNumber, email, dateCreated) values '
			.' (:name, :phoneNumber,:email, :dateCreated)';
		$insertParams = array(
			':name' => $this->name,
			':phoneNumber' => $this->phoneNumber,
			':email' => $this->emailAddress,
			':dateCreated' => Utils::now()
			);
		$insertResponse = DBUtils::executePreparedStatement($insertSQL, $insertParams, null, null, true);
		if(!isset($insertResponse['STAT_TYPE']) || ($insertResponse['STAT_TYPE'] != SC_SUCCESS_CODE)){
			//sth went wrong
			Utils::log(ERROR, 'unable to save record. reason: '
				.json_encode($insertResponse), __CLASS__, __FUNCTION__, __LINE__);
			return Utils::formatResponse(null, SC_FAIL_CODE, 
				SC_FAIL_CODE, 'An error occurred while saving the contact. Please try again later.');
		}
		Utils::log(INFO, 'record saved successfully | response: '
			.json_encode($insertResponse), __CLASS__, __FUNCTION__, __LINE__);
		return Utils::formatResponse(null, SC_SUCCESS_CODE, 
				SC_SUCCESS_CODE, 'Contact saved!');

	}

	protected function setMessageBag($messageBag){
		$this->messageBag = $messageBag;
	}

	public function getMessageBag(){
		return $this->messageBag;
	}

	protected function setIsValid($newState){
		$this->isValid = $newState;
	}

	public function isValid(){
		return $this->isValid;
	}
}