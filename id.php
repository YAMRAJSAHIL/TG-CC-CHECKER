<?php
include __DIR__."/../config/variables.php";
include __DIR__."/config/users.php";
include_once __DIR__."/../functions/bot.php";
include_once __DIR__."/../functions/functions.php";




if ((strpos($message, "/id") === 0)||(strpos($message, "!id") === 0)||(strpos($message, ".id") === 0)||(strpos($message, "!start") === 0)||(strpos($message, "/id") === 0)||(strpos($message, "/id") === 0)){
    
    bot('sendmessage',[
            'chat_id'=>$chat_id,
            'text'=>"<b>   𝙄𝘿 𝙇𝙤𝙤𝙠𝙪𝙥</b> ✅
<b>[↯] 𝗬𝗼𝘂𝗿 𝗜𝗗:</b> <code>$userId</code>
<b>[↯] 𝗚𝗿𝗼𝘂𝗽 𝗜𝗗: </b><code>$chat_id</code>
<b>[↯] 𝗨𝘀𝗲𝗿</b>: @".$username."
<b>[↯] 𝗖𝗼𝗺𝗺𝗮𝗻𝗱 👉 /cmds </b> ✅

 <b>💎 Bot By</b> ➔ @hackedworld69",
            'parse_mode'=>'html',
            'reply_to_message_id'=> $message_id
            ]);
}


?>