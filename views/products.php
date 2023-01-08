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
<body class="p-2">
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
    <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3> W koszyku: 

                <?php
                 if(isset($_SESSION['cart'])) {
                  echo count($_SESSION['cart']);
                }
                ?>
                </h3>

              <a style="color:white;" href="./new-order.php"><button class="btn btn-block btn-dark ">Zamów</button></a>
              
              </div>
              <div class="icon">
                <i class="fas fa-shopping-cart"></i>
              </div>            
            </div>
          </div>
  
  <?php
   
    echo "</div>" ;
    echo "<div class='d-inline-flex flex-wrap'>";
    require_once '../scripts/connect.php';
    $sql = "SELECT * FROM `products`";
    $result = $mysqli->query($sql);
    while($product = $result->fetch_assoc()) {
      echo <<< INFO
      <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-info">
              <span class="info-box-icon"><i class="fas fa-box-open"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><h3>$product[name]</h3></span>
                <span class="info-box-number"><p>$product[price] zł</p></span>

                <form class="d-inline-flex p-2" action="../scripts/add-product.php" method="post">
                <input type="number" value="$product[id]" hidden="true" name="product_id" />
                <input class="col-md-2" type="number" value="1" name="quantity"/>
                <button class="btn btn-block btn-dark" type="submit">Dodaj do koszyka</button>
              </form>
                
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>    
      
INFO;
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
