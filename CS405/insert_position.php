
<?php
	include 'header.php';
?><br>
<h1 class="titles">Insert/Update/Remove Position</h1>
<p class="para">Only position and year are needed to remove</p>
<form method="post">

<p>Average Points Per Game: <br><input type="text" class="box" name="avgppg" placeholder="Average Points Per Game"></p>
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

$position = array('RB',"WR","TE","QB","K","DEFENSE");


echo "Select Position <br>";
echo '<select class="box" name="position">';
        for($i = 0; $i<count($position);$i++)
        {
                echo '<option>'.$position[$i] . '</option>';
        }
echo '</select><br><br>';


echo "Select Year<br>";
echo '<select class="box" name="season">';
        for($i = (count($team3)-1); $i>=0;$i--)
        {
                echo '<option>'.$team3[$i].'</option>';
                //echo '<option>'.$team[$i] . '</option>';
        }
echo '</select><br><br>';


?>


<input type="submit" name="position_clicked" class="button" value="Insert/Change">
<input type="submit" name="position_remove" class="button" value="Remove">
</form>

<form action="CS405_Project.php" method="post">
<input type="submit" class="back-button" value="Back">
</form>


<?php

if(isset($_POST['position_clicked'])){
        $mysqli = new mysqli('localhost','root','Dpmaster7!','CS405_Project');

        if($mysqli->connect_errno){
                echo "Could not connect to database \n";
                echo "Error: ". $mysqli->connect_error. "\n";
                exit;
        }
        else{
                $avgppg = $_POST["avgppg"];
                $position = $_POST["position"];
                $year = $_POST["season"];
		

                $data_team = "SELECT * FROM position WHERE position_name='$position' AND year='$year'";
                $select_team = mysqli_query($mysqli, $data_team);
                $final_team = mysqli_fetch_assoc($select_team);
		echo 'still here';
                if($final_team["position_name"] == $position && $avgppg!='' && $final_team["year"] == $year){
                        if(!empty($avgppg)){
				$sql = "UPDATE position SET avg_ppg = '$avgppg' WHERE position_name = '$position' AND year = '$year'";
				echo 'here';
			}
		}
                if(($final_team["year"] != $year && $avgppg!='' && $final_team["avg_ppg"]!="NULL")){
                        $sql = "INSERT INTO position (position_name,avg_ppg,year) VALUES ('$position','$avgppg','$year')";
			echo 'here2';
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

        


if(isset($_POST['position_remove'])){
        $mysqli = new mysqli('localhost','root','Dpmaster7!','CS405_Project');

        if($mysqli->connect_errno){
                echo "Could not connect to database \n";
                echo "Error: ". $mysqli->connect_error. "\n";
                exit;
        }
        else{
		
                $avgppg = $_POST["avgppg"];
                $year = $_POST["season"];

                $data_team = "SELECT * FROM position WHERE position_name='$position' AND year='$year'";
                $select_player = mysqli_query($mysqli, $data_player);
                $final_player = mysqli_fetch_assoc($select_player);
                $sql = "DELETE FROM position WHERE position_name='$position' AND year='$year'";
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
