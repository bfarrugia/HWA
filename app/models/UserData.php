<?php

/*
 * Class User
 * Data representation of a User model.
 *
 */
class User extends Model
{
	/* 
     * Build model with existing data if possible
     */
	public function __construct($data = false){
		parent::__construct(get_class($this), 'users', $data);

		if(!isset($this->_data['id']))
			$this->_data = $data;
	}
}