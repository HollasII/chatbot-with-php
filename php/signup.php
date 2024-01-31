<?php
    session_start();
    include_once "config.php";
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){
        //user email valid
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {//if email is valid

            //if email already exists
            $sql = mysqli_query($conn, "SELECT email FROM users WHERE email = '{$email}'");
            if (mysqli_num_rows($sql) > 0) {
                echo "$email - This email already exists!";
            }else {
                //check if file is uploaded
                if(isset($_FILES['file'])){
                    $img_name = $_FILES['image']['name'];//getting uploaded image
                    $img_name = $_FILES['image']['type'];//getting uploaded image type
                    $tmp_name = $_FILES['image']['tmp_name'];//temp name used to save/move files in folder

                    //explode image and get file extension
                    $img_explode = explode('.', $img_name);
                    $img_ext = end($img_explode); //file extension

                    $extensions = ['png', 'jpeg', 'jpg'];
                    if (in_array($img_ext, $extensions) === true) {
                        $time = time();//store current time of file being saved

                        $new_img_name = $time.$img_name;
                        if (move_uploaded_file($tmp_name, "images/".$new_img_name)) {
                            $status = "Active now"; //once user signs up, status becomes active
                            $random_id = rand(time(), 10000000); //random id for user

                            //insert all user data inside table
                            $sql2 = mysqli_query($conn, "INSERT INTO users (unique_id,fname,lname,email,password,img,status)
                                                VALUES ({$random_id},'{fname}',	'{lname}',	'{email}',	'{password}', '{$new_img_name}', '{$status}')");
                            if ($sql2) {// if these data inserted
                                $sql3 = mysqli_query($conn, "SELECT * FROM users WHERE email ='{$email}'");
                                if (mysqli_num_rows($sql3)>0) {
                                    $row = mysqli_fetch_assoc($sql3);
                                    $_SESSION['unique_id'] = $row['unique_id']; //
                                    echo "SUCCESS";
                                } else {
                                    echo "stuff";
                                }
                                
                            }else {
                                echo "Somethig went wrong";
                            }
                        }
                        
                    }else {
                        echo "Please select an image file - jpeg, jpg, png!";
                    }
                }else {
                    echo "Please select an image";
                }
            }
        }else {
            echo "$email - This is not a valid email!";
        }
    }else{
        echo "All input fields are required!!";
    }
?>