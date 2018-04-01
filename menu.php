<?php
include_once("functions.php");

if(isset($_GET["notification_ajax"])){
	$_GET["notification_ajax"]=strip_tags($_GET["notification_ajax"]);
	if($_GET["notification_ajax"]==true){
		//Needed for ajax polling
		session_start_control(true);
		if(userLoggedIn()){
			echo checkNotifications();
			exit();
		}
	}
}

?>

Menu		
<hr />

<?php
if (!userLoggedIn()) {
	echo "
	<a href='index.php' class='navigation'>Home</a>\n
	<a href='login.php' class='navigation'>Log-in</a>\n
	<a href='register.php' class='navigation'>Register</a>\n
	<a href='about_us.php' class='navigation'>About Us</a>\n";

}else{
	echo "<a href='index.php' class='navigation'>Home</a>\n";

	echo "<a href='profile.php' class='navigation' id='profile_link'>Profile";

	$notifications=checkNotifications();
	if($notifications>0)
		echo "(".$notifications.")";

	echo "</a>\n";

	echo "<a href='logout.php' class='navigation'>Log-out</a>\n
	<a href='about_us.php' class='navigation'>About Us</a>\n";
?>
<script type="text/javascript"><!--
	/*AJAX notifications push*/
	var docOriginalTitle=document.title;
    function evaluateNotifications(){
            var notifReq = new XMLHttpRequest();
	            notifReq.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    if (!isNaN(parseFloat(this.responseText)) && this.responseText != "0") {
                        document.getElementById("profile_link").innerHTML = "Profile("+this.responseText+")";
						document.title=docOriginalTitle+"("+this.responseText+")";
					}else if(this.responseText == "0"){
						document.getElementById("profile_link").innerHTML = "Profile";
						document.title=docOriginalTitle;
                    }
					setTimeout(evaluateNotifications,2000);
                }
            }
	        notifReq.open("GET", "menu.php?notification_ajax=true");
	        notifReq.send();
    }

	evaluateNotifications();

/*END AJAX notifications push*/
//--></script>
<?php
}
?>