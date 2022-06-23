<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'b_fname' => 'required|max:255',
            'b_lname' => 'required|max:255',
            'b_email' => 'required|max:255',
            'b_mobile' => 'required|max:255',
            'b_addr_1' => 'required|max:255',
            'b_addr_2' => 'required|max:255',
            'b_country' => 'required|max:255',
            'b_city' => 'required|max:255',
            'b_state' => 'required|max:255',
            'b_zip' => 'required|max:255',
            's_fname' => 'required|max:255',
            's_lname' => 'required|max:255',
            's_email' => 'required|max:255',
            's_mobile' => 'required|max:255',
            's_addr_1' => 'required|max:255',
            's_addr_2' => 'required|max:255',
            's_country' => 'required|max:255',
            's_city' => 'required|max:255',
            's_state' => 'required|max:255',
            's_zip' => 'required|max:255',
        ];
    }
}
