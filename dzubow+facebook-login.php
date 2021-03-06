<?php

$app_id = "177823159007563";
$app_secret = "YOUR_APP_SECRET";
$my_url = "http://localhost/facebook";

session_start();
$code = $_REQUEST["code"];

if (empty($code)) {
    $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
    $dialog_url = "https://www.facebook.com/dialog/oauth?client_id="
        . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
        . $_SESSION['state'];

    echo("<script> top.location.href='" . $dialog_url . "'</script>");
}

if ($_REQUEST['state'] == $_SESSION['state']) {
    $token_url = "https://graph.facebook.com/oauth/access_token?"
        . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
        . "&client_secret=" . $app_secret . "&code=" . $code;

    $response = file_get_contents($token_url);
    $params = null;
    parse_str($response, $params);

    $graph_url = "https://graph.facebook.com/me?access_token="
        . $params['access_token'];

    $user = json_decode(file_get_contents($graph_url));
    echo("Hello " . $user->name);
}
else {
    echo("The state does not match. You may be a victim of CSRF.");
}

?>

<!--<html>-->
<!--<head>-->
<!--    <title>My Facebook Login Page</title>-->
<!--</head>-->
<!--<body>-->
<!--<div id="fb-root"></div>-->
<!--<script>-->
<!--    window.fbAsyncInit = function() {-->
<!--        FB.init({-->
<!--            appId      : 'YOUR_APP_ID',-->
<!--            status     : true,-->
<!--            cookie     : true,-->
<!--            xfbml      : true,-->
<!--            oauth      : true-->
<!--        });-->
<!--    };-->
<!--    (function(d){-->
<!--        var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}-->
<!--        js = d.createElement('script'); js.id = id; js.async = true;-->
<!--        js.src = "//connect.facebook.net/en_US/all.js";-->
<!--        d.getElementsByTagName('head')[0].appendChild(js);-->
<!--    }(document));-->
<!--</script>-->
<!--<div class="fb-login-button">Login with Facebook</div>-->
<!--</body>-->
<!--</html>-->