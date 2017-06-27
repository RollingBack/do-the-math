<?php
namespace DoTheMath;
/**
 * Created by PhpStorm.
 * User: qitianpeng
 * Date: 2017/6/27
 * Time: 下午1:35
 */
class Singleton
{
    /**
     * @var null
     */
    protected static $instance = null;

    /**
     * Singleton constructor.
     */
    private function __construct()
    {
    }

    /**
     *
     */
    private function __clone()
    {
    }

    /**
     * @return null|static
     */
    public static function getInstance()
    {
        if(self::$instance === null){
            self::$instance = new static();
        }
        return self::$instance;
    }
}