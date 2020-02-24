<!DOCTYPE html>
<html>

<head>
    <!-- <link rel="stylesheet" type="text/css" href="PM-css/styles.css"> -->
    <link rel="stylesheet" type="text/css" href="PM-css/home-style.css">

    <title>Personnel Management</title>

    <script src="https://code.iconify.design/1/1.0.4/iconify.min.js"></script>


</head>

<body>
    <!-- <div class="page_body" style="margin: 0 -16px 0 0px; padding: 0;"> -->

    <!-- HTML for nav links and logo -->
    <div class="page_container">
        <div class="nav_bar">
            <div class="nav_stack nav_logo">
                <h2>AdminMax</h2>
            </div>
            <div class="nav_stack">
                <div class="nav_links">
                    <div class="n_link">
                        <button class="nav_button" onclick="window.location.href = 'home.php';">Home</button>
                    </div>
                    <div class="n_link">
                        <button class="nav_button" onclick="window.location.href = 'PM-pages/personnel.php';">Personnel</button>
                    </div>
                    <div class="n_link">
                        <button class="nav_button" onclick="window.location.href = 'PM-pages/events.php';">Events</button>
                    </div>
                    <div class="n_link">
                        <button class="nav_button" onclick="window.location.href = 'PM-pages/messaging.php';">Messaging</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="home_body">
            <h1 class="page_title">AdminMax</h1>
            <p class="page_caption">Take Control</p>
            <div class="card_body">
                <div class="column_clip">
                    <div class="card_column">
                        <article class="card" id="card1">
                            <figure>
                            <span class="iconify icon_style" data-icon="bx:bx-group" data-inline="false"></span>
                            </figure>

                            <div>
                                <p>
                                    Manage your team members, create groups, build email lists
                                </p>
                                <h1 onclick="window.location.href = 'PM-pages/personnel.php';">
                                    Personnel
                                </h1>
                            </div>
                        </article>
                    </div>
                    <div class="card_column">
                        <article class="card" id="card2">
                            <figure>
                            <span class="iconify icon_style" data-icon="bx-bx-calendar" data-inline="false"></span>
                            </figure>

                            <div>
                                <p>
                                    View and schedule events, track attendance
                                </p>
                                <h1 onclick="window.location.href = 'PM-pages/events.php';">
                                    Events
                                </h1>
                            </div>
                        </article>
                    </div>
                    <div class="card_column">
                        <article class="card" id="card3">
                            <figure>
                            <span class="iconify icon_style" data-icon="bx:bx-comment-detail" data-inline="false"></span>
                            </figure>

                            <div>
                                <p>
                                    Contact your team, send messages by group
                                </p>
                                <h1 onclick="window.location.href = 'PM-pages/messaging.php';">
                                    Messaging
                                </h1>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>


        <div class="footer">
            <nav>
                <a class='footer_link' href="home.php">Home</a> |
                <a class='footer_link' href="PM-pages/personnel.php">Personnel</a> |
                <a class='footer_link' href="PM-pages/events.php">Events</a> |
                <a class='footer_link' href="PM-pages/messaging.php">Messaging</a>
            </nav>
            <p class="footer_note">Devs: Alex Whitaker, Cainan Howard, Sammy Awad, Timothy Krenz</p>
        </div>
    </div>



    <script type="text/javascript" src="PM-script/index_card1.js"></script>
    <script type="text/javascript" src="PM-script/index_card2.js"></script>
    <script type="text/javascript" src="PM-script/index_card3.js"></script>

</body>

</html>