<?php
	include 'header.php';
?><br>
<h1 class="titles">Insert/Update/Remove Player</h1>
<p class="para">Only player name and year are needed to remove</p>

<form method="post">
<p>Full Name: <br><input type="text" class="box" name="pname" placeholder="Player Name"> </p>
<p>DOB(YYYY-MM-DD): <br><input type="text" class="box" name="dob" placeholder="Date of Birth"></p>
<p>Highest Point Total:  <br><input type="text" class="box" name="hpoint" placeholder="Higherst Point Total"></p>
<p>Number Of Games Played: <br><input type="text" class="box" name="numg" placeholder="Number of Games Played"></p>
<p>Average Points Per Game: <br><input type="text" class="box" name="avgppg" placeholder="Average Points Per Game"></p>
<?php

$position = array('RB',"WR","TE","QB","K","DEFENSE");


echo "Select Position <br>";
echo '<select class="box" name="position">';
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
$result2;
mysqli_close($conn);

echo "Select Year <br>";
echo '<select class="box" name="season">';
        for($i = (count($team3)-1); $i>=0;$i--)
        {
                echo '<option>'.$team3[$i].'</option>';
                //echo '<option>'.$team[$i] . '</option>';
        }
echo '</select><br><br>';


$conn=mysqli_connect('localhost','root','Dpmaster7!','CS405_Project');
$sql = "SELECT DISTINCT team_name FROM team;";
$result=mysqli_query($conn,$sql);
$team2 = array();
while($result2=mysqli_fetch_array($result)){
        array_push($team2,$result2['team_name']);
}
$result2;
mysqli_close($conn);

echo "Select Team <br>";
echo '<select class="box" name="team">';
        for($i = 0; $i<count($team2);$i++)
        {
                echo '<option>'.$team2[$i].'</option>';
        }
echo '</select><br><br>';
?>

<input type="submit" class="button" name="player_clicked"  value="Insert/Change">
<input type="submit" class="button" name="player_remove"  value="Remove">
</form>






<form action="CS405_Project.php" method="post">
<input type="submit" class="back-button" value="Back">
</form>


<?php

if(isset($_POST['player_clicked'])){
        $mysqli = new mysqli('localhost','root','Dpmaster7!','CS405_Project');

        if($mysqli->connect_errno){
                echo "Could not connect to database \n";
                echo "Error: ". $mysqli->connect_error. "\n";
                exit;
        }
        else{
                $pname = $_POST["pname"];
                $dob2 = $_POST["dob"];
                $year = $_POST["season"];
                $hpoint = $_POST["hpoint"];
                $numg = $_POST["numg"];
                $avgppg = $_POST["avgppg"];
                $team = $_POST["team"];
		$position = $_POST["position"];
		$dob='';
		
		for($i=0;$i<strlen($dob2);$i++){
			if($dob2[$i]!='-'){$dob.=$dob2[$i];}
		}
		$data_team = "SELECT * FROM player WHERE name='$pname' AND year='$year'";
                $select_player = mysqli_query($mysqli, $data_player);
                $final_player = mysqli_fetch_assoc($select_player);
		$flag=FALSE;
                if($final_player["name"] == $pname && $pname!='' && $final_player["year"] == $year||$flag==FALSE){
                        if(!empty($dob)){
				$sql5 = "UPDATE player SET date_of_birth = '$dob' WHERE name = '$pname' AND year='$year'";
			        $mysqli->query($sql5);
				$flag=TRUE;
}
                        if(!empty($hpoint)){
				$sql6 = "UPDATE player SET high_point = '$hpoint' WHERE name = '$pname' AND year='$year'";
				$flag=TRUE;
                		$mysqli->query($sql6);
}
                        if(!empty($numg)){
				$sql7 = "UPDATE player SET games_played = '$numg' WHERE name = '$pname' AND year='$year'";
                		$mysqli->query($sql7);
				$flag=TRUE;
}
			if(!empty($avgppg)){
				$sql8 = "UPDATE player SET avg_ppg = '$avgppg' WHERE name = '$pname' AND year='$year'";
                		$mysqli->query($sql8);
				$flag=TRUE;
}
			if(!empty($team)){
                                $sql9 = "UPDATE employed_by SET team_name = '$team' WHERE player_name = '$pname' AND year='$year'";
                                $mysqli->query($sql9);
				$flag=TRUE;
			}
			if(!empty($position)){
                                $sql10 = "UPDATE plays_as SET position_name = '$position' WHERE player_name = '$pname' AND year='$year'";
                                $mysqli->query($sql10);
				$flag=TRUE;
			}
}


                if(($final_player["name"] != $pname && $pname!='')||$final_player["year"] != $year||$flag==FALSE)
{
                        $sql3 = "INSERT INTO plays_as (player_name,position_name,year) VALUES ('$pname','$position','$year')";
                        $sql4 = "INSERT INTO employed_by (player_name,team_name,year) VALUES ('$pname','$team','$year')";
                        $sql2 = "INSERT INTO player (name,date_of_birth,games_played,avg_ppg,high_point,year) VALUES ('$pname','$dob','$numg','$avgppg','$hpoint','$year')";
				
                }
                if(($mysqli->query($sql2) === TRUE && $mysqli->query($sql4) === TRUE && $mysqli->query($sql3) === TRUE)||($flag ===TRUE)){
                        header('LOCATION: http://dmpa227.netlab.uky.edu/CS405_project/CS405_Project.php');
                }
                else{
                        echo "Error: ". $sql3 . "<br>". $mysqli->error. " ---- or a field is not populated";
                }


	}
	exit;
}

if(isset($_POST['player_remove'])){
        $mysqli = new mysqli('localhost','root','Dpmaster7!','CS405_Project');

        if($mysqli->connect_errno){
                echo "Could not connect to database \n";
                echo "Error: ". $mysqli->connect_error. "\n";
                exit;
        }
        else{
                $pname = $_POST["pname"];
                $dob2 = $_POST["dob"];
                $year = $_POST["season"];
                $hpoint = $_POST["hpoint"];
                $numg = $_POST["numg"];
                $avgppg = $_POST["avgppg"];
                $team = $_POST["team"];
                $position = $_POST["position"];
                $dob='';
                for($i=0;$i<strlen($dob2);$i++){
                        if($dob2[$i]!='-'){$dob.=$dob2[$i];}
                }
                $data_team = "SELECT * FROM player WHERE name='$pname' AND year='$year'";
                $select_player = mysqli_query($mysqli, $data_player);
                $final_player = mysqli_fetch_assoc($select_player);
		$sql = "DELETE FROM plays_as WHERE player_name='$pname' AND year='$year'";
		$sql2 = "DELETE FROM employed_by WHERE player_name='$pname' AND year='$year'";
		$sql3 = "DELETE FROM player WHERE name='$pname' AND year='$year'";
                if($mysqli->query($sql) === TRUE){
                        header('LOCATION: http://dmpa227.netlab.uky.edu/CS405_project/CS405_Project.php');
                }
                else{
                        echo "Error: ". $sql3 . "<br>". $mysqli->error. " ---- or a field is not populated";
                }

	}
	exit;
}
?>
</body>
</html>
