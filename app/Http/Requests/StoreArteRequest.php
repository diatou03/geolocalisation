<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArteRequest extends FormRequest
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
        'nom' => 'required|string|max:255',
        'description' => 'nullable|string',
        'type' => 'required|string|max:100',
        'date_creation' => 'required|date',
    ];
}
public function store(StoreArteRequest $request)
{
    Arte::create($request->validated());
    return redirect()->route('artes.index')
                     ->with('success', 'Arte créé avec succès.');
}

}
