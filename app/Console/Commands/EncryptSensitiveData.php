<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EncryptSensitiveData extends Command
{
    protected $signature = 'app:encrypt-sensitive-data';

    protected $description = 'Cifra los datos sensibles existentes de la plataforma sin volver a cifrar datos ya protegidos';

    /**
     * Determina si un valor ya está cifrado correctamente
     * con la APP_KEY actual.
     */
    private function isEncrypted(string $value): bool
    {
        try {
            Crypt::decryptString($value);

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Cifra una columna únicamente cuando el valor
     * todavía no está cifrado.
     */
    private function encryptColumn(
        string $table,
        string $column,
        string $primaryKey
    ): int {
        $encrypted = 0;

        $rows = DB::table($table)
            ->whereNotNull($column)
            ->where($column, '<>', '')
            ->get([$primaryKey, $column]);

        foreach ($rows as $row) {
            $value = $row->{$column};

            if ($this->isEncrypted($value)) {
                continue;
            }

            DB::table($table)
                ->where($primaryKey, $row->{$primaryKey})
                ->update([
                    $column => Crypt::encryptString($value),
                ]);

            $encrypted++;
        }

        return $encrypted;
    }

    public function handle()
    {
        $this->info('Iniciando verificación de datos sensibles...');
        $this->newLine();

        $fields = [
            [
                'table' => 'case_files',
                'column' => 'description',
                'primaryKey' => 'id',
            ],
            [
                'table' => 'case_comments',
                'column' => 'comment',
                'primaryKey' => 'id',
            ],
            [
                'table' => 'chat_messages',
                'column' => 'message',
                'primaryKey' => 'id',
            ],
            [
                'table' => 'mensajes_foro',
                'column' => 'content',
                'primaryKey' => 'uuid',
            ],
            [
                'table' => 'evaluacion_respuestas',
                'column' => 'respuesta',
                'primaryKey' => 'uuid',
            ],
            [
                'table' => 'crisis_reports',
                'column' => 'description',
                'primaryKey' => 'uuid',
            ],
        ];

        $totalEncrypted = 0;

        foreach ($fields as $field) {
            $count = $this->encryptColumn(
                $field['table'],
                $field['column'],
                $field['primaryKey']
            );

            $this->info(
                "{$field['table']}.{$field['column']}: {$count} registros cifrados."
            );

            $totalEncrypted += $count;
        }

        $this->newLine();

        if ($totalEncrypted === 0) {
            $this->info(
                'Todos los datos sensibles existentes ya estaban cifrados.'
            );
        } else {
            $this->info(
                "Proceso completado. Registros cifrados: {$totalEncrypted}."
            );
        }

        return Command::SUCCESS;
    }
}