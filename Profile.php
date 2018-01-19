<?php

set_time_limit(0);

require_once 'SPOClient.php';

function connectSPO($url,$username,$password)
{
    try {
        $client = new SPOClientPoint($url);
        $client->signIn($username,$password);
		return $client;
        echo 'You have been authenticated successfully\n';
    }
    catch (Exception $e) {
        echo 'Authentication failed: ',  $e->getMessage(), "\n";
    }
}

$username = 'USERNAME-OFFICE-365';
$password = 'PASSWORD-OFFICE-365';

$url = "https://YOUR-SHAREPOINT-DOMAIN.sharepoint.com";

$client = connectSPO($url,$username,$password);

$profile_mail = "USER-EMAIL";

$url_parse = urlencode("'i:0#.f|membership|".$profile_mail."'");

$options = array(
		  'list' => '$select=PictureUrl,AccountName&@v='.$url_parse.'',
		  'id' => NULL,
		  'method' => 'GET'
	   );

$content = $client->getHeaders($options);

if ($content->d->PictureUrl) {

$new_url = $content->d->PictureUrl;

$server_path = $_SERVER['DOCUMENT_ROOT'] . "/profile-images/"  // path to save image on server directory

$options = array(
		  'url' => $new_url,
		  'id' => NULL,
		  'method' => 'GET',
		  'pictureType' => NULL,
		  'picturePath' => $server_path 
	   );

$client->requestImage($options);  // fetch sharepoint server to get profile image
	
} 

?>