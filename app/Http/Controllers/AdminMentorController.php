<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use App\Models\SystemLog; // Certifique-se de ter criado este Model no passo anterior
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Permission;

class AdminMentorController extends Controller
{
    /**
     * Lista todos os mentores e os logs do sistema.
     * TODOS os mentores podem visualizar.
     * Apenas quem tem 'gerenciar_equipe' pode editar/excluir.
     */
    public function index()
    {
        $mentores = Mentor::with('permissions')->get();

        // Busca todas as permissões para exibir no modal
        $todasPermissoes = Permission::all()->groupBy('group');

        return view('mentor.admin.index', compact('mentores', 'todasPermissoes'));
    }

    /**
     * Cria um novo mentor no banco de dados.
     */
    public function store(Request $request)
    {
        // Verifica permissão de gerenciar mentoes
        $user = Auth::guard('mentor')->user();
        if (!$user->hasPermission('manage_mentores')) {
            return back()->with('error', 'Você não tem permissão para cadastrar mentores.');
        }

        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:mentores,email',
            'password' => 'required|min:6',
            'funcao' => 'required|string'
        ]);

        $mentor = Mentor::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Criptografa a senha
            'funcao' => $request->funcao,
            'status' => 'ativo',
        ]);

        // Grava no Log
        $this->registrarLog('Criação', "Cadastrou o mentor: {$mentor->nome} ({$mentor->email})");

        return back()->with('success', 'Novo mentor cadastrado com sucesso!');
    }

    /**
     * Atualiza os dados de um mentor existente.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::guard('mentor')->user();
        
        // Verifica permissão de manage_mentores
        if (!$user->hasPermission('manage_mentores')) {
            return back()->with('error', 'Você não tem permissão para editar mentores.');
        }

        $mentor = Mentor::findOrFail($id);
        $isAdmin = $user->funcao === 'Admin';

        // PROTEÇÃO: Não-Admins não podem editar Admins
        if ($mentor->funcao === 'Admin' && !$isAdmin) {
            return back()->with('error', 'Apenas administradores podem editar outros administradores.');
        }

        // Validação básica (nome sempre necessário)
        $request->validate([
            'nome' => 'required|string',
        ]);
        
        // Se for Admin, valida email e função também
        if ($isAdmin) {
            $request->validate([
                'email' => "required|email|unique:mentores,email,{$id}",
                'funcao' => 'required|string'
            ]);
        }

        // PROTEÇÃO: Impede desativar a própria conta
        if ($user->id == $id && $request->status === 'inativo') {
            return back()->with('error', 'Você não pode desativar sua própria conta enquanto está logado.');
        }

        // Lógica para alterar senha apenas se o campo for preenchido
        if ($request->filled('password')) {
            $mentor->password = Hash::make($request->password);
        }

        // Monta array de atualização
        $updateData = [
            'nome' => $request->nome,
            'status' => $request->status ?? $mentor->status,
        ];
        
        // Apenas Admin pode atualizar email e função
        if ($isAdmin) {
            $updateData['email'] = $request->email;
            $updateData['funcao'] = $request->funcao;
        }

        $mentor->update($updateData);

        // Grava no Log
        $this->registrarLog('Edição', "Atualizou dados do mentor: {$mentor->nome}");

        return back()->with('success', 'Dados atualizados.');
    }

    /**
     * Remove um mentor.
     */
    public function destroy($id)
    {
        $user = Auth::guard('mentor')->user();
        
        // Verifica se tem permissão de manage_mentores
        if (!$user->hasPermission('manage_mentores')) {
            return back()->with('error', 'Você não tem permissão para excluir mentores.');
        }

        // Segurança: Impede que você exclua sua própria conta logada
        if ($user->id == $id) {
            return back()->with('error', 'Você não pode excluir sua própria conta.');
        }

        $mentor = Mentor::findOrFail($id);
        
        // PROTEÇÃO: Não-Admins não podem excluir Admins
        if ($mentor->funcao === 'Admin' && $user->funcao !== 'Admin') {
            return back()->with('error', 'Apenas administradores podem excluir outros administradores.');
        }
        
        $nomeBkp = $mentor->nome;

        $mentor->delete();

        // Grava no Log
        $this->registrarLog('Exclusão', "Removeu o mentor: {$nomeBkp}");

        return back()->with('success', 'Mentor removido.');
    }

    /**
     * Função auxiliar privada para registrar logs.
     */
    private function registrarLog($acao, $descricao)
    {
        SystemLog::create([
            'mentor_id' => Auth::guard('mentor')->id(),
            'acao' => $acao,
            'descricao' => $descricao,
            'ip_address' => request()->ip()
        ]);
    }

    public function updatePermissions(Request $request, $id)
    {
        $user = Auth::guard('mentor')->user();
        
        // Verifica se tem permissão de gerenciar equipe
        if (!$user->hasPermission('gerenciar_equipe')) {
            abort(403, 'Você não tem permissão para gerenciar acessos.');
        }

        $mentor = Mentor::findOrFail($id);

        // PROTEÇÃO: Não permite editar permissões de Admins
        if ($mentor->isAdmin()) {
            return back()->with('error', 'Administradores possuem todas as permissões automaticamente e não podem ser editadas.');
        }

        // Sincroniza permissões
        $mentor->permissions()->sync($request->permissions ?? []);

        // Grava no Log
        $this->registrarLog('Permissões', "Alterou as permissões de: {$mentor->nome}");

        return back()->with('success', 'Permissões atualizadas com sucesso!');
    }
}
