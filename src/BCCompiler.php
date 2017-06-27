<?php
namespace DoTheMath;
/**
 * Created by PhpStorm.
 * User: qitianpeng
 * Date: 2017/6/27
 * Time: 下午1:39
 */
class BCCompiler
{
    /**
     * @var null
     */
    protected static $instance = null;

    /**
     * 设置精度
     * @param $precision
     * @return mixed
     */
    function setPrecision($precision)
    {
        //do nothing
    }

    /**
     * 加法计算
     * @param $value1
     * @param $value2
     * @return mixed
     */
    function add($value1, $value2)
    {
        return "bcadd($value1, $value2)";
    }

    /**
     * 减法计算
     * @param $value1
     * @param $value2
     * @return mixed
     */
    function sub($value1, $value2)
    {
        return "bcsub($value1, $value2)";
    }

    /**
     * 乘法计算
     * @param $value1
     * @param $value2
     * @return mixed
     */
    function mul($value1, $value2)
    {
        return "bcmul($value1, $value2)";
    }

    /**
     * 除法计算
     * @param $value1
     * @param $value2
     * @return mixed
     */
    function div($value1, $value2)
    {
        return "bcdiv($value1, $value2)";
    }

    /**
     * 求模计算
     * @param $value1
     * @param $value2
     * @return mixed
     */
    function mod($value1, $value2)
    {
        return "bcmod($value1, $value2)";
    }

    /**
     * 乘方计算
     * @param $value1
     * @param $value2
     * @return mixed
     */
    function pow($value1, $value2)
    {
        return "bcpow($value1, $value2)";
    }
}