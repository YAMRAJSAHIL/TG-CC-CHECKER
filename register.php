<?php
if (preg_match('/\/register/', $message)) {
    // Load the existing users.
    $users = file_get_contents('Database/free.txt');
    $freeusers = explode("\n", $users);

    // Check if the user has already registered.
    if (in_array($userId, $freeusers)) {
        $response = '𝙐𝙎𝙀𝙍 𝘼𝙇𝙍𝙀𝘼𝘿𝙔 𝙍𝙀𝙂𝙄𝙎𝙏𝙀𝙍𝙀𝘿 ❌';
    } else {
        // If not, add the user to the file.
        $file = fopen('Database/free.txt', 'a');
        fwrite($file, $userId . "\n");
        fclose($file);

        $response = '𝙐𝙎𝙀𝙍 𝙍𝙀𝙂𝙄𝙎𝙏𝙀𝙍𝙀𝘿 𝙎𝙐𝘾𝘾𝙀𝙎𝙎𝙁𝙐𝙇𝙇𝙔 ✅!
        Now click /start';
    }

    // Send the response.
    reply_tox($chatId, $message_id, $keyboard, $response);
}
?>
