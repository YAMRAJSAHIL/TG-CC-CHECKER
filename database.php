<?php

$update = json_decode(file_get_contents('php://input'), true);
if (isset($update['message'])) {
    $userId = $update['message']['from']['id'];
}

$users = file_get_contents('Database/free.txt');
$freeusers = explode("\n", $users);

$owners = file_get_contents('Database/owner.txt');
$admins = explode("\n", $owners);

$pm = file_get_contents('Database/paid.txt');
$pms = explode("\n", $pm);

$rank = "[Free]";
if (isset($userId)) {
    if (in_array($userId, $admins)) {
        $rank = "[Owner]";
    } elseif (in_array($userId, $pms)) {
        $rank = "[Premium]";
    } elseif (isset($allowedUsers) && in_array($userId, $allowedUsers)) {
        $rank = "[Authorized]";
    } else {
        $rank = "[Error]"; // Handle error for unidentified users
    }
} else {
    $rank = "[Error]"; // Handle error for missing user ID
}

// Concatenate elements with the same date using line breaks
$pms = array_reduce($pms, function ($carry, $item) {
    [$userId, $expiryDate] = explode(' ', $item, 2);
    $carry[$expiryDate][] = $userId;
    return $carry;
}, []);

$pms = array_map(function ($users, $expiryDate) {
    return implode("\n", $users) . " $expiryDate";
}, $pms, array_keys($pms));

$pms = implode("\n", $pms);

?>
