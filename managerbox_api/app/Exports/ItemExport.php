<?php


namespace App\Exports;

use App\Models\ItemInStock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ItemExport implements FromCollection, WithHeadings
{
    /**
     * Retorna a coleção de dados para exportação.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return ItemInStock::all();
    }

    /**
     * Define os cabeçalhos das colunas no arquivo exportado.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nome',
            'Descrição',
            'Quantidade Atual',
            'Quantidade Máxima',
            'Preço de Custo',
            'Preço de Venda',
            'Tipo de Unidade',
            'Localização',
            'Ativo',
        ];
    }
}
