<?php

require_once("libraries/TeamSpeak3/TeamSpeak3.php");
require_once("config.php");
###
try{
	$ts['bot'] = TeamSpeak3::factory("serverquery://".$bot['query_login'].":".$bot['query_password']."@".$bot['server_ip'].":".$bot['query_port']."/?server_port=".$bot['server_port']."&blocking=0");
	$ts['bot']->selfUpdate(array('client_nickname'=>$bot['query_nickname']));
}catch(TeamSpeak3_Adapter_ServerQuery_Exception $e){
	echo $e->getMessage();
}
// Check server packet loss every second.
while(true){
	sleep(1);
	$serverInfo = $ts['bot']->getInfo();
	$totalPacketloss = (float)$serverInfo["virtualserver_total_packetloss_total"]->toString() *100;
	
	echo $totalPacketloss;
	if($totalPacketloss >= 49.9999) {
		$ts['bot']->message("[COLOR=#CF000F][B]The server is experiencing an extreme amount of laggs. [Possible DDoS?](Average packet loss ".$totalPacketloss."%)[/COLOR]");
		sleep(30);
		continue;
	}
	else if($totalPacketloss >= 29.9999)
	{	
		$ts['bot']->message("[COLOR=#F89406][B]The server is experiencing alot of laggs. (Average packet loss ".$totalPacketloss."%)[/COLOR]");
		sleep(30);
		continue;
	}
	else if($totalPacketloss >= 18.9999)
	{	
		$ts['bot']->message("[COLOR=#F2784B][B]The server is experiencing moderate laggs. (Average packet loss ".$totalPacketloss."%)[/COLOR]");
		sleep(30);
		continue;
	}
	else if($totalPacketloss >= 9.9999)
	{
		$ts['bot']->message("[COLOR=#BDC3C7][B]The server is experiencing minor laggs. (Average packet loss ".$totalPacketloss."%)[/COLOR]");
		sleep(30);
		continue;
	}
}