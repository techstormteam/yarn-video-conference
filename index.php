<?php
//$host = "localhost";
//$user = 'root';
//$pw = '';

$host = 'readonly.cygyqlngdnzg.us-east-1.rds.amazonaws.com';
$db = 'yarn';
$user = 'test123';
$pw = '9S4sDGLPUQwufTtT';
$max_participants = 0;
$url_redirect = "";

//$conn = mysqli_connect($host, $user, $pw, $db);
$conn = mysqli_connect($host, $user, $pw) or die(mysqli_error());
mysqli_select_db($conn, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$table = "video_conferences";
$sql = "SELECT max_participants FROM $table";
$url_sql = "SELECT terminate_url_redirect from $table";
$sql_max_film_count = "SELECT max_filmstrip_count FROM $table";
$result = mysqli_query($conn, $sql);
$result2 = mysqli_query($conn, $url_sql);
$result3 = mysqli_query($conn, $sql_max_film_count);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $max_participants = $row["max_participants"];
    }
} else {
    echo "0 results";
}

if (mysqli_num_rows($result2) > 0) {
    while ($row = mysqli_fetch_assoc($result2)) {
        $url_redirect = $row["terminate_url_redirect"];
    }
} else {
    echo "0 results";
}

if (mysqli_num_rows($result3) > 0) {
    while ($row = mysqli_fetch_assoc($result3)) {
        $max_film = $row["max_filmstrip_count"];
    }
} else {
    echo "0 results";
}

$msg = file_get_contents("http://portal.netcastdigital.net/getInfo.php?conf=myconf&max_users_msg=1");

$html_container = file_get_contents("http://portal.netcastdigital.net/getInfo.php?conf=myconf&html_container=1");

// Process for dial number
$dialFlag = false;
if (!empty($_GET["conf"]) && !empty($_GET["call"]) && !empty($_GET["unlock_room"])) {
    $passwordForUnlock = $_GET["unlock_room"];
    $numberCallTo = $_GET["call"];
    $conference = $_GET["conf"];
    $dialFlag = true;
}

