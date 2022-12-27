<?php

    session_start();

    $error = 0;
    foreach ($_POST as $key => $value) {
        if (empty($value)) {
            $error = 1;
        }
    }

    if($error == 1) {
        $_SESSION['error'] = "Wypełnij wszystkie pola";
        echo "<script>history.back();</script>";
        exit();
    }

    require_once 'connect.php';
    
    try {
        $stmt = $mysqli->prepare("SELECT * FROM `users` WHERE `email` = ?");
        $stmt->bind_param("s", $_POST['email']);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($stmt->affected_rows == 1 && password_verify($_POST['pass'], $user['pass'])) {
            $_SESSION['success'] = "Prawidłowo zalogował się użytkownik $_POST[email]";
            header('location: ../views/logged.php');
            exit();
        } else {
            $_SESSION['success'] = "Nie zalogowałeś się na użytkownika $_POST[email]";
        }

    } catch (Exception $e) {
        echo $e->getMessage();
        if($stmt->affected_rows != 1) {
            $_SESSION['error'] = "Nie zalogowałeś się na użytkownika $_POST[email]";
        }
    }

    header('location: ../');
?>