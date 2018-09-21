<?php

	require_once("../config.php");

	session_start();
	$loggedin = 0;
	$update = 0;

	if(isset($_SESSION["admin"])) {
		$loggedin = 1;
		$name = ($_SESSION["admin"]);
	} else {
		header("location:index.php");
	}

	$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

	//Updating
	if(isset($_GET["view"])) {
		$id = trim($_GET["id"]);
		$stmt = "SELECT * FROM products WHERE `id` =".$id;

		$result = $conn->query($stmt);

		$update = 1;

		if ($result->num_rows === 1) {
				$values = $result->fetch_assoc();
		} else {
		    echo "There are no matching records.";
		}
	}

      //  if (isset($_POST["eliminate"])) {
        //    foreach($_POST["prod"] as $prod) {
          //      $id = $prod;
            //    $stmt = $pdo->prepare("DELETE FROM products WHERE id=?");
              //  $stmt->bindParam(1, $id);
          //      $stmt->execute();
          //  }
      //  }


	if(isset($_GET["update"]) && ($_SERVER["REQUEST_METHOD"] == "POST")) {
		$id = $_POST["id"];

		if(isset($_POST["delete"])) {
			$sql = "DELETE FROM products WHERE `products`.`id` = ".$id;

			$result = $conn->query($sql);

			if ($result) {
					echo ("Product was successfully deleted.");
			} else {
					echo "There was a problem deleting the product.";
			}
		} else {
			$fields = array("prname", "price","cat_id", "description", "tags", "offer");
			$input = array();

			$input["offer"] = "";

			foreach($fields as $field) {
				if(!empty(trim($_POST[$field]))) {
					$input[$field] = trim($_POST[$field]);
				}
			}

			$sql = "UPDATE `products` SET `name` = '".$input["prname"]."', `description` = '".$input["description"]."',  `tags` = '".$input["tags"]."', `specialoffer` = '".$input["offer"]."', `price` = '".$input["price"]."' WHERE `products`.`id` = ".$id;

			$result = $conn->query($sql);

			if ($result) {
					echo ("Product was successfully updated.");
			} else {
					echo "There was a problem updating the product.";
			}
	}

	} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminate"])) {
            foreach($_POST["prod"] as $prod) {
                $id = $prod;
                $stmt = $pdo->prepare("DELETE FROM products WHERE id=?");
                $stmt->bindParam(1, $id);
                $stmt->execute();
            }
        }elseif($_SERVER["REQUEST_METHOD"] == "POST"){
		$fields = array("prname", "price","cat_id", "description", "tags", "offer","youtubelink");
		$input = array();
		foreach($fields as $field) {
			if(!empty(trim($_POST[$field]))) {
				$input[$field] = trim($_POST[$field]);
			}
		}

		$target_dir = "../images/";
		$target_file = $target_dir . basename($_FILES["image"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

		if (file_exists($target_file)) {
		    echo "Sorry, image file already exists.";
		    $uploadOk = 0;
		}

		if ($_FILES["image"]["size"] > 500000) {
		    echo "Sorry, your file is too large.";
		    $uploadOk = 0;
		}

		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = 0;
		}

		if ($uploadOk == 0) {
		    echo "Sorry, your file was not uploaded.";

		} else {
			move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
		}

		$input["offer"] = (!empty(trim($_POST["offer"])))? trim($_POST["offer"]) : "";
		$input["image"] = substr(($target_dir . $_FILES["image"]["name"]), 3);

		if($uploadOk === 1) {
			$sql = "INSERT INTO `products` (`id`, `name`, `image`, `price`,`cat_id`, `description`, `tags`, `specialoffer`,`youtubelink`) VALUES (NULL, '".$input["prname"]."', '".$input["image"]."', '".$input["price"]."','".$input["cat_id"]."', '".$input["description"]."', '".$input["tags"]."', '".$input["offer"]."','".$input["youtubelink"]."');";

			$result = $conn->query($sql);

			if ($result) {
					echo ("Product was successfully added.");
			} else {
					echo "There was a problem adding the product.";
			}
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
    <script src="/style/js/jquery.min.js"></script>
    <script src="/style/js/bootstrap.min.js"></script>
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
include "header1.php";
?>

<div class="bs-example">
	<ul class="nav nav-pills">
				<li ><a href="index.php">Admin Home</a></li>
				<li ><a href="addcarosel.php">Add Carousel</a></li>
				<li class="active"><a href="products.php">Add Product</a></li>
				<li><a href="search.php?p=update">Update Product</a></li>
				<li><a href="search.php?p=delete">Delete Product</a></li>
				<li ><a href="vieworders.php">View Orders</a></li>
	</ul>
</div>
	<?php //if($loggedin === 1) {echo 'Welcome, '.$name.'!<br><a href="index.php?logout">Logout</a>'; } ?>
<!--     <div>
            <a href="search.php?p=update">Update</a>
            <a href="search.php?p=delete">Delete</a>
        </div>

				<a href="index.php">MAIN MENU</a>
			-->
				<div style="margin-left:20%; margin-top:7%">
				<div class="cont">
					<h3>Add Products:</h3>
					<form action="<?php if($update == 1) echo '?update';?>" method="POST" enctype="multipart/form-data">
						<?php if($update == 1) { ?>
							<input name="id" type="hidden" value="<?php echo $values["id"]; ?>">
						<?php		} ?>
					Name: <input type="text" name="prname" value="<?php if($update == 1)  echo $values["name"]; ?>" autocomplete="off"><br>
					Price: <input type="text" name="price" value="<?php if($update == 1)  echo $values["price"]; ?>" autocomplete="off"><br>
					Categories: <input type="text" name="cat_id" value="<?php if($update == 1)  echo $values["cat_id"]; ?>" autocomplete="off"><br>
					Description: <textarea name="description"><?php if($update == 1)  echo $values["description"]; ?></textarea><br>
					Tags: <input type="text" name="tags" value="<?php if($update == 1)  echo $values["tags"]; ?>" autocomplete="off"><br>
					Offer: <input type="text" name="offer" value="<?php if($update == 1)  echo $values["specialoffer"]; ?>" autocomplete="off"><br>
					Image: <input type="file" name="image"><br>
          YouTube link: <input type="text" name="youtubelink" autocomplete="off"><br>
					<?php if($update == 1) {
						echo ('<input type="submit" value="Update"><input type="submit" name="delete" value="Delete">');
					} else {
					echo ('<input type="submit" value="Add">');
					}
					?>
					</form>
				</div>
			</div>


<!--up to this part-->


      <!--  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
-->
<!-- <?php
$stmt = $pdo->prepare("SELECT * FROM products");
$stmt->execute();

echo "<table>\n";
while ($row=$stmt->fetch()) { ?> -->
    <!-- <tr>
    <td><?php echo $row["name"]; ?></td>
    <td><?php echo $row["id"]; ?></td>
    <td><input type="checkbox" name="prod[]" value="<?php echo $row["id"]; ?>"></td>
    </tr> -->
<!-- <?php
}
?> -->
<!-- <br>
<input type="submit" value="Eliminate" name="eliminate">
</form> -->

</body>
</html>
<?php $conn->close(); ?>
