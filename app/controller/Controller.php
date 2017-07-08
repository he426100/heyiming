<?php
class Controller {
	protected $db;

	public function __construct(){
		$this->db = Db::init();
	}
}