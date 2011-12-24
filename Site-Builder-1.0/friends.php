<?php
define("theme", "true");
include "connect.php";
include "site_include.php";
include "theme.php";
makenav($id, $logoutUrl);


	  
include "foot.php";

?>
<div id="friends"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>

	   <script>
  window.fbAsyncInit = function() {
    FB.init({appId  : 'balrg', status : true, cookie : true, xfbml : true });

 FB.Event.subscribe('auth.login', function(response) {
        window.location.reload();
      });


};


   document.getElementById('friends').innerHTML = 'Searching .....'; 
	


 FB.api('/me/friends', { fields : 'id', offset : 0, limit : 25 }, function(response) {  
       var outstring = '<p>Friends:</p>';
       for (var i=0, l=response.data.length; i<l; i++) {
         var friend = response.data[i];
         outstring = outstring + '<fb:profile-pic uid="' + friend.id + '"  width="50" height="50" />' 
		                        + '<fb:name uid="' + friend.id + '" />&nbsp;&nbsp;&nbsp;'
       }
       document.getElementById('friends').innerHTML = outstring; 
       FB.XFBML.parse(document.getElementById('friends'));
	   
	   });
</script>

