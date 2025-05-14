<?php
$botToken = 'YOUR_BOT_TOKEN';
$targetChatId = 'YOUR_CHAT_ID';

$update = json_decode(file_get_contents('php://input'), true);
//file_put_contents('log.txt', print_r($update, true), FILE_APPEND);

if (isset($update['message'])) {
    $message = $update['message'];
    $chatId = $message['chat']['id'];
    $text = $message['text'] ?? '';

    if ($chatId != $targetChatId) exit;

    if ($text === '/start') {
        sendMessage($chatId, "👋 Hello and welcome! I'm your advertisement link assistant. Please send me your links, and I'll format them nicely for you.");
        exit;
    }

    if ($text === '/help') {
        sendMessage($chatId, "🔍 How to use this bot:\n\n" .
            "Send me Telegram channel links in any of these formats:\n" .
            "• @username\n" .
            "• https://t.me/username\n" .
            "• 1 - @username\n" .
            "• 1 - https://t.me/username\n\n" .
            "I'll format them with numbers and remove duplicates!");
        exit;
    }

    $usernames = extractUsernames($text);

    if (count($usernames) > 0) {
        $uniqueUsernames = array_unique($usernames);

        $response = '';
        foreach ($uniqueUsernames as $index => $username) {
            $response .= ($index + 1) . ". @$username\n";
        }

        sendMessage($chatId, $response);
        sendMessage($chatId, "I am waiting for the next list!");
    } else {
        sendMessage($chatId, "Please send advertisement links in one of the supported formats. Type /help for instructions.");
    }
}

function extractUsernames($text)
{
    $usernames = [];
    $patterns = [
        '/@([a-zA-Z0-9_]+)/',
        '/https:\/\/t\.me\/([a-zA-Z0-9_]+)/',
        '/\d+\s*-\s*@([a-zA-Z0-9_]+)/',
        '/\d+\s*-\s*https:\/\/t\.me\/([a-zA-Z0-9_]+)/'
    ];

    foreach ($patterns as $pattern) {
        preg_match_all($pattern, $text, $matches);
        if (isset($matches[1])) {
            $usernames = array_merge($usernames, $matches[1]);
        }
    }

    return $usernames;
}

function sendMessage($chatId, $text)
{
    global $botToken;

    $ch = curl_init("https://api.telegram.org/bot$botToken/sendMessage");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML'
        ],
        CURLOPT_SSL_VERIFYPEER => false
    ]);

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}
