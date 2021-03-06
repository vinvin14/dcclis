<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IARPostRequest extends FormRequest
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
        $id = null;
        if($this->iar) {
            $id = $this->iar->id;
        }
        return [
            'iar_number' => "required|max:255|unique:iar_table,iar_number,$id"
        ];

        
        // $rules = [
        //     'iar_number' => 'required|unique:iar_table|max:255',
            
        // ];

        // if (in_array($this->method(), ['PUT', 'PATCH'])) {
        //     $iar = $this->route()->parameter('product');

        //     $rules['name'] = [
        //         'required',
        //         'string',
        //         'max:255',
        //         Rule::unique('loan_products')->ignore($product),
        //     ];
        // }

        // return $rules;
    }

    public function messages()
    {
        if (@$this->iar) {
            return [
                'iar_number.unique' => "IAR number is already existing!"
            ];
        }
        else {
            return parent::messages(); // TODO: Change the autogenerated stub
        }


    }
}
