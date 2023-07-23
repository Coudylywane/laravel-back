<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;



class NiveauStoreRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
            return [
                'libelle' => ['required','string', 'unique:niveaux'],
                'cycle_id' => 'required|exists:cycles,id', // Vérifie si le cycle_id existe dans la colonne "id" de la table "cycles"
            ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(){
        return [
            'libelle.required' => 'Le libelle est obligatoire',
            'cycle_id.required' => 'Le cycle est obligatoire',
            'cycle_id.exists' => 'Le cycle n\'existe pas dans la base de donnees',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], 422)
        );
    }
}
