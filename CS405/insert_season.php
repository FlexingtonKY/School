<?php
	include 'header.php';
?><br>

<h1 class="titles">Insert/Update/Remove Season</h1>
<p class="para">Select the super bowl winner</p>


<form method="post">
<?php

$conn=mysqli_connect('localhost','root','Dpmaster7!','CS405_Project');
$sql = "SELECT DISTINCT year FROM team ORDER BY year ASC;";
$result=mysqli_query($conn,$sql);
$team3 = array();
while($result2=mysqli_fetch_array($result)){
        array_push($team3,$result2['year']);
}
$result2;
mysqli_close($conn);

echo "Select Year<br>";
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

<input type="submit" name="season_clicked" class="button" value="Insert/Change">
<input type="submit" name="season_remove" class ="button" value="Remove">
</form>

<form action="CS405_Project.php" method="post">
<input type="submit" class="back-button" value="Back">
</form>

<?php

if(isset($_POST['season_clicked'])){
        $mysqli = new mysqli('localhost','root','Dpmaster7!','CS405_Project');

        if($mysqli->connect_errno){
                echo "Could not connect to database \n";
                echo "Error: ". $mysqli->connect_error. "\n";
                exit;
        }
        else{
                $tname = $_POST["team"];
                $year = $_POST["season"];

                $data_team = "SELECT * FROM season WHERE year='$year'";
                $select_team = mysqli_query($mysqli, $data_team);
                $final_team = mysqli_fetch_assoc($select_team);
                if(!empty($final_team)){
                        $sql = "UPDATE season SET super_bowl_champ = '$tname' WHERE  year = '$year'";
        
                       }

                else{
                        $sql = "INSERT INTO season (year,super_bowl_champ) VALUES ('$year','$tname')";
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

if(isset($_POST['season_remove'])){
        $mysqli = new mysqli('localhost','root','Dpmaster7!','CS405_Project');

        if($mysqli->connect_errno){
                echo "Could not connect to database \n";
                echo "Error: ". $mysqli->connect_error. "\n";
                exit;
        }
        else{

                $tname = $_POST["team"];
                $year = $_POST["season"];

                $data_team = "SELECT * FROM season WHERE year='$year'";


                $select_player = mysqli_query($mysqli, $data_player);
                $final_player = mysqli_fetch_assoc($select_player);
                $sql = "DELETE FROM season WHERE year='$year'";
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
