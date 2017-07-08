<?php
/**
 * 框架核心
 */
class Heyiming{
	protected $_config = ['db' => [], 'timezone' => 'PRC'];

	public function __construct($config = []){
		if(!empty($config)){
			$this->_config = array_merge($this->_config, $config);
		}
		//设置时区
		date_default_timezone_set($this->_config['timezone']);
	}

	/**
	 * 运行程序
	 * @return [type] [description]
	 */
	public function run(){
		spl_autoload_register(array($this, 'loadClass'));
		$this->removeMagicQuotes();
		$this->registerErrorHandle();
		$this->setCacheHandle();
		$this->setDbConfig();
		$this->loadHelper();
		$this->route();
	}

	/**
	 * 路由处理
	 */
	public function route(){
		$controllerName = $this->_config['defaultController'];
		$actionName = $this->_config['defaultAction'];
		$param = array();

		$url = $_SERVER['REQUEST_URI'];
		// 清除?之后的内容
		$position = strpos($url, '?');
		$url = $position === false ? $url : substr($url, 0, $position);
		//删除前后的'/'
		$url = trim($url, '/');

		if(!empty($url)){
			//使用'/'分隔字符串并存入数组
			$urlArr = explode('/', $url);
			//删除空的数组元素
			$urlArr = array_filter($urlArr);
			//获取控制器名
			$controllerName = ucfirst($urlArr[0]);
			//获取动作名
			array_shift($urlArr);
			$actionName = !empty($urlArr) ? $urlArr[0] : $actionName;
			//获取url参数
			array_shift($urlArr);
			$param = !empty($urlArr) ? $urlArr : [];
		}
		//判断控制器和操作是否存在
		$controller = $controllerName . 'Controller';
		if(!class_exists($controller)){
			exit($controller.'控制器不存在');
		}
		if(!method_exists($controller, $actionName)){
			exit($actionName.'方法不存在');
		}

		try{
			//如果控制器和操作名存在，则是李华控制器，因为控制器对象里面还会用到控制器名和操作名，所以实例化的时候把他们两的名称也传进去，结合controller基类一起看
			$dispatch = new $controller();
			//$diapatch保存控制器实例化后的对象，我们就可以调用它的方法，也可以向方法中传入参数，以下等同于;$dispatch->$actionName($param)
			$this->send(call_user_func_array(array($dispatch, $actionName), $param));
		} catch(Exception $e){
			if($e instanceof HttpResponseException){
				header("Location: ".$e->getMessage()."\r\n");
				exit();
			}
			$this->send($e->getMessage());
		}
	}

	/**
	 * 检测开发环境
	 */
	public function registerErrorHandle(){
		Error::register();
	}

	/**
	 * 注册缓存处理
	 */
	public function setCacheHandle(){
		Cache::init();
	}

	/**
	 * 删除敏感字符
	 * @param  mixed $value
	 * @return mixed
	 */
	public function stripSlashesDeep($value){
		return is_array($value) ? array_map(array($this, 'stripSlashesDeep'), $value) : stripslashes($value);
	}

	/**
	 * 检测敏感字符并删除
	 * @return [type] [description]
	 */
	public function removeMagicQuotes(){
		if(get_magic_quotes_gpc()){
			$_GET = isset($_GET) ? $this->stripSlashesDeep($_GET) : [];
			$_POST = isset($_GET) ? $this->stripSlashesDeep($_POST) : [];
			$_COOKIE = isset($_GET) ? $this->stripSlashesDeep($_COOKIE) : [];
			$_SESSION = isset($_GET) ? $this->stripSlashesDeep($_SESSION) : [];
		}
	}

	/**
	 * 数据库初始化
	 */
	public function setDbConfig(){
		Db::init();
	}

	protected function loadHelper(){
		include __DIR__.'/library/helper.php';
	}

	/**
	 * 输出响应内容
	 * @param  string $response [description]
	 * @return [type]           [description]
	 */
	protected function send($response = ''){
		if(!is_null($response) && !is_string($response)){
			echo json_encode($response);
		} else {
			echo $response;
		}
		exit();
	}

	/**
	 * 自动加载控制器类和模型类
	 * @return [type] [description]
	 */
	public function loadClass($class){
		$framework = __DIR__.'/library/'.$class.'.php';
		$controller = APP_PATH.'app/controller/'.$class.'.php';
		$model = APP_PATH.'app/model/'.$class.'.php';

		if(file_exists($framework)){
			include $framework;
		} elseif(file_exists($controller)){
			include $controller;
		} elseif(file_exists($model)){
			include $model;
		} else {
			//错误代码
		}
	}
}