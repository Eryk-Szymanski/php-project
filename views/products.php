<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard 2</title>

  <?php
    require_once '../style/style.css';
  ?>
  
</head>
<body>
  <button><a href="./new-order.php">Zamów</a></button>
  <?php
    if(isset($_SESSION['cart'])) {
      echo count($_SESSION['cart']);
    }
    require_once '../scripts/connect.php';
    $sql = "SELECT * FROM `products`";
    $result = $mysqli->query($sql);
    while($product = $result->fetch_assoc()) {
      echo <<< INFO
      <p>$product[name]</p>
      <form action="../scripts/add-product.php" method="post">
        <input type="number" value="$product[id]" hidden="true" name="product_id" />
        <input type="number" value="1" name="quantity"/>
        <button type="submit">Dodaj do koszyka</button>
      </form>
INFO;
      }
  ?>
</body>
</html>
