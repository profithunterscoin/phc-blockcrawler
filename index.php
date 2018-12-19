<?php

	require_once ("bc_daemon.php");
	require_once ("bc_layout.php");
	
	
//	If a block hash was provided the block detail is shown
	if (isset ($_REQUEST["block_hash"]))
	{
		site_header ("Block Detail Page");
		
		block_detail ($_REQUEST["block_hash"], TRUE);
	}
	
//	If a block height is provided the block detail is shown
	elseif (isset ($_REQUEST["block_height"]))
	{
		site_header ("Block Detail Page");
		
		block_detail ($_REQUEST["block_height"]);
	}
	
//	If a TXid was provided the TX Detail is shown
	elseif (isset ($_REQUEST["transaction"]))
	{
		site_header ("Transaction Detail Page");
		
		tx_detail ($_REQUEST["transaction"]);
	}

//	If a TXid was provided the TX Detail is shown
	elseif (isset ($_REQUEST["account_balance"]))
	{
		site_header ("Public Account Balance");
		
		tx_detail ($_REQUEST["account_balance"]);
	}
	
//	If there were no request parameters the menu is shown
	else
	{
		site_header ("Profit Hunters Coin (PHC) - Block Crawler 1.1");
		
		echo "	<div id=\"side_bar\">\n";
		echo "\n";

		echo "		<div id=\"node_info\">\n";
		echo "\n";


		if (getmasternodedebug() == "masternode started remotely")
		{
			$MNSTATUS = "Master";	
		}
		else
		{
			$MNSTATUS = "Peer";
		}

		if ($MNSTATUS != "")
		{
			echo "			<div class=\"node_detail\">\n";
			echo "				<span class=\"node_desc\">Node Status:</span><br>\n";
			echo "				".$MNSTATUS."\n";
			echo "			</div>\n";
			echo "\n";
		}

		//$chain_health = getchainhealth();

		//if ($chain_health != "")
		//{
		//	echo "		<div class=\"node_detail\">\n";
		//	echo "			<span class=\"node_desc\">Chain Health:</span><br>\n";
		//	echo "			".$chain_health."\n";
		//	echo "		</div>\n";
		//	echo "\n";
		//}
		
		$network_info = getinfo ();

		echo "			<div class=\"node_detail\">\n";
		echo "				<span class=\"node_desc\">Block Count:</span><br>\n";
		echo "				".$network_info["blocks"]."\n";
		echo "			</div>\n";
		echo "\n";

		echo "			<div class=\"node_detail\">\n";
		echo "				<span class=\"node_desc\">PoW Difficulty:</span><br>\n";
		echo "				". number_format($network_info["difficulty"], 2) ."\n";
		echo "			</div>\n";
		echo "\n";

		$net_speed = getnetworkhashps() / 1000;
		
		if ($net_speed != "")
		{
			echo "			<div class=\"node_detail\">\n";
			echo "				<span class=\"node_desc\">PoW Hashrate:</span><br>\n";
			echo "				". number_format($net_speed, 2) ." GH/s\n";
			echo "			</div>\n";
			echo "\n";
		}

		// network stake weight
		$mining_info = getmininginfo();
		$mining_info["netstakeweight"] = $mining_info["netstakeweight"] / 100000000;

		echo "			<div class=\"node_detail\">\n";
		echo "				<span class=\"node_desc\">PoS Net-Weight:</span><br>\n";
		echo "				". number_format($mining_info["netstakeweight"], 2) ."\n";
		echo "			</div>\n";
		echo "\n";
	
		$masternode_count = getmasternodecount();

		if ($masternode_count != "")
		{
            echo "          	<div class=\"node_detail\">\n";
            echo "                  	<span class=\"node_desc\">Masternodes:</span><br>\n";
            echo "                  	". $masternode_count ." \n";
            echo "          	</div>\n";
            echo "\n";
		}


		echo "			<div class=\"node_detail\">\n";
		echo "				<span class=\"node_desc\">Connections:</span><br>\n";
		echo "				".$network_info["connections"]."\n";
		echo "			</div>\n";
		echo "\n";



		if ($network_info["moneysupply"] != "")
		{
                        echo "          	<div class=\"node_detail\">\n";
                        echo "                  	<span class=\"node_desc\">Current Supply:</span><br>\n";
                        echo "                  	". number_format($network_info["moneysupply"], 2) ." PHC\n";
                        echo "          	</div>\n";
                        echo "\n";
		}

		if ($network_info["lastreward"] != "")
		{
                        echo "          	<div class=\"node_detail\">\n";
                        echo "                  	<span class=\"node_desc\">Last Reward (PoW/PoS/MN):</span><br>\n";
                        echo "                  	". number_format($network_info["lastreward"], 2) ." PHC\n";
                        echo "          	</div>\n";
                        echo "\n";
		}

		
		echo "		</div>\n";
		echo "\n";


		echo "		<div id=\"api_info\">\n";
		echo "\n";

		echo "			<div class=\"node_detail\">\n";
		echo "				<span class=\"node_desc\">API Commands:</span><br>\n";
		echo "				<a href=\"bc_api.php?request=getinfo\">getinfo</a><br>\n";
		echo "				<a href=\"bc_api.php?request=getblockcount\">getblockcount</a><br>\n";
		echo "				<a href=\"bc_api.php?request=masternodelistaddr\">masternodelistaddr</a><br>\n";
		echo "				<a href=\"bc_api.php?request=masternodelistfull\">masternodelistfull</a><br>\n";
		echo "				<a href=\"bc_api.php?request=getbestblockhash\">getbestblockhash</a><br>\n";
		echo "				<a href=\"bc_api.php?request=getblock e3ab6a24f2f8e2ff3960e9ad0e18e268ca9da633977ba57a7d9c8a55da137d1e\">getblock</a><br>\n";
		echo "				<a href=\"bc_api.php?request=getblockbynumber 116436\">getblockbynumber</a><br>\n";
		echo "				<a href=\"bc_api.php?request=getblockcount\">getblockcount</a><br>\n";
		echo "				<a href=\"bc_api.php?request=getblockhash 116436\">getblockhash</a><br>\n";
		echo "				<a href=\"bc_api.php?request=getblocktemplate\">getblocktemplate</a><br>\n";
		echo "				<a href=\"bc_api.php?request=getcheckpoint\">getcheckpoint</a><br>\n";
		echo "				<a href=\"bc_api.php?request=getconnectioncount\">getconnectioncount</a><br>\n";
		echo "				<a href=\"bc_api.php?request=getpeerinfo\">getpeerinfo</a><br>\n";
		echo "				<a href=\"bc_api.php?request=getdifficulty\">getdifficulty</a><br>\n";
		echo "				<a href=\"bc_api.php?request=getnettotals\">getnettotals</a><br>\n";
		echo "				<a href=\"bc_api.php?request=getrawmempool\">getrawmempool</a><br>\n";
		echo "				<a href=\"bc_api.php?request=getrawtransaction 3fe0f681243c305fb2f5f93d74e4872a64de8d11e58ed784ac801fdf8cc73e27-000\">getrawtransaction</a><br>\n";
		echo "				<a href=\"bc_api.php?request=getreceivedbyaddress PNPPvrTgsyXSjtLgE9a9oL8MK8BZ68Ffrv\">getreceivedbyaddress</a><br>\n";
		echo "				<a href=\"bc_api.php?request=getstakesubsidy hexstring\">getstakesubsidy</a><br>\n";
		echo "				<a href=\"bc_api.php?request=getstakinginfo\">getstakinginfo</a><br>\n";
		echo "				<a href=\"bc_api.php?request=gettransaction 3fe0f681243c305fb2f5f93d74e4872a64de8d11e58ed784ac801fdf8cc73e27-000\">gettransaction</a><br>\n";
		echo "				<a href=\"bc_api.php?request=listbanned\">listbanned</a><br>\n";
		echo "				<a href=\"bc_api.php?request=listsinceblock\">listsinceblock</a><br>\n";
		echo "				<a href=\"bc_api.php?request=listreceivedbyaddress PNPPvrTgsyXSjtLgE9a9oL8MK8BZ68Ffrv\">listreceivedbyaddress</a><br>\n";


		echo "			</div>\n";
		echo "\n";

		echo "		</div>\n";
		echo "\n";

		echo "	</div>\n";
		echo "\n";


		echo "	<div id=\"site_menu\">\n";
		echo "\n";
		
		echo "		<div class=\"menu_item\">\n";
		echo "			<span class=\"menu_desc\">Enter a Block Index / Height</span><br>\n";
		echo "			<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"post\">\n";
		echo "				<input type=\"text\" name=\"block_height\" size=\"40\"><br>\n";
		echo "				<input type=\"submit\" name=\"submit\" value=\"Jump To Block\">\n";
		echo "			</form>\n";
		echo "		</div>\n";
		echo "\n";

		echo "		<div class=\"menu_item\">\n";
		echo "			<span class=\"menu_desc\">Enter A Block Hash</span><br>\n";
		echo "			<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"post\">\n";
		echo "				<input type=\"text\" name=\"block_hash\" size=\"40\"><br>\n";
		echo "				<input type=\"submit\" name=\"submit\" value=\"Jump To Block\">\n";
		echo "			</form>\n";
		echo "		</div>\n";
		echo "\n";

		echo "		<div class=\"menu_item\">\n";
		echo "			<span class=\"menu_desc\">Enter A Transaction ID</span><br>\n";
		echo "			<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"post\">\n";
		echo "				<input type=\"text\" name=\"transaction\" size=\"40\"><br>\n";
		echo "					<input type=\"submit\" name=\"submit\" value=\"Jump To TX\">\n";
		echo "			</form>\n";
		echo "		</div>\n";
		echo "\n";

		echo "		<div class=\"menu_item\">\n";
		echo "			<span class=\"menu_desc\">Enter A PHC Address</span><br>\n";
		echo "			<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"post\">\n";
		echo "				<input type=\"text\" name=\"account_balance\" size=\"40\"><br>\n";
		echo "					<input type=\"submit\" name=\"submit\" value=\"Balance\">\n";
		echo "			</form>\n";
		echo "		</div>\n";
		echo "\n";

		echo "		<div class=\"menu_item\">\n";
		echo "			<span class=\"menu_desc\">Masternode List:</span><br>\n";


		$masternode_list = getmasternodelist ();

		$output = array();
		$output_cnt = 0;

		foreach ($masternode_list as $key => $value)
		{
    		//echo "{$key} => {$value} ";
			$data = array();
			$value = str_replace("        ", " ", $value);
			$value = str_replace("     ", " ", $value);
			$value = str_replace("   ", " ", $value);
			$value = str_replace("  ", " ", $value);

			//echo $value . "<br>";
			$data = explode(" ", $value);

			//////////////////////////////////////////
			// GetTimeDiff https://gist.github.com/peponi/3425414
				$seconds = $data[6];
				$minutes = (int)($seconds / 60);
    			$hours = (int)($minutes / 60);
    			$days = (int)($hours / 24);
    			if ($days >= 1) {
      				$uptime = $days . ' day' . ($days != 1 ? 's' : '');
    				} else if ($hours >= 1) {
      				$uptime = $hours . ' hour' . ($hours != 1 ? 's' : '');
    				} else if ($minutes >= 1) {
      				$uptime = $minutes . ' minute' . ($minutes != 1 ? 's' : '');
    			} else {
      				$uptime = $seconds . ' second' . ($seconds != 1 ? 's' : '');
    			}
			/////////////////////////////////////////

			//echo $data[4] . " " . $data[2] . " " . $data[1] . " " . $uptime . "<br>\n";
			$output[$output_cnt] = $data[4] . " " . $data[2] . " " . $data[1] . " " . $uptime;
			$output_cnt = $output_cnt + 1;
			
		}

		sort($output);

		for ($i = 0; $i <= $output_cnt - 1; $i++)
		{
			echo $output[$i] . "<br>\n";
		}

		echo "		</div>\n";
		echo "\n";

		echo "	</div>\n";
		echo "\n";
	}
	
	
	site_footer ();

/******************************************************************************
	This script is Copyright � 2013 Jake Paysnoe.
	I hereby release this script into the public domain.
	Jake Paysnoe Jun 26, 2013
******************************************************************************/
?>
