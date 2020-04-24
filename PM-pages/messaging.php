<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="../PM-css/styles.css">
  <link rel="stylesheet" type="text/css" href="../PM-css/home-style.css">
  <link rel="stylesheet" type="text/css" href="../PM-css/messaging-style.css">

  <!-- javascript functions for page -->
  <script type="text/javascript" src="../PM-script/personnel_script.js"></script>
  <script src="../PM-script/logout.js"></script>

  <title>Personnel Management</title>

</head>

<body>
  <?php require '../PM-extras/db_utils.php';
  $link = create_connection();
  if (!check_session()) header("location: login.php");

  // Import PHPMailer classes into the global namespace
  // These must be at the top of your script, not inside a function
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require '../PHPMailer-Master/src/Exception.php';
  require '../PHPMailer-Master/src/PHPMailer.php';
  require '../PHPMailer-Master/src/SMTP.php';
  ?>

  <!-- HTML for nav links and logo -->
  <div class="page_container">
    <div class="nav_bar">
      <div class="nav_logo">
        <h2>AdminMax</h2>
      </div>
      <div class="nav_stack">
        <div class="nav_links">
          <div class="n_link">
            <button class="nav_button nav_button_others" onclick="window.location.href = '../index.php';">Home</button>
          </div>
          <div class="n_link">
            <button class="nav_button nav_button_others" onclick="window.location.href = '../PM-pages/personnel.php';">Personnel</button>
          </div>
          <div class="n_link">
            <button class="nav_button nav_button_others" onclick="window.location.href = '../PM-pages/events.php';">Events</button>
          </div>
          <div class="n_link">
            <button class="nav_button nav_button_others" onclick="window.location.href = '../PM-pages/messaging.php';">Messaging</button>
          </div>
        </div>
      </div>
      <?php if (check_session()) { ?>
                <button class="nav_button nav_button_others log_button" onclick="logout()">Log Out</button>
            <?php } else { ?>
                <button class="nav_button nav_button_others log_button" onclick="window.location.href = '../PM-pages/login.php';">Log In</button>
            <?php } ?>
    </div>

    <div class="home_body message_bg">
      <!-- Page content goes here -->
      <div class="messaging_wrapper">
        <form method="post">

          <input type="text" name="msg_from" placeholder="From" class="message_input" style="width: 400px;" <?php echo "value='".get_email($link, $_SESSION['id'])."'" ?>/><br>
          <input type="text" name="msg_to" placeholder="To" class="message_input" style="width: 400px;" />
          <input type="text" name="msg_sbj" placeholder="Subject" class="message_input msg_wide" />

          <div id="msg_text" contenteditable="true" class="message_input msg_wide msg_cont">



          </div>
          <input type="submit" name="msg_send" value="Send" class="nav_button" style="margin-left: 0;" />
        </form>

        <?php
        if (array_key_exists('msg_send', $_POST)) {
          // Instantiation and passing `true` enables exceptions
          $mail = new PHPMailer(true);

          try {
            //Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'cwhita11@vols.utk.edu';                     // SMTP username
            $mail->Password   = 'PrideDrums150';                               // SMTP password
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('cwhita11@vols.utk.edu', 'utk');
            $mail->addAddress('alexw37743@gmail.com', 'Alex Whitaker');     // Add a recipient
            $mail->addReplyTo('info@example.com', 'Information');
            // Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
          } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
          }
        }
        ?>


      </div>
    </div>


    <div class="footer">
      <nav>
        <a class='footer_link' href="../index.php">Home</a> |
        <a class='footer_link' href="../PM-pages/personnel.php">Personnel</a> |
        <a class='footer_link' href="../PM-pages/events.php">Events</a> |
        <a class='footer_link' href="../PM-pages/messaging.php">Messaging</a>
      </nav>
      <p class="footer_note">Devs: Alex Whitaker, Cainan Howard, Sammy Awad, Timothy Krenz</p>
    </div>

</body>

</html>