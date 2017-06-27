<?php
require_once '../vendor/autoload.php';
use PHPUnit\Framework\TestCase;
use DoTheMath\HighPrecisionExpressionSolver;
/**
 * Created by PhpStorm.
 * User: qitianpeng
 * Date: 2017/6/27
 * Time: 下午3:23
 */
class HighPrecisionExpressionSolverTest extends TestCase
{
    public function testCalculate()
    {
        $hp = new HighPrecisionExpressionSolver();
        $hp->setExpression('1+2-3*4-18/9');
        $this->assertEquals('-11', $hp->calculate());
        $hp->setExpression('1+(2-3)*4-18/9');
        $this->assertEquals('-5', $hp->calculate());
        $hp->setExpression('1+(2-3*2+3)*4-18/9');
        $this->assertEquals('-5', $hp->calculate());
        $hp->setExpression('1+(2-3*2+3)-2*4-18/-9');
        $this->assertEquals('-6', $hp->calculate());
        $hp->setExpression('1+(2-3*2+3)-2**4-18/-9');
        $this->assertEquals('-14', $hp->calculate());
        $hp->setExpression('1.2+(2.5-3*2.0+3.0)-2.0**4-18.8/-9');
        $this->assertEquals('-13.21111112', $hp->calculate());
    }

    public function testCompiler()
    {
        $hp = new HighPrecisionExpressionSolver();
        $hp->setExpression('1+2-3*4-18/9');
        $this->assertEquals('bcsub(bcsub(bcadd(1, 2), bcmul(3, 4)), bcdiv(18, 9))', $hp->compile());
        $hp->setExpression('1+(2-3)*4-18/9');
        $this->assertEquals('bcsub(bcadd(1, bcmul(bcsub(2, 3), 4)), bcdiv(18, 9))', $hp->compile());
    }
}
