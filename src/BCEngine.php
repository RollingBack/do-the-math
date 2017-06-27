<?php
namespace DoTheMath;
/**
 * Created by PhpStorm.
 * User: qitianpeng
 * Date: 2017/6/27
 * Time: 下午1:38
 */
class BCEngine extends CalEngine
{
    /**
     * @var null
     */
    protected static $instance = null;
    /**
     * @param $precision
     * @return mixed|void
     */
    function setPrecision($precision)
    {
        bcscale($precision);
    }

    /**
     * @param $value1
     * @param $value2
     * @return string
     */
    function add($value1, $value2)
    {
        return bcadd($value1, $value2);
    }

    /**
     * @param $value1
     * @param $value2
     * @return string
     */
    function sub($value1, $value2)
    {
        return bcsub($value1, $value2);
    }

    /**
     * @param $value1
     * @param $value2
     * @return string
     */
    function mul($value1, $value2)
    {
        return bcmul($value1, $value2);
    }

    /**
     * @param $value1
     * @param $value2
     * @return string
     */
    function div($value1, $value2)
    {
        return bcdiv($value1, $value2);
    }

    /**
     * @param $value1
     * @param $value2
     * @return string
     */
    function mod($value1, $value2)
    {
        return bcmod($value1, $value2);
    }

    /**
     * @param $value1
     * @param $value2
     * @return string
     */
    function pow($value1, $value2)
    {
        return bcpow($value1, $value2);
    }
}