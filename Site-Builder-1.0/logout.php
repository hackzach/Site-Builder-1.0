<?php
include "connect.php";

if($me) {
}
else {
header("Location: index.php");
}
?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <body>
    <div id="fb-root"></div>
	<script src="http://connect.facebook.net/en_US/all.js"></script>
	<script>
		window.fbAsyncInit = function() {
			FB.init({appId  : 'blah', status : true, cookie : true, xfbml : true });


			FB.logout(function response() {
				window.location.reload();
			});
 
		};


 FB.Event.subscribe('auth.logout', function(response) {
        window.location.reload();
      });
	</script>
</body />
</html />