<?php
namespace App\Shared\Infra\Database;

class Filter extends Expression 
{
    /**
     * @var string
     */
    private string $variable;
    /**
     * @var string
     */
    private string $operator;
    /**
     * @var string
     */
    private string $value;

    /**
     * Filter constructor.
     * @param $variable
     * @param $operator
     * @param $value
     */
    public function __construct($variable, $operator, $value)
    {
        $this->variable = $variable;
        $this->operator = $operator;

        $this->value = $this->transform($value);
    }

    /**
     * @param $value
     * @return string
     */
    private function transform($value): string
    {
        $foo = array();
        if (is_array($value)){
            foreach ($value as $x){
                if(is_integer($x)){
                    $foo[] = $x;
                }
                else if (is_string($x)){
                    $foo[] = "'$x'";
                }
            }
            $result = '('. implode(', ', $foo) . ')';
        }
        else if (is_string($value)){
            $result = "'$value'";
        }
        else if (is_null($value)){
            $result = 'NULL';
        }
        else if (is_bool($value)){
            $result = $value ? 'TRUE' : 'FALSE';
        }
        else {
            $result = $value;
        }
        return $result;
    }

    /**
     * @return string
     */
    public function dump(): string
    {
        return "$this->variable $this->operator $this->value";
    }
}