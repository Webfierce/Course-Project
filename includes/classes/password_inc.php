<?php
// Create a random string for password
function pass($len) {
  $pwd="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$";
  $password=substr(str_shuffle($pwd),0,$len);
  return $password;
}
 //length of generated password
  $newpassword = pass(10);
  $hashedPwd = password_hash($newpassword, PASSWORD_DEFAULT);

// Send email containing the generated password

include 'PHPMailer/PHPMailerAutoload.php';
    //Server settings
    $mail = new PHPMailer;
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'no.reply.project24@gmail.com';        // SMTP username
    $mail->Password = 'W1mp13N0rman';                  // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('sharedproject24@gmail.com', 'W.Norman');
    $mail->addAddress($email);

    $body ='<html>
            <style media="screen">
              body {
                font-family: sans-serif;
                background-color: #696969;
              }

              .mailHeader {
                align-items: center;
                width: 100%;
                margin: 0;
                padding: 0;
                background-color: rgba(0,0,0);
                color: #fff;
                font-family: cursive;
                text-align: center;
                border: 2px solid #FFFF00;
                -webkit-animation: mailHeader 5s infinite; /* Safari 4.0 - 8.0 */
                animation: mailHeader 5s infinite;
              }

              /* Safari 4.0 - 8.0 */
              @-webkit-keyframes mailHeader {
                50% {border-color: #FFA500;}
              }

              @keyframes mailHeader {
                50% {border-color: #FFA500;}
              }

              .fullname {
                font-family: sans-serif;
                font-weight: bold;
              }

              .mailBody {
                margin-left: 180px;
              }

              .extra {
                margin-left: 150px;
              }

              .pwd {
                box-sizing: border-box;
                text-align: center;
                width: 100%;
                padding: 10px;
                margin-left: 33%;
                font-size: 28px;
                font-weight: bold;
                background-color: #000;
                color: #fff;
                border-radius: 5px;
                border: 2px solid #FFFF00;
                -webkit-animation: mailHeader 5s infinite; /* Safari 4.0 - 8.0 */
                animation: mailHeader 5s infinite;
              }
            </style>
            <body>
              <div>
                <h1>Thank you for joining our community <span class="fullname"><?php {$firstname}. {$lastname}.?><span></h1>
                <h3>We have provided you an account password down below</h3>
              </div>

              <h4>Thank you for creating an account to be a part of our entertainment</h4>
              <p><b>Here is the following information you provided us.</b></p>

              <div class="mailBody">
                <p>Username:<?php $username?><br>Firstname:<?php $firstname?><br>Lastname:<?php $lastname?><br>Email:<?php $email?><br>Gender:
                <?php $gen?><br>Date of Birth:<?php $birthDate?><br><h4>Your Password to your account is:</h4><br><span><?php echo $newpassword ?></span></p>
              </div>

            </body>
            </html>';

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is your Account Password';
    $mail->Body    = $newpassword;
    $mail->AltBody = strip_tags($body);
    $mail->send(header('Location: index.php?signup=success'));
