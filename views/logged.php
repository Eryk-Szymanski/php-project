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
  <?php
    if (isset($_SESSION['success'])) {
      echo "<p>Witaj $_SESSION[user_name]</p>";
      if ($_SESSION['user_role'] == 'user') {
        require_once '../scripts/connect.php';
        $sql = "SELECT orders.number FROM `orders` WHERE `user_id` = $_SESSION[user_id]";
        $result = $mysqli->query($sql);
        echo <<< INFO
        <h5><a href="./products.php">Wszystkie produkty</a></h5>
        <h3>twoje zamówienia</h3>
INFO;
        while ($order = $result->fetch_assoc()) {
          echo "<a href='./order-details.php?number=$order[number]'>$order[number]</a><br>";
        }
      }
      elseif ($_SESSION['user_role'] == 'superuser') {
        echo <<< INFO
INFO;
      }
      elseif ($_SESSION['user_role'] == 'admin') {
        echo <<< INFO
INFO;
      }
    }
  ?>
</body>
</html>
