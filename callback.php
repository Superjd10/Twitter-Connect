<?php
/**
 * @file
 * Take the user when they return from Twitter. Get access tokens.
 * Verify credentials and redirect to based on response from Twitter.
 */

/* Start session and load lib */
session_start();
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');

/* If the oauth_token is old redirect to the connect page. */
if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
  $_SESSION['oauth_status'] = 'oldtoken';
  header('Location: ./clearsessions.php');
}

/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

/* Request access tokens from twitter */
$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

/* Save the access tokens. Normally these would be saved in a database for future use. */
$_SESSION['access_token'] = $access_token;

$user_info = $connection->get('account/verify_credentials'); 
// Print user's info  
print_r($user_info);  

mysql_connect('MYSQL_HOST', 'MYSQL_USER', 'MYSQL_PASSWORD');  
mysql_select_db('MYSQL_DATABASE');

$tokennumero1 = $access_token['oauth_token'];
$tokennumero2 = $access_token['oauth_token_secret'];
$nombreentwitter = $user_info->screen_name;

if(isset($user_info->error)){  
    // Something's wrong, go back to square 1  
    header('Location: connect.php'); 
} else { 
    // Let's find the user by its ID  
    $query = mysql_query("SELECT * FROM twitter WHERE username='$nombreentwitter'");  
    $result = mysql_fetch_array($query);  
  
    // If not, let's add it to the database  
    if(empty($result)){  
        $query = mysql_query("INSERT INTO twitter (username, oauth_token, oauth_token_secret) VALUES ('$nombreentwitter', '$tokennumero1', '$tokennumero2')");  
        $query = mysql_query("SELECT * FROM twitter WHERE username = " . mysql_insert_id());  
        $result = mysql_fetch_array($query);  
    } else {  
        // Update the tokens  
        $query = mysql_query("UPDATE twitter SET oauth_token='$tokennumero1', oauth_token_secret='$tokennumero2' WHERE username='$nombreentwitter'");  
    }  

    $_SESSION['username'] = $result['username'];  
    $_SESSION['oauth_token'] = $result['oauth_token']; 
    $_SESSION['oauth_secret'] = $result['oauth_token_secret']; 
 
    header('Location: index.php');  
}  

/* Remove no longer needed request tokens */
unset($_SESSION['oauth_token']);
unset($_SESSION['oauth_token_secret']);

/* If HTTP response is 200 continue otherwise send to connect page to retry */
if (200 == $connection->http_code) {
  /* The user has been verified and the access tokens can be saved for future use */
  $_SESSION['status'] = 'verified';
  header('Location: ./index.php');
} else {
  /* Save HTTP status for error dialog on connnect page.*/
  header('Location: ./clearsessions.php');
}
