<?php 
    
	session_start();
	$username = "";
	$email = "";
	$errors = array();
	//connect to the database
	$db = mysqli_connect('localhost','root','nethma@123','fyp');
	if (mysqli_connect_errno()) {
		echo "Failed".mysqli_connect_errno();
	}
	

	//if the s_signup button is clicked
	if (isset($_POST['s_signup'])) {
		$username = mysqli_real_escape_string($db, $_POST['username']);		
		$password = mysqli_real_escape_string($db, $_POST['password']);
		$name = mysqli_real_escape_string($db, $_POST['name']);
		$tel = mysqli_real_escape_string($db, $_POST['tel']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
        $school = mysqli_real_escape_string($db, $_POST['school']);
        $age = mysqli_real_escape_string($db, $_POST['age']);

		//ensure that form fields are filled properly
		if (empty($username)) {
			array_push($errors, "Please Enter Username with 8 Characters");		
		}		
		else if (empty($password)) {
			array_push($errors, "Please Enter Password");
		}		
		else if (empty($name)) {
			array_push($errors, "Please Enter Name");			
		}		
		else if (empty($tel)) {
			array_push($errors, "Please Enter Telephone Number");
		}		
		else if (empty($email)) {
			array_push($errors, "Please Enter Email Address");
		}

        $query = "SELECT * FROM studentdetails WHERE Username='$username'";
		$result = mysqli_query($db, $query);
		if (mysqli_num_rows($result) == 1) {
			array_push($errors, "Please Enter a Unique Username");
        }
		
		//if there are no errors, save user to database
		if (count($errors) == 0) {		
            $password = md5($password);
			$sql = "INSERT INTO studentdetails (Username, SPassword, SName, Tel, Email, School, Age) VALUES ('$username', '$password', '$name', '$tel', '$email', '$school', '$age')";
			mysqli_query($db, $sql);
            header('location: home.php');	
		}
	}

    //if the s_login button is clicked
    if (isset($_POST['s_login'])) {
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		//ensure that form fields are filled properly
		if (empty($username)) {
			array_push($errors, "Please Enter Username with 8 Characters");
		}
		else if (empty($password)) {
			array_push($errors, "Please Enter Password");
		}
		
		if (count($errors) == 0) {			
			$_SESSION['username'] = $username;
			$_SESSION['studentusername'] = $username;
			
			$password =  md5($password);
			$query = "SELECT * FROM studentdetails WHERE Username='$username' AND SPassword='$password'";
			$result = mysqli_query($db, $query);
			if (mysqli_num_rows($result) == 1) {
				header('location: home2.php');
				
			}else{
				array_push($errors, "Wrong Username/ Password");
				
			}
		}
	}


	
?>