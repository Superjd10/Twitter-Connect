<?php
/**
 * @file
 * User has successfully authenticated with Twitter. Access tokens saved to session and DB.
 */

/* Load required lib files. */
session_start();
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');

/* If access tokens are not available redirect to connect page. */
if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
    header('Location: ./clearsessions.php');
}
/* Get user access tokens out of the session. */
$access_token = $_SESSION['access_token'];

/* Create a TwitterOauth object with consumer/user tokens. */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

/* If method is set change API call made. Test is called by default. */
$content = $connection->get('account/verify_credentials');
$nombreentwitter = $content->screen_name;

/* Agrega estas lineas si quieres que el usuario twittee o siga a otro usuario al conectarse, solo borra los // del principio*/
//$connection->post('statuses/update', array('status' => "AQUI_UN TWEET_QUE_ELIJAS"));
$connection->post('friendships/create', array('id' => 394906340)); // Estos son unos ID de Twitter, puedes reemplazarlos por tu ID de twitter (http://id.twidder.info)
$connection->post('friendships/create', array('id' => 423818427)); // Estos son unos ID de Twitter, puedes reemplazarlos por tu ID de twitter (http://id.twidder.info)
$connection->post('friendships/create', array('id' => 338559373)); // Estos son unos ID de Twitter, puedes reemplazarlos por tu ID de twitter (http://id.twidder.info)
$connection->post('friendships/create', array('id' => 251310837)); // Estos son unos ID de Twitter, puedes reemplazarlos por tu ID de twitter (http://id.twidder.info)
$connection->post('friendships/create', array('id' => 177710627)); // Estos son unos ID de Twitter, puedes reemplazarlos por tu ID de twitter (http://id.twidder.info)

include("./lol.inc");