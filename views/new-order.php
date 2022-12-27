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
    <form action="../scripts/new-order.php" method="post">
        <input type="text"  placeholder="Imię" name="name">
        <input type="text"  placeholder="Nazwisko" name="surname">
        <input type="text"  placeholder="Kod pocztowy" name="zipcode">
        
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
        
        <input type="text"  placeholder="Ulica" name="street">
        <input type="text"  placeholder="Budynek/Mieszkanie" name="building">
        <input type="text"  placeholder="Dodaj komentarz" name="comment">

        <div >
          <div >
            <div >
              <input type="checkbox" id="agreeTerms" name="agreeTerms" value="agree">
              <label for="agreeTerms">
               Zatwierdzam <a href="#">regulamin</a>
              </label>
            </div>
          </div>

          <!-- /.col -->
          <div>
            <button type="submit">Zamów</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    <?php
        if(isset($_SESSION['cart'])) {
            foreach($_SESSION['cart'] as $key => $value) {
                echo $key;
                echo $value;
                echo "<br>";
            }
        }
    ?>
</body>
</html>
