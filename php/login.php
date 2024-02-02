<?php
    session_start();
    include_once "config.php";
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    if (!empty($email) && !empty($password)) {
        //match entered email and password to database files
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}' AND password = '{$password}'");
        if (mysqli_num_rows($sql)>0) {//if credentials match
            $row = mysqli_fetch_assoc($sql);
            $status = "Active now";

            //updating user status
            $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}");
            if ($sql2) {
                $_SESSION['unique_id'] = $row['unique_id'];
                echo "SUCCESS";
            }
        } else {
            echo "Email or password is incorrect!";
        }
        
    } else {
        echo "All input fields required!!";
    }
    
?>