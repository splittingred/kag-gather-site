<?php
if (empty($_REQUEST['u'])) die();
if (empty($_REQUEST['s'])) $_REQUEST['s'] = 'medium';

require_once dirname(__FILE__).'/lib/Cache.php';

$username = str_replace(array('/','.'),'',urldecode($_REQUEST['u']));
$size = str_replace(array('/','.'),'',urldecode($_REQUEST['s']));
if (empty($username) || empty($size)) die();

$cache = new Cacher();
$avatar = $cache->get($username.'.avatar');
if (empty($avatar)) {
    $a = @file_get_contents('https://api.kag2d.com/player/'.$username.'/avatar');
    if (!empty($a)) {
        $avatar = json_decode($a,true);
        if (!empty($avatar)) {
            $cache->set('avatar/'.$username.'.avatar',$avatar,3600);
        }
    }
}
if (empty($avatar)) {
    header('Location: /images/mm.jpg');
} elseif (array_key_exists($size,$avatar)) {
    header('Location: '.$avatar[$size]);
}
die();
