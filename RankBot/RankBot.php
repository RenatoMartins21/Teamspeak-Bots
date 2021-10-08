<?php

/////////////////////////////////////////////////
/* ==============[CONFIGURATION]============== */
$host = "127.0.0.1";	//IP of the server
$port = "10011";		//Query port
$server_port = "9987";	//Virtual server port
$user = "serveradmin";	//Query login username
$pass = "";			//Query login password
$name = 'RankBot';		//Bot's name
$debug = false;			//When enabled will print some debug info
$defaultchannel = 5;	//Channel to move
/////////////////////////////////////////////////

if($debug) echo("Loading framework\n");
require_once("lib/TeamSpeak3/TeamSpeak3.php");
goto main;
main:
// connecting to the server
if($debug) echo("Connecting\n");
$ts3 = TeamSpeak3::factory("serverquery://".$user.":".$pass."@".$host.":".$port."/?server_port=".$server_port."&blocking=0");
$ts3->request('clientupdate client_nickname='.$name); // setting the name
$ts3->clientMove($ts3->whoamiGet("client_id"), $defaultchannel);
$connect = false;
if($debug) echo("Registering event\n");
// registering event listener
$ts3->notifyRegister("channel");
$ts3->notifyRegister("textchannel");
$ts3->notifyRegister("textprivate");
if($debug) echo("Registering callback\n");
// registering callback function
TeamSpeak3_Helper_Signal::getInstance()->subscribe("notifyTextmessage", "onTextmessage");
if($debug) echo("Waiting for event\n");
// waiting for event
try {while(1) $ts3->getAdapter()->wait();}
catch(TeamSpeak3_Transport_Exception $error) {$connect = true;}
  
function fetchGroup($user)
{
  global $ts3, $debug;
  if($debug) echo("Fetching servergroup of user: ".$user."\n");
  $id_request = $ts3->request("clientfind pattern=".$user)->toString();
  if($debug) echo("Clientfind string array:\n"); print_r($id_request); echo("\n");
  $id_result = explode(" ", $id_request);
  $id = substr($id_result['0'], 5);
  if($debug) echo("Invoker's ID: ".$id."\n");
  $group_request = $ts3->request("clientinfo clid=".$id)->toString();
  if($debug) echo("Group find string array:\n"); print_r($group_request); echo("\n");
  $group_result = explode(" ", $group_request);
  $servergroup = substr($group_result['21'], 20);
  if($debug) echo("User ".$user." is member of servergroup: ".$servergroup."\n");
  return $servergroup;
}
function gizisent($tekst,$ts3,$id){

$ts3->execute("sendtextmessage", array("msg" => $tekst, "target" => $id, "targetmode" => TeamSpeak3::   	  TEXTMSG_CHANNEL));

}
// called function on event
function onTextmessage(TeamSpeak3_Adapter_ServerQuery_Event $event, TeamSpeak3_Node_Host $host)
{
  global $ts3, $name, $debug;    
  $msg = $event["msg"];
  $invoker = $event["invokername"];
 
  if($invoker != $name) {
   
  if($debug) echo($invoker.": ".$msg."\n");
  
  if($debug) echo("User ".$invoker." passed security check\n");
 
 $invoker_db = $ts3->clientGetByName($invoker);
 
  if($invoker_db["client_unique_identifier"] == "DOgQ0YV9+wZ9YMdD3JPfhvlv/xqM=" OR $invoker_db["client_unique_identifier"] == "gWszaxdv1W+8KlIHafUe+ZdOaiI=")  {

 // preparing the command arguments
  $block = array(11, 26, 2);
  $values[1] = intval( $uid );
  $id_a = $ts3->getId();
  $arguments = explode(" ", $msg);
  if($debug) echo("Arguments:\n"); print_r($arguments);echo("\n");  
  switch ($arguments[0]) {
	case "!ping":
		gizisent("Pong!",$ts3,$id_a);
		break;
	case "!add":
		if (in_array($arguments[1], $block)){
		gizisent("Access denied",$ts3,$id_a);
		} else {
		$ts3->serverGroupClientAdd($arguments[1],$arguments[2]);		
		gizisent("Rank was add",$ts3,$id_a);
		}
		break;	  
	case "!del":
		if (in_array($arguments[1], $block)){
		gizisent("Access denied",$ts3,$id_a);
		} else {
		$ts3->serverGroupClientDel($arguments[1],$arguments[2]);		
		gizisent("Rank was remove",$ts3,$id_a);
		}
		break;			
	case "!info":
		gizisent("Project GzPro.net",$ts3,$id_a);
		break;	  
	case "!help":
		gizisent("Commands:
		!ping - test
		!add <id ServerGroup> <dbid user> - Giving Rank
		!del <id ServerGroup> <dbid user> - Remove Rank
		!info - Information Bot",$ts3,$id_a);
  }
 
}
}
}
if($connect) {
  if($debug) echo("Connection lost, reconnecting...\n");
  goto main; }
?>