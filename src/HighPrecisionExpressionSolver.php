<?php
namespace DoTheMath;
/**
 * Created by PhpStorm.
 * User: qitianpeng
 * Date: 2017/6/27
 * Time: 下午1:40
 */
/**
 * 高精度算数表达式解析器
 * Class HighPrecision
 */
class HighPrecisionExpressionSolver
{
    /**
     *默认精度8
     */
    const DEFAULT_PRECISION = 8;
    /**
     * 表达式
     * @var string
     */
    public $expression;

    /**
     * 精度
     * @var int
     */
    public $precision;

    /**
     * 解析引擎
     * @var BCEngine
     */
    public $engine;

    /**
     * HighPrecision constructor.
     * @param string $expression
     * @internal param int $precision
     * @internal param string $engine
     */
    public function __construct($expression='')
    {
        //表达式开头如果不是<?php, 加上<?php 便于获取Token
        if($expression != ''){
            $expression = trim($expression);
            if(substr($expression, 0, 5) != '<?php'){
                $expression = '<?php '.$expression;
            }
            $this->expression = $expression;
        }
        $this->precision = self::DEFAULT_PRECISION;
        $this->engine = EngineFactory::getInstance('BCEngine');
        $this->engine->setPrecision(self::DEFAULT_PRECISION);
        return $this;
    }

    /**
     * 设置表达式
     * @param $expression
     * @return $this
     */
    public function setExpression($expression)
    {
        $expression = trim($expression);
        if(substr($expression, 0, 5) != '<?php'){
            $expression = '<?php '.$expression;
        }
        $this->expression = $expression;
        return $this;
    }

    /**
     * 设置引擎
     * @param CalEngine $engine
     */
    public function setEngine(CalEngine $engine)
    {
        $this->engine = $engine;
    }

    /**
     * 获取运算符优先级
     * @param $op1
     * @param $op2
     * @return bool
     */
    public function greaterPrecedence($op1, $op2){
        $arr = [['('], ['+', '-'], ['*', '/', '%'], ['**']];
        $op1Value = 0;
        $op2Value = 0;
        foreach ($arr as $key=> $value){
            if(in_array($op1, $value)){
                $op1Value = $key;
            }
            if(in_array($op2, $value)){
                $op2Value = $key;
            }
        }
        return $op1Value >= $op2Value;
    }

    /**
     * 计算或者解析中缀表达式
     * @param $infix
     * @param $val1
     * @param $val2
     * @return string
     * @throws Exception
     */
    private function cal($infix, $val1, $val2){
        switch ($infix){
            case '+':
                return $this->engine->add($val1, $val2);
            case '-':
                return $this->engine->sub($val1, $val2);
            case '*':
                return $this->engine->mul($val1, $val2);
            case '/':
                return $this->engine->div($val1, $val2);
            case '%':
                return $this->engine->mod($val1, $val2);
            case '**':
                return $this->engine->pow($val1, $val2);
            default :
                throw new Exception('不支持的计算类型!');
        }
    }

    /**
     * 清洗PHP获取的token
     * @param $tokens
     * @throws Exception
     */
    private function cleanTokens(&$tokens){
        $lastToken = '';
        $parenthesesStack = new SplStack();
        $getPositive = false;
        foreach ($tokens as $key=> $eachToken){
            if($eachToken == '('){
                $parenthesesStack->push($eachToken);
            }elseif($eachToken == ')'){
                $parenthesesStack->pop();
            }
            if(is_array($eachToken)){
                $tokenName = token_name($eachToken[0]);
                if($tokenName != 'T_LNUMBER' && $tokenName != 'T_DNUMBER'){
                    if(token_name($eachToken[0]) == 'T_STRING'){
                        throw new Exception('哥们,暂时不支持+, -, *, /, %, **之外的运算');
                    }elseif(token_name($eachToken[0]) == 'T_POW'){
                        $tokens[$key] = $eachToken[1];
                        continue;
                    }
                    unset($tokens[$key]);
                    continue;
                }else{
                    if($lastToken == '-' && $getPositive){
                        $tokens[$key][1] = -$tokens[$key][1];
                        $getPositive = false;
                    }
                }
            }
            if(!is_array($lastToken) && $lastToken != '' && $eachToken == '-' && $lastToken != ')'){
                unset($tokens[$key]);
                $getPositive = true;
            }
            $lastToken = $eachToken;
        }
        if(!$parenthesesStack->isEmpty()){
            throw new Exception('哥们,表达式括号没闭合');
        }
    }

    /**
     * 获取解析结果
     * @return mixed
     * @throws Exception
     */
    protected function getResult()
    {
        $tokens = token_get_all($this->expression);
        try{
            $this->cleanTokens($tokens);
        }catch (Exception $e){
            throw $e;
        }
        $numbers = new SplStack();
        $operators = new SplStack();
        $calculateAndPush = function()use($operators, $numbers){
            $op = $operators->pop();
            $val1 = $numbers->pop();
            $val2 = $numbers->pop();
            $numbers->push($this->cal($op, $val2, $val1));
        };
        foreach ($tokens as $eachToken){
            if(is_array($eachToken)){
                $tokenName = token_name($eachToken[0]);
                if($tokenName == 'T_LNUMBER' || $tokenName == 'T_DNUMBER'){
                    $numbers->push($eachToken[1]);
                }
            }else{
                if($eachToken == '('){
                    $operators->push($eachToken);
                }elseif($eachToken == ')'){
                    while(!$operators->isEmpty() && $operators->top() != '('){
                        $j = $this->greaterPrecedence($operators->top(), $eachToken);
                        if($j){
                            $calculateAndPush();
                        }
                    }
                    if($operators->top() == '('){
                        $operators->pop();
                    }
                }else{
                    while(!$operators->isEmpty() && $topOp = $operators->top()){
                        $j = $this->greaterPrecedence($topOp, $eachToken);
                        if($j){
                            $calculateAndPush();
                        }else{
                            break;
                        }
                    }
                    $operators->push($eachToken);
                }
            }
        }
        while (!$operators->isEmpty()){
            $calculateAndPush();
        }
        $result = $numbers->pop();
        if(!$numbers->isEmpty() || !$operators->isEmpty()){
            throw new Exception('表达式存在错误,不能完成解析计算!');
        }
        return $result;
    }

    /**
     * 把表达式编译成bc表达式
     * @return mixed
     */
    public function compile()
    {
        if(!$this->engine instanceof BCCompiler){
            $this->setEngine(EngineFactory::getInstance('BCCompiler'));
        }
        return $this->getResult();
    }

    /**
     * 计算表达式的值
     * @return mixed
     */
    public function calculate()
    {
        if(!$this->engine instanceof BCEngine){
            $this->setEngine(EngineFactory::getInstance('BCEngine'));
        }
        return $this->getResult();
    }
}