<?php

function redirect_relative($uri){
	/*Redirects on the relative URI*/
	$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$redirect = str_replace (basename($_SERVER['PHP_SELF']), $uri , $redirect );
	header('HTTP/1.1 308 Permanent Redirect');
	header('Location: ' . $redirect);
	exit();

}



function session_start_control($ajax){
	/*start session and control for timeout*/
	/*Set $ajax to true to handle
	 *automatic ajax requests, that should not be considered
	 *to decide the inactivity of the user.*/
	session_start();
	$t=time(); $diff=0; $new=false;
	if (isset($_SESSION['time'])){
		$t0=$_SESSION['time']; $diff=($t-$t0); // inactivity
	} else {
		$new=true;
	}

	if ($new){
		$_SESSION['time']=time();
	} else if ($diff > 120) { // Inactivity >= 2 minutes
		$_SESSION=array();
		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
		if (ini_get("session.use_cookies")) { // PHP using cookies to handle session
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - time()-1, $params["path"],
			$params["domain"], $params["secure"], $params["httponly"]);
		}
		session_destroy(); // destroy session
		session_start();
		$_SESSION['time']=time();
	} else if(!$ajax){
		$_SESSION['time']=time(); /* update time */
	}
}


function checkCookie($page){
	/*set a cookie. If there is no cookies in the get, then it is the first visit.
	 * Redirect in order to refresh the page, this time the cookie can be checked
	 * because the GET has been set.*/
	if(!isset($_COOKIE["236037_cookie_test"])){
		if(!isset($_GET['cookies'])){
			setcookie("236037_cookie_test", 1, time()+86400);
			header('Location: '.$page.'?cookies=true');
			exit();
		}
		if(count($_COOKIE) <= 0){
			header("Location: no_cookies.html");
			exit();
		}
	}
}





function userLoggedIn(){
	if(isset($_SESSION["236037_user"])){
		return true;
	}else{
		return false;
	}

}

function dbConnect(){
	$con = mysqli_connect("localhost","repositoryprojects","","my_repositoryprojects");
	if(!$con)
		return false;
	else
		return $con;

}

function checkNotifications(){
	$error="none";
	if(userLoggedIn()){
			try{
				$conn = dbConnect();
				if(!$conn)
					throw new Exception(mysqli_connect_error());
				$notifications=mysqli_query($conn, "SELECT * FROM bid_exceeded WHERE user='" . $_SESSION["236037_user"]. "'");
				if(!$notifications)
					throw new Exception(mysqli_error($conn));
				return mysqli_num_rows($notifications);
			}
			catch(Exception $e){
				$error=$e->getMessage();
			}
	}else{
		//Someone got here in an irregular way!
		//Just do nothing.
	}

}

function showUser(){
	$error="none";
	if(userLoggedIn()){
		try{
			$conn = dbConnect();
			if(!$conn)
				throw new Exception(mysqli_connect_error());
			$user=mysqli_query($conn, "SELECT email, firstname, familyname FROM user WHERE email='" . $_SESSION["236037_user"]. "'");
			if(!$user)
				throw new Exception(mysqli_error($conn));
			return mysqli_fetch_array($user, MYSQLI_ASSOC);
		}
		catch(Exception $e){
			$error=$e->getMessage();
			return $error;
		}
	}else{
		//Someone got here in an irregular way!
		//Just do nothing.
	}

}




?>
