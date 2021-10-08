<?php

include 'config.php';
require_once 'lib/ts3admin.class.php';
require_once 'lib/helper.php';


function before ($this, $inthat){
    return substr($inthat, 0, strpos($inthat, $this));
};

function firstchannel($GlobalChannel) {
        global $query;
        $channelList = $query->getElement('data',$query->channelList());
        $channelsInSection = array();
        $channelsIdList = array();
        foreach ((array) $channelList as $channel){
            if ($channel['pid'] == $GlobalChannel)
                $channelsInSection[] = $channel['channel_name'];
        }
        foreach ((array) $channelsInSection as $channelName){
            $channelsIdList[] = before('.',$channelName);
        }
        unset($channelsInSection,$channelList);
        for ($i=1;$i>=1;$i++) {
            if (!in_array($i,$channelsIdList))
                return $i;
        }
    }
function lastSchannel($cid) {
        global $query;
        $channelList = $query->getElement('data',$query->channelList());
        $channelSubs = array();
     
        foreach ((array) $channelList as $channel){
            if ($channel['pid'] == $cid)
                $channelSubs[] = $channel;
        }
        return @$channelSubs[count($channelSubs)-1] or false;
    }
function channelorder($chNum,$GlobalChannel) {
        global $query;
        $channelList = $query->getElement('data',$query->channelList());
        $channelsInSection = array();
        foreach ((array) $channelList as $channel){
            if ($channel['pid'] == $GlobalChannel)
                $channelsInSection[] = $channel; 
        }
        foreach ((array) $channelsInSection as $channel){
            $channelNum = before('.', $channel['channel_name']);
            if (($channelNum+1) == $chNum) {
                $channelSubs = lastSchannel($channel['cid']);
                if (is_array($channelSubs) == true) {
                    return $channelSubs['cid']; 
                } else {
                    return $channel['cid'];
                }
            }
        }
        return false;
    } 
 
$query = new ts3admin($teamspeak['address'], $teamspeak['tcp']);

if($query->getElement('success', $query->connect()))
{
    $query->login($teamspeak['login'],$teamspeak['password']);
    $query->selectServer($teamspeak['udp']);
    $query->setName("(GzPro.net)".$bot['name']);
    $core = $query->getElement('data',$query->whoAmI());
    $query->clientMove($core['client_id'],$bot['default_channel']);
    $users = $query->getElement('data',$query->clientList('-groups -voice -away -times'));
     
    while(1)
    {
        $users = $query->getElement('data',$query->clientList('-groups -voice -away -times -uid'));
     
        foreach ((array) $users as $client)           
        {
            $info = $query->getElement('data',$query->clientInfo($client['clid']));
            $user_groups = explode(',',$client['client_servergroups']);
         
            $clid = $client['clid'];
            $client_database_id = $client['client_database_id'];
            $userNick = $client['client_nickname'];
            $uid = $client['client_unique_identifier'];
                 
            $data = date('d.m.Y');
            $godz = date('H:i');
           
            $channelNumber = firstchannel($GlobalChannel);
            $NextChannel = channelorder($channelNumber,$GlobalChannel);         
         
            $desc = $cDesc['Title'];
            $desc .= $cDesc['Number']."[b] {$channelNumber} [/b]\n";
            $desc .= $cDesc['User']." [URL=client://{$clid}/{$uid}]{$userNick}[/URL]\n";
            $desc .= $cDesc['Date']."[b] {$data} {$godz}[/b]";
            $desc .= $cDesc['Info'];
         
         
                if ( ($info['client_version'] != "ServerQuery") && ((isInGroup($user_groups,$createChannel))))
                {             
                    $query->channelCreate(array(
                        "channel_name" => $channelNumber.". ".$NameChannel,
                        "channel_topic" => $cTopic,
                        "channel_description" => $desc,
                        "channel_flag_permanent" => true,
                        "channel_codec" => $CHcodec,
                        "channel_codec_quality" => $CHquality,
                        "channel_password" => false));
                             
                $channelList = $query->getElement('data',$query->channelList());
                    foreach ((array) $channelList as $channel){
                        $check = $channelNumber.". ".$NameChannel;
                        if ($channel['channel_name'] == $check){                         
                            $query->channelMove($channel['cid'],$GlobalChannel,$NextChannel); 
                            for ($i = 1; $i <= $SubChannels; $i++){ 
                                $query->channelCreate(array(
                                    "channel_name" => $i.$nameSubChannels,
                                    "channel_flag_permanent" => true,
                                    "channel_codec" => $SCHcodec,
                                    "channel_codec_quality" => $SCHquality,
                                    "channel_password" => false,
                                    "cpid" => $channel['cid']));
                            }
                            $query->setClientChannelGroup($cadminGruop,$channel['cid'],$client_database_id);
                            $query->sendMessage(1, $client['clid'], $infotoUser);
                            $query->clientMove ($client['clid'], $channel['cid']);
                            $query->serverGroupDeleteClient ($createChannel[0], $client_database_id);
                                     
                        }                         
                    } 
            }

        }         
     sleep(1);
    } 
}
?>