<?php

	require_once("../config.php");
	session_start();
	$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

	if(isset($_GET["logout"])) {
		unset($_SESSION["admin"]);
		header("location: index.php");
	}

	$loggedin = 0;
	$update = 0;

	if(isset($_SESSION["admin"])) {
		$loggedin = 1;
		$name = ($_SESSION["admin"]);
	}

	if(isset($_POST["uname"]) && isset($_POST["pword"])) {
		$username = $_POST["uname"];
		$password = $_POST["pword"];

		$stmt = "SELECT * FROM admin WHERE username ='".$username."'  AND password ='".$password."'";

		$result = $conn->query($stmt);

		if ($result->num_rows === 1) {
			$_SESSION['admin']= $username;
			header("location: ?loggedin");
		} else {
		    echo "The username or password is incorrect.";
		}

	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>ADMIN</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../style/css/bootstrap.css">
	<link rel="stylesheet" href="../style/css/style.css">
	<link rel="stylesheet" href="../style/css/admin.css">

    <style type="text/css">
      .bs-example{
      	margin: 20px;
      }
    body{
      padding-top: 70px;

    }
    /*padding*/
    .bpadding{
    margin-top: 10px;
    }
    .bs-example{
      margin: 20px;
    }

    </style>
</head>

<body>
<?php
include "header.php";
?>

	<?php if($loggedin == 0) { ?>
		<div class="wrapper" style="margin-left:4%;">
			<form action="" method="POST">
        <h2>Admin Login</h2>

        <p>Please fill in your credentials to login.</p>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <div class="form-group">

                <label>Username:<sup>*</sup></label>

                <input type="text" name="uname"class="form-control">

            </div>

            <div class="form-group">

                <label>Password:<sup>*</sup></label>

                <input type="password" name="pword" class="form-control">

            </div>

            <div class="form-group">

                <input type="submit" class="btn btn-primary" value="Submit">

            </div>

</form>
</div>
<?php } else { ?>
<div class="container index-form">
       <div class="row background">
       <div class="col-sm-4"></div>
       <div class="col-sm-4">
        <div style="text-align:center; ">
	<div class="cont">
		<a href="admin/d_register.php"><span class="text1">Register Doctor<span></a><br>
	</div>

</div>
</div>
</div>
<?php } ?>
</div>
</div>
<?php include "../footer.php" ?>
<script src="/style/js/jquery.min.js"></script>
<script src="/style/js/bootstrap.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>
