<!DOCTYPE html>
<html>
<head>
    <title>Relatório</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        div.page-break {
            page-break-before: always;
        }

        div.footer {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div style="text-align: center; margin-bottom: 20px;">
        <img src="{{ $imageSrc }}" alt="Logo" width="150">
    </div>

    <h2 style="text-align: center;">Listagem de registros</h2>

    @foreach($dados as $pagina => $registros)
        <table>
            <thead>
                <tr>
                    <th>DT. CADASTRO</th>
                    <th>NOME</th>
                    <th>EMAIL</th>
                    <!-- Adicione outras colunas conforme necessário -->
                </tr>
            </thead>
            <tbody>
                @foreach($registros as $registro)
                    <tr>
                        <td>{{ $registro['created_at']->format('d/m/Y') }}</td>
                        <td>{{ $registro['name'] }}</td>
                        <td>{{ $registro['email'] }}</td>
                        <!-- Adicione outras colunas conforme necessário -->
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Mostra o número da página em cada página -->
        <div class="footer">
            Página {{ $pagina + 1 }} de {{ $totalPaginas }}
        </div>

        <!-- Adicione quebra de página no final de cada página, exceto na última -->
        @if($pagina < $totalPaginas - 1)
            <div class="page-break"></div>
        @endif
        
    @endforeach

</body>
</html>