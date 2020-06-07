<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="description" content="Blah">
		<meta name=viewport content="width=device-width,initial-scale=1">
		<title></title>
		<Link rel="stylesheet" href="style.css">
	</head>
	<body>
	
		<header>
			<nav>
				<a href="#">
					<img src="football.png" alt="logo" class="Logo">
				</a>
			</nav>
		</header>

  <div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="http://dmpa227.netlab.uky.edu/CS405_project/CS405_Project.php">Home</a>
  <a href="http://dmpa227.netlab.uky.edu/CS405_project/insert_player.php">Insert Player</a>
  <a href="http://dmpa227.netlab.uky.edu/CS405_project/insert_season.php">Insert Season</a>
  <a href="http://dmpa227.netlab.uky.edu/CS405_project/insert_team.php">Insert Team</a>
  <a href="http://dmpa227.netlab.uky.edu/CS405_project/insert_position.php">Insert Position</a>
  <a href="http://dmpa227.netlab.uky.edu/CS405_project/season_stats.php">Super Bowl Champs</a>
  <a href="http://dmpa227.netlab.uky.edu/CS405_project/team_stats.php">Team Statistics</a>
  <a href="http://dmpa227.netlab.uky.edu/CS405_project/login.php">Sign Out</a> 

</div>



<!-- Use any element to open the sidenav -->

<span style="font-size:30px;cursor:pointer;margin-left:85%" class="sidebar" onclick="openNav()">[Menu]</span>



<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
</script>

