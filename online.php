<?php
include ("configue.php");
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\htdocs\abdura\PHPMailer-master/src/Exception.php';
require 'C:\xampp\htdocs\abdura\PHPMailer-master/src/PHPMailer.php';
require 'C:\xampp\htdocs\abdura\PHPMailer-master/src/SMTP.php';
//require 'vendor/autoload.php';
function verify_token($name, $Email, $verify)
{
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'abdillahmwinyikai1@gmail.com';
        $mail->Password = 'pbld sehs eabe umms';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('abdillahmwinyikai1@gmail.com');
        $mail->addAddress($Email);

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('./images/copy2.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Email verification from Maliki Online Banking.';
        $email_template = "
        <h2>You have registered with Maliki Online Banking</h2>
         <h5>Verify your email to login with the link given below</h5>
         <a href='http://localhost/abdura/verify.php?verify_token=$verify'>Click me</a>";
        $mail->Body = $email_template;
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
if (isset($_POST["submit"])) {
    $name = $_POST['fullName'];
    $Email = $_POST['email'];
    $user = $_POST['user'];
    $pswd = $_POST['password'];
    $Confirm = $_POST['confirms'];
    $verify = md5(rand());
    $duplicate = "SELECT * FROM table1 where fullName='$name' OR email='$Email'";
    $row = mysqli_query($conn, $duplicate);
    if (mysqli_num_rows($row) > 0) {
        echo "<script>alert('User name or email has already been taken');</script>";
    } else {
        if ($Confirm == $pswd) {
            echo "<script>alert('Registration successful');</script>";
            verify_token("$name", "$Email", "$verify");
            $mui = mysqli_query($conn, "INSERT INTO table1 (fullName,email,user,confirmPassword,verify_token) VALUES('$name','$Email','$user','$Confirm','$verify')");
        } else {
            echo "<script>alert('Password does not match');</script>";
        }
    }
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <title>Document</title>
</head>

<body>
    <div class="nav">
        <h1 class="fs-4" style="color:orangered;width:100%;text-align:center;margin-top:50px;">Maliki Online Banking
        </h1>
    </div>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header">
                        <h2 class="text-center">Form registration</h2>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group mb-3">
                                <label for="name" class="fs-4">Full name</label>
                                <input type="text" name="fullName" id="" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="email" class="fs-4">Email Address</label>
                                <input type="text" name="email" id="" class="form-control">
                            </div> 1 1
                            <div class="form-group mb-3">
                                <label for="user" class="fs-4">User name</label>
                                <input type="text" name="user" id="" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="password" class="fs-4">Password</label>
                                <input type="password" name="password" id="" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="confirm" class="fs-4">Confirm password</label>
                                <input type="password" name="confirms" id="" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <input type="checkbox" name="check" id="" class="fs-2" required />
                                <label for="" class="fs-5">Confirm you have agreed our terms and conditions</label>
                                <input type="file" name="" id="">
                            </div>
                            <button class="btn btn-success ms-4 mt-4" name="submit" type="submit">Open account</button>
                            <p class="mt-4 text-center fs-4">Already have an account? <a href="">Login</a></p>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>