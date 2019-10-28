<?php
namespace App\models;

/**
 * Исходники бота, которого я написал ранее
 * https://github.com/Tao309/test_telegram_d_bot
 *
 * Class Bot
 */
class TelegramBot {
    private $token = '';
    private $chat_id = '';

    public function __construct(string $message = null)
    {
        //Добавить токен
        $this->token = '';
        //Добавить id пользователя
        $this->chat_id = 0;

        if(!empty($message))
        {
            $this->sendAnswer($message);
        }
    }

    private function sendAnswer($message):void
    {
        $response = array(
            'chat_id' => $this->chat_id,
            'text' => $message
        );

        $ch = curl_init('https://api.telegram.org/bot' . $this->token . '/sendMessage');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_exec($ch);
        curl_close($ch);
    }
}
