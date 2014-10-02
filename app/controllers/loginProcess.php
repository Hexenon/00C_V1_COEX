<?php

     
    sec_session_start(); 
         
    if (isset($_POST['email'], $_POST['p'])) {
        $email = $_POST['email'];
        $password = $_POST['p']; // The hashed password.
     
        if (login($email, $password, $mysqli) == true) {
            // Login success 
            header(BASE_URL . 'ControlPanel.php');
        } else {
            // Login failed 
            header(BASE_URL . '?error=1');
        }
    } else {
        // The correct POST variables were not sent to this page. 
        echo 'Invalid Request';
    }

?>