<?php

function clean($message) {
    return htmlspecialchars(trim($message));
}

function random_strings($length_of_string) {
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str_shuffled = str_shuffle($str_result);
    return substr($str_shuffled, 0, $length_of_string);
}

if ((strpos($message, "/code") === 0) || (strpos($message, "!code") === 0) || (strpos($message, ".code") === 0)) {
    $owners = file_get_contents('Database/owner.txt');
    $admins = explode("\n", $owners);
    if (!in_array($userId, $admins)) {
        sendMessage($chatId, "⚠️ 𝗬𝗼𝘂 𝗮𝗿𝗲 𝗡𝗼𝘁 𝗮𝗻 𝗔𝗗𝗠𝗜𝗡 !", $messageId);
    } else {
        $command = substr($message, 6);
        $command = clean($command);

        if ($command == ' ' || $command == '') {
            $expiryDays = 1;
            $amountOfCodes = 1;
        } else {
            $cmdExplode = explode('-', $command);
            if (count($cmdExplode) != 2) {
                sendMessage($chatId, "⚠️ 𝗜𝗻𝘃𝗮𝗹𝗶𝗱 𝗰𝗼𝗺𝗺𝗮𝗻𝗱 𝗳𝗼𝗿𝗺𝗮𝘁.                                           /code {expiry_days}-{amount_of_codes}", $messageId);
                exit;
            }
            $expiryDays = (int)$cmdExplode[0];
            $amountOfCodes = (int)$cmdExplode[1];
        }

        $expiryDate = date('d M Y', strtotime("+$expiryDays days"));

        $credt = array();
        while ($amountOfCodes > 0) {
            $rnds = 'BH-' . random_strings(4) . '-' . random_strings(4) . '-' . random_strings(4);
            $credt[] = $rnds;
            $amountOfCodes = $amountOfCodes - 1;
        }

        foreach ($credt as $code) {
            $credtf = fopen('Database/codes.txt', 'a');
            fwrite($credtf, "[$code|$expiryDays],\n");
            fclose($credtf);
            $formattedCode = "<code>$code</code>";
            $messageToSend = urlencode(
                "┏━━━━━━━⍟\n" .
                "┃𝐊𝐞𝐲 𝐂𝐫𝐞𝐚𝐭𝐞𝐝 ✅\n" .
                "┗━━━━━━━━━━━⊛\n\n" .
                "✿├𝙐𝙨𝙖𝙜𝙚 /redeem\n" .
                "✿├𝑲𝒆𝒚: $formattedCode\n" .
                "✿├𝑫𝒂𝒚𝒔: $expiryDays\n" .
                "✿├𝗘𝘅𝗽𝗶𝗿𝗲𝘀 𝗼𝗻 $expiryDate\n" .
                "🜲 𝑹𝒂𝒏𝒌: PREMIUM @hackedworld69"
            );
            sendMessage($chatId, $messageToSend, $messageId);
        }
    }
}
?>
