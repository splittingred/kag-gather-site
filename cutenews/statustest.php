<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>KAG Gather</title>
  <meta http-equiv="Content-Language" content="English">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link rel="stylesheet" type="text/css" href="style.css" media="screen">
  <link rel="shortcut icon" href="images/favicon.ico">
</head>
<body>

<div id="header">
  <h1><img src="kagbanner.png" width="800" height="148"></h1>
</div>
										
<div id="wrap">
  <div id="content">
  <div id="ribbon">
    	 <a href="index.html"><img src="menuimg/home1.png" onMouseOver="this.src='menuimg/home1hover.png'" onMouseOut="this.src='menuimg/home1.png'"></a>
         <a href="chat.html"><img src="menuimg/play2.png" onMouseOver="this.src='menuimg/play2hover.png'" onMouseOut="this.src='menuimg/play2.png'"></a>
         <a href="https://forum.kag2d.com/threads/kag-gather-rules-last-updated-18-03-2013.12175/"><img src="menuimg/rules3.png" onMouseOver="this.src='menuimg/rules3hover.png'" onMouseOut="this.src='menuimg/rules3.png'"></a>
         <a href="https://forum.kag2d.com/social-forums/kag-gather.545/"><img src="menuimg/forum4.png" onMouseOver="this.src='menuimg/forum4hover.png'" onMouseOut="this.src='menuimg/forum4.png'"></a>
         <a href="https://forum.kag2d.com/threads/kag-gather-guide.12174/"><img src="menuimg/about5.png" onMouseOver="this.src='menuimg/about5hover.png'" onMouseOut="this.src='menuimg/about5.png'"></a>
         <a href="status.html"><img src="menuimg/status6.png" onMouseOver="this.src='menuimg/status6hover.png'" onMouseOut="this.src='menuimg/status6.png'"></a>
   </div>
<div id="status">
<center>
		<?php

function get_page($url) {
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

class kagAPI{
    const url = "https://api.kag2d.com/server";

    function online($ip, $port) {
        echo self::url . "/ip/$ip/port/$port\n";
        $page = get_page(self::url . "/ip/$ip/port/$port/status");
        $json = json_decode($page);
        if(is_null($json)) {
            return false;
        }
        return (bool)$json->serverStatus->connectable;
    }
}

$kag = new kagAPI();
echo $kag->online("5.39.93.105", 10001) ? "true" : "false";
echo "\n";
?>
</center> 
</div>

<div id="footwrap">
  <div id="footer">
    <small><strong><font color="white">KAG Gather - © Copyright 2013 - Made and maintained by ilaks | <a href="http://kag2d.com" >kag2d.com</a><a> - <a href="login.php">login page</a>
  </div>
  </div>
</div>

</body>
</html>