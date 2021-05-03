<?php
namespace App\Shared\Infra\Database;

abstract class Expression
{
    /**
     *
     */
    const AND_OPERATOR = 'AND ';
    /**
     *
     */
    const OR_OPERATOR = 'OR ';

    /**
     * @return string
     */
    abstract public function dump(): ?string;
}