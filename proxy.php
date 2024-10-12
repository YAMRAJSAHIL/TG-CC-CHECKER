<?php


/////////////////////==========[HTTP]==========////////////////

if (strpos($text, "/http") === 0) {
    // Step 1: Send "Processing..." message
    $urlProcessing = 'https://api.telegram.org/bot' . $botToken . '/sendMessage';
    $postProcessing = array(
        'chat_id' => $chat_id,
        'text' => "𝗣𝗿𝗼𝗰𝗲𝘀𝘀𝗶𝗻𝗴...",
    );

    $chProcessing = curl_init();
    curl_setopt($chProcessing, CURLOPT_URL, $urlProcessing);
    curl_setopt($chProcessing, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($chProcessing, CURLOPT_POST, 1);
    curl_setopt($chProcessing, CURLOPT_POSTFIELDS, $postProcessing);
    $result = curl_exec($chProcessing);
    $resultArray = json_decode($result, true);
    $messageId = $resultArray['result']['message_id'];
    curl_close($chProcessing);

    // Your existing code to fetch proxies and prepare them
    file_put_contents("fresh_http.txt", file_get_contents("https://api.proxyscrape.com/?request=getproxies&proxytype=http&timeout=5000&country=all&ssl=all&anonymity=all"));
    $amount = file_get_contents("https://api.proxyscrape.com?request=amountproxies&proxytype=http&timeout=5000&country=all&ssl=all&anonymity=all");
    $last_updated = file_get_contents('https://api.proxyscrape.com?request=lastupdated&proxytype=http');

    // Step 2: Delete "Processing..." message before sending the document
    $urlDelete = 'https://api.telegram.org/bot' . $botToken . '/deleteMessage';
    $postDelete = array(
        'chat_id' => $chat_id,
        'message_id' => $messageId,
    );

    $chDelete = curl_init();
    curl_setopt($chDelete, CURLOPT_URL, $urlDelete);
    curl_setopt($chDelete, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($chDelete, CURLOPT_POST, 1);
    curl_setopt($chDelete, CURLOPT_POSTFIELDS, $postDelete);
    curl_exec($chDelete);
    curl_close($chDelete);

    // Your existing code to send the document
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot'.$botToken.'/sendDocument');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    $post = array(
      'chat_id' => $chat_id,
      'caption' => "*Proxy type:* `HTTPS` ✅\n⌬ *Country:* `All`\n⌬ *Timeout:* `5000`\n⌬ *Total proxy count:* `$amount`\n⌬ *Last Updated:* `$last_updated`\n---------------------------\n*Uploaded by @hackedworld69 *",
      'parse_mode' => "markdown",
      'reply_to_message_id'=> $message_id,
      'document' => new CURLFile(realpath('fresh_http.txt'))
    );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_exec($ch);
          }


/////////////////////==========[SOCKS4]==========////////////////

if (strpos($text, "/socks4") === 0){
        // Step 1: Send "Processing..." message
    $urlProcessing = 'https://api.telegram.org/bot' . $botToken . '/sendMessage';
    $postProcessing = array(
        'chat_id' => $chat_id,
        'text' => "𝗣𝗿𝗼𝗰𝗲𝘀𝘀𝗶𝗻𝗴...",
    );

    $chProcessing = curl_init();
    curl_setopt($chProcessing, CURLOPT_URL, $urlProcessing);
    curl_setopt($chProcessing, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($chProcessing, CURLOPT_POST, 1);
    curl_setopt($chProcessing, CURLOPT_POSTFIELDS, $postProcessing);
    $result = curl_exec($chProcessing);
    $resultArray = json_decode($result, true);
    $messageId = $resultArray['result']['message_id'];
    curl_close($chProcessing);

    // Your existing code to fetch proxies and prepare them
            file_put_contents("fresh_socks4.txt", file_get_contents("https://api.proxyscrape.com/?request=getproxies&proxytype=socks4&timeout=5000&country=all"));
            $amount = file_get_contents("https://api.proxyscrape.com?request=amountproxies&proxytype=socks4&timeout=5000&country=all");
            $last_updated = file_get_contents('https://api.proxyscrape.com?request=lastupdated&proxytype=socks4');
            
    // Step 2: Delete "Processing..." message before sending the document
    $urlDelete = 'https://api.telegram.org/bot' . $botToken . '/deleteMessage';
    $postDelete = array(
        'chat_id' => $chat_id,
        'message_id' => $messageId,
    );

    $chDelete = curl_init();
    curl_setopt($chDelete, CURLOPT_URL, $urlDelete);
    curl_setopt($chDelete, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($chDelete, CURLOPT_POST, 1);
    curl_setopt($chDelete, CURLOPT_POSTFIELDS, $postDelete);
    curl_exec($chDelete);
    curl_close($chDelete);
    
    // Your existing code to send the document
            $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot'.$botToken.'/sendDocument');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
      $post = array(
        'chat_id' => $chat_id,
        'caption' => "*Proxy type:* `SOCKS4` ✅\n⌬ *Country:* `All`\n⌬ *Timeout:* `5000`\n⌬ *Total proxy count:* `$amount`\n⌬ *Last Updated:* `$last_updated`\n---------------------------\n*Uploaded by @hackedworld69 *",
        'parse_mode' => "markdown",
        "reply_to_message_id"=> $message_id,
        'document' => new CURLFile(realpath('fresh_socks4.txt'))
        );
      curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

      curl_exec($ch);
          }


/////////////////////==========[SOCKS5]==========////////////////

if (strpos($text, "/socks5") === 0){
            // Step 1: Send "Processing..." message
    $urlProcessing = 'https://api.telegram.org/bot' . $botToken . '/sendMessage';
    $postProcessing = array(
        'chat_id' => $chat_id,
        'text' => "𝗣𝗿𝗼𝗰𝗲𝘀𝘀𝗶𝗻𝗴...",
    );

    $chProcessing = curl_init();
    curl_setopt($chProcessing, CURLOPT_URL, $urlProcessing);
    curl_setopt($chProcessing, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($chProcessing, CURLOPT_POST, 1);
    curl_setopt($chProcessing, CURLOPT_POSTFIELDS, $postProcessing);
    $result = curl_exec($chProcessing);
    $resultArray = json_decode($result, true);
    $messageId = $resultArray['result']['message_id'];
    curl_close($chProcessing);

    // Your existing code to fetch proxies and prepare them
            file_put_contents("fresh_socks5.txt", file_get_contents("https://api.proxyscrape.com/?request=getproxies&proxytype=socks5&timeout=5000&country=all"));
            $amount = file_get_contents("https://api.proxyscrape.com?request=amountproxies&proxytype=socks5&timeout=5000&country=all");
            $last_updated = file_get_contents('https://api.proxyscrape.com?request=lastupdated&proxytype=socks5');
    // Step 2: Delete "Processing..." message before sending the document
    $urlDelete = 'https://api.telegram.org/bot' . $botToken . '/deleteMessage';
    $postDelete = array(
        'chat_id' => $chat_id,
        'message_id' => $messageId,
    );

    $chDelete = curl_init();
    curl_setopt($chDelete, CURLOPT_URL, $urlDelete);
    curl_setopt($chDelete, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($chDelete, CURLOPT_POST, 1);
    curl_setopt($chDelete, CURLOPT_POSTFIELDS, $postDelete);
    curl_exec($chDelete);
    curl_close($chDelete);
    
    // Your existing code to send the document        
            $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot'.$botToken.'/sendDocument');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
      $post = array(
        'chat_id' => $chat_id,
        'caption' => "*Proxy type:* `SOCKS5` ✅\n⌬ *Country:* `All`\n⌬ *Timeout:* `5000`\n⌬ *Total proxy count:* `$amount`\n⌬ *Last Updated:* `$last_updated`\n---------------------------\n*Uploaded by @hackedworld69 *",
        'parse_mode' => "markdown",
        "reply_to_message_id"=> $message_id,
        'document' => new CURLFile(realpath('fresh_socks5.txt'))
        );
      curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

      curl_exec($ch);
          }

?>