<?php
// [LIMECART V1]
//

// [SITE SETTINGS]
//
$shopName = "LimeCart Online LimeCoin Store";
$currency = '[LC]'; //Currency sumbol or code
$fee = 1; //Fees for admin, handling, etc...
$adminEmail = "YOUREMAIL@WHERE.COM";
$domain = "coinfreaks.com";
$coldStorageAddress = "Lc7Gty6dyG9sBZj4n3vpBfZp7XreRJAJm8"; // Address for coins to be sent after transaction confirmation for security
$mandrilApi = "GETYOUROWN-OR-THIS-WONT-WORK-ITS-FREE"; // API key for MAILCHIMP from Mandril, free 12,000 mails a month go sign up!

// [DATABASE]
//
$db_username = 'USER';
$db_password = 'PASS';
$db_name = 'cart';
$db_host = 'localhost';
$mysqli = new mysqli($db_host, $db_username, $db_password,$db_name);

// [DAEMON SETTINGS]
//
$rpcserver = "localhost";
$rpcport = "1337";
$rpcuser = "x";
$rpcpass = "xx";

// [DISPLAY]
//
$displayWalletStats = True; // Shows only blockcount, is daemon online, connections. Default is ON
$styleSheet = "style.css";
$coinLogo = "limecoin.png";
$displayBTC_USD = True;
$displayLC_BTC = True;
$displayLC_USD = True;

// [DO NOT EDIT BELOW HERE UNLESS YOU KNOW WHAT YOU ARE DOING]
//
//
// [DEBUG]
//
$debug = False; //

// [UPGRADE]
//
$versionCheck = True; // Site checks for new version, if found a email is sent to site admin
$versionFile = "https://raw.githubusercontent.com/Limecoin/LimeCart/master/version.txt"; // Leave this, this is the file that is checked for new versions, security patches, etc

// [DONATION]
// One can remove this here, simple change to 0.0 or False, but consider this free open source software needs
// more development, if you leave the donation in place more features can be made available to the community.
// its completely transparent, and was not hidden in code obscurely, the option to remove it is right here.
// Please see wiki on github for more information, but consider leaving it. 
$donation = True; // Please leave to true, change below  to a low percent must be over 0.01
$donationAmount = 1; // Donation for development of LimeCart, must remain over 0.01, this is a percentage of each sale.
// This is how such software can remain free and plugins, tools, themes and future development be added to it, if you support LimeCoin LC,
// Please consider supporting LimeCart.

?>