<?php  

function create_connection () {
	$link = mysqli_connect("localhost", "root", "", "Personnel"); 
  
	if ($link == false) { 
		die("ERROR: Could not connect. " .mysqli_connect_error()); 
		return NULL;
	} else {
		return $link;
	}	
}


function print_people($link) {
	echo "<h2 class=centered>Print all people</h2>";
	$sql = "SELECT * FROM People ORDER BY Last_Name"; 
	if ($res = mysqli_query($link, $sql)) { 
		if (mysqli_num_rows($res) > 0) { 
			echo "<table class=centered>"; 
			echo "<tr>"; 
			echo "<th>Firstname</th>"; 
			echo "<th>Lastname</th>"; 
			echo "<th>Email</th>"; 
			echo "<th>Start Date</th>";
			echo "</tr>"; 
			while ($row = mysqli_fetch_array($res)) { 
				echo "<tr>"; 
				echo "<td>".$row['First_Name']."</td>"; 
				echo "<td>".$row['Last_Name']."</td>"; 
				echo "<td>".$row['Email']."</td>";
				echo "<td>".$row['Activation_Date']."</td>";				
				echo "</tr>"; 
			} 
			echo "</table>"; 
			mysqli_free_result($res); 
		} 
		else { 
			echo "No matching records are found."; 
		} 
	} 
	else { 
		echo "ERROR: Could not able to execute $sql. "
									.mysqli_error($link); 
	} 
	mysqli_close($link); 
}

?> 