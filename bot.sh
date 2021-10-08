#!/bin/bash
# Colors
ESC_SEQ="\x1b["
COL_RESET=$ESC_SEQ"39;49;00m"
COL_GREEN=$ESC_SEQ"32;01m"
COL_GOLD=$ESC_SEQ"30;33m"

echo -e "$COL_GOLD
                 ╔/════════════════╔๑ஜ۩۞۩ஜ๑╗════════════════\╗
                 ║                                            ║
                 ║         ♦   Start Your Bot Here  ♦         ║
                 ║          ♦                      ♦          ║
                 ║           ♦                    ♦           ║
                 ║                                            ║
                 ╚\════════════════╚๑ஜ۩۞۩ஜ๑╝════════════════/╝
				 $COL_RESET
				 "
 
if [ $1 = 'stop' ] 
    then 
        pkill -f DdosGuard_Bot
		echo -e "Bot: $COL_GREEN Bot has been STOPED! $COL_RESET"
    fi

if [ $1 = 'start' ] 
    then 
        screen -A -m -d -S Bot php **BOTNAMEFILE**.php
		echo -e "Bot: $COL_GREEN Bot has been STARTED! $COL_RESET"
    fi

#####################################################################################################
# You need to edit this file to be able to start the bots.
# For the Ban bot use - banbot.php instead of **BOTNAMEFILE**.php on Line 27 on this file.
# For the Channel bot use - channelbot.php instead of **BOTNAMEFILE**.php on Line 27 on this file.
# For the DDos Guard bot use - ddosguard.php instead of **BOTNAMEFILE**.php on Line 27 on this file.
# For the Online bot use - onlinebot.php instead of **BOTNAMEFILE**.php on Line 27 on this file.
# For the Rank bot use - RankBot.php instead of **BOTNAMEFILE**.php on Line 27 on this file.
# For the VPN Guard bot use - vpnguard.php instead of **BOTNAMEFILE**.php on Line 27 on this file.
#####################################################################################################
#
# For the WebRank Bot and the Banner bot you don't need to start them but you need to place them on a
# webserver for it to work.
#
#####################################################################################################