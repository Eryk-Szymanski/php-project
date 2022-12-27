<?php

    session_start();

    $error = 0;
    foreach ($_POST as $key => $value) {
        if (empty($value)) {
            $error = 1;
        }
    }

    if (!isset($_POST['agreeTerms'])) {
        $error = 1;
    }

    if($error == 1) {
        echo "<script>history.back();</script>";
        exit();
    }

    require_once 'connect.php';
    
    $testNumber = "271220222335";
    $testProducts = array(array('wood' => 1, 'product_id' => 1));
    $myJSON = json_encode($testProducts);
    try {
        $stmt = $mysqli->prepare("INSERT INTO orders(number, user_id, products, comment, name, surname, zipcode, city_id, street, building) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sisssssiss", $testNumber, $_SESSION['user_id'], $myJSON, $_POST['comment'], $_POST['name'], $_POST['surname'], $_POST['zipcode'], $_POST['city_id'], $_POST['street'], $_POST['building']);
        $stmt->execute();

        if ($stmt->affected_rows == 1) {
            echo "działa";
            $_SESSION['success'] = "Prawidłowo utworzono zamówienie nr $testNumber";
        }

    } catch (Exception $e) {
        echo $e->getMessage();
        if($stmt->affected_rows != 1) {
            $_SESSION['error'] = "Nie utworzono zamówienia";
        }
    }

    header('location: ../views/logged.php');
?>