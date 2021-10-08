<?php

//////////////// CONFIG ////////////////
/*	Server IP				*/	$teamspeak['address'] = '';
/*	UDP Port				*/	$teamspeak['udp'] = '9987';
/*	Query Port				*/	$teamspeak['tcp'] = '10011';
/*	Query login				*/	$teamspeak['login'] = 'serveradmin';
/*	Query pass				*/	$teamspeak['password'] = '';
/*	Bot nickname			*/	$bot['name'] = 'VPN Guard';
/*	Bot default channel		*/	$bot['default_channel'] = 1; 
/*	Interval in sec			*/	$bot['interval'] = 1; 
/*	Message to client		*/	$message = "Turn the VPN off";
/*	Poke to client			*/	$poke = "";
/*	Kick message			*/	$kick_message = 'VPN detected';
/*	Allowed VPN Servergroup	*/	$vpn_allowed_servergroup = array(231);
/*	Server ID				*/	$default = 1;
/*	Log 1 for on			*/	$log = 1;
    
//////////////// CONFIG END //////////////// 

//////////////// FUNCTION ////////////////
date_default_timezone_set('Europe/Warsaw');
require_once 'lib/ts3admin.class.php';
require_once 'lib/helper.php';

//START VPN	CHECK
function vpn($user_ip)
{
	/*     CONFIG     */
	$open_ports = 0;
	$ports_to_kick = 1; 
	$detect_ports = '';
	/*    CONFIG END     */
	
	/* ############### TCP START ############### */
	$ports = array(
	/*	 PPTP	*/ 1723,
	/* OpenVPN 	*/ 1194, 443, 8888, 992
	);
	foreach($ports as $port)
	{
		if ($fp = fsockopen("tcp://".$user_ip, $port, $errno, $errstr, 1))
		{
			$open_ports++;
			$detect_ports .= "TCP: ".$port."<br>";
			fclose($fp);
		}
	}
	/* ############### TCP END ############### */	
	
	/* ############### UDP START ############### */
	
	$ports_udp = array(
	/* OpenVPN 	*/ 1194, 53, 80, 8888, 992
	);	
	foreach($ports_udp as $port_udp)
	{
		$fp = fsockopen("udp://".$user_ip, $port_udp, $errno, $errstr);
		socket_set_timeout($fp, 1);	 
		fwrite($fp, "\x38\xa1\xd6\x91\xd6\xa2\x9f\xb3\x2b\x00\x00\x00\x00\x00");
		$recived = fread($fp, 8192);
		$recived_all .= $recived." (".(strlen($recived)).") <br>";
		$size = strlen($recived);
		if ( $size >= 25)
		{
			$detect_ports .= "UDP: ".$port_udp."<br>";
			$open_ports++;
			$open_ports++;
		}
		fclose($fp);	
	}
	/* ############### UDP END ############### */	

	/* ############### L2TP START ############### */
	
	$fp = fsockopen("udp://".$user_ip, 500, $errno, $errstr);
	socket_set_timeout($fp, 1);	
	fwrite($fp, "\x5b\x7c\x32\x1a\x6a\x65\x38\x98\x00\x00\x00\x00\x00\x00\x00\x00\x01\x10\x02\x00\x00\x00\x00\x00\x00\x00\x01\x38\x0d\x00\x00\xc8\x00\x00\x00\x01\x00\x00\x00\x01\x00\x00\x00\xbc\x01\x01\x00\x05\x03\x00\x00\x24\x01\x01\x00\x00\x80\x01\x00\x05\x80\x02\x00\x02\x80\x04\x00\x0e\x80\x03\x00\x01\x80\x0b\x00\x01\x00\x0c\x00\x04\x00\x00\x70\x80\x03\x00\x00\x24\x02\x01\x00\x00\x80\x01\x00\x05\x80\x02\x00\x02\x80\x04\x00\x02\x80\x03\x00\x01\x80\x0b\x00\x01\x00\x0c\x00\x04\x00\x00\x70\x80\x03\x00\x00\x24\x03\x01\x00\x00\x80\x01\x00\x05\x80\x02\x00\x01\x80\x04\x00\x02\x80\x03\x00\x01\x80\x0b\x00\x01\x00\x0c\x00\x04\x00\x00\x70\x80\x03\x00\x00\x24\x04\x01\x00\x00\x80\x01\x00\x01\x80\x02\x00\x02\x80\x04\x00\x01\x80\x03\x00\x01\x80\x0b\x00\x01\x00\x0c\x00\x04\x00\x00\x70\x80\x00\x00\x00\x24\x05\x01\x00\x00\x80\x01\x00\x01\x80\x02\x00\x01\x80\x04\x00\x01\x80\x03\x00\x01\x80\x0b\x00\x01\x00\x0c\x00\x04\x00\x00\x70\x80\x0d\x00\x00\x18\x1e\x2b\x51\x69\x05\x99\x1c\x7d\x7c\x96\xfc\xbf\xb5\x87\xe4\x61\x00\x00\x00\x04\x0d\x00\x00\x14\x40\x48\xb7\xd5\x6e\xbc\xe8\x85\x25\xe7\xde\x7f\x00\xd6\xc2\xd3\x0d\x00\x00\x14\x90\xcb\x80\x91\x3e\xbb\x69\x6e\x08\x63\x81\xb5\xec\x42\x7b\x1f\x00\x00\x00\x14\x26\x24\x4d\x38\xed\xdb\x61\xb3\x17\x2a\x36\xe3\xd0\xcf\xb8\x19");
	$recived = fread($fp, 8192);
	$size2 = strlen($recived);
		if ( $size2 >= 100)
		{
			$detect_ports .= "L2TP: 500 <br>";
			$open_ports++;
			$open_ports++;
		}
	fclose($fp);
		
	/* ############### L2TP END ############### */
	
			return $open_ports;	
}
//END VPN CHECK 

