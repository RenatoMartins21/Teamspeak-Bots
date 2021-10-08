<?php
/* ######### CONFIGURATION ######### */

$imgname = 'default.png';
$extension = 'png';
$font = 'Eras_Demi_ITC.ttf';
$dbfile = "db.txt";
$extension = 'png';
date_default_timezone_set('Europe/Warsaw');

/* ######### CONFIGURATION END ######### */

$patch = dirname(__FILE__).'/';
header('Content-Type: image/'.$extension);

// Function to get the client IP address
function get_client_ip() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
$currents_ip = get_client_ip();

//Connect to database
$db = file($dbfile);
for($i=0;$i<count($db);$i++) 
{ 
	if($i == 0)
	{
		list(
		$status[$i],
		$address[$i],
		$port[$i],
		$server_name[$i],
		$user_online[$i],
		$user_max[$i],
		$server_version[$i],
		$ping[$i],
		$packet_lost[$i],
		$news[$i]
		) = explode(" | ", $db[$i]);
	}
	else
	{
		list(
		$database_id[$i],
		$nickname[$i],
		$unique_id[$i],
		$client_version[$i],
		$os[$i],
		$country[$i],
		$client_ip[$i]
		) = explode(" | ", $db[$i]);
	}
}

$news = base64_decode($news[0]);	
$found = array_search($currents_ip, $client_ip);
$time = date("H:i");
$data = date("d.m.y");


$welcome = "Welcome";
$on = "on";
$severname = '"TeamSpeakName"';

$online = "Online:";
$datatxt = "Date:";
$timetext = "Time:";
$pingtxt = "Ping:";
$packet_losttxt = "P.Lost:";


$img = imagecreatefrompng($imgname);
$color =  ImageColorAllocate($img, 255, 255, 255);
$kolor =  ImageColorAllocate($img, 153, 0, 0);

imagettftext($img, 20, 0, 190, 230, $kolor, $patch. $font, $news );

imagettftext($img, 24, 0, 30, 50, $color, $patch. $font, $welcome );
imagettftext($img, 24, 0, 30, 100, $color, $patch. $font, $nickname[$found]);
imagettftext($img, 24, 0, 30, 150, $color, $patch. $font, $on );
imagettftext($img, 24, 0, 30, 200, $color, $patch. $font, $severname );


imagettftext($img, 22, 0, 350, 40, $color, $patch. $font, $online );
imagettftext($img, 22, 0, 500, 40, $color, $patch. $font, $user_online[0]+0);

imagettftext($img, 22, 0, 350, 80, $color, $patch. $font, $datatxt);
imagettftext($img, 22, 0, 500, 80, $color, $patch. $font, $data);

imagettftext($img, 22, 0, 350, 120, $color, $patch. $font, $timetext);
imagettftext($img, 22, 0, 500, 120, $color, $patch. $font, $time);

imagettftext($img, 22, 0, 350, 160, $color, $patch. $font, $pingtxt);
imagettftext($img, 22, 0, 500, 160, $color, $patch. $font, ''.number_format($ping[0],0,',','').' ms');

imagettftext($img, 22, 0, 350, 200, $color, $patch. $font, $packet_losttxt);
imagettftext($img, 22, 0, 500, 200, $color, $patch. $font, ''.number_format($packet_lost[0],2,',','').'%');


imagealphablending($img,false);
imagesavealpha($img,true);
imagepng($img);
imagedestroy($img);
die;


?>