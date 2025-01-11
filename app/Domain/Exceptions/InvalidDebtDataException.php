<?php

namespace App\Domain\Exceptions;

class InvalidDebtDataException extends DomainException
{
    public function __construct(array $invalidData = [])
    {
        parent::__construct("Invalid Debt Data: " . json_encode($invalidData));
    }
}
