<?php
include_once "functions.php";
session_start_control(false);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>DPI Homepage</title>
	<link rel="shortcut icon" href="images/favicon.ico" />
	<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
<script>
window.addEventListener("load", function(){
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      "background": "#eaf7f7",
      "text": "#5c7291"
    },
    "button": {
      "background": "#56cbdb",
      "text": "#ffffff"
    }
  },
  "showLink": false,
  "position": "top",
  "content": {
    "message": "This website use cookies to ensure you get the best experience. It does not collect any personal data, it only tracks your operations on the website in order to react to them."
  }
})});
</script>
</head>

<body>
	<div id="main">
		<noscript>
			<div id="top-nojavascript">
				Your experience on this website will be improved by activating Javascript!
			</div>
		</noscript>

		<div id="top-nav">

			<b>DPI </b>
			<small>
				<i>Don't Purchase Illegaly!</i>
			</small>

		</div>


		<div id="header">

			<img src="images/header.jpg" alt="Logo"/>

		</div>



		<div id="navigation">
			<?php include("menu.php");?>

		</div>

		<br />
		<br />

		<div id="content">
			<?php
			$error="none";
			if(!userLoggedIn()){
				echo "<h1>Not logged in.</h1><p class='error'>Log-in to access this wonderful functionality.</p>\n";
			}else{
				try{
					$conn = dbConnect();
					if(!$conn)
						throw new Exception(mysqli_connect_error());

					mysqli_autocommit($conn, false);
					$notifications=mysqli_query($conn, "SELECT name, bid FROM bid_exceeded be JOIN item it ON be.item = it.ID WHERE be.user='" . $_SESSION["236037_user"]. "' FOR UPDATE");
					if(!$notifications)
						throw new Exception(mysqli_error($conn));

					$p_message="";
					if( mysqli_num_rows($notifications) != 0){
						$p_message = "<h1>Your bids have been surpassed</h1>\n";
						$single_notification=mysqli_fetch_array($notifications, MYSQLI_ASSOC);
						while( $single_notification != NULL){
							$p_message= $p_message."<p>Your bid of ". $single_notification["bid"] . "&euro; on the item <i>" . $single_notification["name"]. "</i> has been surpassed.</p>\n";
							$single_notification=mysqli_fetch_array($notifications, MYSQLI_ASSOC);
						}

						//Ok notifications have been shown, let's delete them.
						$notification_delete=mysqli_query($conn, "DELETE FROM bid_exceeded WHERE user='" . $_SESSION["236037_user"]. "'");
						if(!$notification_delete)
							throw new Exception(mysqli_error($conn));
					}
					mysqli_commit($conn);
					mysqli_autocommit($conn, true);
				}
				catch(Exception $e){
					$error=$e->getMessage();
					mysqli_rollback($conn);
					mysqli_autocommit($conn, true);
				}
				if($error=="none" && isset($p_message))
					echo $p_message;

				//Show generic info on the user
				$user=showUser();
				if(is_array($user)){
					echo "<h1>Your information</h1>\n";
					echo "<p>Email: ".$user["email"]."</p>\n";
					echo "<p>Firstname: ".$user["firstname"]."</p>";
					echo "<p>Family name: ".$user["familyname"]."</p>";
				}else{
					echo "<h1>Error</h1>\n";
					echo "<p>Sorry, we can't retrieve your data right now.</p>\n";
				}
			}



            ?>

			</div>



			<div id="footer">

				<hr />

				Layout based on
				<a href="http://www.dreamtemplate.com/">DreamTemplate</a>

			</div>



		</div>
	
</body>

</html>
