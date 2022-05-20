<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'         => ['required', 'string'],
            'description'   => ['required', 'string'],
            'status'        => ['required', 'string'],
            'project_id'    => ['required', 'integer'],
            'user_id'       => ['required', 'integer'],
        ];
    }
}
