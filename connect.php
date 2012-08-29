<?php

/**
 * @file
 * Check if consumer token is set and if so send user to get a request token.
 */

/**
 * Exit with an error message if the CONSUMER_KEY or CONSUMER_SECRET is not defined.
 */
require_once('config.php');
if (CONSUMER_KEY === '' || CONSUMER_SECRET === '') {
  echo 'You need a consumer key and secret to test the sample code. Get one from <a href="https://twitter.com/apps">https://twitter.com/apps</a>';
  exit;
}
?>

<div style="margin:0 auto;width:350px"><a href="javascript: void(0)" onclick="window.open('./redirect.php','t_redirect', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=no,width=800, height=700'); return false;"><img src="TwitterLoginGraciasATheNovaGp.png" alt="Entra con tu cuenta de Twitter"/></a></div>  			