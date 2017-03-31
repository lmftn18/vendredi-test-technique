<?php

namespace App\Http\Requests;


use App\Http\Controllers\Admin\EducationCrudController;
use App\Http\Controllers\Admin\SchoolCrudController;
use App\Http\Controllers\Admin\UserCrudController;
use Backpack\CRUD\app\Http\Requests\CrudRequest;

class CandidateRequest extends CrudRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
             'user_id' => 'required',
             'school_id' => 'required',
             'education_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'user_id' => UserCrudController::SINGLE_NAME,
            'school_id' => SchoolCrudController::SINGLE_NAME,
            'education_id' => EducationCrudController::SINGLE_NAME,
        ];
    }
}
