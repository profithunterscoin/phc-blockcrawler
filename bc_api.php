<?php

/******************************************************************************


	Accessing data via this API is done using HTTP GET requests.
	
	The "request" parameter is to be used for all requests,
	Here is a sample URL requesting "getinfo":

	http://www.sample.com/path_to_Block_Crawler/bc_api?request=getinfo
	
	This API will support all single-parameter JSON-RPC methods
	supported by the satoshi wallet, except those blocked in code.
	
	Several functions regarding wallet balances and transactions
	are blocked in the release version of this API.

******************************************************************************/
//	Enable the wallet
	require_once ("bc_daemon.php");
	
//	A check for no request
	if (!isset ($_REQUEST["request"]) || $_REQUEST["request"] == "")
	{
		bcapi_error (0, "No Request");
	}

//	URL formatting is stripped from the request
	$request = urldecode ($_REQUEST["request"]);
	
//	The request is split in case anyone tries to send a multi-parameter
//	request to the API, any parameters after method will be ignored
	$request = explode (" ", $request);
	

//	These are security checks to ensure that no one uses the API
//	to request balance data or mess up the wallet.

	$disabled_api = array(
		"masternode",
		"getbalance",
		"listaccounts",
		"listtransactions",
		"keypoolrefill",
		"addmultisigaddress",
		"listreceivedbyaddress",
		"addnode",
		"addredeemscript",
		"clearbanned",
		"checkkernel",
		"checkwallet",
		"createmultisig",
		"createrawtransaction",
		"darksend",
		"decoderawtransaction",
		"decodescript",
		"dumpprivkey",
		"dumpwallet",
		"encryptwallet",
		"getaccount",
		"getaccountaddress",
		"getaddednodeinfo",
		"getaddressesbyaccount",
		"getnewaddress",
		"getnewpubkey",
		"getnewstealthaddress",
		"getwork",
		"getworkx",
		"importaddress",
		"importprivkey",
		"importstealthaddress",
		"importwallet",
		"listaddressgroupings",
		"liststealthaddresses",
		"listtransactions",
		"listunspent",
		"makekeypair",
		"masternodelist",
		"move",
		"ping",
		"repairwallet",
		"resendtx",
		"reservebalance",
		"scanforstealthtxns",
		"searchrawtransactions",
		"sendalert",
		"sendfrom",
		"sendmany",
		"sendrawtransaction",
		"sendtoaddress",
		"sendtostealthaddress",
		"setaccount",
		"setban",
		"settxfee",
		"signmessage",
		"signrawtransaction",
		"smsgaddkey",
		"smsgbuckets",
		"smsgdisable",
		"smsgenable",
		"smsggetpubkey",
		"smsginbox",
		"smsglocalkeys",
		"smsgoptions",
		"smsgoutbox",
		"smsgscanbuckets",
		"smsgscanchain",
		"smsgsend",
		"smsgsendanon",
		"spork",
		"submitblock",
		"validateaddress",
		"validatepubkey",
		"verifymessage"
	);
	

	foreach ($disabled_api as &$value)
	{
		if ($request[0] == $value)
		{
			bcapi_error (7, "Method Not Permitted: firewall");
		}	
	}


	if (strpos(" " . $request[0], "firewall") > 0)
	{
		bcapi_error (7, "Method Not Permitted: firewall");
	}	




//	Check to stop remote users from killing the daemon via API
	if ($request[0] == "stop")
	{
		bcapi_error (6, "Method Not Permitted: stop");
	}	

// Masternode IP Address/Status List (modified query)
	if ($request[0] == "masternodelistaddr")
	{
		$request[0] = "masternode";
		$query["params"][0] = "list";
		$query["params"][1] = "addr";
	}

// Masternode IP Address/Status List (modified query)
	if ($request[0] == "masternodelistfull")
	{
		$request[0] = "masternode";
		$query["params"][0] = "list";
		$query["params"][1] = "full";
	}

// Masternode Status  (modified query)
	if ($request[0] == "masternodestatus")
	{
		$request[0] = "masternode";
		$query["params"][0] = "status";
	}

// Masternode Debug  (modified query)
	if ($request[0] == "masternodedebug")
	{
		$request[0] = "masternode";
		$query["params"][0] = "debug";
	}

// GetStakeSubsidy  (standard query)
	if ($request[0] == "getstakesubsidy")
	{
		$query["params"][0] = $request[1];
	}

// GetReceivedByAccount  (standard query)
	if ($request[0] == "getreceivedbyaccount")
	{
		$query["params"][0] = $request[1];
		$query["params"][1] = $request[2];
	}

// GetBlockHash  (standard query)
	if ($request[0] == "getblockhash")
	{
		$query["params"][0] = $request[1];
	}

// GetBlock  (standard query)
	if ($request[0] == "getblock")
	{
		$query["params"][0] = $request[1];
	}

//	The first word of the request is passed to the daemon as a
//	JSON-RPC method
	$query["method"] = $request[0];
	
//	The data is fetched from the wallet
	$result = wallet_fetch ($query);

//	The wallet fetch routine has removed the JSON formatting for 
//	internal use. The JSON format is re-applied for the the feed
	print_r (json_encode ($result));

//	That's it.
	exit;

//	this function is here to generate repetitive error messages
	function bcapi_error ($code, $message)
	{
		$error["code"] = $code;
		$error["message"] = $message;
		
		print_r (json_encode($error));
		exit;
	}
?>
