<?php
class Db
{
    protected static $instance;
    /**
     * 获取实例
     * @return void
     */
    public static function init()
    {
        if (is_null(self::$instance)) {
        	self::$instance = new MysqliDb ([
	            'host' => $GLOBALS['config']['db']['db_host'],
	            'username' => $GLOBALS['config']['db']['db_user'], 
	            'password' => $GLOBALS['config']['db']['db_pass'],
	            'db'=> $GLOBALS['config']['db']['db_name'],
	            'prefix' => $GLOBALS['config']['db']['prefix'],
	        ]);
        }
        return self::$instance;
    }
    public static function where($where){
        $instance = self::init();
        foreach ($where as $key => $vo) {
            if(is_int($key)){
                $instance->where($vo);
            }
            if(is_array($vo)){
                $instance->where($key, $vo[0], $vo[1]);
            } else {
                $instance->where($key, $vo);
            }
        }
        return $instance;
    }

    public static function select($table, $where = [], $columns = '*', $numRows = null){
        $instance = self::where($where);
        return $instance->get($table, $numRows, $columns);
    }

    public static function find($table, $where = [], $columns = '*'){
        $instance = self::where($where);
        return $instance->getOne($table, $columns);
    }

    public static function value($table, $where = [], $column = null){
        if(is_string($where)){
            $column = $where;
            $where = [];
        }
        $instance = self::where($where);
        return $instance->getValue($table, $column);
    }

    public static function column($table, $where = [],$column = null){
        if(is_string($where)){
            $column = $where;
            $where = [];
        }
        $instance = self::where($where);
        return $instance->getValue($table, $column, null);
    }
}