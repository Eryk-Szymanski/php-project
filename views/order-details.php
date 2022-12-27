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
    if (isset($_GET['number'])) {
      require_once '../scripts/connect.php';
      $sql = "SELECT * FROM `orders` WHERE `number` = $_GET[number]";
      $result = $mysqli->query($sql);
      $order = $result->fetch_assoc();
      echo <<< INFO
        <p>$order[products]</p>
INFO;
    }
  ?>
</body>
</html>
