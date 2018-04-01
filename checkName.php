<?php
include_once "functions.php";
if(isset($_GET["email"])){
	$user=strip_tags($_GET["email"]);
	try{
		$conn = dbConnect();
		if(!$conn)
			throw new Exception(mysqli_connect_error());

		$user=mysqli_real_escape_string($conn, $user);

		$duplicateResult=mysqli_query($conn, "SELECT email FROM user WHERE email='" . $user . "' FOR UPDATE");

		if(!$duplicateResult)
			throw new Exception(mysqli_error($conn));

		$duplicateResult=mysqli_fetch_array($duplicateResult, MYSQLI_ASSOC);

		if($duplicateResult!=NULL)
			echo "unavailable";
	}
	catch(Exception $e){
		echo "error";
	}
}else {
	echo "error";
}

?>