<?php
	include 'header.php'
?><br>
<h1 class="titles">Insert/Update/Remove Team</h1>
<p class="para">Only team name and year are needed to remove</p>


<form method="post">
<p>Team Name: <br><input type="text" class="box" name="tname" placeholder="e.g.Patriots"> </p>
<p>City:  <br><input type="text" class="box" name="city" placeholder="e.g.New England"></p>
<p>Year:  <br><input type="text" class="box" name="year" placeholder="e.g.2018"></p>
<p>Win Percentage: <br><input type="text" class="box" name="win_percentage" placeholder="e.g.0.50"></p>

<input type="submit" name="team_clicked" class="button" value="Insert/Change">
<input type="submit" name="team_remove" class ="button" value="Remove">
</form>

<form action="CS405_Project.php" method="post">
<input type="submit" class="back-button" value="Back">
</form>

<?php

if(isset($_POST['team_clicked'])){
        $mysqli = new mysqli('localhost','root','Dpmaster7!','CS405_Project');

        if($mysqli->connect_errno){
                echo "Could not connect to database \n";
                echo "Error: ". $mysqli->connect_error. "\n";
                exit;
        }
        else{
                $tname = $_POST["tname"];
                $city = $_POST["city"];
                $year = $_POST["year"];
                $win_percentage = $_POST["win_percentage"];
                
		$data_team = "SELECT * FROM team WHERE team_name='$tname' AND year='$year' ";
                $select_team = mysqli_query($mysqli, $data_team);
                $final_team = mysqli_fetch_assoc($select_team);
                if($final_team["team_name"] == $tname && $tname!='' && $final_team["year"] == $year){
			if(!empty($city)){$sql = "UPDATE team SET city = '$city' WHERE team_name = '$tname' AND year = '$year'";}
			if(!empty($win_percentage)){$sql = "UPDATE team SET win_percentage = '$win_percentage' WHERE team_name = '$tname' AND year = '$year'";}
			}
			
		if(($final_team["team_name"] != $tname && $tname!='')||$final_team["year"] != $year){
			$sql = "INSERT INTO team (team_name,city,year,win_percentage) VALUES ('$tname','$city','$year','$win_percentage')";
			$sql2 = "INSERT INTO position (position_name,avg_ppg,year) VALUES ('K','0','$year')";
			$sql3 = "INSERT INTO position (position_name,avg_ppg,year) VALUES ('TE','0','$year')";
			$sql4 = "INSERT INTO position (position_name,avg_ppg,year) VALUES ('QB','0','$year')";
			$sql5 = "INSERT INTO position (position_name,avg_ppg,year) VALUES ('RB','0','$year')";
                        $sql6 = "INSERT INTO position (position_name,avg_ppg,year) VALUES ('WR','0','$year')";
			$mysqli->query($sql2);$mysqli->query($sql3);$mysqli->query($sql4);$mysqli->query($sql5);$mysqli->query($sql6);	
		}
                if($mysqli->query($sql) === TRUE){
                        header('LOCATION: http://dmpa227.netlab.uky.edu/CS405_project/CS405_Project.php');
                }
                else{
                        echo "Error: ". $sql . "<br>". $mysqli->error. " ---- or a field is not populated";
                }

				
	}
	exit;		
}		
              
if(isset($_POST['team_remove'])){
        $mysqli = new mysqli('localhost','root','Dpmaster7!','CS405_Project');

        if($mysqli->connect_errno){
                echo "Could not connect to database \n";
                echo "Error: ". $mysqli->connect_error. "\n";
                exit;
        }
        else{
                
                $tname = $_POST["tname"];
                $city = $_POST["city"];
                $year = $_POST["year"];
                $win_percentage = $_POST["win_percentage"];

                $data_team = "SELECT * FROM team WHERE team_name='$tname' AND year='$year' ";


                $select_player = mysqli_query($mysqli, $data_player);
                $final_player = mysqli_fetch_assoc($select_player);
                $sql = "DELETE FROM team WHERE team_name='$tname' AND year='$year'";
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
