<?php
require_once('../authorize/mastodon.php');
use HalcyonSuite\HalcyonForMastodon\Mastodon;
if (isset($_POST['acct'])) {
$domain = explode("@", mb_strtolower(htmlspecialchars((string)filter_input(INPUT_POST, 'acct'), ENT_QUOTES)))[2];
$URL= 'https://'.$domain;
$api= new Mastodon();
if ( !preg_match('/(^[a-z0-9\-\.\/]+?\.[a-z0-9-]+$)/', $domain) ) {
header('Location: '.$api->clientWebsite.'/login?cause=domain', true, 303);
die();
} else {
try {
$client_id = $api->getInstance($URL)["client_id"];
$authorizeURL= $URL.'/oauth/authorize?client_id='.$client_id.'&response_type=code&scope=read+write+follow&website='.$api->clientWebsite.'&redirect_uri='.urlencode($api->clientWebsite.'/auth?&host='.$domain);
header("Location: {$authorizeURL}", true, 303);
die();
} catch (Exception $e) {
header('Location: '.$api->clientWebsite.'/login?cause=domain', true, 303);
die();
}
}
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Halcyon for Mastodon</title>
<link rel="shortcut icon" href="/assets/images/favicon.ico">
<link rel="stylesheet" href="/login/assets/css/style.css" media="all">
<link rel="stylesheet" href="//cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css" media="all">
<link rel="stylesheet" href="//cdn.staticfile.org/cookieconsent2/3.0.4/cookieconsent.min.css">
<script src="//yastatic.net/jquery/3.2.1/jquery.min.js"></script>
<script src="//cdn.staticfile.org/cookieconsent2/3.0.4/cookieconsent.min.js"></script>
<script src="/assets/js/jquery-cookie/src/jquery.cookie.js"></script>
<script src="/login/assets/js/halcyon_login.js"></script>
<script>
if(
localStorage.getItem("current_id") |
localStorage.getItem("current_instance") |
localStorage.getItem("current_authtoken")
){
location.href = "/";
};
</script>
</head>
<body>
<header id="header">
<div id="header_wrap">
<div id="header_title_wrap" class="header_box header_right_box">
<div class="header_box_child title_box">
<a href="/">
<img src="/login/assets/images/halcyon-title.png" alt="Halcyon for mastodon">
</a>
</div>
</div>
<div id="header_menu_wrap" class="header_box header_left_box">
<nav class="header_box_child nav_box">
<ul>
<a href="https://social.csswg.org/@halcyon" class="no-underline">
<li>
<span><i class="fa fa-newspaper-o" aria-hidden="true"></i>News</span>
</li>
</a>
<a href="https://notabug.org/halcyon-suite/halcyon" class="no-underline">
<li>
<span><i class="fa fa-code" aria-hidden="true"></i>Source</span>
</li>
</a>
<a href="/terms/" class="no-underline">
<li>
<span><i class="fa fa-balance-scale" aria-hidden="true"></i>Terms</span>
</li>
</a>
<a href="http://www.nikisoft.one/contact.php" class="no-underline">
<li>
<span><i class="fa fa-envelope" aria-hidden="true"></i>Contact</span>
</li>
</a>
<a href="#login_form_wrap" class="no-underline">
<li>
<span><i class="fa fa-user-circle-o" aria-hidden="true"></i>Login</span>
</li>
</a>
</ul>
</nav>
</div>
</div>
</header>
<main id="main">
<div id="login_form_wrap">
<div class="login_form">
<form method="POST" >
<h2>Login to Halcyon</h2>
<p>
or <a href="https://qoto.org/auth/sign_up/">create an account</a>
</p>
<div class="session_aleart">
<span></span>
</div>
<div class="login_form_main">
<input name="acct" type="text" class="login_form_input" placeholder="@johndoe@example.com" required>
<label class="login_form_continue pointer">
<i class="fa fa-chevron-circle-right" aria-hidden="true"></i>
<input id="login_continue" type="submit" value="" class="invisible"></input>
</label>
</div>
<div class="login_form_agree">
<label class="login_form_agree_check disallow_select pointer">
<i class="fa fa-check-square-o" aria-hidden="true"></i>
I agree with the <a href="/terms">Terms</a>
<input id="agree" type="checkbox" required checked class="invisible">
</label>
</div>
</form>
</div>
</div>
<article id="article">
<h2>What is Halcyon</h2>
<p>
Halcyon is a webclient for <a href="https://qoto.org/auth/sign_up">Mastodon</a> which aims to recreate the simple and beautiful user interface of Twitter while keeping all advantages of decentral networks in focus.
</p>
<div class="image_wrap">
<ul>
<li><img src="/login/assets/images/preview2.png" alt="halcyon_screenshot"></li>
<li><img src="/login/assets/images/preview1.png" alt="halcyon_screenshot"></li>
<li><img src="/login/assets/images/preview0.png" alt="halcyon_screenshot"></li>
</ul>
<button class="prev_button switch_button"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
<button class="next_button switch_button"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
</div>
<h2>Contact / Feedback</h2>
<p>
Mastodon: <a href="https://qoto.org/@hfreemo" target="_blank">＠freemo@qoto.org</a><br/>
</p>
</article>
</main>
<!-- FOOTER -->
<footer id="footer">
<div class="footer_anchor">
<a href="#">
<i class="fa fa-angle-up" aria-hidden="true"></i>
</a>
</div>
<span>Photo by <a href="https://www.flickr.com/photos/95387826@N08/">Michio Morimoto on Flickr</a> (CC BY 2.0)</span><br/>
<span>Halcyon version <?php echo file_get_contents("../version.txt") ?></span>
</footer>
</body>
<script>
window.cookieconsent.initialise({
"palette": {
"popup": {
"background": "#000"
},
"button": {
"background": "#f1d600"
}
},
"theme": "classic",
"position": "bottom"
});
</script>
<?php if (isset($_GET['cause'])): ?>
<script>
$(function() {
var cause = "<?= htmlspecialchars((string)filter_input(INPUT_GET, 'cause'), ENT_QUOTES) ?>";
if(cause === "domain") {
$('.login_form_main').addClass('error');
$('.session_aleart').removeClass('invisible');
$('.session_aleart > span').text('This instance does not exsist.');
}
});
$(document).on('click','.login_form_main', function(e) {
$(this).removeClass('error');
});
</script>
<?php endif; ?>
</html>
