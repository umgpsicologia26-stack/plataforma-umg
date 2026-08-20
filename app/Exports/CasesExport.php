<?php

namespace App\Exports;

use App\Models\CaseFile;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CasesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return CaseFile::with([
            'user',
            'moderator'
        ])
        ->latest()
        ->get()
        ->map(function ($case) {

            return [
                $case->case_number,

                $case->type,

                $case->description,

                $case->status,

                $case->user
                    ? (
                        $case->user->full_name
                        ?? trim(
                            ($case->user->first_name ?? '') .
                            ' ' .
                            ($case->user->last_name ?? '')
                        )
                    )
                    : 'No asignado',

                $case->moderator
                    ? (
                        $case->moderator->full_name
                        ?? trim(
                            ($case->moderator->first_name ?? '') .
                            ' ' .
                            ($case->moderator->last_name ?? '')
                        )
                    )
                    : 'No asignado',

                $case->created_at
                    ? $case->created_at->format('d/m/Y H:i:s')
                    : '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Numero de Caso',
            'Tipo',
            'Descripcion',
            'Estado',
            'Usuario',
            'Moderador',
            'Fecha de creación',
        ];
    }
}