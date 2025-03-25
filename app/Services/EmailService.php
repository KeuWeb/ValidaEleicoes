<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function sendEmail(string $email, string $subject, string $messageBody, string $url = null)
    {
        try {
            Mail::html($messageBody, function ($message) use ($email, $subject) {
                $message->to($email)->subject($subject);
            });

            return [
                'status' => 'success',
                'message' => 'E-mail enviado com sucesso!'
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Falha ao enviar o e-mail: ' . $e->getMessage()
            ];
        }
    }
}
