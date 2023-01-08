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
    ?>
    <div class="col-md-4">
    <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Zamów</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
    <form action="../scripts/new-order.php" method="post">
        <input type="text" class="form-control" name="name" placeholder="Imię"> <br>
        <input type="text" class="form-control" name="surname" placeholder="Nazwisko"> <br>
        <input type="text" class="form-control" name="zipcode" placeholder="Kod pocztowy"> <br>

        <?php
          require_once '../scripts/connect.php';
          $sql = "SELECT * FROM `cities`";
          $result = $mysqli->query($sql);
          $city = $result->fetch_assoc();
        ?> 
          
        <div>
          <select name="city_id" style="width: 100%;" data-select2-id="9" tabindex="-1" aria-hidden="true">
            <?php
              while ($city = $result->fetch_assoc()) {
                echo "<option value=\"$city[id]\">$city[city]</option>";
                
              }
            ?>
          </select>
        </div>
        <br>
        <input type="text" class="form-control" name="street" placeholder="Ulica"> <br>
        <input type="text" class="form-control" name="building" placeholder="Budynek/Mieszkanie"> <br>
        <textarea style="resize:none;" class="form-control" rows="3" name="comment" placeholder="Dodaj komentarz..."></textarea>
        <br>
        <div >
          <div >
            <div >
              <input type="checkbox" id="agreeTerms" name="agreeTerms" value="agree">
              <label for="agreeTerms">
              <h5> Zatwierdzam <a href="#">regulamin</a> </h5>
              </label>
            </div>
          </div>

          <!-- /.col -->
            <h5><button type="submit" class="btn btn-block btn-outline-info">Zamów</a></h5>
          <!-- /.col -->
        </div>
      </form>
      </div>
      </div>
      </div>
      <table class="table table-striped">
        <tr>
          <th>Produkt</th>
          <th>Ilość</th>
          <th>Cena za sztukę</th>
          <th>Cena całkowita</th>
        </tr>
    <?php
      if(isset($_SESSION['cart'])) {
        require_once '../scripts/connect.php';
        $cart_value = 0;
        foreach($_SESSION['cart'] as $key => $value) {
          $sql = "SELECT name, price FROM `products` WHERE id = $key";
          $result = $mysqli->query($sql);
          $product = $result->fetch_assoc();
          $final_price = intval($value) * intval($product['price']);
          $cart_value += $final_price;
          echo <<< INFO
          <tr>
            <td>$product[name]</td>
            <td>$value</td>
            <td>$product[price] zł</td>
            <td>$final_price zł</td>
          </tr>
INFO;
        }
        $_SESSION['cart_value'] = $cart_value;
        echo "<h5>Cena końcowa: $_SESSION[cart_value] zł</h5>";
      }
    ?>
    </table>
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
