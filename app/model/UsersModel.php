<?php
class UsersModel extends Model{
	protected $dbTable = 'users';

	public function __construct($data = null){
		parent::__construct($data);
	}
}