$conn->close();
?>
<html itemscope itemtype="http://schema.org/Product" prefix="og: http://ogp.me/ns#" xmlns="http://www.w3.org/1999/html">
    <head>

        <script src="libs/sweet-alert.js"></script>
        <link rel="stylesheet" href="css/sweet-alert.css"/>
        <!--#include virtual="title.html" -->
        <link rel="icon" type="image/png" href="/images/favicon.ico"/>
        <meta property="og:title" content="Yarn Conference"/>
        <meta property="og:image" content="/images/logo.png"/>
        <meta property="og:description" content="Join a video conference powered by Yarn"/>
        <meta description="Join a video conference powered by Yarn"/>
        <meta itemprop="name" content="Yarn Conference"/>
        <meta itemprop="description" content="Join a video conference powered by Yarn"/>
        <meta itemprop="image" content="/images/logo.png"/>
        <script src="libs/jquery-2.1.1.min.js"></script>
        <script src="config.js?v=5"></script><!-- adapt to your needs, i.e. set hosts and bosh path -->
        <script src="simulcast.js?v=8"></script><!-- simulcast handling -->
        <script src="libs/strophe/strophe.jingle.adapter.js?v=4"></script><!-- strophe.jingle bundles -->
        <script src="libs/strophe/strophe.min.js?v=1"></script>
        <script src="libs/strophe/strophe.disco.min.js?v=1"></script>
        <script src="libs/strophe/strophe.caps.jsonly.min.js?v=1"></script>
        <script src="libs/strophe/strophe.jingle.js?v=2"></script>
        <script src="libs/strophe/strophe.jingle.sdp.js?v=2"></script>
        <script src="libs/strophe/strophe.jingle.sdp.util.js?v=1"></script>
        <script src="libs/strophe/strophe.jingle.sessionbase.js?v=1"></script>
        <script src="libs/strophe/strophe.jingle.session.js?v=2"></script>
        <script src="libs/strophe/strophe.util.js"></script>
        <script src="libs/colibri/colibri.focus.js?v=12"></script><!-- colibri focus implementation -->
        <script src="libs/colibri/colibri.session.js?v=1"></script>
        <script src="libs/jquery-ui.js"></script>
        <script src="libs/rayo.js?v=1"></script>
        <script src="libs/tooltip.js?v=1"></script><!-- bootstrap tooltip lib -->
        <script src="libs/popover.js?v=1"></script><!-- bootstrap tooltip lib -->
        <script src="libs/pako.bundle.js?v=1"></script><!-- zlib deflate -->
        <script src="libs/toastr.js?v=1"></script><!-- notifications lib -->
        <script src="interface_config.js?v=4"></script>
        <script src="muc.js?v=17"></script><!-- simple MUC library -->
        <script src="estos_log.js?v=2"></script><!-- simple stanza logger -->
        <script src="desktopsharing.js?v=3"></script><!-- desktop sharing -->
        <script src="data_channels.js?v=3"></script><!-- data channels -->
        <script src="app.js?v=22"></script><!-- application logic -->
        <script src="commands.js?v=1"></script><!-- application logic -->
        <script src="chat.js?v=15"></script><!-- chat logic -->
        <script src="contact_list.js?v=7"></script><!-- contact list logic -->
        <script src="side_panel_toggler.js?v=1"></script>
        <script src="util.js?v=7"></script><!-- utility functions -->
        <script src="etherpad.js?v=9"></script><!-- etherpad plugin -->
        <script src="prezi.js?v=6"></script><!-- prezi plugin -->
        <script src="smileys.js?v=3"></script><!-- smiley images -->
        <script src="replacement.js?v=7"></script><!-- link and smiley replacement -->
        <script src="moderatemuc.js?v=4"></script><!-- moderator plugin -->
        <script src="analytics.js?v=1"></script><!-- google analytics plugin -->
        <script src="rtp_sts.js?v=5"></script><!-- RTP stats processing -->
        <script src="local_sts.js?v=2"></script><!-- Local stats processing -->
        <script src="videolayout.js?v=30"></script><!-- video ui -->
        <script src="connectionquality.js?v=1"></script>
        <script src="toolbar.js?v=6"></script><!-- toolbar ui -->
        <script src="toolbar_toggler.js?v=2"></script>
        <script src="canvas_util.js?v=1"></script><!-- canvas drawing utils -->
        <script src="audio_levels.js?v=3"></script><!-- audio levels plugin -->
        <script src="media_stream.js?v=2"></script><!-- media stream -->
        <script src="bottom_toolbar.js?v=6"></script><!-- media stream -->
        <script src="moderator.js?v=2"></script><!-- media stream -->
        <script src="roomname_generator.js?v=1"></script><!-- generator for random room names -->
        <script src="keyboard_shortcut.js?v=3"></script>
        <script src="recording.js?v=1"></script>
        <script src="tracking.js?v=1"></script><!-- tracking -->
        <script src="jitsipopover.js?v=3"></script>
        <script src="message_handler.js?v=2"></script>
        <script src="api_connector.js?v=2"></script>
        <script src="settings_menu.js?v=1"></script>
        <script src="avatar.js?v=2"></script><!-- avatars -->
        <link rel="stylesheet" href="css/font.css?v=6"/>
        <link rel="stylesheet" href="css/toastr.css?v=1"/>
        <link rel="stylesheet" type="text/css" media="screen" href="css/main.css?v=30"/>
        <link rel="stylesheet" type="text/css" media="screen" href="css/videolayout_default.css?v=15" id="videolayout_default"/>
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet"/>
        <link rel="stylesheet" href="css/jquery-impromptu.css?v=4"/>
        <link rel="stylesheet" href="css/modaldialog.css?v=3"/>
        <link rel="stylesheet" href="css/popup_menu.css?v=4"/>
        <link rel="stylesheet" href="css/popover.css?v=2"/>
        <link rel="stylesheet" href="css/jitsi_popover.css?v=2"/>
        <link rel="stylesheet" href="css/contact_list.css?v=4"/>
        <link rel="stylesheet" href="css/chat.css?v=5"/>
        <link rel="stylesheet" href="css/welcome_page.css?v=2"/>
        <link rel="stylesheet" href="css/settingsmenu.css?v=1"/>
        <!--
            Link used for inline installation of chrome desktop streaming extension,
            is updated automatically from the code with the value defined in config.js -->
        <link rel="chrome-webstore-item" href="https://chrome.google.com/webstore/detail/diibjkoicjeejcmhdnailmkgecihlobk"/>
        <script src="libs/jquery-impromptu.js"></script>
        <script src="libs/jquery.autosize.js"></script>
        <script src="libs/prezi_player.js?v=2"></script>
        <script src="my_app.js"></script><!-- Can't use because of cross platform disabled  -->
    </head>
    <body>
        <div id="welcome_page">
            <head>
                <title></title>
                <meta charset="UTF-8"/>
                <meta name="viewport" content="width=device-width" />
                <style>
                    /*basic reset*/
                    * {margin: 0; padding: 0;}
                    /*adding a black bg to the body to make things clearer*/
                    body {
                        background: black;
                        font-family:monospace;
                        color:springgreen;
                    }
                    canvas {display: block;}
                </style>
            </head>
            <body>
                <div>
                </div>
                <canvas id="c"></canvas>
                <script>
                    var c = document.getElementById("c");
                    var ctx = c.getContext("2d");
                    //making the canvas full screen
                    c.height = window.innerHeight;
                    c.width = window.innerWidth;
                    //gamma characters - taken from the unicode charset
                    var gamma = "абвгдежзийклмнопрстуфхцчшщъьюя";
                    gamma += "AАБВГДЕЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЮЯ";
                    gamma += "abcdefghijklnopqrstuvwxyz";
                    gamma += "ABCDEFGHIJKLNOPQRSTUVWXYZ";
                    gamma += "田由甲申甴电甶男甸甹町画甼甽甾甿畀畁畂畃畄畅畆畇畈畉畊畋界畍畎畏畐畑";

                    //converting the string into an array of single characters
                    gamma = gamma.split("");

                    var font_size = 10;
                    var columns = c.width / font_size; //number of columns for the rain
                    //an array of drops - one per column
                    var drops = [];
                    //x below is the x coordinate
                    //1 = y co-ordinate of the drop(same for every drop initially)
                    for (var x = 0; x < columns; x++) {
                        drops[x] = 1;
                    }

                    //drawing the characters
                    function draw() {
                        //Black BG for the canvas
                        //translucent BG to show trail
                        ctx.fillStyle = "rgba(0, 0, 0, 0.05)";
                        ctx.fillRect(0, 0, c.width, c.height);

                        ctx.fillStyle = "#0F0"; //green text
                        ctx.font = font_size + "px arial";
                        //looping over drops
                        for (var i = 0; i < drops.length; i++) {
                            //a random gamma character to print
                            var text = gamma[Math.floor(Math.random() * gamma.length)];
                            //x = i*font_size, y = value of drops[i]*font_size
                            ctx.fillText(text, i * font_size, drops[i] * font_size);

                            //sending the drop back to the top randomly after it has crossed the screen
                            //adding a randomness to the reset to make the drops scattered on the Y axis
                            if (drops[i] * font_size > c.height && Math.random() > 0.975) {
                                drops[i] = 0;
                            }

                            //incrementing Y coordinate
                            drops[i]++;
                        }
                    }

                    setInterval(draw, 33);

                </script>
            </body>
        </div>
        <div id="videoconference_page">
            <div style="position: relative;" id="header_container">
                <div id="header">
                    <span id="toolbar">
                        <a class="button" data-container="body" data-toggle="popover" data-placement="bottom" shortcut="mutePopover" content="Mute / Unmute" onclick='toggleAudio();'>
                            <i id="mute" class="icon-microphone"></i>
                        </a>
                        <div class="header_button_separator"></div>
                        <a class="button" data-container="body" data-toggle="popover" data-placement="bottom" shortcut="toggleVideoPopover" content="Start / stop camera" onclick='toggleVideo();'>
                            <i id="video" class="icon-camera"></i>
                        </a>
                        <span id="recording" style="display: none">
                            <div class="header_button_separator"></div>
                            <a class="button" data-container="body" data-toggle="popover" data-placement="bottom" content="Record" onclick='toggleRecording();'>
                                <i id="recordButton" class="icon-recEnable"></i>
                            </a>
                        </span>
                        <div class="header_button_separator"></div>
                        <a class="button" data-container="body" data-toggle="popover" data-placement="bottom" content="Lock / unlock room" onclick="Toolbar.openLockDialog();">
                            <i id="lockIcon" class="icon-security"></i>
                        </a>
                        <div class="header_button_separator"></div>
                        <a class="button" data-container="body" data-toggle="popover" data-placement="bottom" content="Invite others" onclick="Toolbar.openLinkDialog();">
                            <i class="icon-link"></i>
                        </a>
                        <div class="header_button_separator"></div>
                        <span class="toolbar_span">
                            <a class="button" data-container="body" data-toggle="popover" shortcut="toggleChatPopover" data-placement="bottom" content="Open / close chat" onclick='BottomToolbar.toggleChat();'>
                                <i id="chatButton" class="icon-chat"><span id="unreadMessages"></span></i>
                            </a>
                        </span>
                        <span id="prezi_button">
                            <div class="header_button_separator"></div>
                            <a class="button" data-container="body" data-toggle="popover" data-placement="bottom" content="Share Prezi" onclick='Prezi.openPreziDialog();'>
                                <i class="icon-prezi"></i>
                            </a>
                        </span>
                        <span id="etherpadButton">
                            <div class="header_button_separator"></div>
                            <a class="button" data-container="body" data-toggle="popover" data-placement="bottom" content="Shared document" onclick='Etherpad.toggleEtherpad(0);'>
                                <i class="icon-share-doc"></i>
                            </a>
                        </span>
                        <div class="header_button_separator"></div>
                        <span id="desktopsharing" style="display: none">
                            <a class="button" data-container="body" data-toggle="popover" data-placement="bottom" content="Share screen" onclick="toggleScreenSharing();">
                                <i class="icon-share-desktop"></i>
                            </a>
                        </span>
                        <div class="header_button_separator"></div>
                        <a class="button" data-container="body" data-toggle="popover" data-placement="bottom" content="Enter / Exit Full Screen" onclick='buttonClick("#fullScreen", "icon-full-screen icon-exit-full-screen");
                                Toolbar.toggleFullScreen();'>
                            <i id="fullScreen" class="icon-full-screen"></i>
                        </a>
                        <span id="sipCallButton" style="display: none">
                            <div class="header_button_separator"></div>
                            <a class="button" data-container="body" data-toggle="popover" data-placement="bottom" content="Call number" onclick='callSipButtonClicked();'>
                                <i class="icon-telephone"></i></a>
                        </span>
                        <div class="header_button_separator"></div>
                        <a class="button" data-container="body" data-toggle="popover" data-placement="bottom" content="Settings" onclick='PanelToggler.toggleSettingsMenu();'>
                            <i id="settingsButton" class="icon-settings"></i>
                        </a>
                        <div class="header_button_separator"></div>
                        <span id="hangup">
                            <a class="button" data-container="body" data-toggle="popover" data-placement="bottom" content="Hang Up" onclick='hangup();'>
                                <i class="icon-hangup" style="color:#ff0000;font-size: 1.4em;"></i>
                            </a>
                        </span>
                    </span>
                </div>
                <div id="subject"></div>
            </div>
            <div id="settings">
                <h1>Connection Settings</h1>
                <form id="loginInfo">
                    <label>JID: <input id="jid" type="text" name="jid" placeholder="me@example.com"/></label>
                    <label>Password: <input id="password" type="password" name="password" placeholder="secret"/></label>
                    <label>BOSH URL: <input id="boshURL" type="text" name="boshURL" placeholder="/http-bind"/></label>
                    <input id="connect" type="submit" value="Connect" />
                </form>
            </div>
            <div id="reloadPresentation"><a onclick='Prezi.reloadPresentation();'><i title="Reload Prezi" class="fa fa-repeat fa-lg"></i></a></div>
            <div id="videospace" onmousemove="ToolbarToggler.showToolbar();">
                <div id="largeVideoContainer" class="videocontainer">
                    <div id="presentation"></div>
                    <div id="etherpad"></div>
                    <a target="_new"><div class="watermark leftwatermark"></div></a>
                    <a target="_new"><div class="watermark rightwatermark"></div></a>
                    <a class="poweredby" href="http://yarn-me.com" target="_new" >powered by Yarn</a>
                    <img id="activeSpeakerAvatar" src=""/>
                    <canvas id="activeSpeakerAudioLevel"></canvas>
                    <video id="largeVideo" autoplay oncontextmenu="return false;"></video>
                </div>
                <div id="remoteVideos">
                    <span id="localVideoContainer" class="videocontainer">
                        <span id="localNick" class="nick"></span>
                        <span id="localVideoWrapper">
                            <!--<video id="localVideo" autoplay oncontextmenu="return false;" muted></video> - is now per stream generated -->
                        </span>
                        <audio id="localAudio" autoplay oncontextmenu="return false;" muted></audio>
                        <span class="focusindicator"></span>
                        <<div class="connectionindicator">
                            <span class="connection connection_empty"><i class="icon-connection"></i></span>
                            <span class="connection connection_full"><i class="icon-connection"></i></span>
                        </div>>

                    </span>
                    <audio id="userJoined" src="sounds/joined.wav" preload="auto"></audio>
                    <audio id="userLeft" src="sounds/left.wav" preload="auto"></audio>
                </div>
                <span id="bottomToolbar">
                    <span class="bottomToolbar_span">
                        <a class="bottomToolbarButton" data-container="body" data-toggle="popover" shortcut="toggleChatPopover" data-placement="top" content="Open / close chat" onclick='BottomToolbar.toggleChat();'>
                            <i id="chatBottomButton" class="icon-chat-simple">
                                <span id="bottomUnreadMessages"></span>
                            </i>
                        </a>
                    </span>
                    <div class="bottom_button_separator"></div>
                    <span class="bottomToolbar_span">
                        <a class="bottomToolbarButton" data-container="body" data-toggle="popover" data-placement="top" id="contactlistpopover" content="Open / close contact list" onclick='BottomToolbar.toggleContactList();'>
                            <i id="contactListButton" class="icon-contactList">
                                <span id="numberOfParticipants"></span>
                            </i>
                        </a>
                    </span>
                    <div class="bottom_button_separator"></div>
                    <span class="bottomToolbar_span">
                        <a class="bottomToolbarButton" data-container="body" data-toggle="popover" shortcut="filmstripPopover" data-placement="top" content="Show / hide film strip" onclick='BottomToolbar.toggleFilmStrip()'>
                            <i id="filmStripButton" class="icon-filmstrip"></i>
                        </a>
                    </span>
                </span>
            </div>
            <div id="chatspace" class="right-panel">
                <div id="nickname">
                    <div id="html-container">
                        <?php echo $html_container; ?>
                    </div>
                    <div id="chat-container">
                        Enter a nickname in the box below
                        <form>
                            <input type='text' id="nickinput" placeholder='Choose a nickname' autofocus>
                        </form>
                    </div>
                </div>

            <!--div><i class="fa fa-comments">&nbsp;</i><span class='nick'></span>:&nbsp;<span class='chattext'></span></div-->
                <div id="chatconversation"></div>
                <audio id="chatNotification" src="sounds/incomingMessage.wav" preload="auto"></audio>
                <textarea id="usermsg" placeholder='Enter text...' autofocus></textarea>
                <div id="smileysarea">
                    <div id="smileys" onclick="Chat.toggleSmileys()">
                        <img src="images/smile.svg"/>
                    </div>
                </div>
            </div>
            <div id="contactlist" class="right-panel">
                <ul>
                    <li class="title"><i class="icon-contact-list"></i> CONTACT LIST</li>
                </ul>
            </div>
            <div id="settingsmenu" class="right-panel">
                <div class="icon-settings"> SETTINGS</div>
                <img id="avatar" src="/images/avatar_logo.png"/>
                <div class="arrow-up"></div>
                <input type="text" id="setDisplayName" placeholder="Name">
                    <input type="text" id="setEmail" placeholder="E-Mail">
                        <button onclick="SettingsMenu.update()" id="updateSettings">Update</button>
                        </div>
                        <!--a id="downloadlog" onclick='dump(event.target);' data-container="body" data-toggle="popover" data-placement="right" data-content="Download logs" ><i class="fa fa-cloud-download"></i></a-->
                        </div>
                        <script>
                            function getParticipant() {
                                if ($('#numberOfParticipants').html() === "") {
                                    return 1;
                                } else {
                                    return $('#numberOfParticipants').html();
                                }
                            }
                            
                            window.setTimeout(function () {
                                if (getParticipant() > <?php echo $max_participants ?>) {
                                    swal({
                                        title: "Message",
                                        text: "<?php echo $msg; ?>",
                                        type: "warning",
                                        confirmButtonColor: "#DD6B55",
                                        confirmButtonText: "OK",
                                        closeOnConfirm: false
                                    },
                                    function () {
                                        window.location.href = "<?php echo $url_redirect; ?>";
                                    });
                                }
                            }, 5000);
                            
                            // Get parameters from url to dial number if any.
                            if (<?php echo $dialFlag; ?>) {
                                connection.rayo.dial(numberInput.value, 'fromnumber', roomName);
                            }
                        </script>
                        </body>
                        </html>
