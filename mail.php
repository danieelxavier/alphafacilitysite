<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';


    // validation expected data exists
    if(!isset($_POST['name']) ||
        !isset($_POST['email']) ||
        !isset($_POST['subject']) ||
        !isset($_POST['message'])) {
        // died(json_encode(array('status'=>"error", 'message'=>"We are sorry, but there appears to be a problem with the form you submitted.")));      
            var_dump(http_response_code(422));
        echo json_encode(array('status'=>'error', 'message'=>'We are sorry, but there appears to be a problem with the form you submitted.'));
        exit(0);

    }
    else{
        $name = $_POST['name']; // required
        $email = $_POST['email']; // required
        $subject = $_POST['subject']; // required
        $message = $_POST['message']; // required


        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->CharSet = 'UTF-8';
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'makersitesdcx@gmail.com';                 // SMTP username
            $mail->Password = 'makersites@2019';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom($email, $name);
             $mail->addAddress('shipping.mao@alphafacilitygroup.com', 'Alpha Facility');     // Add a recipient
             $mail->addAddress('operational.manager@alphafacilitygroup.com', 'Alpha Facility');     // Add a recipient
            $mail->addReplyTo($email, $name);
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            $email_title = $subject;

            $email_message = "CONTATO FEITO PELO SITE<br><br>";
            $email_message .= "Responder para: ".$email." <br><br>";
            $email_message .= $message;

            $name = ""; // required
            $email = ""; // required
            $subject = ""; // required
            $message = ""; // required

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $email_title;
            $mail->Body    = $email_message;
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


            //send the message, check for errors
            if (!$mail->send()) { 
                $result = array('status'=>"error", 'message'=>"Mailer Error: ".$mail->ErrorInfo);//
                echo json_encode($result);
            } else {
                $result = array('status'=>"success", 'message'=>"Message sent jotinha.");
                echo json_encode($result);
            }

        } catch (Exception $e) {

            var_dump(http_response_code(422));
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }

    }

?>