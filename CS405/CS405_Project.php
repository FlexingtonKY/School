<?php

        require "header.php";

?>


<h1 class="titles">Search Player Information</h1>

<form class="main" method="post">
<?php
//TO DO: all lower case input maybe for comparison, formatting output, include the attributes when outputing, input data, add functionality to change data.
$position = array('ANY','RB',"WR","TE","QB","K","DEFENSE");


echo "Player Name (Leave empty to search multiple players, also capatilaize the first letter in the first and last name)<br>";
echo "<input type=text name=player_name placeholder='Full Name'><br><br>";

echo "Select Position<br>";
echo '<select class=box name="position">';
	for($i = 0; $i<count($position);$i++)
	{
		echo '<option>'.$position[$i] . '</option>';	
	}
echo '</select><br><br>';



$conn=mysqli_connect('localhost','root','Dpmaster7!','CS405_Project');
$sql = "SELECT DISTINCT year FROM team ORDER BY year ASC;";
$result=mysqli_query($conn,$sql);
$team3 = array();
while($result2=mysqli_fetch_array($result)){
        array_push($team3,$result2['year']);
}
array_push($team3,"ANY");
$result2;
mysqli_close($conn);

echo "Select Year<br>";
echo "<select name='season' class='box'>";
        for($i = (count($team3)-1); $i>=0;$i--)
        {
                echo '<option>'.$team3[$i].'</option>';
                //echo '<option>'.$team[$i] . '</option>';
        }
echo '</select><br><br>';



$conn=mysqli_connect('localhost','root','Dpmaster7!','CS405_Project');
$sql = "SELECT DISTINCT team_name FROM team;";
$result=mysqli_query($conn,$sql);
$team2 = array("ANY");
while($result2=mysqli_fetch_array($result)){
	array_push($team2,$result2['team_name']);	
}
$result2;
mysqli_close($conn);

echo "Select Team<br>";
echo "<select name='team' class='box'>";
        for($i = 0; $i<count($team2);$i++)
        {
		echo '<option>'.$team2[$i].'</option>';
                //echo '<option>'.$team[$i] . '</option>';
        }
echo '</select><br>';
?>
	<input type = 'submit' class="button" name='query'>
</form>




<?php
if(isset($_POST['query'])){

	$conn=mysqli_connect('localhost','root','Dpmaster7!','CS405_Project');
	if(!$conn)
	{
	        die("Connection failed: ".mysqli_connect_error());
	}
	
	$pname = $_POST["player_name"];
	$season = $_POST["season"];
	$position = $_POST["position"];
	$team = $_POST["team"];
	$field = '$pname';

	$sql="SELECT DISTINCT player.name,plays_as.position_name,team.team_name,player.games_played,player.avg_ppg,player.high_point,team.year FROM position,player,team,employed_by,plays_as WHERE plays_as.year=player.year AND plays_as.year=position.year AND employed_by.year=player.year AND employed_by.year = team.year AND employed_by.player_name=player.name AND employed_by.team_name=team.team_name AND plays_as.player_name=player.name AND plays_as.position_name=position.position_name AND player.year=team.year ";
	if($pname!=''){$sql.=" AND player.name='$pname'";}
	if($season!='ANY'){$sql.=" AND team.year='$season'";}
	if($position!='ANY'){$sql.=" AND plays_as.position_name='$position'";}
	if($team!='ANY'){$sql.=" AND team.team_name='$team'";}
	$sql.= ";";
	$result=mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)>0){
	// output data of each row
                echo "<table id='myTable' style='border: solid 1px black;' cellspacing='2' cellpadding='2'>
                         <tr>
                         <th onclick='sortTable(0)'>Name</th>
                         <th onclick='sortTable(1)'>Position Name</th>
                         <th onclick='sortTable(2)'>Team Name</th>
                         <th onclick='sortTable(3)'>Year</th>
                         <th onclick='sortTable(4)'>Games Played</th>
                         <th onclick='sortTable(5)'>Avg PPG</th>
                         <th onclick='sortTable(6)'>High Point</th>
			 </tr>";

		while($row = mysqli_fetch_assoc($result)){
				//while ($row = mysqli_fetch_array($results)) {
    				echo 
        			'<tr>
					<td>'.$row['name'].'</td>
            				<td>'.$row['position_name'].'</td>
            				<td>'.$row['team_name'].'</td>
            				<td>'.$row['year'].'</td>
            				<td>'.$row['games_played'].'</td>
            				<td>'.$row['avg_ppg'].'</td>
            				<td>'.$row['high_point'].'</td>
				</tr>';
				

				//echo $row["name"]," | ",$row["position_name"], " | ",$row["team_name"], " | ",$row["year"]," | ",$row["games_played"], " | ",$row["avg_ppg"], " | ",$row["high_point"],"<br>";
			}
		echo'</table>';
		}


		else{
			echo"0 results";
			
		}



	mysqli_close($conn);
}
?>

<script>


function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable");
  switching = true;
  // Set the sorting direction to ascending:
  dir = "asc";
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /* Check if the two rows should switch place,
      based on the direction, asc or desc: */
	//document.write(!isNaN(x.innerHTML));
	//document.write(x.innerHTML));
      if(!isNaN(x.innerHTML)){
	if(dir=="asc"){        
	if (Number(x.innerHTML) > Number(y.innerHTML)) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
       }
       else if (dir == "desc") {
        if (Number(x.innerHTML) < Number(y.innerHTML)) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
	}
       }
      } else {
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount ++;
    } else {
      /* If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again. */
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
</script>

</body>
</html>
