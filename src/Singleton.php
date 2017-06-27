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
     * CalEngine constructor.
     */
    private final function __construct() { }

    /**
     *
     */
    protected final function __clone() { }

    /**
     * @return null
     */
    public static function getInstance() {
        if(static::$instance === null){
            static::$instance = new static();
        }
        return static::$instance;
    }
}