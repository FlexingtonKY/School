<?php
	include "header.php";
?>

<h1 class="titles">Search Super Bowl Winners</h1>

<form class="main" method="post">
<?php

$conn=mysqli_connect('localhost','root','Dpmaster7!','CS405_Project');
$sql = "SELECT DISTINCT year FROM team;";
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

?>
        <input type = 'submit' class="button" name='query'>
</form>

<form action="CS405_Project.php" method="post">
<input type="submit" class="back-button" value="back">
</form>


<?php
if(isset($_POST['query'])){

        $conn=mysqli_connect('localhost','root','Dpmaster7!','CS405_Project');
        if(!$conn)
        {
                die("Connection failed: ".mysqli_connect_error());
        }

        $season = $_POST["season"];

        $sql="SELECT * FROM season WHERE year!='' ";
        if($season!='ANY'){$sql.=" AND year='$season'";}
        $sql.= ";";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
        // output data of each row
                echo "<table id='myTable' style='border: solid 1px black;' cellspacing='2' cellpadding='2'>
                         <tr>
                         <th onclick='sortTable(0)'>Year</th>
                         <th onclick='sortTable(1)'>Super Bowl Champ</th>
                         </tr>";

                while($row = mysqli_fetch_assoc($result)){
                                //while ($row = mysqli_fetch_array($results)) {
                                echo
                                '<tr>
                                        <td>'.$row['year'].'</td>
                                        <td>'.$row['super_bowl_champ'].'</td>
                                </tr>';

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
