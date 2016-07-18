<?php

/**
 * Class UserController
 * Handles specific user-building routes through form requests
 */
class UsersController extends Controller{

	/**
	 *  Build user and validate information from form inputs before saving to database
	 */
	public function registerRoute(){
		// Get data from request
		$values = $this->parseUserInputValues();
		$valid = true;

		// Validate via regex patterns and magic length numbers
		if($valid = $valid && isset($values['firstname'])){
			$valid = ($valid && !empty($values['firstname'])
				&& preg_match('/[a-zA-Z\s]+/', $values['firstname']) && strlen($values['firstname']) < 30);
		}

		if($valid = $valid && isset($values['lastname'])){
			$valid = ($valid && !empty($values['lastname'])
				&& preg_match('/[a-zA-Z\s]+/', $values['lastname']) && strlen($values['lastname']) < 30);
		}

		if($valid = $valid && isset($values['address1'])){
			$valid = ($valid && !empty($values['address1'])
				&& strlen($values['address1']) < 64);
		}

		if($valid = $valid && isset($values['address2'])){
			$valid = ($valid && strlen($values['address2']) < 64);
		}

		if($valid = $valid && isset($values['city'])){
			$valid = ($valid && !empty($values['city'])
				&& strlen($values['city']) < 30);
		}

		if($valid = $valid && isset($values['state'])){
			$valid = ($valid && !empty($values['state'])
				&& $this->_stateMatch($values['state']) && strlen($values['state']) < 3);
		}

		if($valid = $valid && isset($values['zipcode'])){
			$valid = ($valid && !empty($values['zipcode']));
			if($valid = ($valid && preg_match('/^\d{5}(?:-\d{4})?$/', $values['zipcode']))){
				if(strpos($values['zipcode'], '-') > 0)
					$valid = ($valid && strlen($values['zipcode']) == 10);
				else
					$valid = ($valid && strlen($values['zipcode']) == 5);
			}
		}

		if($valid = $valid && isset($values['country'])){
			$valid = ($valid && !empty($values['country'])
				&& $values['country'] == 'US');
		}

		// Route back to the main page if there is an error
		if(!$valid){
			App::redirect('', ["error"=>"1"]);
		}

		// Save the user
		$user = new User($values);
		$user->save();

		if($user->getData('id')){
			App::redirect('confirmation',["id" => $user->getData('id')]);
		}
		App::redirect('',['error' => "1"]);
	}

	/**
	 *  Check state from input values against array of all states
	 */
	private function _stateMatch($state){
		$stateArray = ["AL","AK","AZ","AR","CA","CO","CT","DE","DC","FL","GA","HI","ID","IL","IN","IA","KS","KY","LA","ME","MD","MA","MI","MN","MS","MO","MT","NE","NV","NH","NJ","NM","NY","NC","ND","OH","OK","OR","PA","RI","SC","SD","TN","TX","UT","VT","VA","WA","WV","WI","WY"];
		return in_array($state, $stateArray);
	}

	/**
	 *  Creates PHP sanitized objects based on inputs that are passed back
	 */
	private function parseUserInputValues(){
		// Create empty array to act as input container
		$inputVals = [];

		// Set all other sanitized values as needed
		$inputVals['firstname'] = $this->sanitizeInput(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
		$inputVals['lastname'] = $this->sanitizeInput(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
		$inputVals['address1'] = $this->sanitizeInput(INPUT_POST, 'address1', FILTER_SANITIZE_STRING);
		$inputVals['address2'] = $this->sanitizeInput(INPUT_POST, 'address2', FILTER_SANITIZE_STRING);
		$inputVals['city'] = $this->sanitizeInput(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
		$inputVals['state'] = $this->sanitizeInput(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
		$inputVals['zipcode'] = $this->sanitizeInput(INPUT_POST, 'zipcode', FILTER_SANITIZE_STRING);
		$inputVals['country'] = $this->sanitizeInput(INPUT_POST, 'country', FILTER_SANITIZE_STRING);

		return $inputVals;
	}
}