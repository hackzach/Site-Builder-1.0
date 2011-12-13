<?php

//JSON Array structure:
/*
Array
(
    [algorithm] => HMAC-SHA256
    [expires] => 1294495200
    [issued_at] => 1294491469
    [oauth_token] => 
    [registration] => Array
        (
            [name] => Snzakk Sczack
            [email] => zacharyp.og@gmail.com
            [location] => Array
                (
                    [name] => Chicago, Illinois
                    [id] => 1.08659242498E+14
                )

            [gender] => female
            [birthday] => 03/04/1989
            [status] => dfd
            [isprivate] => 
        )

    [registration_metadata] => Array
        (
            [fields] => [
		{'name': 'name'}, 
		{'name': 'email'},
        {'name': 'location'},
			{'name' : 'gender'}, 
			{'name' : 'birthday'}, 
	{'name' : 'status' , 'description' : 'Player Title' , 'type' : 'text'},
 	{'name' : 'isprivate' , 'description' : 'Make Profile Private?' , 'type' : 'checkbox'}
]
        )

    [user] => Array
        (
            [locale] => en_US
            [country] => us
        )

    [user_id] => 1484931720
)


*/

//get cookie functions

function get_facebook_cookie($app_id, $application_secret) {
  $args = array();
  parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);
  ksort($args);
  $payload = '';
  foreach ($args as $key => $value) {
    if ($key != 'sig') {
      $payload .= $key . '=' . $value;
    }
  }
  if (md5($payload . $application_secret) != $args['sig']) {
    return null;
  }
  return $args;
}

$cookie = get_facebook_cookie("id", "secret");
?>