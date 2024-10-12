
<?php
include 'function/antispam.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

ini_set('log_errors', TRUE);
ini_set('error_log', 'errors.log');

//=========RANK DETERMINE=========//
$gate = "𝘽𝙍𝘼𝙄𝙉𝙏𝙍𝙀𝙀 3𝘿 𝙇𝙊𝙊𝙆𝙐𝙋";
$currentDate = date('Y-m-d');
$rank = "FREE";
$expiryDate = "0";
$paidUsers = file('Database/paid.txt', FILE_IGNORE_NEW_LINES);
$freeUsers = file('Database/free.txt', FILE_IGNORE_NEW_LINES);
$owners = file('Database/owner.txt', FILE_IGNORE_NEW_LINES);
if (in_array($userId, $owners)) {
    $rank = "OWNER";
    $expiryDate = "UNTIL DEAD";
} else {
    foreach ($paidUsers as $index => $line) {
        list($userIdFromFile, $userExpiryDate) = explode(" ", $line);
        if ($userIdFromFile == $userId) {
            if ($userExpiryDate < $currentDate) {
                unset($paidUsers[$index]);
                file_put_contents('Database/paid.txt', implode("\n", $paidUsers));
                $freeUsers[] = $userId;
                file_put_contents('Database/free.txt', implode("\n", $freeUsers));
            } else {
                $rank = "PAID";
                $expiryDate = $userExpiryDate;
            }
        }
    }
}
//=======RANK DETERMINE END=========//
$update = json_decode(file_get_contents("php://input"), TRUE);
$text = $update["message"]["text"];
//========WHO CAN CHECK FUNC========//
if (preg_match('/^(\/xxx|\.xxx|!xxx)/', $text)) {
    $userid = $update['message']['from']['id'];
    if (!checkAccess($userid)) {
        $sent_message_id = send_reply($chatId, $message_id, $keyboard, "<b> $userlink 𝘠𝘖𝘜 𝘈𝘙𝘌 𝘕𝘖𝘛 𝘗𝘙𝘌𝘔𝘐𝘜𝘔 𝘜𝘚𝘌𝘙  ❌</b>", $message_id);
        exit();
    }
    $start_time = microtime(true);
    $chatId = $update["message"]["chat"]["id"];
    $message_id = $update["message"]["message_id"];
    $keyboard = "";
    //=======WHO CAN CHECK END========//
    //====ANTISPAM AND WRONG FORMAT====//
    if (strlen($text) <= 5) {
        sendMessage($chatId, '<b>•!𝙒𝙍𝙊𝙉𝙂 𝙁𝙊𝙍𝙈𝘼𝙏!                  𝙏𝙚𝙭𝙩 𝙎𝙝𝙤𝙪𝙡𝙙 𝙊𝙣𝙡𝙮 𝘾𝙤𝙣𝙩𝙖𝙞𝙣 - <code>/vbv cc|mm|yy|cvv</code>• 𝙂𝘼𝙏𝙀𝙒𝘼𝙔 <code>3DS Lookup</code>', $message_id);
        exit();
    }


  

    //==ANTISPAM AND WRONG FORMAT END==//
    //=======checker part start========//
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        extract($_POST);
    } elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
        extract($_GET);
    }
    function inStr($string, $start, $end, $value) {
        $str = explode($start, $string);
        $str = explode($end, $str[$value]);
        return $str[0];
    }
    $lista = substr($text, 5);
    $separa = explode("|", $lista);
    $cc = isset($separa[0]) ? substr($separa[0], 0, 16) : ''; // Get only first 16 digits
    $mes = isset($separa[1]) ? $separa[1] : '';
    $ano = isset($separa[2]) ? $separa[2] : '';
    $cvv = isset($separa[3]) ? $separa[3] : '';
    $last4 = substr($cc, 12, 16);
    $sent_message_id = send_reply($chatId, $message_id, $keyboard, "<b>𝙍𝙀𝘼𝘿𝙄𝙉𝙂 𝙐𝙍 𝙍𝙀𝙌𝙐𝙀𝙎𝙏 ✅</b>");
    function value($str, $find_start, $find_end) {
        $start = @strpos($str, $find_start);
        if ($start === false) {
            return "";
        }
        $length = strlen($find_start);
        $end = strpos(substr($str, $start + $length), $find_end);
        return trim(substr($str, $start + $length, $end));
    }
    function mod($dividendo, $divisor) {
        return round($dividendo - (floor($dividendo / $divisor) * $divisor));
    }
    //================[Functions and Variables]================//
    function vbv($input) {
        // Replace underscores with spaces
        $output = str_replace('_', ' ', $input);
        // Convert to title case (first letter uppercase, rest lowercase)
        $output = ucwords(strtolower($output));
        return $output;
    }
    #------[CC Type Randomizer]------#
    $cardNames = array("3" => "American Express", "4" => "Visa", "5" => "MasterCard", "6" => "Discover");
    $card_type = $cardNames[substr($cc, 0, 1) ];

    //==================[BIN LOOK-UP]======================//
    // Initialize cURL session
