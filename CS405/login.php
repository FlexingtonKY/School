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

<Title>Fantasy Football Database Login</Title>

<form method="post">

<input type="text" name="username" placeholder="Username"><br>
<input type="password" name="password" placeholder="Password"><br>

<input type="submit" class="button" name="login_clicked" value="login">
</form>

<form action="register.php" method="post">
<input type="submit" class="button" value="register">


<?php
if($error==true){
	echo "<p class='error'>Login Failed. Retry or Register.</p>";
}
if(isset($_POST['login_clicked'])){
        $mysqli = new mysqli('localhost','root','Dpmaster7!','CS405_Project');

        if($mysqli->connect_errno){
                echo "Could not connect to database \n";
                echo "Error: ". $mysqli->connect_error. "\n";
                exit;
        }
        else{
                $uname = $_POST["username"];
                $pass = $_POST["password"];
                $data_pass = "SELECT password FROM login WHERE username='$uname'";	
		$select_pass = mysqli_query($mysqli, $data_pass);		
		$final_pass = mysqli_fetch_assoc($select_pass);		

		if($final_pass["password"] == $pass && $pass!=''){
			header('LOCATION: http://dmpa227.netlab.uky.edu/CS405_project/CS405_Project.php');	
		
		}
		else{
			echo "<p class='error'>Login Failed. Retry or Register</p>";	

                	
		}

                

                exit; 
        }
}

?>
</form>
<?php

        require "footer.php";

?>

