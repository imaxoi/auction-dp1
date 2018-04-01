<?php
include_once "functions.php";
session_start_control(false);

$error="no_registration";

if(!userLoggedIn()){
	if(isset($_POST["email"]) && isset($_POST["psw"]) && isset($_POST["firstname"]) && isset($_POST["familyname"])){
		$user=strip_tags($_POST["email"]);
		$psw=strip_tags($_POST["psw"]);
		$first=strip_tags($_POST["firstname"]);
		$family=strip_tags($_POST["familyname"]);

		try{
			$conn = dbConnect();
			if(!$conn)
				throw new Exception(mysqli_connect_error());

			$user=mysqli_real_escape_string($conn, $user);
			$psw=mysqli_real_escape_string($conn, $psw);
			$first=mysqli_real_escape_string($conn, $first);
			$family=mysqli_real_escape_string($conn, $family);

			//Input validation
			if(!filter_var($user, FILTER_VALIDATE_EMAIL))
				throw new Exception("Data inserted is not valid.");
				
			if(preg_match ( "/^([A-z]|[0-9])+$/" , $psw) != 1 || preg_match ( "/\d/" , $psw) != 1 || preg_match ( "/[a-zA-Z]/" , $psw) !=1 ){
				throw new Exception("Data inserted is not valid.");
			}
			if(preg_match ( "/^([A-z])+$/" , $first) != 1 || preg_match ( "/^([A-z])+$/" , $family) !=1)
				throw new Exception("Data inserted is not valid.");

			$psw=password_hash(mysqli_real_escape_string($conn, $psw),PASSWORD_DEFAULT);


			mysqli_autocommit($conn, false);
			$duplicateResult=mysqli_query($conn, "SELECT email FROM user WHERE email='" . $user . "' FOR UPDATE");
			if(!$duplicateResult)
				throw new Exception(mysqli_error($conn));
			$duplicateResult=mysqli_fetch_array($duplicateResult, MYSQLI_ASSOC);

			if($duplicateResult!=NULL)
				throw new Exception("The registration can't be completed: a user with this email already exists.");

			$insertion=mysqli_query($conn, "INSERT INTO user VALUES('".$user."', '".$psw."', '".$first."', '".$family."')");
			if($insertion!= true)
				throw new Exception(mysqli_error($conn));
			$error="none";
			mysqli_commit($conn);
			mysqli_autocommit($conn, true);
			$_SESSION["236037_user"]=$user;
		}catch(Exception $e){
			$error=$e->getMessage();
			mysqli_rollback($conn);
			mysqli_autocommit($conn, true);
		}

	}


}


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>DPI Registration</title>
	<link href="style.css" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="images/favicon.ico" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
					if($error == "no_registration"){
						if(userLoggedIn()){
							echo "<h1>Error during registration</h1> <p> You are already logged in, it is not possible to register another account.</p>";
						}else{
							include("register_form.html");
						}
					}else if ($error == "none"){
						echo "<h1>Registration successful</h1><p>Registration completed, enjoy!</p>\n";
					}else{
						echo "<h1>Error</h1><p>".$error."</p>\n";
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
