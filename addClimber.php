<?php
	//Turn on error reporting
	ini_set('display_errors', 'On');
	
	//Connects to the database
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","broedera-db","u00kFHGxpWuH5GTI","broedera-db");
	if(!$mysqli || $mysqli->connect_errno){
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Mountain Climbing Database</title>
		<link rel="stylesheet" type="text/css" href="PHPstyle.css">
	</head>
	<body>
		<div id="pageDiv">
			<h3>Status</h3>
			<p>
				<?php	
					//Create add query and execute
					if(!($stmt = $mysqli->prepare("INSERT INTO mtn_climber(fname, lname, birthYear, gender, zip) VALUES (?,?,?,?,?)"))){
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}
					if(!($stmt->bind_param("ssisi",$_POST['fname'],$_POST['lname'],$_POST['birthYear'],$_POST['gender'],$_POST['zip']))){
						echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
					}
					if(!$stmt->execute()){
						echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
					} else {
						if ($stmt->affected_rows == 0)
							echo "Error, added " . $stmt->affected_rows . " rows to mtn_climber.";
						else
							echo "Added " . $stmt->affected_rows . " row to mtn_climber.";
					}
				?>
			</p>
			<!--Source: http://stackoverflow.com/questions/5025941/is-there-a-way-to-get-a-button-element-to-link-to-a-location-without-wrapping-->
			<button onclick="window.location='http://web.engr.oregonstate.edu/~broedera/CS340/project/mtnClmbDB.php';">Back</button>
		</div>
	</body>
</html>