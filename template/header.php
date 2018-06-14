<!DOCTYPE HTML>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Social Network</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrapp.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="styles/style.css?d=<?php echo time(); ?>">
  </head>
  <body>
		<nav class="navbar navbar-expand-md fixed-top" id="container">
				<div id="head_wrap" class="container">
					<div id="header">
						<img class="img-rounded" src="images/logo.png"/>
						<form method="post" action="" id="form1" style="" class="form-inline">
							<div class="form-group">
								<label for="email">Email</label>
								<input type="email" name="email" class="form-control" placeholder="Email" required="required" />
							</div>
							<div class="form-group">
								<label for="pwd">Password</label>
								<input type="password" class="form-control" name="pass" placeholder="Password" required="required"/>
							</div>
								<button  name="login" type="submit" class="btn btn-default"><span name="login" class="glyphicon glyphicon-log-in"></span> Login</button>
						</form>
					</div>
		</nav>