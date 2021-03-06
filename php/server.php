<?php
include_once "inc/user-connection.php";

session_start();
$name = mysqli_real_escape_string($conn, $_POST['name']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$email = mysqli_real_escape_string($conn, $_POST['email']);

// sign up 
if (isset($_POST['sign-up'])) {
    if (!empty($email)) {
        if (!empty($password)) {
            $check_email = "SELECT * FROM user WHERE email=?";

            $stmt_email = $conn->prepare($check_email);
            $stmt_email->bind_param('s', $email);
            $stmt_email->execute();
            $stmt_email->store_result();

            // if email is taken
            if ($stmt_email->num_rows() > 0) {
                $_SESSION['alert'] = "alert alert-danger alert-dismissible fade show";
                $_SESSION['message'] = "ERROR: Email already taken.";
                header("location: ../html/sign-up.php");
                exit();
            }
            // if  email isn't taken, insert into database
            else {
                $sql = "INSERT INTO user (name,email,password) values (?,?,?)";

                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param('sss', $name, $email, $password);
                    $stmt->execute();
                    $stmt->store_result();
                    $_SESSION['alert'] = "alert alert-success alert-dismissible fade show";
                    $_SESSION['message'] = "Successfully created account!";
                    header("location: ../html/sign-in.php");
                    exit();
                }
            }
        }
    }
}

// admin sign up
if (isset($_POST['createAdmin'])) {
    if (!empty($email)) {
        if (!empty($password)) {
            $check_email = "SELECT * FROM admin WHERE email=?";

            $stmt_email = $conn->prepare($check_email);
            $stmt_email->bind_param('s', $email);
            $stmt_email->execute();
            $stmt_email->store_result();

            // if email is taken
            if ($stmt_email->num_rows() > 0) {
                $_SESSION['alert'] = "alert alert-danger alert-dismissible fade show";
                $_SESSION['message'] = "ERROR: Email already taken.";
                header("location: ../dashboard/employees.php");
                exit();
            }
            // if  email isn't taken, insert into database
            else {
                $sql = "INSERT INTO admin (name,email,password) values (?,?,?)";

                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param('sss', $name, $email, $password);
                    $stmt->execute();
                    $stmt->store_result();
                    $_SESSION['alert'] = "alert alert-success alert-dismissible fade show";
                    $_SESSION['message'] = "Successfully created account!";
                    header("location: ../dashboard/employees.php");
                    exit();
                }
            }
        }
    }
}

// sign in
if (isset($_POST['sign-in'])) {
    if (!empty($email) and !empty($password)) {
        $sql = 'SELECT email, password,name FROM user WHERE email = ?';

        // preparing the SQL statement will prevent SQL injection.
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('s', $_POST['email']);
            $stmt->execute();
            $stmt->store_result(); // Store the result so we can check if the account exists in the database.

            // If email exists in sign_up table
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($email, $password,$name);
                $stmt->fetch();

                // if password user enters matches the one in the database
                if (password_verify($password, $hashed_password)) {
                    $_SESSION['email'] = $email;
                    $_SESSION['name'] = $name;
                    $_SESSION['password'] = $password;
                    // upon successful login, redirect user to landing apge
                    header("location: ../customer/customer.php");
                    exit();

                // incorrect password
                } else {
                    $_SESSION['alert'] = "alert alert-danger alert-dismissible fade show";
                    $_SESSION['message'] = "ERROR: Entered wrong password - Please try again";
                    header("location: ../html/sign-in.php");
                    exit();
                }
            }

            // wrong email
            else{
                $_SESSION['alert'] = "alert alert-danger alert-dismissible fade show";
                    $_SESSION['message'] = "ERROR: Entered wrong email - Please try again";
                    header("location: ../html/sign-in.php");
                    exit();
            }
        }
    }
}
// checks admin credential
if (isset($_POST['admin-sign-in'])) {
    if (!empty($email) and !empty($password)) {
        $sql = 'SELECT email, password, name FROM admin WHERE email = ?';

        // preparing the SQL statement
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('s', $_POST['email']);
            $stmt->execute();
            $stmt->store_result(); // Store the result so we can check if the account exists in the database.

            // If email exists in sign_up table
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($email, $password, $name);
                $stmt->fetch();

                // if password user enters matches the one in the database
                if (password_verify($password, $hashed_password)) {
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;
                    $_SESSION['password'] = $password;
                    // upon successful login, redirect user to landing apge
                    header("location: ../dashboard/dashboard.php");
                    exit();
                } else {
                    $_SESSION['alert'] = "alert alert-danger alert-dismissible fade show";
                    $_SESSION['message'] = "ERROR: Entered wrong password - Please try again";
                    header("location: ../html/admin-sign-in.php");
                    exit();
                }
            } 
            // wrong email
            else{
                $_SESSION['alert'] = "alert alert-danger alert-dismissible fade show";
                $_SESSION['message'] = "ERROR: Entered wrong email - Please try again";
                header("location: ../html/admin-sign-in.php");
                exit();
            }
        }
    }
}
$stmt->close();
$conn->close();
