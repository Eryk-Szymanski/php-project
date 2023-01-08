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
  <?php
    if (isset($_SESSION['success'])) {
      echo <<< LOGOUT
      <form action="../scripts/logout.php" method="post">
      <div class="col-md-1">
      <button type="submit" class="btn btn-info btn-block btn-flat"> Wyloguj </button>
       </div> <br>
      </form>
LOGOUT;
      echo "<h2><p>Witaj, $_SESSION[user_name]</p></h2>";
      require_once '../scripts/connect.php';
      if ($_SESSION['user_role'] == 'user') {
        $sql = "SELECT orders.number FROM `orders` WHERE `user_id` = $_SESSION[user_id] ORDER BY created_at desc";
        $result = $mysqli->query($sql);
        echo <<< USER
        <div class="col-md-2">
        <h5><a href="./products.php"><button type="button" class="btn btn-block btn-outline-info">Wszystkie produkty</button></a></h5>
        </div>
        <h2>Twoje zamówienia</h2>
USER;
        while ($order = $result->fetch_assoc()) {
          echo "<div class='callout callout-info col-md-2'><a  href='./order-details.php?number=$order[number]'>$order[number]</a></div>";
        }
      }
      elseif ($_SESSION['user_role'] == 'superuser') {
        $sql = "SELECT orders.number FROM `orders` WHERE `status` = 0";
        $result = $mysqli->query($sql);
        echo <<< SUPERUSER
        <div class="col-md-2">
        <h5><a href="./products.php"><button type="button" class="btn btn-block btn-outline-info">Wszystkie produkty</button></a></h5>
        </div>
        <div class="col-md-4">
        <div class="info-box">
          <span class="info-box-icon bg-info"><i class="far fa-bell"></i></span>

          <div class="info-box-content">
            <span class="info-box-text"><h3>Zamówienia do zaakceptowania</h3></span>       
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
        
SUPERUSER;

        while ($order = $result->fetch_assoc()) {
          echo "<div class='callout callout-info col-md-2'><a href='./order-details.php?number=$order[number]'>$order[number]</a></div>";
        }

        $sql = "SELECT orders.number FROM `orders` WHERE `status` = 1";
        $result = $mysqli->query($sql);  
        echo <<< SUPERUSER

        <div class="col-md-4">
        <div class="info-box">
          <span class="info-box-icon bg-success"><i class="far fa-check-circle"></i></span>
          <div class="info-box-content">
            <span class="info-box-text"><h3>Zamówienia zaakceptowane</h3></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>

SUPERUSER;
        
        while ($order = $result->fetch_assoc()) {
          echo "<div class='callout callout-info col-md-2'><a href='./order-details.php?number=$order[number]'>$order[number]</a></div>";
        }

        $sql = "SELECT orders.number FROM `orders` WHERE `status` = 2";
        $result = $mysqli->query($sql);  
        echo <<< SUPERUSER
        <div class="col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-danger"><i class="fas fa-backspace"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><h3>Zamówienia odrzucone</h3></span>                
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>

SUPERUSER;
        while ($order = $result->fetch_assoc()) {
          echo "<div class='callout callout-info col-md-2'><a href='./order-details.php?number=$order[number]'>$order[number]</a></div>";
        }
      }
      elseif ($_SESSION['user_role'] == 'admin') {
        $sql = "SELECT users.id, users.name, users.surname, roles.role FROM `users` JOIN `roles` ON users.role_id = roles.id";
        $result = $mysqli->query($sql);
        echo <<< ADMIN
        <div class="col-md-2">
        <h5><a href="./products.php"><button type="button" class="btn btn-block btn-outline-info">Wszystkie produkty</button></a></h5>
        </div>
        <h3>Użytkownicy</h3>
        <table class="table table-striped">
          <tr>
            <th>Id</th>
            <th>Imię</th>
            <th>Nazwisko</th>
            <th>Rola</th>
          </tr>
ADMIN;
        while ($user = $result->fetch_assoc()) {
          echo <<< USERSADMIN
          <tr>
            <td>$user[id]</td>
            <td>$user[name]</td>
            <td>$user[surname]</td>
            <td>$user[role]</td>
          </tr>
USERSADMIN;
        }
        echo "</table>";
      }
    }
  ?>

<!-- jQuery -->
<script src="../AdminLTE/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../AdminLTE/dist/js/adminlte.min.js"></script>
</body>
</html>
