<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Throwable;

class RepairDoubleEncryption extends Command
{
    protected $signature = 'app:repair-double-encryption';

    protected $description = 'Repara registros que fueron cifrados dos veces';

    public function handle()
    {
        $this->info('Iniciando reparación de doble cifrado...');
        $this->newLine();

        $repaired = 0;
        $skipped = 0;

        /*
        |--------------------------------------------------------------------------
        | CASE FILES
        |--------------------------------------------------------------------------
        */

        $caseFiles = DB::table('case_files')
            ->whereNotNull('description')
            ->where('description', '<>', '')
            ->get();

        foreach ($caseFiles as $case) {
            try {
                $value = Crypt::decryptString($case->description);
                $value = Crypt::decryptString($value);

                DB::table('case_files')
                    ->where('id', $case->id)
                    ->update([
                        'description' => Crypt::encryptString($value),
                    ]);

                $repaired++;
            } catch (Throwable $e) {
                $skipped++;
            }
        }

        $this->info(
            "case_files.description: {$repaired} reparados, {$skipped} omitidos."
        );

        $this->newLine();

        /*
        |--------------------------------------------------------------------------
        | CASE COMMENTS
        |--------------------------------------------------------------------------
        */

        $comments = DB::table('case_comments')
            ->whereNotNull('comment')
            ->where('comment', '<>', '')
            ->get();

        $commentsRepaired = 0;
        $commentsSkipped = 0;

        foreach ($comments as $comment) {
            try {
                $value = Crypt::decryptString($comment->comment);
                $value = Crypt::decryptString($value);

                DB::table('case_comments')
                    ->where('id', $comment->id)
                    ->update([
                        'comment' => Crypt::encryptString($value),
                    ]);

                $commentsRepaired++;
            } catch (Throwable $e) {
                $commentsSkipped++;
            }
        }

        $this->info(
            "case_comments.comment: {$commentsRepaired} reparados, {$commentsSkipped} omitidos."
        );

        $this->newLine();

        /*
        |--------------------------------------------------------------------------
        | CHAT MESSAGES
        |--------------------------------------------------------------------------
        */

        $chatMessages = DB::table('chat_messages')
            ->whereNotNull('message')
            ->where('message', '<>', '')
            ->get();

        $chatRepaired = 0;
        $chatSkipped = 0;

        foreach ($chatMessages as $message) {
            try {
                $value = Crypt::decryptString($message->message);
                $value = Crypt::decryptString($value);

                DB::table('chat_messages')
                    ->where('id', $message->id)
                    ->update([
                        'message' => Crypt::encryptString($value),
                    ]);

                $chatRepaired++;
            } catch (Throwable $e) {
                $chatSkipped++;
            }
        }

        $this->info(
            "chat_messages.message: {$chatRepaired} reparados, {$chatSkipped} omitidos."
        );

        $this->newLine();

        /*
        |--------------------------------------------------------------------------
        | EVALUATION ANSWERS
        |--------------------------------------------------------------------------
        */

        $answers = DB::table('evaluacion_respuestas')
            ->whereNotNull('respuesta')
            ->where('respuesta', '<>', '')
            ->get();

        $answersRepaired = 0;
        $answersSkipped = 0;

        foreach ($answers as $answer) {
            try {
                $value = Crypt::decryptString($answer->respuesta);
                $value = Crypt::decryptString($value);

                DB::table('evaluacion_respuestas')
                    ->where('uuid', $answer->uuid)
                    ->update([
                        'respuesta' => Crypt::encryptString($value),
                    ]);

                $answersRepaired++;
            } catch (Throwable $e) {
                $answersSkipped++;
            }
        }

        $this->info(
            "evaluacion_respuestas.respuesta: {$answersRepaired} reparados, {$answersSkipped} omitidos."
        );

        $this->newLine();

        /*
        |--------------------------------------------------------------------------
        | FINAL
        |--------------------------------------------------------------------------
        */

        $this->info('Reparación finalizada.');

        return Command::SUCCESS;
    }
}