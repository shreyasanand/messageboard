<!--
  Filename: board.php
  Student Name: Shreyas Anand
  Student ID: 1000981001
-->

<?php
session_start();
?>

<html>
<head><title>Message Board</title>
    <a href="https://github.com/shreyasanand/messageboard"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/365986a132ccd6a44c23a9169022c0b5c890c387/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f7265645f6161303030302e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_red_aa0000.png"></a>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
        function showDialog() {
            $("#myModal").modal('show');
        }
    </script>
</head>
<h1>Post It!</h1>
<body style="background-color: #484848;">
    <form action="" method="POST">
        <p class="bootstrap_overide">User name: <input type="text" name="name" /></p>
        <p class="bootstrap_overide">Password: <input type="password" name="password" /></p>
        <p><input type="submit"/></p>
        <p class="bootstrap_overide">Are you a new user? Click here to register</p>
        <p><input type="submit" name="register" value="Register"/>
            <input type="button" onclick="showDialog()" value="Demo login"/></p>
        <div id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Demo login</h4>
                    </div>
                    <div class="modal-body">
                        <p>Username: testuser</p>
                        <p>Password: test@123</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
try {

  // Once the user registers display an appropriate message 
  if(isset($_SESSION['register'])){
	if($_SESSION['register'] == 'true'){
		echo "New user registered successfully";
		unset($_SESSION['register']);
	} else {
		echo "User already exists";
		unset($_SESSION['register']);
	}
  }

  // Check if the user and the password exists in the database
  if (isset($_POST['name']) && isset($_POST['password'])){
  	$name = $_POST['name'];
  	$pwd = $_POST['password'];
  
  	$dbname = dirname($_SERVER["SCRIPT_FILENAME"]) . "/mydb.sqlite";
  	$dbh = new PDO("sqlite:$dbname");
 	$dbh->beginTransaction();
  	$dbh->commit();

  	$stmt = $dbh->prepare('select * from users');
  	$stmt->execute();
  	while ($row = $stmt->fetch()) {
    		if (($row['username'] == $name) && ($row['password'] == md5($pwd))) {
			$_SESSION['user'] = $name;
			header("Location: posts.php");
  		} else {
			$flag = 1; 
		}
  	}
	if($flag == 1){
		echo "Invalid username/password. Try again";
	}
   }

  // Redirect to the register page once the user clicks on register
  if (isset($_POST['register'])){
	header("Location: register.php");
}

} catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}
?>
</body>
</html>
