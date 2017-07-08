<?php
function view($view, $params = []){
	$_view = new View($view, $params);
	$_view->display();
}
function model($model, $params = null){
	$model = ucfirst($model).'Model';
	return new $model($params);
}