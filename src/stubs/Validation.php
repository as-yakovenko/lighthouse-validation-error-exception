<?php

namespace App\Validations;

use Yakovenko\ValidationErrorException\ValidationDefault;

trait Validation
{
    use ValidationDefault;
    
    /**
     * This trait provides custom business logic validations.
     *
     * You can define various methods within this trait to handle
     * specific validation rules or logic that are unique to your
     * application's business requirements. By including this trait,
     * the implementing class can leverage the methods from 
     * ValidationErrorException and add additional validation logic
     * as needed.
     */
}