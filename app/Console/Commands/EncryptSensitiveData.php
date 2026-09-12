<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EncryptSensitiveData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:encrypt-sensitive-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cifra los datos sensibles existentes de la plataforma';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando cifrado de datos sensibles...');
        $this->newLine();

        /*
         * CASE FILES
         */
        $caseFiles = DB::table('case_files')
            ->whereNotNull('description')
            ->where('description', '<>', '')
            ->get();

        foreach ($caseFiles as $case) {
            DB::table('case_files')
                ->where('id', $case->id)
                ->update([
                    'description' => Crypt::encryptString($case->description),
                ]);
        }

        $this->info("case_files.description: {$caseFiles->count()} registros cifrados.");

        /*
         * CASE COMMENTS
         */
        $comments = DB::table('case_comments')
            ->whereNotNull('comment')
            ->where('comment', '<>', '')
            ->get();

        foreach ($comments as $comment) {
            DB::table('case_comments')
                ->where('id', $comment->id)
                ->update([
                    'comment' => Crypt::encryptString($comment->comment),
                ]);
        }

        $this->info("case_comments.comment: {$comments->count()} registros cifrados.");

        /*
         * CHAT MESSAGES
         */
        $chatMessages = DB::table('chat_messages')
            ->whereNotNull('message')
            ->where('message', '<>', '')
            ->get();

        foreach ($chatMessages as $message) {
            DB::table('chat_messages')
                ->where('id', $message->id)
                ->update([
                    'message' => Crypt::encryptString($message->message),
                ]);
        }

        $this->info("chat_messages.message: {$chatMessages->count()} registros cifrados.");

        /*
         * EVALUATION ANSWERS
         */
        $answers = DB::table('evaluacion_respuestas')
            ->whereNotNull('respuesta')
            ->where('respuesta', '<>', '')
            ->get();

        foreach ($answers as $answer) {
            DB::table('evaluacion_respuestas')
                ->where('uuid', $answer->uuid)
                ->update([
                    'respuesta' => Crypt::encryptString($answer->respuesta),
                ]);
        }

        $this->info("evaluacion_respuestas.respuesta: {$answers->count()} registros cifrados.");

        $this->newLine();
        $this->info('Cifrado de datos sensibles completado.');
        
        return Command::SUCCESS;
    }
}