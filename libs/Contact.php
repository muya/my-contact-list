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

	public function update($id){
		$updateSQL = 'update contacts set name=:name, phoneNumber=:phoneNumber, '.
			'email=:email where id=:id limit 1';
		$updateParams = array(
			':name' => $this->name,
			':phoneNumber' => $this->phoneNumber,
			':email' => $this->emailAddress,
			':id' => $id
		);
		$updateResponse = DBUtils::executePreparedStatement($updateSQL, $updateParams, null, null, true);
		if(!isset($updateResponse['STAT_TYPE']) || ($updateResponse['STAT_TYPE'] != SC_SUCCESS_CODE)){
			//sth went wrong
			Utils::log(ERROR, 'unable to update record. reason: '
				.json_encode($updateResponse), __CLASS__, __FUNCTION__, __LINE__);
			return Utils::formatResponse(null, SC_FAIL_CODE, 
				SC_FAIL_CODE, 'An error occurred while updating the contact. Please try again later.');
		}
		Utils::log(INFO, 'record updated successfully | response: '
			.json_encode($updateResponse), __CLASS__, __FUNCTION__, __LINE__);
		return Utils::formatResponse(null, SC_SUCCESS_CODE, 
				SC_SUCCESS_CODE, 'Contact updated!');
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

	public function destroy($id){
		$deleteSQL = 'delete from contacts where id=:id';
		$deleteParams = array(':id' => $id);
		$deleteResponse = DBUtils::executePreparedStatement($deleteSQL, $deleteParams, null, null, true);
		if(!isset($deleteResponse['STAT_TYPE']) || ($deleteResponse['STAT_TYPE'] != SC_SUCCESS_CODE)){
			//sth went wrong
			Utils::log(ERROR, 'unable to remove record. reason: '
				.json_encode($deleteResponse), __CLASS__, __FUNCTION__, __LINE__);
			return Utils::formatResponse(null, SC_FAIL_CODE, 
				SC_FAIL_CODE, 'An error occurred while removing the contact. Please try again later.');
		}
		Utils::log(INFO, 'record removed successfully | response: '
			.json_encode($deleteResponse), __CLASS__, __FUNCTION__, __LINE__);
		return Utils::formatResponse(null, SC_SUCCESS_CODE, 
				SC_SUCCESS_CODE, 'Contact removed!');
	}

	public function getEmail(){
		return $this->emailAddress;
	}
	public function getName(){
		return $this->name;
	}
	public function getPhoneNumber(){
		return $this->phoneNumber;
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