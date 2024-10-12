<?php


function checkAndUpdateUserStatus($userId, $username, $firstname, $chatId, $messageId) {
    $currentDate = date('Y-m-d');
    $rank = "FREE";
    $expiryDate = "0";

    $paidUsers = file('Database/paid.txt', FILE_IGNORE_NEW_LINES);
    $freeUsers = file('Database/free.txt', FILE_IGNORE_NEW_LINES);
    $owners = file('Database/owner.txt', FILE_IGNORE_NEW_LINES);

    if(in_array($userId, $owners)) {
        $rank = "OWNER";
       $expiryDate = "UNTIL DEAD"; 
    } else {
        foreach ($paidUsers as $index => $line) {
            list($userIdFromFile, $userExpiryDate) = explode(" ", $line);
            if ($userIdFromFile == $userId) {
                if ($userExpiryDate < $currentDate) {
                    unset($paidUsers[$index]); //
                    file_put_contents('Database/paid.txt', implode("\n", $paidUsers));
                    $freeUsers[] = $userId; // add to free users list
                    file_put_contents('Database/free.txt', implode("\n", $freeUsers));
                } else {
                    $rank = "PAID";
                    $expiryDate = $userExpiryDate;
                }
            }
        }
    }
    $messageToSend = "<b>
⍟ ├𝙐𝙎𝙀𝙍 » @$username 
⍟ ├𝙐𝙎𝙀𝙍𝙄𝘿 » <code>$userId</code>
⍟ ├𝙐𝙎𝙀𝙍 𝙐𝙍𝙇 » $firstname
⍟ ├𝙍𝘼𝙉𝙆 » $rank
⍟ ├𝙀𝙓𝙋𝙄𝙍𝙔 𝘿𝘼𝙏𝙀 » $expiryDate</b>";

    sendMessage($chatId, urlencode($messageToSend), $messageId);
}

// Then in the '/credits' command
if (strpos($message, "/credits") === 0) {
    checkAndUpdateUserStatus($userId, $username, $firstname, $chatId, $messageId);
}
