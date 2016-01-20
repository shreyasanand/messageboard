<!--
  Filename: posts.php
  Student Name: Shreyas Anand
  Student ID: 1000981001
-->

<?php
session_start();
$name = $_SESSION['user'];

// Connect to the database
$dbname = dirname($_SERVER["SCRIPT_FILENAME"]) . "/mydb.sqlite";
$dbh = new PDO("sqlite:$dbname");
$dbh->beginTransaction();
?>

<html>
<head>
    <title>Message board</title>
    <a href="https://github.com/shreyasanand/messageboard"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/365986a132ccd6a44c23a9169022c0b5c890c387/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f7265645f6161303030302e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_red_aa0000.png"></a>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<h1>Post It!</h1>
<body style="color:white; background-color:#484848;">

<?
// Check if a user has logged in
if($name){

echo "<div>";
echo "Welcome $name";
echo '<form action="" method="GET">';
echo '<input id="logout" type="submit" name="logout" value="Logout">
</form></div>';

try {

// Insert to the posts table the message entered by the user once clicked on post button
if(isset($_POST['submit'])){
	$msg = $_POST['message'];
	if($msg != ""){
		$id = uniqid();
		$dbh->exec('insert into posts values("'.$id.'","'.$name.'",datetime("now"),"'.htmlentities($msg).'")')
			or die(print_r($dbh->errorInfo(), true));
		$dbh->commit();
	}
}
} catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}

// Get the full name of the user who posted the message from the users table and display
$stmt = $dbh->prepare('select * from posts order by datetime');
$stmt->execute();
echo "<div><table id='posts_table' border=1 cellpadding='10' cellspacing='0'><tr><th>User</th><th>Post</th></tr>";
while($row = $stmt->fetch()) {
	$username = $row['postedby'];
	$stmnt = $dbh->prepare('select * from users where username="'.$username.'"');
	$stmnt->execute();
	$innerrow = $stmnt->fetch();
	$fullname = $innerrow['fullname'];
	$datetime = $row['datetime'];
	$message = $row['message'];
	echo "<tr><td width=25%>$username<br>Name: $fullname<br>Posted on: $datetime</td><td width=75%>$message</td><tr>";
}
echo "</table></div>";

// Unset the session once the user logs out and redirect to the first page
if (isset($_GET['logout'])){
   session_unset();
   header("location:board.php");
}

echo '<form action="posts.php" method="POST">';
echo '<textarea name="message" rows="4" cols="50" placeholder="Enter your message here..."></textarea><br>';	
echo '<input type="submit" name="submit" value="Post"/></form>';

}
// If there is no user logged in display this message
else {
        echo "<p>Please login first!</p>";
}

?>
</body>
</html>
