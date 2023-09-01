<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="height=device-height, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="ie-edge">
	<link rel="stylesheet" href="public/style/styles.css">
	<title>Polls</title>
</head>
<body class="body">
				<header>
				<h1><a href="<?php echo 'http://'.$_SERVER['HTTP_HOST']; ?>">Polls</h1>
				<nav>
								<ul>
												<li>
																<a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/create'?>">Create</a>
												</li>
												<li>
																<a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/how-to-use'?>">How to use</a>
												</li>
												<li>
																<a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/contact'?>">Contact me</a>
												</li>
								</ul>
				</header>
				<main>
								<?php
												switch(explode('?', $_SERVER['REQUEST_URI'])[0]){
																case '/':
																				require_once realpath('src/mcv/views/allpolls.php');								
																				break;
																case '/view':
																				require_once realpath('src/mcv/views/pollView.php');
																				break;
																case '/how-to-use':
																				require_once realpath('src/mcv/views/how-to-use.php');
																				break;
																case '/contact':
																				require_once realpath('src/mcv/views/contact.php');
																				break;
																case ('/create' or '/update'):
																				require_once realpath('src/mcv/views/createpoll.php');
																				break;
												}
								?>
				</main>
</body>
</html>
