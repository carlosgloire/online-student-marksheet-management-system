<?php
$error = null;
$success = null;
$mysqli = require(__DIR__ . "/database.php");

if (isset($_POST['send'])) {
    if (isset($_POST['message']) && isset($_POST['subject'])) {
        $message = nl2br(htmlspecialchars($_POST['message']));
        $subject = htmlspecialchars($_POST['subject']);

        // Fetch all form teachers' emails
        $query = $mysqli->prepare("SELECT email FROM form_tutors");
        $query->execute();
        $result = $query->get_result();
        $teachers = $result->fetch_all(MYSQLI_ASSOC);
   
        if (!$teachers) {
            $error = "No form teachers found. Please try again.";
        } 
        elseif(empty($subject) || empty($message)){
            $error = "Please complete all the fields.";
        }else {
            $mail = require __DIR__ . "/mailer.php";
            $mail->setFrom("noreply@example.com",'STUDENT MARKSHEET MANAGEMENT SYSTEM');            $mail->Subject = $subject;
            $mail->CharSet = 'UTF-8'; // Set charset to UTF-8

            // Create the email body with the message from the textarea
            $email_body = <<<END
            <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f5f5f5;
                        padding: 20px;
                    }
                    .container {
                        background-color: #fff;
                        padding: 30px;
                        border-radius: 8px;
                        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                        white-space: pre-wrap; /* Preserve white space and line breaks */
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <p>$message</p>
                </div>
            </body>
            </html>
            END;

            $mail->Body = $email_body;
            $mail->isHTML(true);

            $errors = [];
            foreach ($teachers as $teacher) {
                $mail->clearAllRecipients();
                $mail->addAddress($teacher['email']);

                try {
                    $mail->send();
                } catch (Exception $e) {
                    $errors[] = "Message could not be sent to {$teacher['email']}. Mailer error: {$mail->ErrorInfo}";
                }
            }

            if (empty($errors)) {
                $success = "Message sent to all form teachers.";
            } else {
                $error = implode("<br>", $errors);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../asset/style.css">
    <link rel="stylesheet" href="../asset/responsive.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcement</title>
</head>

<body>
    <section class="connect-section">
        <div class="connect">
            <h3>Announcement</h3>
            <form action="" method="post">
                <div class="input-content">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                    <div class="all-inputs">
                        <label for="">Subject</label>
                        <input type="text" name="subject" placeholder="Enter the subject here">
                    </div>
                    <div class="all-inputs">
                        <textarea name="message" placeholder="Enter your message here" style="width: 100%; border:none"></textarea>
                    </div>
                </div>
                <div class="btn">
                    <button type="submit" name="send">Send</button>
                </div>
                <p class="error"><?= $error?></p><p class="success"><?= $success ?></p>
            </form>
        </div>
    </section>
</body>
</html>
