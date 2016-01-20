<!--
  Filename: register.php
  Student Name: Shreyas Anand
  Student ID: 1000981001
-->

<?php
session_start();
?>

<html>
    <head>
        <title>New user registration</title>
        <a href="https://github.com/shreyasanand/messageboard"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/365986a132ccd6a44c23a9169022c0b5c890c387/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f7265645f6161303030302e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_red_aa0000.png"></a>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <h1>Post It!</h1>
    <body style="background-color:#484848; color:white;">
        Enter the details to register
        <br><br>
        <form action="" method="POST">
            <table>
            <tr><td>User name: </td><td><input type="text" name="username" /></td></tr>
            <tr><td>Name: </td><td><input type="text" name="name" /></td></tr>
            <tr><td>Password: </td><td><input type="password" name="pwd" /></td></tr>
            <tr><td>Email: </td><td><input type="text" name="mail" /></td></tr>
            <tr><td><input type="submit" name="submit"/></td>
            <td><input type="submit" name="login" value="Back to login"/>      
            </td>
            </tr>
            </table>
        </form>
    </body>
</html>

<?
try{

// Perform the following functions once the user clicks on submit button
if(isset($_POST['submit'])){
	
	$username = $_POST['username'];
	$name = $_POST['name'];
	$pwd = $_POST['pwd'];
	$email = $_POST['mail'];
	$dbname = dirname($_SERVER["SCRIPT_FILENAME"]) . "/mydb.sqlite";
	$dbh = new PDO("sqlite:$dbname");
	$dbh->beginTransaction();
	
	$stmnt = $dbh->prepare('select username from users where username="'.$username.'"');
	$stmnt->execute();

	// Check if the user enters all the details 
	if($username == ""){
		echo "Enter a username";
	}elseif($name == ""){
		echo "Enter a name";
	}elseif ($pwd == ""){
		echo "Enter a password";	
	}
	// Check if the entered username already exists
	elseif ($stmnt->fetchColumn()){
		$_SESSION['register'] = 'false';
		header("Location: board.php");
	}else{
		$dbh->exec('insert into users values("'.$username.'","' . md5("$pwd") . '","'.$name.'","'.$email.'")')
			or die(print_r($dbh->errorInfo(), true));
		$dbh->commit();
		$_SESSION['register']= 'true';
		header("Location: board.php");
	}
}
}
catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}

// A button to navigate back to login page
if(isset($_POST['login'])){
	header("Location: board.php");
}

?>
