<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
require_once('PHPMailer/Exception.php');
require_once('PHPMailer/OAuth.php');
require_once('PHPMailer/PHPMailer.php');
require_once('PHPMailer/SMTP.php');
require_once('PHPMailer/POP3.php');

$welcome_msg = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
   
</head>
<body style="background-color: #E5E5E5; font-family: Arial;color: #3C3C3C;margin:0;padding: 0;">
    <div style="background-color: #E5E5E5; ">     
            <table style="width:100%;border-collapse:collapse;" bgcolor="#E5E5E5" cellpadding="0" cellspacing="0" border="0">
                <tbody>
                    <tr>
                        <td>
                            <table style="background-color:#ffffff;width:600px;border-collapse:collapse;margin:30px auto;border-radius: 20px;" cellpadding="0" align="center" cellspacing="0" border="0">
                                <tbody>
                                    <tr>
                                        <td style="padding: 30px;">
                                            <img src="https://i.imgur.com/bzXtueL.jpeg" alt="" style="width: 126px; float: right;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="https://i.imgur.com/c1nMk2C.png" alt="" style="margin: 0 auto;display: block;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 47px 30px 0px; ">
                                            <p style="font-size: 16px; line-height: 20px; margin: 0;">Dear [USER_NAME],</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 20px 30px 30px; ">
                                            <p style="font-size: 16px; line-height: 20px; margin: 0;">Thank you for submitting your request. We have received the details and your request is now in our system.</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0 30px 30px; ">
                                            <table style="width:600px;border-collapse:collapse;margin: 0 auto;">
                                                <tbody>
                                                    <tr style="background: #F5F5F5;">
                                                        <td colspan="2" style="padding: 6px 12px;font-size: 16px; line-height: 18px; ">
                                                            Request Details:
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 12px 0 0 0;font-size: 16px; line-height: 18px; ">Request ID: [REQUEST_ID]</td>
                                                        <td style="padding: 12px 0 0 0;font-size: 16px; line-height: 18px; ">Submitted on: [SUBMISSION_DATE]</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0px 30px 15px; ">
                                            <p style="font-size: 16px; line-height: 20px; margin: 0;">Our team will review it and provide an update soon. If you have any questions, feel free to reply to this email.</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0px 30px 30px; ">
                                            <p style="font-size: 16px; line-height: 20px; margin: 0;">Best regards,</p>
                                            <p style="font-size: 16px; line-height: 20px; margin: 0;">Team Design & Comms</p>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot style="background: #F5F5F5; border-radius: 0 0 20px 20px; display: table;">
                                    <tr>
                                        <td style="padding: 30px 30px 15px;">
                                            <p style="font-size: 16px; line-height: 20px; margin: 0;">This email is sent from the Request Management Tool (Secure Design & Comms). It is system-generated. If you reply to this email, please do not change the subject line.</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0px 30px 30px;">
                                            <p style="font-size: 16px; line-height: 20px; margin: 0;">Copyright © 2025 Secure Meters Ltd.</p>
                                            <p style="font-size: 16px; line-height: 20px; margin: 0;">All rights reserved.</p>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>

    </div>
    
</body>
</html>';

// Create a new PHPMailer instance
$mail = new PHPMailer();

try {
    // Enable SMTP debugging (disable for production)
    $mail->SMTPDebug = false; // Set to 2 for detailed debugging info

    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Email credentials
    $mail->Username = 'marketing@thinquilab.com';
    $mail->Password = 'uykrmerqthzfmaxk'; // Use environment variables for security

    // Email details
    $mail->setFrom('marketing@thinquilab.com', 'ThinquiLab');
    $mail->Subject = 'API Limit';
    $mail->Body = $welcome_msg;
    $mail->addAddress('Rahul.Dungawat@securemeters.com');
    $mail->isHTML(true);

    // Send email
    if ($mail->send()) {
        echo 'Email sent successfully.';
    } else {
        echo 'Email sending failed: ' . $mail->ErrorInfo;
    }
} catch (Exception $e) {
    echo 'An error occurred: ' . $e->getMessage();
}
?>
