<?php

	require_once("../config.php");

	$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$stmt = "SELECT * FROM orders";

		$result = $conn->query($stmt);

		$orders = array();
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				array_push($orders, $row);
			}
		}

		$stmt = "SELECT * FROM products";

		$result = $conn->query($stmt);

		$products = array();
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				array_push($products, $row);
			}
		}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>view orders | ADMIN</title>
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
include "header1.php";
?>
<div class="bs-example">
	<ul class="nav nav-pills">
				<li ><a href="index.php">Admin Home</a></li>
				<li ><a href="addcarosel.php">Add Carousel</a></li>
				<li><a href="products.php">Add Product</a></li>
				<li><a href="search.php?p=update">Update Product</a></li>
				<li><a href="search.php?p=delete">Delete Product</a></li>
				<li class="active"><a href="vieworders.php">View Orders</a></li>
	</ul>
</div>
<div style="text-align:center; margin-top:2%">
<div class="cont" style="margin:3px; padding:5px;">

        <table class="table" boarder="1" cellpadding="10" cellspannig="5">
            <thead>
                <tr>
                    <th>ID</th>
										<th>Product Name </th>
										<th>Product price</th>
                    <th>BUYER'S NAME</th>
                    <th>ADDRESS</th>
                    <th>PHONE NUMBER</th>
                    <th>ORDER TIME</th>
                    <th>DELEVERY</th>
                </tr>
            </thead>
        <?php if(count($orders) > 0) {
					foreach($orders as $order){
	?>
                <tr>

                    <td><?php echo $order["id"]; ?> </td>
										<?php

										$stmt2 = $pdo->prepare("SELECT * FROM products WHERE id=?");
										$stmt2->bindParam(1, $order["product_id"]);
										$stmt2->execute();
										$actual_row = $stmt2->fetch();

										?>
										<td><?php echo $actual_row["name"]; ?></td>
										<td><?php echo $actual_row["price"]; ?></td>
                    <td><?php echo $order["buyername"]; ?> </td>
                    <td><?php echo $order["address"]; ?> </td>
                    <td><?php echo $order["phone"]; ?> </td>
                    <td><?php echo $order["ordertime"]; ?></td>
                    <td><?php echo $order["delivered"]; ?></td>

                </tr>
        <?php }

	} else { echo "No orders found.";} ?>

        </tbody>
    </table>
</div>
</div>
<script src="/style/js/jquery.min.js"></script>
<script src="/style/js/bootstrap.min.js"></script>
</body>
</html>
