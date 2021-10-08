<?php

######Server
/*	Server IP				*/	$teamspeak['address'] = '127.0.0.1';
/*	UDP Port				*/	$teamspeak['udp'] = '9987';
/*	Query Port				*/	$teamspeak['tcp'] = '10011';
/*	Query login				*/	$teamspeak['login'] = 'serveradmin';
/*	Query pass				*/	$teamspeak['password'] = '';
/*	Bot nickname			*/	$bot['name'] = 'ChannelBot';
/*	Bot default channel		*/	$bot['default_channel'] = 1; 
/*	Server ID				*/	$default = 1;

#######Config
/*  Your TimeZone			*/	$timezone = 'America/Los_Angeles';
/*	Rank to create channel	*/	$createChannel = array(26);
/*	Main Channel	 		*/	$GlobalChannel = 280;
/*	Channel Admin Gruop		*/	$cadminGruop = 5;
/*	Message To user			*/	$infotoUser = 'You were moved on your new channel';

#######Channel
/*	Default Channel Name	*/	$NameChannel = 'New Private Channel';
/*	Channel Topic			*/	$cTopic = 'Here Change Date';
/*	Codeck 4 = Voice		*/  $CHcodec = 4;
/*	Quality					*/  $CHquality = 6;
/*	Channel Desc1			*/  $cDesc['Title'] = "[size=11]Private Channel[/size]\n\n";
/*	Channel Desc2			*/	$cDesc['Number'] = "Channel Number:";
/*	Channel Desc3			*/  $cDesc['User'] = "Channel Owner:";
/*	Channel Desc4			*/  $cDesc['Date'] = "Created:";
/*	Channel Desc5			*/  $cDesc['Info'] = "\n\n Informations for user";

#######SubChannel
/*	NameSubChannel 			*/	$nameSubChannels = ". Subchannel";
/*	How many Subchannels	*/	$SubChannels = 2;
/*	Codeck 4 = Voice		*/  $SCHcodec = 4;
/*	Quality					*/  $SCHquality = 6;

?>