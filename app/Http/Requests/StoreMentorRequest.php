<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Importante para validar o array

class StoreMentorRequest extends FormRequest
{
    /**
     * Permite que todos os usuários tentem validar.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Define as regras de validação.
     */
    public function rules(): array
    {
        // Define os únicos valores que aceitaremos para disponibilidade
        $periodosValidos = [
            '29_manha', '29_tarde', '29_noite', '29_madrugada',
            '30_manha', '30_tarde', '30_noite', '30_madrugada',
        ];

        return [
            // Validação dos campos normais
            'nome'          => ['required', 'string', 'max:255'],
            'rg'            => ['required', 'string', 'max:20', 'unique:hackathonMentores,rg'],
            'instituicao'   => ['required', 'string', 'max:255'],
            'especialidade' => ['required', 'string', 'max:255'],

            // Validação da disponibilidade (obrigatório, deve ser um array)
            'disponibilidade'   => ['required', 'array', 'min:1'],

            // Validação de CADA item dentro do array 'disponibilidade'
            'disponibilidade.*' => ['string', Rule::in($periodosValidos)],
        ];
    }

    /**
     * Mensagens de erro personalizadas.
     */
    public function messages(): array
    {
        return [
            'nome.required'             => 'O campo nome é obrigatório.',
            'rg.unique'                 => 'Este RG já está cadastrado.',
            'disponibilidade.required'  => 'Você deve selecionar pelo menos um período de disponibilidade.',
            'disponibilidade.*.in'      => 'Um dos períodos de disponibilidade selecionados é inválido.',
        ];
    }

    /**
     * (Opcional) Para a validação 'rg' funcionar
     * com dígito verificador para todos os estados, instale:
     * composer require laravel-brasil/validation
     *
     * E mude a regra 'rg' para:
     * 'rg' => ['nullable', 'string', 'max:20', 'unique:hackathon_mentores,rg', 'rg'],
     */
}
