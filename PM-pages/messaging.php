<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="../PM-css/styles.css">
  <link rel="stylesheet" type="text/css" href="../PM-css/home-style.css">
  <link rel="stylesheet" type="text/css" href="../PM-css/messaging-style.css">

  <!-- javascript functions for page -->
  <script type="text/javascript" src="../PM-script/personnel_script.js"></script>


  <title>Personnel Management</title>

</head>

<body>

  <!-- HTML for nav links and logo -->
  <div class="page_container">
    <div class="nav_bar">
      <div class="nav_stack nav_logo">
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
    </div>

    <div class="home_body message_bg">
      <!-- Page content goes here -->
      <div class="messaging_wrapper">

        <input type="text" name="msg_to" placeholder="To" class="message_input" style="width: 400px;"/>
        <input type="text" name="msg_sbj" placeholder="Subject" class="message_input msg_wide" />

        <div id="msg_text" contenteditable="true" class="message_input msg_wide msg_cont">

        </div>
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