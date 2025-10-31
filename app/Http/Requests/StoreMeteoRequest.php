<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMeteoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
{
    return [
        'localisation_id' => 'required|exists:localisations,id',
        'temperature' => 'required|numeric',
        'humidite' => 'required|numeric',
        'pression' => 'required|numeric',
        'description' => 'nullable|string|max:255',
    ];
}

  public function store(StoreMeteoRequest $request)
{
    Meteo::create($request->validated());
    return redirect()->route('meteo.index');
}
  
        
}
