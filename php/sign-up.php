<?php
$name = filter_input(INPUT_POST, 'name');
$password = filter_input(INPUT_POST, 'password');
$email = filter_input(INPUT_POST, 'email');
$username = filter_input(INPUT_POST, 'username');

if (!empty($email)) {
    if (!empty($password)) {

        $host = "swe-project-db.ckec3iue5fvo.us-east-2.rds.amazonaws.com";
        $dbusername = "admin";
        $dbpassword = "softwareengineering";
        $dbname = "user";

        // Create connection
        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
        if (mysqli_connect_error())
            die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());

        // insert into tables
        else {
            // checks if username or email is already taken
            $check_email = "SELECT * FROM sign_up WHERE email ='$email'";
            $validate_email = mysqli_query($conn, $check_email);

            if (mysqli_num_rows($validate_email) > 0) {
                header("location: ../html/sign-up-error.html");
            }
            // if  email isn't taken, insert into database
            else {
                $sql = "INSERT INTO sign_up (name,email,password) values ('$name','$email','$password')";

                if ($conn->query($sql))
                    echo "<script> window.location.assign('../html/dashboard.html'); </script>";
                else
                header("location: ../html/sign-up-error.html");
            }
            $conn->close();
        }
    } else {
        echo "Password should not be empty";
        die();
    }
} else {
    echo "email should not be empty";
    die();
}
