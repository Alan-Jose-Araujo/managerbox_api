<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Itens</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        th {
            background-color: #f0f0f0;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        tr:hover {
            background-color: #ddd;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Relatório de Itens</h1>
        <p>Data: {{ date('d/m/Y') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Quantidade Atual</th>
                <th>Quantidade Máxima</th>
                <th>Preço de Custo</th>
                <th>Preço de Venda</th>
                <th>Tipo de Unidade</th>
                <th>Localização</th>
                <th>Ativo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->current_quantity }}</td>
                    <td>{{ $item->maximum_quantity }}</td>
                    <td>R$ {{ number_format($item->cost_price, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($item->sell_price, 2, ',', '.') }}</td>
                    <td>{{ $item->unity_type }}</td>
                    <td>{{ $item->location }}</td>
                    <td>{{ $item->is_active ? 'Sim' : 'Não' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>Gerado por: {{ auth()->user()->name }}</p>
    </div>
</body>
</html>
