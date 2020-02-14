﻿<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../PM-css/styles.css">
    <title>Messaging</title> 


    <meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
 * {box-sizing: border-box;}

input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-top: 6px;
  margin-bottom: 16px;
  resize: vertical;
}

input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
</style>
</head>





<body>

    <!-- Nav-bar links -->
    <ul>
        <li><a href="../index.php">Home</a></li>
        <li><a href="personnel.php">Personnel</a></li>
        <li><a href="events.php">Events</a></li>
        <li><a class="active" href="messaging.php">Messaging</a></li>
    </ul>

    <h3>Compose Message</h3>
    
    <div class="container">
        <form action="/action_page.php">
            <label for="fname">First Name</label>
            <input type="text" id="fname" name="firstname" placeholder="Your name..">

            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="lastname" placeholder="Your last name..">

   

            <label for="subject">Subject</label>
            <textarea id="subject" name="subject" placeholder="Write something.." style="height:200px"></textarea>

            <input type="submit" value="Submit">
        </form>
    </div>






</body>
</html>