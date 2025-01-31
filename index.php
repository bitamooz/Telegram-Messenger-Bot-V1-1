<?php
/*
🚀 این سورس کد رو به‌صورت کاملاً رایگان از گنجینه برنامه‌نویسی بیت‌آموز دریافت کردی!  
🎯 جدیدترین سورس‌ها، آموزش‌ها و ابزارهای کاربردی رو همین الان از سایت ما دانلود کن:  
🌐 https://BitAmooz.com  

💡 دوست داری همیشه یک قدم جلوتر باشی؟  
هر روز کلی سورس رایگان، تکنیک‌های برنامه‌نویسی و نکات حرفه‌ای توی بیت‌آموز منتشر میشه!  
⏳ وقتشه که سطح کدنویسی خودتو ارتقا بدی!  
🔗 همین الان وارد سایت شو و سورس‌های بیشتری بگیر: https://BitAmooz.com  
*/
set_time_limit(0);
ob_start();
header('Content-Type: application/json');
echo json_encode(['status' => 'ok']);
flush();
require_once 'config.php';

if ($user_id != $admin_id) {
    if ($text === "/start") {
        sendMessage($chat_id, "🌟 به ربات پیام‌رسان خوش آمدید!\n✉️ پیام خود را ارسال کنید تا به مدیریت منتقل شود.");
    } else {
        $forward_result = forwardToAdmin($admin_id, $user_id, $message_id);
        TelAPIBitAmooz('sendMessage', [
            'chat_id' => $admin_id,
            'text' => "📢 یک پیام جدید دارید. \nدر صورت بسته بودن فوروارد از دکمه زیر برای پاسخ دهی استفاده کنید!👌",
            'reply_to_message_id' => $forward_result['result']['message_id'],
            'reply_markup' => json_encode([
                'inline_keyboard' => [[['text' => "📩 ارسال پاسخ", 'callback_data' => "answer:$user_id"]]]
            ])
        ]);
        sendMessage($chat_id, "📨 پیام شما ارسال شد! لطفاً منتظر پاسخ باشید.");
    }
} else {
    if ($text === "/start") {
        sendMessage($chat_id, "👋 ادمین عزیز، خوش آمدید! تمام پیام‌های کاربران به شما ارسال خواهد شد. برای پاسخ دادن، روی پیام‌ها ریپلای کنید.");
    } elseif ($reply) {
        $receiver_id = $reply->forward_from->id ?? null;
        if ($receiver_id) {
            if(isset($update->message->text)) {
                sendMessage($receiver_id, "📩 شما یک پاسخ جدید دریافت کردید! 👇");
                sendMessage($receiver_id, $update->message->text);
                sendMessage($admin_id, "✅ پاسخ ارسال شد.");
            }
            elseif(isset($update->message->photo)) {
                sendMessage($receiver_id, "📸 در پاسخ به شما از طرف مدیر عکس ارسال شد! 👇");
                $photo = end($update->message->photo);
                TelAPIBitAmooz('sendPhoto', [
                    'chat_id' => $receiver_id,
                    'photo' => $photo->file_id
                ]);
                sendMessage($admin_id, "✅ پاسخ ارسال شد.");
            }
            elseif(isset($update->message->video)) {
                sendMessage($receiver_id, "🎥 در پاسخ به شما از طرف مدیر ویدئو ارسال شد! 👇");
                TelAPIBitAmooz('sendVideo', [
                    'chat_id' => $receiver_id,
                    'video' => $update->message->video->file_id
                ]);
                sendMessage($admin_id, "✅ پاسخ ارسال شد.");
            }
            elseif(isset($update->message->animation)) {
                sendMessage($receiver_id, "🎞 در پاسخ به شما از طرف مدیر گیف ارسال شد! 👇");
                TelAPIBitAmooz('sendAnimation', [
                    'chat_id' => $receiver_id,
                    'animation' => $update->message->animation->file_id
                ]);
                sendMessage($admin_id, "✅ پاسخ ارسال شد.");
            }
            elseif(isset($update->message->sticker)) {
                sendMessage($receiver_id, "🎭 در پاسخ به شما از طرف مدیر استیکر ارسال شد! 👇");
                TelAPIBitAmooz('sendSticker', [
                    'chat_id' => $receiver_id,
                    'sticker' => $update->message->sticker->file_id
                ]);
                sendMessage($admin_id, "✅ پاسخ ارسال شد.");
            }
            elseif(isset($update->message->voice)) {
                sendMessage($receiver_id, "🎤 در پاسخ به شما از طرف مدیر ویس ارسال شد! 👇");
                TelAPIBitAmooz('sendVoice', [
                    'chat_id' => $receiver_id,
                    'voice' => $update->message->voice->file_id
                ]);
                sendMessage($admin_id, "✅ پاسخ ارسال شد.");
            }
            elseif(isset($update->message->document)) {
                sendMessage($receiver_id, "📁 در پاسخ به شما از طرف مدیر فایل ارسال شد! 👇");
                TelAPIBitAmooz('sendDocument', [
                    'chat_id' => $receiver_id,
                    'document' => $update->message->document->file_id
                ]);
                sendMessage($admin_id, "✅ پاسخ ارسال شد.");
            }
            elseif(isset($update->message->audio)) {
                sendMessage($receiver_id, "🎵 در پاسخ به شما از طرف مدیر موسیقی ارسال شد! 👇");
                TelAPIBitAmooz('sendAudio', [
                    'chat_id' => $receiver_id,
                    'audio' => $update->message->audio->file_id
                ]);
                sendMessage($admin_id, "✅ پاسخ ارسال شد.");
            }
            elseif(isset($update->message->video_note)) {
                sendMessage($receiver_id, "🎥 در پاسخ به شما از طرف مدیر ویدئو مسیج ارسال شد! 👇");
                TelAPIBitAmooz('sendVideoNote', [
                    'chat_id' => $receiver_id,
                    'video_note' => $update->message->video_note->file_id
                ]);
                sendMessage($admin_id, "✅ پاسخ ارسال شد.");
            }
            elseif(isset($update->message->location)) {
                sendMessage($receiver_id, "📍 در پاسخ به شما از طرف مدیر لوکیشن ارسال شد! 👇");
                TelAPIBitAmooz('sendLocation', [
                    'chat_id' => $receiver_id,
                    'latitude' => $update->message->location->latitude,
                    'longitude' => $update->message->location->longitude
                ]);
                sendMessage($admin_id, "✅ پاسخ ارسال شد.");
            }
            elseif(isset($update->message->contact)) {
                sendMessage($receiver_id, "📞 در پاسخ به شما از طرف مدیر مخاطب ارسال شد! 👇");
                TelAPIBitAmooz('sendContact', [
                    'chat_id' => $receiver_id,
                    'phone_number' => $update->message->contact->phone_number,
                    'first_name' => $update->message->contact->first_name
                ]);
                sendMessage($admin_id, "✅ پاسخ ارسال شد.");
            }
        }
    } elseif ($callback_data && preg_match("/answer:(.*)/", $callback_data, $match)) {
        file_put_contents("temp_response.txt", $match[1]);
        sendMessage($admin_id, "✍️ لطفاً پیام پاسخ را ارسال کنید.");
    } elseif (file_exists("temp_response.txt")) {
        $receiver_id = file_get_contents("temp_response.txt");
        if(isset($update->message->text)) {
            sendMessage($receiver_id, "📩 شما یک پاسخ جدید دریافت کردید! 👇");
            sendMessage($receiver_id, $update->message->text);
            sendMessage($admin_id, "✅ پاسخ ارسال شد.");
        }
        elseif(isset($update->message->photo)) {
            sendMessage($receiver_id, "📸 در پاسخ به شما از طرف مدیر عکس ارسال شد! 👇");
            $photo = end($update->message->photo);
            TelAPIBitAmooz('sendPhoto', [
                'chat_id' => $receiver_id,
                'photo' => $photo->file_id
            ]);
            sendMessage($admin_id, "✅ پاسخ ارسال شد.");
        }
        elseif(isset($update->message->video)) {
            sendMessage($receiver_id, "🎥 در پاسخ به شما از طرف مدیر ویدئو ارسال شد! 👇");
            TelAPIBitAmooz('sendVideo', [
                'chat_id' => $receiver_id,
                'video' => $update->message->video->file_id
            ]);
            sendMessage($admin_id, "✅ پاسخ ارسال شد.");
        }
        elseif(isset($update->message->animation)) {
            sendMessage($receiver_id, "🎞 در پاسخ به شما از طرف مدیر گیف ارسال شد! 👇");
            TelAPIBitAmooz('sendAnimation', [
                'chat_id' => $receiver_id,
                'animation' => $update->message->animation->file_id
            ]);
            sendMessage($admin_id, "✅ پاسخ ارسال شد.");
        }
        elseif(isset($update->message->sticker)) {
            sendMessage($receiver_id, "🎭 در پاسخ به شما از طرف مدیر استیکر ارسال شد! 👇");
            TelAPIBitAmooz('sendSticker', [
                'chat_id' => $receiver_id,
                'sticker' => $update->message->sticker->file_id
            ]);
            sendMessage($admin_id, "✅ پاسخ ارسال شد.");
        }
        elseif(isset($update->message->voice)) {
            sendMessage($receiver_id, "🎤 در پاسخ به شما از طرف مدیر ویس ارسال شد! 👇");
            TelAPIBitAmooz('sendVoice', [
                'chat_id' => $receiver_id,
                'voice' => $update->message->voice->file_id
            ]);
            sendMessage($admin_id, "✅ پاسخ ارسال شد.");
        }
        elseif(isset($update->message->document)) {
            sendMessage($receiver_id, "📁 در پاسخ به شما از طرف مدیر فایل ارسال شد! 👇");
            TelAPIBitAmooz('sendDocument', [
                'chat_id' => $receiver_id,
                'document' => $update->message->document->file_id
            ]);
            sendMessage($admin_id, "✅ پاسخ ارسال شد.");
        }
        elseif(isset($update->message->audio)) {
            sendMessage($receiver_id, "🎵 در پاسخ به شما از طرف مدیر موسیقی ارسال شد! 👇");
            TelAPIBitAmooz('sendAudio', [
                'chat_id' => $receiver_id,
                'audio' => $update->message->audio->file_id
            ]);
            sendMessage($admin_id, "✅ پاسخ ارسال شد.");
        }
        elseif(isset($update->message->video_note)) {
            sendMessage($receiver_id, "🎥 در پاسخ به شما از طرف مدیر ویدئو مسیج ارسال شد! 👇");
            TelAPIBitAmooz('sendVideoNote', [
                'chat_id' => $receiver_id,
                'video_note' => $update->message->video_note->file_id
            ]);
            sendMessage($admin_id, "✅ پاسخ ارسال شد.");
        }
        elseif(isset($update->message->location)) {
            sendMessage($receiver_id, "📍 در پاسخ به شما از طرف مدیر لوکیشن ارسال شد! 👇");
            TelAPIBitAmooz('sendLocation', [
                'chat_id' => $receiver_id,
                'latitude' => $update->message->location->latitude,
                'longitude' => $update->message->location->longitude
            ]);
            sendMessage($admin_id, "✅ پاسخ ارسال شد.");
        }
        elseif(isset($update->message->contact)) {
            sendMessage($receiver_id, "📞 در پاسخ به شما از طرف مدیر مخاطب ارسال شد! 👇");
            TelAPIBitAmooz('sendContact', [
                'chat_id' => $receiver_id,
                'phone_number' => $update->message->contact->phone_number,
                'first_name' => $update->message->contact->first_name
            ]);
            sendMessage($admin_id, "✅ پاسخ ارسال شد.");
        }
        unlink("temp_response.txt");
    } 

}

?>
