<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
  $email = "new email";
  $amount = "Undefined name";
  $select = "Undefined";
  $currencyAmount = "Undefined";


  if(isset($_POST['amount'])){
      $amount = $_POST['amount'];
  }
  if(isset($_POST['email'])){
    $email = $_POST['email'];
  }
  if(isset($_POST['select'])){
    $select = $_POST['select'];
  }
  if(isset($_POST['currencyAmount'])){
    $currencyAmount = $_POST['currencyAmount'];
}
  $mail = new PHPMailer();

  $mail->CharSet = "UTF-8";
  $contentBody = '<html>
  <body>
  <div  
  style="text-align:center;
  width: 500px;
  display:block;
  margin-left: auto; 
  margin-right: auto;">
  <h2>Email: '. $email .'</h2>
  <p>Сумма.руб: ' . $amount .'</p>
  <p>Валюта для конвертации: '. $select .'</p>
  <p>Сумма в валюте: '. $currencyAmount .'</p>
  </div>
  </body>
  </html>';

  //Sending to client
  

  //=======================

  $mail->Subject = 'Order';
  $mail->isHTML(TRUE);
  $mail->Body = $contentBody;
  $mail->isSMTP();
  $mail->Host = 'smtp.yandex.ru';
  $mail->SMTPAuth = TRUE;
  $mail->SMTPSecure = 'ssl';
  $mail->Username = 'currenCyconversion@yandex.ru'; // логин от вашей почты
  $mail->Password = 'iipalwkfwhdzbjsd'; // пароль от почтового ящика
  $mail->Port = '465';
  
  $mail->setFrom('currencyConversion@yandex.ru', $email); //Who is sending the message
  $mail->addAddress($email); //Set who the message is to be sent to
  if(!$mail->Send())
  {
      echo "Something went wrong!";
  }
  echo json_encode([]); //Sendning back an empty array






?>