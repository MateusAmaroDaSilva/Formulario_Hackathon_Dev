<?php

namespace App\Http\Controllers;

use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SystemLogController extends Controller
{
    /**
     * Exibe página de logs de auditoria (apenas para Admin)
     */
    public function index(Request $request)
    {
        $user = Auth::guard('mentor')->user();
        
        // Verifica se é Admin
        if (!$user->isAdmin()) {
            abort(403, 'Apenas administradores podem acessar os logs de auditoria');
        }
        
        // Filtro por tipo de ação
        $filtroAcao = $request->get('acao');
        
        $logsQuery = SystemLog::with('mentor')->latest();
        
        if ($filtroAcao) {
            $logsQuery->where('acao', $filtroAcao);
        }
        
        $logs = $logsQuery->paginate(50);
        
        // Agrupa logs por tipo de ação para os filtros
        $tiposAcao = SystemLog::select('acao')
            ->distinct()
            ->orderBy('acao')
            ->pluck('acao');
        
        return view('mentor.logs.index', compact('logs', 'tiposAcao', 'filtroAcao'));
    }
}
