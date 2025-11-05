<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Inscrições</title>
    <style>
        /* Estilo básico para a tabela parecer um Excel */
        body { font-family: Arial, sans-serif; padding: 20px; }
        h1 { border-bottom: 2px solid #ccc; padding-bottom: 10px; }
        a.export-button {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse; /* Borda única */
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd; /* Bordas cinzas */
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2; /* Fundo cinza no cabeçalho */
        }
        tr:nth-child(even) {
            background-color: #f9f9f9; /* Linhas zebradas */
        }
    </style>
</head>
<body>

    <h1>Dashboard de Inscrições (Total: {{ $submissions->count() }})</h1>

    <a href="/admin/export" class="export-button">
        Baixar Arquivo Excel (.xlsx)
    </a>

    <table>
        <thead>
            <tr>
                <th>Data de Envio</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Área</th>
                <th>Nível</th>
                <th>Acertos (Total)</th>
                <th>Acertos (Fácil)</th>
                <th>Acertos (Médio)</th>
                <th>Acertos (Difícil)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($submissions as $sub)
                <tr>
                    <td>{{ $sub->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $sub->nome }}</td>
                    <td>{{ $sub->email }}</td>
                    <td>{{ $sub->selected_area }}</td>
                    <td>{{ $sub->calculated_level }}</td>
                    <td>{{ $sub->score_total }}</td>
                    <td>{{ $sub->score_facil }}</td>
                    <td>{{ $sub->score_media }}</td>
                    <td>{{ $sub->score_dificil }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>