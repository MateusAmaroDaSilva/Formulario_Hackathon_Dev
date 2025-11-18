<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMentorRequest;
use Illuminate\Http\Request;
// 1. Importe o Controller base do Laravel
use Illuminate\Routing\Controller;

// 2. DÊ UM APELIDO para o seu Model para evitar conflito
use App\Models\HacktonMentores as MentorModel;

// 3. Sua classe DEVE extender 'Controller'
class HacktonMentores extends Controller
{
    /**
     * Mostra o formulário de cadastro.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Salva o novo mentor no banco de dados.
     */
    public function store(StoreMentorRequest $request)
    {
        try {
            // 4. Use o APELIDO (MentorModel) para chamar o Model
            MentorModel::create($request->validated());

            return redirect()->route('hackathon.mentor.store')
                         ->with('success', 'Mentor cadastrado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()
                         ->withErrors(['msg' => 'Erro ao salvar no banco de dados: ' . $e->getMessage()])
                         ->withInput();
        }
    }
}
