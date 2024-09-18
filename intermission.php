<?php include('server1.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>MathSup</title>
	
	<style>
		body{
			
			background-color: #000000;
		}		
		.btn-group button {
  			background-color: #ffffff; 
  			border: 1px solid black; 
  			color: black; 
  			padding: 10px 24px; 
  			cursor: pointer; 
  			float: left; 
            border-radius: 20px;
			margin: 10px 10px 10px 0px;
		}

		.btn-group button:not(:last-child) {
  			border-right: none; 
		}

		.btn-group:after {
  			content: "";
  			clear: both;
  			display: table;
		}

		
		.btn-group button:hover {
		  background-color: #c30000;
		}
	</style>
</head>
<body>
	<form method="post" action="server1.php">
	
	<div style="font-size:5.25em;color:#ffffff;font-weight:bold;text-align: center;height: 200px;width: 1500px;position: fixed;top: 70%;left: 50%;margin-top: -300px;margin-left: -750px;">Intermission</div>
	
	
    <p>
			<a href="home.php">Home</a>
		</p>
	<div style="position: fixed;bottom: 5%;color:#ffffff">Copyright © NNP & RDT</div>
</form>
</body>
</html>