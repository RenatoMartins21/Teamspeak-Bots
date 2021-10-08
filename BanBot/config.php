<?php

/*	Server IP				*/	$teamspeak['address'] = '127.0.0.1';
/*	UDP Port				*/	$teamspeak['udp'] = '9987';
/*	Query Port				*/	$teamspeak['tcp'] = '10011';
/*	Query login				*/	$teamspeak['login'] = 'serveradmin';
/*	Query pass				*/	$teamspeak['password'] = 'pass';
/*	Bot nickname			*/	$bot['name'] = 'BanBot';
/*	Bot default channel		*/	$bot['default_channel'] = 1; 
/*	Server ID				*/	$default = 1;
/*	Message to client		*/	$message = "";

/*	Ban 3h Servergroup	*/	$ban3h = array(12);
/*	Time Ban 3H			*/	$time3h = 10800; 
/*	Reason Ban 3H 		*/  $banreason3h = "3 Hours";

/*	Ban 3D Servergroup	*/	$ban3d = array(13);
/*	Time Ban 3D			*/	$time3d = 259200; 
/*	Reason Ban 3D 		*/  $banreason3d = "3 Days";

/*	Ban 7D Servergroup	*/	$ban7d = array(14);
/*	Time Ban 7D			*/	$time7d = 604800; 
/*	Reason Ban 7D 		*/  $banreason7d = "7 Days";

/*	Ban 30D Servergroup	*/	$ban30d = array(15);
/*	Time Ban 30D		*/	$time30d = 2592000; 
/*	Reason Ban 30D 		*/  $banreason30d = "30 Days";


/*	Ban Perm Servergroup*/	$banperm = array(16);
/*	Time Ban Perm	 	*/	$timeperm = 999999999999; 
/*	Reason Ban Perm 	*/  $banreasonperm = "Perm";

?>