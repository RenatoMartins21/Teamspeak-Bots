<?php
error_reporting(0);
 
/*
U MUST HAVE php5, php5-gd
ADD IT TO CRONTAB -> "* * * * * cd /var/www/banner/ && php run_as_cron.php > /dev/null 2>&1"

/* ######### CONFIGURATION ######### */
$config = array (
	'host' => '',
	'udp' => '9987',
	'query' => '10011',
	'nickname' => 'BannerOnline',
	'login' => 'serveradmin',
	'password' => '',
);
$cachetime = 0; //Cache 60 sec
/* ######### CONFIGURATION END ######### */
$patch = dirname(__FILE__).'/';
require_once("ts3admin.class.php");
global $tsAdmin;
$tsAdmin = new ts3admin($config['host'], $config['query']);
if($tsAdmin->succeeded($tsAdmin->connect())) 
{    	
$tsAdmin->login($config['login'], $config['password']);
$tsAdmin->selectServer($config['udp']);
$tsAdmin->setName($config['nickname']);
$info = $tsAdmin->getElement('data', $tsAdmin->serverInfo());

$online = ($info['virtualserver_clientsonline'] - $info['virtualserver_queryclientsonline']);
$clients = $tsAdmin->clientList("-uid -away -voice -times -groups -info -country -icon -ip -badges -names -clientDBID");
//print_r($clients['data']);

//MESSAGE
$news = $tsAdmin->getElement('data', $tsAdmin->channelInfo(1));
$news = $news['channel_description'];	
$news = base64_encode($news);

$dbfile = "db.txt";
$db = fopen($dbfile, "w"); 
flock($fp, 5); 

$client_db = 
"Status"
." | ".
$config['host']
." | ".
$info['virtualserver_port']
." | ".
$info['virtualserver_name']
." | ".
$online
." | ".
$info['virtualserver_maxclients']
." | ".
$info['virtualserver_version']
." | ".
$info['virtualserver_total_ping']
." | ".
$info['virtualserver_total_packetloss_total']
." | ".
$news
." | ".
"\n";





$i = 0;
foreach ($clients['data'] as $client)
{
	$i++;
	if (is_writeable($dbfile))
		{
			
			$client_db .=
			$client['client_database_id']
			." | ".
			$client['client_nickname']
			." | ".
			$client['client_unique_identifier']
			." | ".
			$client['client_version']
			." | ".
			$client['client_platform']
			." | ".
			$client['client_country']
			." | ".
			$client['connection_client_ip']
			." | ".
			"\n";	
		} 
		else  
		{
			echo "Error with save data...";
		}		
}

			if (!$db_save = fopen($dbfile, "a")) 
			{
				echo "Error with open file...";
			}
			if (fwrite($db_save, $client_db) === FALSE) 
			{
				echo "Error with add data.";
			}		
			fclose($db_save);
	
}
$tsAdmin->logout(); 

echo "\n END";
?>