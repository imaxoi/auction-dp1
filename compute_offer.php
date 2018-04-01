<?php
include_once "functions.php";
session_start_control(false);
$error="none";
if(userLoggedIn()){
	if(isset($_POST["THR"]) && isset($_POST["itemID"])){
		$thr =strip_tags($_POST["THR"]);
		$id =strip_tags($_POST["itemID"]);
		try{
			if(!is_numeric($thr) || !is_numeric($id))
				throw new Exception("Offer not recognized.");

			$thr=round($thr, 2, PHP_ROUND_HALF_EVEN);

			$conn = dbConnect();
			if(!$conn)
				throw new Exception(mysqli_connect_error());

			$thr=mysqli_real_escape_string($conn, $thr);
			$id=mysqli_real_escape_string($conn, $id);

			//Extract from the DB what I will need to do the checkings and lock the table.
			mysqli_autocommit($conn, false);
			$currBid=mysqli_query($conn, "SELECT user, currentbid, maxbid FROM item WHERE ID='" . $id . "' FOR UPDATE");
			if(!$currBid)
				throw new Exception(mysqli_error($conn));
			$currBid=mysqli_fetch_array($currBid, MYSQLI_ASSOC);

			//Is the offer valid?
			if($thr <= $currBid["currentbid"])
				throw new Exception("Invalid offer.");

			if($currBid["user"]==NULL || $currBid["maxbid"]==NULL){
				//First offer, it has to win without increasing.
				$setMaxBid=mysqli_query($conn, "UPDATE item SET maxbid='".$thr."', user='".$_SESSION["236037_user"]."' WHERE ID='" . $id . "'");
				if(!$setMaxBid)
					throw new Exception(mysqli_error($conn));
				$error="You are the highest bidder";
			}else{

				//Is the offerer increasing its own offer?
				if($currBid["user"] == $_SESSION["236037_user"]){
					//Step 3.1: Yes, no controls have to be done. Just change it.
					$setMaxBid=mysqli_query($conn, "UPDATE item SET maxbid='".$thr."' WHERE ID='" . $id . "'");
					if(!$setMaxBid)
						throw new Exception(mysqli_error($conn));
					$error="You are the highest bidder";
				}else{
					//No, more controls have to be done.
					if($thr < $currBid["maxbid"]){
						//The other user's maxbid was better.
						$thr=$thr+0.01;
						$setBid=mysqli_query($conn, "UPDATE item SET currentbid='".$thr."' WHERE ID='" . $id . "'");
						if(!$setBid)
							throw new Exception(mysqli_error($conn));
						$error="Bid exceeded";
					}else if($thr==$currBid["maxbid"]){
						//Equal offers, the first one will win.
						$setBid=mysqli_query($conn, "UPDATE item SET currentbid=maxbid WHERE ID='" . $id . "'");
						if(!$setBid)
							throw new Exception(mysqli_error($conn));
						$error="Bid exceeded";
					}else{
						//Best bidder, update the item
						$newCurrBid=$currBid["maxbid"]+0.01;
						$setBid=mysqli_query($conn, "UPDATE item SET currentbid='".$newCurrBid."', maxbid='".$thr."', user='".$_SESSION["236037_user"]."' WHERE ID='" . $id . "'");
						if(!$setBid)
							throw new Exception(mysqli_error($conn));

						//If there was a bidder, notify him.
						if($currBid["user"]!=""){
							$setNotify=mysqli_query($conn, "INSERT INTO bid_exceeded (user, item, bid) VALUES ('".$currBid["user"]."','".$id."','".$currBid["maxbid"]."')");
							if(!$setNotify)
								throw new Exception(mysqli_error($conn));
						}
						$error="You are the highest bidder";
					}
				}
			}
			mysqli_commit($conn);
			mysqli_autocommit($conn, true);

		}
		catch(Exception $e){
			$error=$e->getMessage();
			mysqli_rollback($conn);
			mysqli_autocommit($conn, true);
		}
		$_SESSION["236037_bid_message"]=$error;

	}

}else{
	//Someone got here in an irregular way!
	//Just do nothing.
}
redirect_relative("index.php");

?>