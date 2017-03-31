<?php

namespace Tests\App\Http\Controllers\Admin;

use Tests\TestCase;

abstract class BaseCrudControllerTest extends TestCase
{
    protected $saveButtonText;

    public function setUp()
    {
        parent::setUp();

        $this->saveButtonText = 'Enregistrer et revenir à la liste';
    }
}