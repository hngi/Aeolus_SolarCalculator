<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// autoload
require_once __DIR__ . '/vendor/autoload.php';

// extract POST array keys
extract($_POST);

$rand = bin2hex(openssl_random_pseudo_bytes(5));

$mail = new PHPMailer(true);

$mail_message = <<<EDO
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "https://www.w3.org/TR/html4/strict.dtd">
<html lang="en-GB">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <!-- <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet'>     -->
    <style type="text/css">
        * { font-size: 16px; font-family: Roboto, Open Sans, "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; line-height: 1.65; color:#333 }
        img { max-width: 100%; margin: 0 auto; display: block; border: 0; }

        body, .mailcontent {height: 100%; background: #e6e6e6; }
    </style>
</head>
<body>
        
    <table class="mailcontent" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
        <tbody>
            <tr>
                <td style="vertical-align:top;padding:75px 5px" valign="top" align="center">
                    <table style="border-collapse:collapse;border-top-left-radius:5px;border-top-right-radius:5px;" width="600px" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="white">
                        <tbody>
                            <tr style="border-top-left-radius:5px;border-top-right-radius:5px;border-top:solid #0099FF 5px;text-align:left;padding:0">
                                <td style="padding:30px 0">
                                    <div>
                                        <center>
                                            <img src="https://hngsolar.herokuapp.com/assets/S.png" style="border:0;line-height:100%;outline:none;text-decoration:none;display:block;height:100px;max-width:100%;width:auto;margin:0 auto;float:none;text-align:center;padding-top:24px" vspace="0" hspace="0" height="100" border="0">
                                        </center>
                                    </div>
                                    <div style="padding:1.5em">
                                        <br>
                                        <p>Dear $name,</p>
                                        <p>Thank you for using the Solar Calculator from HNG Solarizr Inc, below is your last calculation.</p>
                                        <p><strong style="font-weight:700">Your Load Calculation result:</strong></p>

                                        <!-- Calculated data table -->
                                        <table style="border-collapse:collapse" border="1" width="100%" cellpadding="10">
                                            <thead>
                                                <tr>
                                                    <th style="font-family:'Open Sans','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:13px">Appliance</th>
                                                    <th style="font-family:'Open Sans','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:13px">Quantity</th>
                                                    <th style="font-family:'Open Sans','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:13px">Watts</th>
                                                    <th style="font-family:'Open Sans','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:13px">Hours On/Day</th>
                                                    <th style="font-family:'Open Sans','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:13px">Watt Hours/Day</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                $message
                                            </tbody>
                                        </table>

                                        <br>
                                        <div style="font-size:14px">
                                            <b style="font-weight:700; font-size:14px">Total Watt-Hours/Day:</b> $wattage
                                        </div>
                                        <br>
                                        <p style="margin-top:0;margin-bottom:10px">Please contact us at 07017743362 for more clarity.</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
EDO;

header('Content-Type: application/json');

try {
    $mail->isSMTP();
    $mail->Host = '';  
    $mail->SMTPAuth = true;
    $mail->Username = '';   
    $mail->Password = '';   
    $mail->SMTPSecure = '';
    $mail->Port = 465;                    
  
    $mail->setFrom('admin@sure.ng', 'Andikan Gabriel (Slack - @andy)');
    $mail->addAddress($to, $name);
 
    $mail->isHTML(true);
    $mail->Subject = 'Solar Calculations From HNG Solarizr App Inc.';
    $mail->Body    = $mail_message;
 
    $mail->send();
    
    $data = ['result' => true, 'status' => 'sent', 'message' => 'Email has been sent', 'request_id' => $rand];
    
    echo json_encode($data);

} catch (Exception $e) {
    $data = ['result' => false, 'status' => 'failed', 'message' => 'Email could not be sent', 'request_id' => $rand, 'error' => $e->getMessage()];

    echo json_encode($data);
}
