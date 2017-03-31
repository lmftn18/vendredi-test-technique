<?php

namespace App\Http\Requests;

use App\Http\Controllers\Admin\SchoolCrudController;
use Backpack\CRUD\app\Http\Requests\CrudRequest;

class SchoolRequest extends CrudRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
             'value' => 'required|max:255'
        ];
    }

    public function attributes()
    {
        return [
            'value' => SchoolCrudController::SINGLE_NAME,
        ];
    }
}
