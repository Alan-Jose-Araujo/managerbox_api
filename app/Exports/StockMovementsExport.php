<?php

namespace App\Exports;

use App\Models\StockMovement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockMovementsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return StockMovement::with(['user', 'item'])
            ->get()
            ->map(function($movement) {
                return [
                    'Data' => $movement->created_at->format('d/m/Y H:i'),
                    'Item' => $movement->item->name,
                    'Responsável' => $movement->user->name,
                    'Tipo' => $movement->movement_type === 'checkin' ? 'Entrada' : 'Saída',
                    'Quantidade' => $movement->quantity
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Data',
            'Item',
            'Responsável',
            'Tipo',
            'Quantidade'
        ];
    }
}
