<?php
class View {
	protected $view ;
	protected $variables = [];

	public function __construct($view, $variables = []){
		$this->view = $view;
		$this->variables = $variables;
	}

	public function display(){
		extract($this->variables);
        include (APP_PATH . 'app/view/' . $this->view . '.php');
	}
}