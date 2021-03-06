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
		<div id="searchDiv">
			<h3>Search Results</h3>
			<p>Below are the routes  
			<?php
			//Create message to let user know what the search criteria was
			
				if(!($stmt = $mysqli->prepare("SELECT fname, lname FROM mtn_climber WHERE id = ?"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}

				if(!($stmt->bind_param("i",$_POST['f6Cl']))){
					echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
				}

				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($fname, $lname)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
				 echo $fname . " " . $lname . " climbed.";
				}
				$stmt->close();
			?>
			</p>
			<table id="f6Tbl" class="filterTbls">
				<tr>
					<th class="txtCenter">Route</th>
					<th class="txtCenter">Mountain</th>
					<th class="txtCenter">Date Climbed</th>
				</tr>
				<?php
				//Create table to show results
				
					if(!($stmt = $mysqli->prepare("SELECT r.name, m.name, rc.climbDate FROM mtn_climber c INNER JOIN mtn_routeClimbed rc ON rc.cid = c.id INNER JOIN mtn_route r ON r.id = rc.rid INNER JOIN mtn_mountain m ON m.id = r.mtid WHERE c.id = ?"))){
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}

					if(!($stmt->bind_param("i",$_POST['f6Cl']))){
						echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
					}

					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($rname, $mname, $climbDate)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					while($stmt->fetch()){
					 echo "<tr>\n<td class='txtCenter'>\n" . $rname . "\n</td>\n<td class='txtCenter'>\n" . $mname . "\n</td>\n<td class='txtCenter'>\n" . $climbDate . "\n</td>\n</tr>";
					}
					
					if ($stmt->num_rows == 1)
						echo "<p><em>(1 result returned)</em></p>";
					else
					{
						//Print how many results were returned
						echo "<p><em>(".$stmt->num_rows . " reults returned)</em></p>";
					}
					
					$stmt->close();
					?>
			</table>
			<!--Source: http://stackoverflow.com/questions/5025941/is-there-a-way-to-get-a-button-element-to-link-to-a-location-without-wrapping-->
			<button onclick="window.location='http://web.engr.oregonstate.edu/~broedera/CS340/project/mtnClmbDB.php';">Back</button>
		</div>
	</body>
</html>