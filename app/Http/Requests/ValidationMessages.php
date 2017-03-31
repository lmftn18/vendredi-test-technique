<?php

namespace App\Http\Requests;


class ValidationMessages
{
    static public function isRequired($fieldName)
    {
        return "Le champ ${fieldName} est obligatoire.";
    }
}