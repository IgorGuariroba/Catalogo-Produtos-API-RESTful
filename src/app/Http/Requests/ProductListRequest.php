<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductListRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:100',
            'sort' => 'string|in:id,name,price,created_at',
            'direction' => 'string|in:asc,desc',
            'name' => 'string|nullable'
        ];
    }

    public function messages(): array
    {
        return [
            'page.integer' => 'O número da página deve ser um valor inteiro.',
            'page.min' => 'O número da página deve ser pelo menos 1.',
            'per_page.integer' => 'O número de itens por página deve ser um valor inteiro.',
            'per_page.min' => 'O número mínimo de itens por página é 1.',
            'per_page.max' => 'O número máximo de itens por página é 100.',
            'sort.in' => 'O campo de ordenação deve ser um dos seguintes: id, name, price, created_at.',
            'direction.in' => 'A direção da ordenação deve ser asc ou desc.',
            'name.string' => 'O campo de pesquisa deve ser uma string.'
        ];
    }
}
