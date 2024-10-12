
<?php

function getUserProfilePhoto($userId) {
    global $website;
    $url = $website . "/getUserProfilePhotos?user_id=" . $userId . "&limit=1";

    $response = json_decode(file_get_contents($url), TRUE);

    if ($response === FALSE) {
        error_log("Failed to get user profile photo: " . $url);
        return null;
    }
    if ($response['ok'] && count($response['result']['photos']) > 0) {
        return $response['result']['photos'][0][0]['file_id'];
    }

    return null;
}



//============function end==========//
if (preg_match('/^(\/info|\.id|!id)/', $text)) {

    $photoId = getUserProfilePhoto($userId);

    $m = " 𝙐𝙎𝙀𝙍 𝙄𝙉𝙁𝙊𝙍𝙈𝘼𝙏𝙄𝙊𝙉 ✅%0A━━━━━━━━━━━━━%0A<b>× 𝙐𝙎𝙀𝙍𝙉𝘼𝙈𝙀 - @$username%0A× 𝙐𝙎𝘼𝙂𝙀 𝙉𝘼𝙈𝙀  ↯ $firstname%0A× 𝙏𝙂 𝙄𝘿  ↯ <code>$userId</code>%0A× 𝘾𝙃𝘼𝙏 𝙄𝘿 ↯ <code>$chatId</code>%0A× RANK ↯ $rank%0A× 𝙋𝙇𝘼𝙉 𝙀𝙓𝙋𝙄𝙍𝙔 ↯ $expiryDate</b>%0A━━━━━━━━━━━━━%0A<b>|×| DEV - @hackedworld69</b>";

    if ($photoId) {
        sendPhotox($chatId, $photoId, $m);
    } else {
        sendMessage($chatId, $m, $message_id);
    }
}
