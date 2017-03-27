<?php
ini_set('display_errors', true);
ini_set('error_reporting', E_ALL);
error_reporting(E_ALL);

header ('Content-Type: image/png');

$width = 150;
$heigh = 15;
$text_size = 11;
$topic_id = 118018; # ID темы, где автором является аккаунт, чей онлайн показывать
$post_id = 118018; # ID сообщения, где автором является аккаунт, чей онлайн показывать

$im = @imagecreatetruecolor($width, $heigh) or die('Cannot Initialize new GD image stream');

$doc = new DOMDocument();
libxml_use_internal_errors(true);
$doc->loadHTML(file_get_contents("http://forum.minecraft-galaxy.ru/topic/{$topic_id}"));
libxml_use_internal_errors(false);

$xpath = new DOMXPath($doc);

$_ingame = $xpath->query('//*[@id="row1-'.$post_id.'"]/td[1]/div[1]/img[1]');
$_ingame = $_ingame->item(0)->getAttribute('src');

$_inforum = $xpath->query('//*[@id="row1-'.$post_id.'"]/td[1]/div[1]/img[2]');
$_inforum = $_inforum->item(0)->getAttribute('src');

$status = 'Менеджер оффлайн';
$text_color = imagecolorallocate($im, 255, 0, 0);

if(substr_count($_inforum, 'online')){
	$status = 'Менеджер онлайн';
	$text_color = imagecolorallocate($im, 0, 255, 0);
}

if(substr_count($_ingame, 'online')){
	$status = 'Менеджер в игре';
	$text_color = imagecolorallocate($im, 0, 255, 0);
}

 
$col_transparent = imagecolorallocatealpha($im, 255, 255, 255, 255);	  

imagefill($im, 0, 0, $col_transparent);
imagecolortransparent ($im, $col_transparent);

imagettftext($im, $text_size, 0, 2, $text_size, $text_color, './font.ttf', $status);

imagepng($im);
imagedestroy($im);
exit;
?>
