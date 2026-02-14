<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Aula;
use App\Models\AulaRecurso;
use App\Models\AulaCategoria;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AulaController extends Controller
{
    public function index()
    {
        $aulas = Aula::with(['categoria', 'recursos'])->latest()->get();
        $categorias = AulaCategoria::all();

        // Corrija aqui se estiver diferente
        return view('mentor.aulas.index', compact('aulas', 'categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'aula_categoria_id' => 'required|exists:aula_categorias,id',
            'arquivos.*' => 'nullable|file|max:20480', // Max 20MB por arquivo
        ]);

        // 1. Cria a Aula
        $aula = Aula::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'aula_categoria_id' => $request->aula_categoria_id,
            'data_prevista' => $request->data_prevista,
            'publicada' => $request->has('publicada'),
        ]);

        // 2. Processa Arquivos (SeaweedFS)
        if ($request->hasFile('arquivos')) {
            foreach ($request->file('arquivos') as $file) {
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                // Nome único para evitar sobrescrita
                $fileName = Str::random(15) . '.' . $extension;
                $path = "aulas/{$aula->id}/{$fileName}";

                Storage::disk('s3')->put($path, file_get_contents($file));

                $aula->recursos()->create([
                    'titulo' => $originalName,
                    'tipo' => 'arquivo',
                    'path' => $path,
                    'extensao' => $extension
                ]);
            }
        }

        // 3. Processa Links (URLs externas)
        if ($request->links) {
            foreach ($request->links as $index => $url) {
                if ($url) {
                    $aula->recursos()->create([
                        'titulo' => $request->link_titulos[$index] ?? 'Link de Apoio',
                        'tipo' => 'link',
                        'path' => $url,
                    ]);
                }
            }
        }

        SystemLog::create([
            'mentor_id' => Auth::guard('mentor')->id(),
            'acao' => 'Gestão de Aulas',
            'descricao' => 'Criou aula: ' . $aula->titulo,
            'ip_address' => request()->ip(),
        ]);

        return redirect()->back()->with('success', 'Aula criada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $aula = Aula::findOrFail($id);

        $request->validate([
            'titulo' => 'required|string|max:255',
            'aula_categoria_id' => 'required|exists:aula_categorias,id',
            'arquivos.*' => 'nullable|file|max:20480',
        ]);

        // 1. Atualiza dados básicos
        $aula->update([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'aula_categoria_id' => $request->aula_categoria_id,
            'data_prevista' => $request->data_prevista,
            'publicada' => $request->has('publicada'), // Checkbox marcado = true
        ]);

        // 2. Se enviou NOVOS arquivos, adiciona (não substitui os antigos)
        if ($request->hasFile('arquivos')) {
            foreach ($request->file('arquivos') as $file) {
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $fileName = Str::random(15) . '.' . $extension;
                $path = "aulas/{$aula->id}/{$fileName}";

                Storage::disk('s3')->put($path, file_get_contents($file));

                $aula->recursos()->create([
                    'titulo' => $originalName,
                    'tipo' => 'arquivo',
                    'path' => $path,
                    'extensao' => $extension
                ]);
            }
        }

        // 3. Se enviou NOVOS links
        if ($request->links) {
            foreach ($request->links as $index => $url) {
                if ($url) {
                    $aula->recursos()->create([
                        'titulo' => $request->link_titulos[$index] ?? 'Link de Apoio',
                        'tipo' => 'link',
                        'path' => $url,
                    ]);
                }
            }
        }

        SystemLog::create([
            'mentor_id' => Auth::guard('mentor')->id(),
            'acao' => 'Gestão de Aulas',
            'descricao' => 'Editou aula: ' . $aula->titulo,
            'ip_address' => request()->ip(),
        ]);

        return redirect()->back()->with('success', 'Aula atualizada com sucesso!');
    }

    public function destroy($id)
    {
        // BUSCAR PRIMEIRO (Isso permite que o Model dispare o evento de limpeza)
        $aula = Aula::findOrFail($id);
        $tituloAula = $aula->titulo;

        // AO CHAMAR ISSO, O CÓDIGO DO 'booted' LÁ EM CIMA É EXECUTADO AUTOMATICAMENTE
        $aula->delete();

        SystemLog::create([
            'mentor_id' => Auth::guard('mentor')->id(),
            'acao' => 'Gestão de Aulas',
            'descricao' => 'Excluiu aula: ' . $tituloAula,
            'ip_address' => request()->ip(),
        ]);

        return redirect()->back()->with('success', 'Aula e arquivos removidos com sucesso!');
    }

    /**
     * Cria nova categoria de aula
     */
    public function storeCategoria(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100|unique:aula_categorias,nome',
        ]);
        
        AulaCategoria::create([
            'nome' => $request->nome,
            'slug' => Str::slug($request->nome),
        ]);
        
        SystemLog::create([
            'mentor_id' => Auth::guard('mentor')->id(),
            'acao' => 'Gestão de Aulas',
            'descricao' => 'Criou categoria: ' . $request->nome,
            'ip_address' => request()->ip(),
        ]);
        
        return back()->with('success', 'Categoria criada com sucesso!');
    }

    /**
     * Atualiza categoria existente
     */
    public function updateCategoria(Request $request, $id)
    {
        $categoria = AulaCategoria::findOrFail($id);
        
        $request->validate([
            'nome' => "required|string|max:100|unique:aula_categorias,nome,{$id}",
        ]);
        
        $categoria->update([
            'nome' => $request->nome,
            'slug' => Str::slug($request->nome),
        ]);
        
        SystemLog::create([
            'mentor_id' => Auth::guard('mentor')->id(),
            'acao' => 'Gestão de Aulas',
            'descricao' => 'Editou categoria: ' . $categoria->nome,
            'ip_address' => request()->ip(),
        ]);
        
        return back()->with('success', 'Categoria atualizada!');
    }

    /**
     * Remove categoria (só se não tiver aulas vinculadas)
     */
    public function destroyCategoria($id)
    {
        $categoria = AulaCategoria::findOrFail($id);
        
        // Verifica se tem aulas vinculadas
        if ($categoria->aulas()->count() > 0) {
            return back()->with('error', 'Não é possível excluir categoria com aulas vinculadas.');
        }
        
        $nomeCategoria = $categoria->nome;
        $categoria->delete();
        
        SystemLog::create([
            'mentor_id' => Auth::guard('mentor')->id(),
            'acao' => 'Gestão de Aulas',
            'descricao' => 'Excluiu categoria: ' . $nomeCategoria,
            'ip_address' => request()->ip(),
        ]);
        
        return back()->with('success', 'Categoria removida!');
    }
}
