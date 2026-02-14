@extends('layouts.mentor')

@section('title', 'Acesso Negado')

@section('content')
<div class="flex items-center justify-center min-h-[60vh]">
    <div class="text-center max-w-md px-4">
        {{-- Ícone de Bloqueio --}}
        <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6 border-4 border-red-200 shadow-lg">
            <i class="fas fa-lock text-4xl text-red-500"></i>
        </div>
        
        {{-- Título --}}
        <h1 class="text-3xl md:text-4xl font-black text-slate-800 mb-3">Acesso Negado</h1>
        
        {{-- Mensagem --}}
        <p class="text-slate-600 mb-6 text-sm md:text-base">
            Você não possui permissão para acessar esta funcionalidade.
        </p>
        
        {{-- Box de Informação --}}
        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-6 text-left">
            <p class="text-sm text-amber-800 flex items-start gap-2">
                <i class="fas fa-info-circle mt-0.5 shrink-0"></i>
                <span>
                    <strong class="block mb-1">Precisa de acesso?</strong>
                    Entre em contato com um administrador da plataforma para solicitar as permissões necessárias.
                </span>
            </p>
        </div>
        
        {{-- Botão de Voltar --}}
        <a href="{{ route('mentor.dashboard') }}" 
           class="inline-block bg-slate-800 text-white px-6 py-3 rounded-lg hover:bg-slate-900 transition font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transform text-sm md:text-base">
            <i class="fas fa-arrow-left mr-2"></i>
            Voltar ao Dashboard
        </a>
    </div>
</div>
@endsection
