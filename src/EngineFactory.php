<?php
namespace DoTheMath;
/**
 * Created by PhpStorm.
 * User: qitianpeng
 * Date: 2017/6/27
 * Time: 下午1:40
 */
class EngineFactory
{
    /**
     * @param $class
     * @return BCCompiler|BCEngine
     */
    public static function getInstance($class)
    {
        switch ($class){
            case 'BCEngine':
                return BCEngine::getInstance();
                break;
            case 'BCCompiler':
                return BCCompiler::getInstance();
                break;
            default:
                return BCEngine::getInstance();
        }
    }
}