<?php
if ((strpos($message, "/adm") === 0)||(strpos($message, "!adm") === 0)||(strpos($message, ".adm") === 0))
{
  $owners = file_get_contents('Database/owner.txt');
  $admins = explode("\n", $owners);
  if (!in_array($userId, $admins)) {
      sendMessage($chatId,"𝙊𝙊𝙋𝙎! 𝙔𝙊𝙐 𝘼𝙍𝙀 𝙉𝙊𝙏 𝘼𝙉 𝘼𝘿𝙈𝙄𝙉  ❌",$messageId);
  } else
  {
  sendMessage($chatId,urlencode(
    "<b>
Admin commands here

Code generate: /code day-amount
Usage: <code>/code 1-1</code>

Delete expired: /remexp
Usage: <code>/remexp</code>


</b>"),$messageId);
  }
}

?>
