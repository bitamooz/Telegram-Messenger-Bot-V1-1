<?php

$admin_id = "ADMINID";  // شناسه کاربری ادمین
define('BOT_TOKEN', 'TOKEN');  // توکن ربات

function TelAPIBitAmooz($method, $parameters = []) {
    $url = "https://api.telegram.org/bot" . BOT_TOKEN . "/" . $method;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

function sendMessage($chat_id, $message, $reply_to = null) {
    return TelAPIBitAmooz('sendMessage', [
        'chat_id' => $chat_id,
        'text' => $message,
        'reply_to_message_id' => $reply_to,
        'parse_mode' => 'Markdown'
    ]);
}

function forwardToAdmin($admin_id, $user_id, $message_id) {
    return TelAPIBitAmooz('forwardMessage', [
        'chat_id' => $admin_id,
        'from_chat_id' => $user_id,
        'message_id' => $message_id
    ]);
}

$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$user_id = $message->from->id;
$chat_id = $message->chat->id;
$text = $message->text;
$message_id = $message->message_id;
$reply = $message->reply_to_message;
if(isset($update->callback_query)) {
    $callback_query = $update->callback_query;
    $callback_data = $callback_query->data;
    $user_id = $callback_query->message->chat->id;
}


/*
🚀 این سورس کد رو به‌صورت کاملاً رایگان از گنجینه برنامه‌نویسی بیت‌آموز دریافت کردی!  
🎯 جدیدترین سورس‌ها، آموزش‌ها و ابزارهای کاربردی رو همین الان از سایت ما دانلود کن:  
🌐 https://BitAmooz.com  

💡 دوست داری همیشه یک قدم جلوتر باشی؟  
هر روز کلی سورس رایگان، تکنیک‌های برنامه‌نویسی و نکات حرفه‌ای توی بیت‌آموز منتشر میشه!  
⏳ وقتشه که سطح کدنویسی خودتو ارتقا بدی!  
🔗 همین الان وارد سایت شو و سورس‌های بیشتری بگیر: https://BitAmooz.com  
*/ ?>
