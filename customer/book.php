<?php
session_start();
include_once "../php/inc/user-connection.php";


$id = $_GET['hotelID'];
$date = $_GET['bookingDate'];
$dateRange = explode(" to", $_GET['bookingDate']);
$start = trim($dateRange[0]);
$end = trim($dateRange[1]);
$numRooms = $_GET['rooms'];
$roomType = $_GET['type'];
$email = $_SESSION['email'];
$name = $_SESSION['name'];

// gets number of rooms for each room type
$query = "SELECT * from hotel where hotelID = $id";
$result = mysqli_query($conn, $query);
$records = mysqli_fetch_assoc($result);

 // gets reservation ID
 $reservationQuery = mysqli_query($conn, "SELECT ReservationID from reservation where hotelID = $id;");
 $reservation = mysqli_fetch_assoc($reservationQuery);

if (isset($_GET['book'])) {
    if ($roomType == 'standard' && !empty($date)) {

        // if room avaliable
        if ($numRooms <= $records['numStandard']) {
            $subtotal = ($numRooms * $records['priceStandard']);
            $tax = $subtotal * .0825;
            $price = ($numRooms * $records['priceStandard']) * 1.0825;


            // $update = "UPDATE hotel set numStandard = $records[numStandard] - $numRooms where hotelID = $id;";
            // $updateResult = mysqli_query($conn, $update);
            // $insert = "INSERT into reservation (hotelID,hotelName,roomType,email,arrivalDate,departureDate,totalPrice,numRoom) 
            // values ('$id','$records[hotelName]','$roomType','$email','$start','$end','$price','$numRooms');";
            // $insertResult = mysqli_query($conn, $insert);

            // if (!$insertResult || !$updateResult) {
            //     $_SESSION['alert'] = "alert alert-danger alert-dismissible fade show";
            //     $_SESSION['message'] = "Error: " . mysqli_error($conn);
            //     header("location: room-details.php?" . $_SERVER['QUERY_STRING']);
            //     exit();
            // }
            // if no error, send to confirmation page to confirm before booking
            $_SESSION['alert'] = "alert alert-success alert-dismissible fade show";
            $_SESSION['message'] = "Confirm your reservation below. ";
            header("location: invoice.php?name=$name&email=$email&hotelName=$records[hotelName]&reservationID=$reservation[ReservationID]&subtotal=$subtotal&total=$price&roomPrice=$records[priceStandard]&tax=$tax&" . $_SERVER['QUERY_STRING']);
            exit();
        } else {
            $_SESSION['alert'] = "alert alert-danger alert-dismissible fade show";
            $_SESSION['message'] = "Error: The Room you are trying to book is full";
            header("location: room-details.php?" . $_SERVER['QUERY_STRING']);
            exit();
        }
    } else if ($roomType == 'queen' && !empty($date)) {
        // if room avaliable
        if ($numRooms <= $records['numQueen']) {
            $subtotal = ($numRooms * $records['priceQueen']);
            $tax = $subtotal * .0825;
            $price = ($numRooms * $records['priceQueen']) * 1.0825;

            // $update = "UPDATE hotel set numQueen = $records[numQueen] - $numRooms where hotelID = $id;";
            // $updateResult = mysqli_query($conn, $update);
            // $insert = "INSERT into reservation (hotelID,hotelName,roomType,email,arrivalDate,departureDate,totalPrice,numRoom) 
            //             values ('$id','$records[hotelName]','$roomType','$email','$start','$end','$price','$numRooms');";

            // $insertResult = mysqli_query($conn, $insert);

            // if (!$insertResult || !$updateResult) {
            //     $_SESSION['alert'] = "alert alert-danger alert-dismissible fade show";
            //     $_SESSION['message'] = "Error: " . mysqli_error($conn);
            //     header("location: room-details.php?" . $_SERVER['QUERY_STRING']);
            //     exit();
            // }

            $_SESSION['alert'] = "alert alert-success alert-dismissible fade show";
            $_SESSION['message'] = "Confirm your reservation below. ";
            header("location: invoice.php?name=$name&email=$email&hotelName=$records[hotelName]&reservationID=$reservation[ReservationID]&subtotal=$subtotal&total=$price&roomPrice=$records[priceQueen]&tax=$tax&" . $_SERVER['QUERY_STRING']);
            exit();
        } else {
            $_SESSION['alert'] = "alert alert-danger alert-dismissible fade show";
            $_SESSION['message'] = "Error: The Room you are trying to book is full";
            header("location: room-details.php?" . $_SERVER['QUERY_STRING']);
            exit();
        }
    } else if ($roomType == 'king' && !empty($date)) {
        if ($numRooms <= $records['numKing']) {
            $update = "UPDATE hotel set numKing = $records[numKing] - $numRooms where hotelID = $id;";
            $updateResult = mysqli_query($conn, $update);
            $price = ($numRooms * $records['priceKing']) * 1.0825;
            $insert = "INSERT into reservation (hotelID,hotelName,roomType,email,arrivalDate,departureDate,totalPrice,numRoom) 
                        values ('$id','$records[hotelName]','$roomType','$email','$start','$end','$price','$numRooms');";

            $insertResult = mysqli_query($conn, $insert);

            if (!$insertResult || !$updateResult) {
                $_SESSION['alert'] = "alert alert-danger alert-dismissible fade show";
                $_SESSION['message'] = "Error: " . mysqli_error($conn);
                header("location: room-details.php?" . $_SERVER['QUERY_STRING']);
                exit();
            }

            $_SESSION['alert'] = "alert alert-success alert-dismissible fade show";
            $_SESSION['message'] = "Successfully booked your reservation from " . $start .  " to " . $end;
            header("location: room-details.php?" . $_SERVER['QUERY_STRING']);
            exit();
        } else {
            $_SESSION['alert'] = "alert alert-danger alert-dismissible fade show";
            $_SESSION['message'] = "Error: The Room you are trying to book is full";
            header("location: room-details.php?" . $_SERVER['QUERY_STRING']);
            exit();
        }
    } else {
        $_SESSION['alert'] = "alert alert-danger alert-dismissible fade show";
        $_SESSION['message'] = "Error: Enter valid dates.";
        header("location: room-details.php?" . $_SERVER['QUERY_STRING']);
        exit();
    }
}