$ch = curl_init();

      $bin = substr($cc, 0, 6);

      curl_setopt($ch, CURLOPT_URL, 'https://binlist.io/lookup/' . $bin . '/');
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $ch = curl_init();

        $bin = substr($cc, 0, 6);

        curl_setopt($ch, CURLOPT_URL, 'https://binlist.io/lookup/' . $bin . '/');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $bindata = curl_exec($ch);
        $binna = json_decode($bindata, true);
        $brand = $binna['scheme'];
        $country = $binna['country']['name'];
        $alpha2 = $binna['country']['alpha2'];
        $emoji = $binna['country']['emoji'];
        $type = $binna['type'];
        $category = $binna['category'];
        $bank = $binna['bank']['name'];
        $url = $binna['bank']['url'];
        $phone = $binna['bank']['phone'];
        curl_close($ch);

        $bank = "$bank";
        $country = "$country $emoji ";
        $bin = "$bin - ($alpha2) -[$emoji] ";
        $bininfo = "$type - $brand - $category";
        $url = "$url";
        $type = strtoupper($type);


  
  
    //==================[BIN LOOK-UP-END]======================//
    sleep(1);
    edit_sent_message($chatId, $sent_message_id, "<b>
[×] 𝙋𝙍𝙊𝘾𝙀𝙎𝙎𝙄𝙉𝙂 - ■□□□
- - - - - - - - - - - - - - - - - - -
[×] 𝘾𝘼𝙍𝘿 ↯ <code>$lista</code>
[×] 𝙂𝘼𝙏𝙀𝙒𝘼𝙔 ↯ $gate
[×] 𝘽𝘼𝙉𝙆 ↯ $bank
[×] 𝙏𝙔𝙋𝙀 ↯ $bininfo
[×] 𝘾𝙊𝙐𝙉𝙏𝙍𝙔 ↯ $country
- - - - - - - - - - - - - - - - - - -
|×| 𝙈𝘼𝙓 𝙏𝙄𝙈𝙀 ↯ 25 𝙎𝙀𝘾
|×| 𝙍𝙀𝙌 𝘽𝙔 ↯ @$username</b>");

    //-------------------Req 1--------------//

    //==================req 2 end===============//

    sleep(1);
    edit_sent_message($chatId, $sent_message_id, "<b>
[×] 𝙋𝙍𝙊𝘾𝙀𝙎𝙎𝙄𝙉𝙂 - ■■■■
- - - - - - - - - - - - - - - - - - -
[×] 𝘾𝘼𝙍𝘿 ↯ <code>$lista</code>
[×] 𝙂𝘼𝙏𝙀𝙒𝘼𝙔 ↯ $gate
[×] 𝘽𝘼𝙉𝙆 ↯ $bank
[×] 𝙏𝙔𝙋𝙀 ↯ $bininfo
[×] 𝘾𝙊𝙐𝙉𝙏𝙍𝙔 ↯ $country
- - - - - - - - - - - - - - - - - - -
|×| 𝙈𝘼𝙓 𝙏𝙄𝙈𝙀 ↯ 25 𝙎𝙀𝘾
|×| 𝙍𝙀𝙌 𝘽𝙔 ↯ @$username</b>");

    $end_time = microtime(true);
    $time = number_format($end_time - $start_time, 2);
    //======checker part end=========//



    if (strpos($curl11, 'authenticate_successful')) {
        $response = "

<b>💳</b>  <code>$lista</code>
⌬ 𝙂𝘼𝙏𝙀𝙒𝘼𝙔 ↯ <code>$gate</code>
⌬ 𝙍𝙀𝙎𝙋𝙊𝙉𝙎𝙀 ↯ <code>$Status</code>

⌬ 𝘽𝙄𝙉 𝙄𝙉𝙁𝙊 ↯ <code>$bininfo</code> 
⌬ 𝘽𝘼𝙉𝙆 ↯ <code>$bank</code>
⌬ 𝘾𝙊𝙐𝙉𝙏𝙍𝙔 ↯ <code>$country</code>

𝙏𝙄𝙈𝙀 ↯ <code>$time Seconds</code>
$botu";
        sleep(1);
        edit_sent_message($chatId, $sent_message_id, $response);

        } else {
        $response = "𝘼𝙋𝙋𝙍𝙊𝙑𝙀𝘿 ✅

<b>💳</b>  <code>$lista</code>
⌬ 𝙂𝘼𝙏𝙀𝙒𝘼𝙔 ↯ <code>Special Grade</code>
⌬ 𝙍𝙀𝙎𝙋𝙊𝙉𝙎𝙀 ↯ <code>Success</code>

⌬ 𝘽𝙄𝙉 𝙄𝙉𝙁𝙊 ↯ <code>$bininfo</code> 
⌬ 𝘽𝘼𝙉𝙆 ↯ <code>$bank</code>
⌬ 𝘾𝙊𝙐𝙉𝙏𝙍𝙔 ↯ <code>$country</code>

𝙏𝙄𝙈𝙀 ↯ <code>$time Seconds</code
";
        sleep(1);
        edit_sent_message($chatId, $sent_message_id, $response);
    }
}
