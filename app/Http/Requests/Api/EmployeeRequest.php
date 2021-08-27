<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required|string|max:255',
            'gender'    => 'required|in:male,female',
        ];
    }

    /**
     * Action when validation is failed
     * 
     * @param \Illuminate\Contracts\Validation\Validator
     * @return \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $this->setErrorMessageForClient($validator->errors());

        throw new HttpResponseException(response()->json($this->getErrorMessageForClient(), 422));
    }

    /**
     * Setter error message for client
     * 
     * @param array errors data that getted from validator->errors()
     * @return array error message for client
     */
    private function setErrorMessageForClient($errorsData)
    {
        $errorsData         = collect($errorsData);
        $responseErrorsData = [];

        foreach( $errorsData as $key => $errorData ) {
            $responseErrorsData[$key] = $errorData[0];
        }

        $this->errorMessageForClient = [
            'message'      => 'Errors, the given data was invalid',
            'errors'       => $responseErrorsData
        ];

        return $this->errorMessageForClient;
    }

    /**
     * Getter error message for client
     * 
     * @return array error message for client
     */
    private function getErrorMessageForClient()
    {
        return $this->errorMessageForClient;
    }
}
