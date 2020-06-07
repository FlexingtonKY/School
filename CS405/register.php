
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

<Title>Fantasy Football Database Registration</Title>

<b>Populate given fields</b>

<form method="post">

	<input type="text" name="fname" placeholder="First Name"><br>
	<input type="text" name="lname" placeholder="Last Name"><br>
	<input type="text" name="email" placeholder="Email"><br>
	<input type="text" name="username" placeholder="Username"><br>
	<input type="password" name="password" placeholder="Password">
	<input type="password" name="password-repeat" placeholder="Repeat Password"><br>
	<input type="submit" class="button" name="register_clicked"  value="register">
</form>

<form action="login.php" method="post">
<input type="submit" class="back-button" value="Back">
</form>
		

<?php

if(isset($_POST['register_clicked'])){
        $mysqli = new mysqli('localhost','root','Dpmaster7!','CS405_Project');

        if($mysqli->connect_errno){
                echo "Could not connect to database \n";
                echo "Error: ". $mysqli->connect_error. "\n";
                exit;
        }
        else{
		$uname = $_POST["username"];
		$pass = $_POST["password"];
		$pass_repeat=$_POST["password-repeat"];
		$fname = $_POST["fname"];
		$lname = $_POST["lname"];
		$email = $_POST["email"];
		if((empty($uname) || empty($pass) || empty($fname) || empty($lname) || empty($email))||($pass!==$pass_repeat)){}
		else{$sql = "INSERT INTO login (username,password,fname,lname,email) VALUES ('$uname','$pass','$fname','$lname','$email')";}
		if($mysqli->query($sql) === TRUE){
			header('LOCATION: http://dmpa227.netlab.uky.edu/CS405_project/login.php');
		}
                if($pass!==$pass_repeat){
                        echo "<p class='error'>passwords do not match!</p>";
		}	
		else{
			echo "<p class='error'>Populate all given fields!</p>";
		} 
            
		exit;
        }
}
?>


</form>

</body>
</html>

<?php

        require "footer.php";

?>

