<?php
include_once "functions.php";
session_start_control(false);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>DPI About</title>
	<link href="style.css" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="images/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />

<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
<script>
window.addEventListener("load", function(){
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      "background": "#eaf7f7",
      "text": "#5c7291"
    },
    "button": {
      "background": "#56cbdb",
      "text": "#ffffff"
    }
  },
  "showLink": false,
  "position": "top",
  "content": {
    "message": "This website use cookies to ensure you get the best experience. It does not collect any personal data, it only tracks your operations on the website in order to react to them."
  }
})});
</script>
</head>

<body>
	<div id="main">
		<noscript>
			<div id="top-nojavascript">
				Your experience on this website will be improved by activating Javascript!
			</div>
		</noscript>

		<div id="top-nav">

			<b>DPI </b>
			<small>
				<i>Don't Purchase Illegaly!</i>
			</small>

		</div>


		<div id="header">

			<img src="images/header.jpg" alt="Logo"/>

		</div>



		<div id="navigation">
			<?php include("menu.php");?>

		</div>

		<br />
		<br />

		<div id="content">
			<h1>The website </h1>
			<p>
				This website was made as a small (less than 3 weeks, one person only) project for the Distributed Programming course at the Politecnico di Torino.
			The only purpose of this website is to emulate an auction website, with one item only, using Javascript, PHP, HTML5, CSS3, AJAX.
			It has no claim to be a full working auction website, but it was made with cure in order to be extendible in an hypotetic future.
			Enjoy!
			</p>

			<h1>Who "we" are </h1>
			<div class="card" style="width:30%" onclick="window.open('cv.pdf')">
				<img src="images/me.png" alt="Avatar" style="width:100%" />
				<div class="container">
					<h4>
						<b>Massimo Tumolo</b>
					</h4>
					<p>Computer Engineer</p>

				</div>
			</div>

			<h1>W3C Validator</h1>
			<p>
				<a href="http://jigsaw.w3.org/css-validator/check/referer">
					<img style="border:0;width:88px;height:31px"
						src="http://jigsaw.w3.org/css-validator/images/vcss-blue"
						alt="CSS Valido!" />
				</a>
			</p>



		</div>



		<div id="footer">

			<hr />

			Layout based on
			<a href="http://www.dreamtemplate.com/">DreamTemplate</a>

		</div>



	</div>

</body>

</html>
