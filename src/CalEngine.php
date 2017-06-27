<?php
namespace DoTheMath;
/**
 * Created by PhpStorm.
 * User: qitianpeng
 * Date: 2017/6/27
 * Time: 下午1:36
 */
abstract class CalEngine extends Singleton
{
    /**
     * 设置精度
     * @param $precision
     * @return mixed
     */
    abstract function setPrecision($precision);

    /**
     * 加法计算
     * @param $value1
     * @param $value2
     * @return mixed
     */
    abstract function add($value1, $value2);

    /**
     * 减法计算
     * @param $value1
     * @param $value2
     * @return mixed
     */
    abstract function sub($value1, $value2);

    /**
     * 乘法计算
     * @param $value1
     * @param $value2
     * @return mixed
     */
    abstract function mul($value1, $value2);

    /**
     * 除法计算
     * @param $value1
     * @param $value2
     * @return mixed
     */
    abstract function div($value1, $value2);

    /**
     * 求模计算
     * @param $value1
     * @param $value2
     * @return mixed
     */
    abstract function mod($value1, $value2);

    /**
     * 乘方计算
     * @param $value1
     * @param $value2
     * @return mixed
     */
    abstract function pow($value1, $value2);
}