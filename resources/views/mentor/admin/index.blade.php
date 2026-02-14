@extends('layouts.mentor')

@section('title', 'Gestão de Mentores')

@section('content')
    <header class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Equipe Administrativa</h1>
            <p class="text-gray-500 text-sm">Gerencie quem tem acesso ao painel.</p>
        </div>

        <button onclick="openModal('modal-novo-mentor')"
                class="bg-slate-800 text-white px-4 py-2 rounded hover:bg-slate-900 shadow flex items-center gap-2 transition">
            <i class="fas fa-user-plus"></i> Novo Mentor
        </button>
    </header>

    <div class="bg-white rounded-lg shadow overflow-hidden mb-10">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100 border-b border-gray-200">
                <tr>
                    <th class="p-4 text-sm font-semibold text-gray-600">Mentor</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Função</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Status</th>
                    <th class="p-4 text-sm font-semibold text-gray-600 text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($mentores as $m)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 flex items-center gap-3">
                        {{-- Foto do Mentor via Proxy ou Avatar padrão --}}
                        @if($m->foto)
                            <img src="{{ route('mentor.foto.proxy', basename($m->foto)) }}"
                                 class="w-10 h-10 rounded-full object-cover border border-gray-200 shadow-sm"
                                 onerror="this.src='http://ui-avatars.com/api/?name={{ urlencode($m->nome) }}&background=random'"
                                 alt="Foto de {{ $m->nome }}">
                        @else
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold border border-blue-200 text-xs">
                                {{ substr($m->nome, 0, 2) }}
                            </div>
                        @endif

                        <div>
                            <p class="font-bold text-gray-800 flex items-center gap-2">
                                {{ $m->nome }}
                                @if($m->funcao === 'Admin')
                                @endif
                            </p>
                            <p class="text-xs text-gray-500">{{ $m->email }}</p>
                        </div>
                    </td>
                    <td class="p-4 text-sm">
                        @if($m->funcao === 'Admin')
                            <span class="px-2 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700 flex items-center gap-1 w-fit">
                                <i class="fas fa-crown"></i> {{ $m->funcao }}
                            </span>
                        @else
                            <span class="text-gray-600">{{ $m->funcao }}</span>
                        @endif
                    </td>
                    <td class="p-4">
                        <span class="px-2 py-1 rounded-full text-xs font-bold {{ $m->status == 'ativo' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($m->status) }}
                        </span>
                    </td>
                    <td class="p-4 text-right">
                        @if(Auth::guard('mentor')->user()->funcao === 'Admin')
                            <button onclick="openPermissionsModal({{ $m->id }}, '{{ $m->nome }}', {{ $m->permissions->pluck('id') }})"
                                    class="text-purple-600 hover:bg-purple-100 p-2 rounded transition" title="Gerenciar Acessos">
                                <i class="fas fa-lock"></i>
                            </button>
                        @endif

                        {{-- Botão EDITAR: Apenas se tiver permissão manage_mentores --}}
                        @if(Auth::guard('mentor')->user()->hasPermission('manage_mentores'))
                            @php
                                $podeEditar = true;
                                $isAdmin = Auth::guard('mentor')->user()->funcao === 'Admin';
                                
                                // Não-Admins não podem editar Admins
                                if ($m->funcao === 'Admin' && !$isAdmin) {
                                    $podeEditar = false;
                                }
                            @endphp
                            
                            @if($podeEditar)
                                <button onclick="openEditMentor({{ $m->id }}, '{{ $m->nome }}', '{{ $m->email }}', '{{ $m->funcao }}', '{{ $m->status }}')"
                                        class="text-blue-500 hover:bg-blue-100 p-2 rounded transition" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                            @else
                                <span class="text-gray-300 p-2 cursor-not-allowed" title="Apenas Admins podem editar outros Admins">
                                    <i class="fas fa-edit"></i>
                                </span>
                            @endif
                        @endif

                        {{-- Botão EXCLUIR: Apenas se tiver permissão manage_mentores E não for excluir a si mesmo --}}
                        @if(Auth::guard('mentor')->user()->hasPermission('manage_mentores') && Auth::guard('mentor')->id() !== $m->id)
                            @php
                                $podeExcluir = true;
                                $isAdmin = Auth::guard('mentor')->user()->funcao === 'Admin';
                                
                                // Não-Admins não podem excluir Admins
                                if ($m->funcao === 'Admin' && !$isAdmin) {
                                    $podeExcluir = false;
                                }
                            @endphp
                            
                            @if($podeExcluir)
                                <form action="{{ route('admin.mentores.destroy', $m->id) }}" method="POST" class="inline-block" onsubmit="return confirm('ATENÇÃO: Isso removerá o acesso deste mentor. Continuar?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:bg-red-100 p-2 rounded transition" title="Remover">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-300 p-2 cursor-not-allowed" title="Apenas Admins podem excluir outros Admins">
                                    <i class="fas fa-trash-alt"></i>
                                </span>
                            @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Modal Novo Mentor --}}
    <div id="modal-novo-mentor" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
            <div class="bg-slate-900 text-white px-6 py-4 flex justify-between items-center rounded-t-lg">
                <h3 class="font-bold">Cadastrar Novo Mentor</h3>
                <button onclick="closeModal('modal-novo-mentor')" class="text-gray-400 hover:text-white">&times;</button>
            </div>
            <form action="{{ route('admin.mentores.store') }}" method="POST" class="p-6">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nome</label>
                    <input type="text" name="nome" required class="w-full border rounded p-2 focus:ring-slate-500 focus:border-slate-500">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required class="w-full border rounded p-2 focus:ring-slate-500 focus:border-slate-500">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Função</label>
                    <select name="funcao" class="w-full border rounded p-2 focus:ring-slate-500 focus:border-slate-500">
                        <option value="Mentor">Mentor</option>
                        <option value="Coordenador">Coordenador</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Senha Inicial</label>
                    <input type="password" name="password" required minlength="6" class="w-full border rounded p-2 focus:ring-slate-500 focus:border-slate-500" placeholder="Mínimo de 6 caracteres">
                    <p class="text-xs text-gray-500 mt-1"><i class="fas fa-info-circle"></i> A senha deve ter no mínimo 6 caracteres.</p>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal('modal-novo-mentor')" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-slate-800 text-white rounded hover:bg-slate-700">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Editar Mentor --}}
    <div id="modal-editar-mentor" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
            <div class="bg-slate-800 text-white px-6 py-4 flex justify-between items-center rounded-t-lg">
                <h3 class="font-bold">Editar Mentor</h3>
                <button onclick="closeModal('modal-editar-mentor')" class="text-gray-400 hover:text-white">&times;</button>
            </div>
            <form id="form-editar-mentor" method="POST" class="p-6">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nome</label>
                    <input type="text" name="nome" id="edit_nome" required class="w-full border rounded p-2">
                </div>
                
                {{-- EMAIL: Apenas Admin pode editar --}}
                <div class="mb-3" id="email-field-container">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="edit_email" required class="w-full border rounded p-2">
                </div>
                
                <div class="grid grid-cols-2 gap-3 mb-3">
                    {{-- FUNÇÃO: Apenas Admin pode editar --}}
                    <div id="funcao-field-container">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Função</label>
                        <select name="funcao" id="edit_funcao" class="w-full border rounded p-2">
                            <option value="Mentor">Mentor</option>
                            <option value="Coordenador">Coordenador</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Status</label>
                        <select name="status" id="edit_status" class="w-full border rounded p-2">
                            <option value="ativo">Ativo</option>
                            <option value="inativo">Inativo</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nova Senha (Opcional)</label>
                    <input type="password" name="password" minlength="6" placeholder="Deixe em branco para manter" class="w-full border rounded p-2">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal('modal-editar-mentor')" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Permissões --}}
    <div id="modal-permissions" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4">
            <div class="bg-purple-900 text-white px-6 py-4 flex justify-between items-center rounded-t-lg">
                <div>
                    <h3 class="font-bold">Controle de Acesso</h3>
                    <p class="text-xs text-purple-200" id="perm-mentor-name">Carregando...</p>
                </div>
                <button onclick="closeModal('modal-permissions')" class="text-purple-200 hover:text-white">&times;</button>
            </div>

            <form id="form-permissions" method="POST" class="p-6">
                @csrf @method('PUT')
                <div class="space-y-4 max-h-[60vh] overflow-y-auto">
                    @if(isset($todasPermissoes))
                        @foreach($todasPermissoes as $grupo => $permissoes)
                            <div class="border-b pb-2">
                                <h4 class="font-bold text-gray-500 text-xs uppercase mb-2">{{ $grupo }}</h4>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach($permissoes as $p)
                                        <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-50 p-2 rounded transition">
                                            <input type="checkbox" name="permissions[]" value="{{ $p->id }}" class="perm-checkbox form-checkbox text-purple-600 rounded">
                                            <span class="text-sm text-gray-700">{{ $p->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" onclick="closeModal('modal-permissions')" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">Salvar Permissões</button>
                </div>
            </form>
        </div>
    </div>



    <script>
        function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
        function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

        function openEditMentor(id, nome, email, funcao, status) {
            const userFuncao = '{{ Auth::guard('mentor')->user()->funcao }}';
            const isAdmin = userFuncao === 'Admin';
            
            // Preenche formulário
            document.getElementById('edit_nome').value = nome;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_funcao').value = funcao;
            document.getElementById('edit_status').value = status;
            document.getElementById('form-editar-mentor').action = "{{ route('admin.mentores.index') }}/" + id;
            
            // Se NÃO for Admin, esconde campos de email e função
            const emailContainer = document.getElementById('email-field-container');
            const funcaoContainer = document.getElementById('funcao-field-container');
            
            if (!isAdmin) {
                // Esconde visualmente email e função
                emailContainer.style.display = 'none';
                funcaoContainer.style.display = 'none';
                
                // Remove o atributo 'required' do email para não bloquear submit
                document.getElementById('edit_email').removeAttribute('required');
            } else {
                // Admin vê tudo
                emailContainer.style.display = 'block';
                funcaoContainer.style.display = 'block';
                document.getElementById('edit_email').setAttribute('required', 'required');
            }
            
            openModal('modal-editar-mentor');
        }

        function openPermissionsModal(id, nome, userPermissions) {
            document.getElementById('perm-mentor-name').innerText = "Definindo acessos para: " + nome;
            document.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = false);
            userPermissions.forEach(permId => {
                let check = document.querySelector(`.perm-checkbox[value="${permId}"]`);
                if(check) check.checked = true;
            });
            document.getElementById('form-permissions').action = "{{ route('admin.mentores.index') }}/" + id + "/permissoes";
            openModal('modal-permissions');
        }
    </script>
@endsection
