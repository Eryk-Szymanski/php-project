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
<div class="p-2">
  <?php if (isset($_SESSION['success'])) : ?>
    <?php
      echo <<< LOGOUT
        <form action="../scripts/logout.php" method="post">
        <div class="col-md-1">
        <button type="submit" class="btn btn-info btn-block btn-flat"> Wyloguj </button>
         </div> <br>
        </form>
LOGOUT;
    if (isset($_GET['number'])) {
      require_once '../scripts/connect.php';
      $sql = "SELECT orders.*, cities.city FROM `orders` JOIN `cities` ON cities.id = orders.city_id WHERE `number` = $_GET[number]";
      $result = $mysqli->query($sql);
      $order = $result->fetch_assoc();
      $status_string = "";
      switch($order['status']) {
        case 0:
          $status_string = "Czeka na akceptację";
          break;
        case 1:
          $status_string = "Zaakceptowane";
          break;
        case 2:
          $status_string = "Odrzucone";
          break;
      }
      echo <<< INFO
      <div class="col-md-3">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Numer: $order[number]</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <h5>Status: $status_string</h5><br>
              <h5>Zamawiający: $order[name] $order[surname]</h5><br> 
              <h5>Adres: $order[zipcode] $order[city]</h5><br>
              <h5>$order[street] $order[building]</h5><br>
              <h5>Wartość zamówienia: $order[final_price] zł</h5><br>
              <h5>Utworzono: $order[created_at]</h5><br>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
       
        <table class="table table-striped">
          <tr>
            <th>Nazwa</th>
            <th>Ilość</th>
            <th>Cena jednostkowa</th>
            <th>Cena końcowa</th>
          </tr>
INFO;
      $products = json_decode($order['products'], false);
      foreach ($products as $product) {
        $sql = "SELECT name, price FROM `products` WHERE id = $product->product_id";
        $result = $mysqli->query($sql);
        $product_data = $result->fetch_assoc();
        $final_price = intval($product->quantity) * intval($product_data['price']);
        echo <<<INFO
        <tr>
          <td>$product_data[name]</td>
          <td>$product->quantity</td>
          <td>$product_data[price]</td>
          <td>$final_price</td>
        </tr>
INFO;
      }
      echo "</table>";
    }
    echo "<div class='d-inline-flex p-2'>";
    if (isset($_SESSION['user_role'])) {
      if($_SESSION['user_role'] == 'superuser') {
        echo <<< ACCEPT
        <form class="p-2" action="../scripts/accept-order.php" method="post">
          <input type="text" value="accept" hidden="true" name="decision" />
          <input type="text" value="$_GET[number]" hidden="true" name="number" />
          <div>
          <button type="submit" class="btn btn-info btn-block btn-flat"> Zaakceptuj </button>
           </div> 
        </form>
ACCEPT;
        echo <<< REJECT
        <form class="p-2" action="../scripts/accept-order.php" method="post">
          <input type="text" value="reject" hidden="true" name="decision" />
          <input type="text" value="$_GET[number]" hidden="true" name="number" />
          <div>
          <button type="submit" class="btn btn-info btn-block btn-flat">Odrzuć </button>
           </div>
        </form>
        </div>
REJECT;
      }
    }
  ?>
  <?php endif ?>
</div>
<!-- jQuery -->
<script src="./AdminLTE/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./AdminLTE/dist/js/adminlte.min.js"></script>
</body>
</html>
