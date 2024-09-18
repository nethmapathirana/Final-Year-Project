<?php 

	if (isset($_POST['quizzes'])) {
		include 'quizhome.php';			
	}

	if (isset($_POST['exams'])) {
		include 'intermission.php';			
	}
	if (isset($_POST['chatbot'])) {
		include 'intermission.php';			
	}

	if (isset($_POST['english'])) {
		include 'home3.php';			
	}

	if (isset($_POST['sinhala'])) {
		include 'intermission.php';			
	}

	if (isset($_POST['home'])) {
		include 'home.php';			
	}

	if (isset($_POST['back'])) {
		include 'home2.php';			
	}

	if (isset($_POST['back2'])) {
		include 'home3.php';			
	}

	if (isset($_POST['algebra'])) {
		include 'algebraquiz.php';			
	}

	if (isset($_POST['differentiation'])) {
		include 'intermission.php';			
	}

	if (isset($_POST['integration'])) {
		include 'intermission.php';			
	}


?>