//////////////// FUNCTION END ////////////////

//////////////// BOT ////////////////
$query = new ts3admin($teamspeak['address'], $teamspeak['tcp']);

if($query->getElement('success', $query->connect()))
{
    $query->login($teamspeak['login'],$teamspeak['password']);
    $query->selectServer($teamspeak['udp']);
    $query->setName($bot['name']);
	$core = $query->getElement('data',$query->whoAmI());
    $query->clientMove($core['client_id'],$bot['default_channel']);
    $users = $query->getElement('data',$query->clientList('-groups -voice -away -times'));
    while(true) 
	{ 
    $users = $query->getElement('data',$query->clientList('-groups -voice -away -times'));
        
        foreach ($users as $client) 
		{
		$info = $query->getElement('data',$query->clientInfo($client['clid']));
		$user_groups = explode(',',$client['client_servergroups']);
			 
            if ( ($info['client_version'] != "ServerQuery") && (!(isInGroup($user_groups,$vpn_allowed_servergroup))) )
			{
				$clid = $client['clid'];
				if ( ((empty($user[$clid])) && (empty($user_ip[$clid]))) || ($user_ip[$clid] != $info['connection_client_ip']))
				{
					$user[$clid] = vpn($info['connection_client_ip']);
					$user_ip[$clid] = $info['connection_client_ip'];
				}
				if (filter_var($info['connection_client_ip'], FILTER_VALIDATE_IP))
				{
					if ($user[$clid] >= 3)
					{	
						if ($message != "")
						{
							$query->sendMessage(1, $client['clid'], $message);
						}
						if ($poke != "")
						{
							$query->clientPoke($client['clid'], $poke);
						}

						$query->clientKick($client['clid'], "server", $kick_message." [".$user[$clid]."]");
						
						//unset ($user[$clid]);
						//LOGGING
						if ($log == 1)
						{
							$fp=fopen("log.txt", "a"); 
							flock($fp, 3); 
							fwrite($fp, "".date('d.m.Y H:i')."	");
							fwrite($fp, "Detect VPN"." [".$user[$clid]."]"."	");
							fwrite($fp, "".$client['client_nickname']."	"); 
							fwrite($fp, "".$info['connection_client_ip']."	");
							fwrite($fp, "".$info['client_unique_identifier']."	");
							fwrite($fp, "\n");
							fclose($fp);
						}
						
						
					}
				}      
            }
        }

		
		
		
        sleep($bot['interval']);
    }
}
//////////////// BOT END ////////////////
?>
