<?php	
if ($_COOKIE['3xi90']==1)
{
  header('Location: ../error3.html'); 
}
else
{
 function getRealIpAddr()
{
    if(!empty($_SERVER['HTTP_CF_CONNECTING_IP']))
    {
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) 
    {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   
    {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
$_SERVER['REMOTE_ADDR'] = getRealIpAddr();

$uidweb = $_POST['uid'];

include 'config.php';
require_once 'lib/ts3admin.class.php';
$query = new ts3admin($ip, $portquery);
if($query->getElement('success', $query->connect()))
{
    $query->login($login,$pass);
    $query->selectServer($port);
    $query->setName("(Gzpro.net)".$nick);
			
	$cldbid = $query->clientGetDbIdFromUid($uidweb);	
	
	$clid =	$query->getElement('data',$query->clientGetIds($uidweb));	
	if($clid){	
			foreach ($cldbid as $clientuid)
				{				
				$cldbid = $clientuid["cldbid"];
					foreach($_POST['ranks_list'] as $ranks){
						foreach ($clid as $cid){	
		
						$id = $cid["clid"];
						$client_ip = $query->clientInfo($id);
		
							foreach ($client_ip as $clip){
								$ip = $clip["connection_client_ip"];
								$u_ranks = $clip["client_servergroups"];
								$ranksarray = explode(",", $u_ranks);
								$num_ranks = count($ranksarray);																
							}	
						}
						if($ip == $_SERVER['REMOTE_ADDR']){
							if($num_ranks < $rank_limit){						
							$query->serverGroupAddClient($ranks,$cldbid);
							header('Location: ../done.html');
							}else{header('Location: ../error1.html'); }
						}else{header('Location: ../error2.html'); }	
					}															
				}				
	}else{header('Location: ../error4.html');}	
}
$query->logout();
setcookie("3xi90",1,time()+$flood);
}



?>