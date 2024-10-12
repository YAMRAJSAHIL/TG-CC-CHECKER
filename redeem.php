<?php

if (strpos($message, "/redeem") === 0) {
    $codeToRedeem = trim(substr($message, 8));

    $codesAndExpiryDays = file('Database/codes.txt', FILE_IGNORE_NEW_LINES);
    $found = false;
    $newCodesAndExpiryDays = [];

    foreach ($codesAndExpiryDays as $line) {
        $line = trim($line);
        if (strpos($line, '[') === 0 && strpos($line, ']') !== false) {
            $parts = explode("|", substr($line, 1, -1));
            $codeFromFile = trim($parts[0]);

            if (strcasecmp($codeToRedeem, $codeFromFile) === 0 && !$found) {
                $found = true;
                
                $expiryDays = (int) $parts[1];
                $expiryDate = date('Y-m-d', strtotime("+$expiryDays days"));
                file_put_contents('Database/paid.txt', "$userId $expiryDate\n", FILE_APPEND);

                sendMessage($chatId, "𝗞𝗲𝘆 𝗥𝗲𝗱𝗲𝗲𝗺𝗲𝗱 𝗦𝘂𝗰𝗰𝗲𝘀𝘀𝗳𝘂𝗹𝗹𝘆! 🎉                                                      𝐃𝐨 𝐉𝐨𝐢𝐧 @hackedworld69", $messageId);
            } else {
                $newCodesAndExpiryDays[] = $line;
            }
        }
    }

    if ($found) {
        file_put_contents('Database/codes.txt', implode("\n", $newCodesAndExpiryDays));
    } else {
        sendMessage($chatId, "𝗜𝗻𝘃𝗮𝗹𝗶𝗱 𝗼𝗿 𝗮𝗹𝗿𝗲𝗮𝗱𝘆 𝗥𝗲𝗱𝗲𝗲𝗺𝗲𝗱 𝗰𝗼𝗱𝗲 ❌", $messageId);
    }
}
?>
