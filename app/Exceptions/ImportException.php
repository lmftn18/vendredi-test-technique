<?php

namespace App\Exceptions;

class ImportException extends VendrediException
{
    public function addLineNumber($lineNumber)
    {
        $this->message = "Ligne ${lineNumber} - " . $this->message;

        return $this;
    }

    public function setFieldsCannotBeBeEmpty($requiredFields, $lineNumber)
    {
        $this->message = 'Import stoppé, les champs suivants ne peuvent pas être nuls: <br>- ' . implode('<br>- ', $requiredFields);
        $this->addLineNumber($lineNumber);

        return $this;
    }
}