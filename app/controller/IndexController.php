<?php
class IndexController extends Controller {
	function __construct(){
		parent::__construct();
	}

    public function index()
    {
        Cache::set('hello', 'hello', 5);
        return view('index', ['hello' => Cache::get('hello'), 'user' => model('users')->getOne('user_name')]);
    }
}