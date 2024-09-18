<?php
session_start();

$studentusername = $_SESSION['username'];

$db_host = 'localhost'; // Database host
$db_user = 'root'; // Database username
$db_pass = 'nethma@123'; // Database password
$db_name = 'fyp'; // Database name

// Create connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check for timeout
$timeout = isset($_GET['timeout']) ? $_GET['timeout'] == 1 : false;

// Fetch student answers
$sql_student_answers = "SELECT * FROM student_answers WHERE username='$studentusername'";
$result_student_answers = mysqli_query($conn, $sql_student_answers);

$correct_count = 0;
$total_questions = 0;
$easy_count = 0;
$medium_count = 0;
$hard_count = 0;

if (mysqli_num_rows($result_student_answers) > 0) {
    // Initialize array to store question results
    $question_results = [];

    while ($student_answer = mysqli_fetch_assoc($result_student_answers)) {
        $question_id = $student_answer['id'];
        $student_selected_answer = $student_answer['s_answer'];

        // Fetch the correct answer and category for this question
        $sql_correct_answer = "SELECT correct_ans, category FROM questions WHERE id='$question_id'";
        $result_correct_answer = mysqli_query($conn, $sql_correct_answer);
        $question_data = mysqli_fetch_assoc($result_correct_answer);
        $correct_answer = $question_data['correct_ans'];
        $category = $question_data['category']; // Get the category of the question

        // Increment total questions
        $total_questions++;

        // Check if the student's answer is correct
        if ($student_selected_answer == $correct_answer) {
            $correct_count++;
            
            // Increment the appropriate category counter
            if ($category == 'Easy') {
                $easy_count++;
            } elseif ($category == 'Medium') {
                $medium_count++;
            } elseif ($category == 'Hard') {
                $hard_count++;
            }

            $question_results[] = [
                'question_id' => $question_id,
                'correct' => true,
                'student_answer' => $student_selected_answer,
                'correct_answer' => $correct_answer
            ];
        } else {
            $question_results[] = [
                'question_id' => $question_id,
                'correct' => false,
                'student_answer' => $student_selected_answer,
                'correct_answer' => $correct_answer
            ];
        }
    }
} else {
    echo "No answers found for this user.";
    exit();
}

// Calculate time taken
$time_taken = isset($_SESSION['start_time']) ? time() - $_SESSION['start_time'] : 0;
$finished_on_time = !$timeout ? 'Yes' : 'No';

// Determine the student level
$sql_level = "SELECT S_Level FROM student_level_identifier WHERE Finished_on_Time = '$finished_on_time' AND Easy_count = '$easy_count' AND Medium_count = '$medium_count' AND Hard_count = '$hard_count'";
$result_level = mysqli_query($conn, $sql_level);

$student_level = 'Not Determined'; // Default in case no matching level is found
if (mysqli_num_rows($result_level) > 0) {
    $student_level = mysqli_fetch_assoc($result_level)['S_Level'];
}

// Update the student_details table with the determined level
if ($student_level !== 'Not Determined') {
    $sql_update_level = "UPDATE studentdetails SET S_Level = '$student_level' WHERE username = '$studentusername'";
    if (!mysqli_query($conn, $sql_update_level)) {
        echo "Error updating student level: " . mysqli_error($conn);
    }
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <style>
        body {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            margin: 0;
            padding: 0;
            background: url('background3.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border: 2px solid #00008b;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #00008b;
            font-size: 2em;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        .summary {
            text-align: center;
            margin-top: 20px;
            font-size: 1.2em;
            color: #00008b;
        }
        .question-result {
            margin-bottom: 20px;
            padding: 15px;
            border: 2px solid #87cefa;
            border-radius: 10px;
            background-color: #f0f8ff;
        }
        .correct {
            color: #32cd32;
            font-weight: bold;
        }
        .incorrect {
            color: #ff4500;
            font-weight: bold;
        }
        .btn-group {
            text-align: center;
            margin-top: 20px;
        }
        button {
            padding: 12px 30px;
            background-color: #00008b;
            color: #ffffff;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.2s;
        }
        button:hover {
            background-color: #1e90ff;
            transform: scale(1.05);
        }
        /* Balloon Animation */
        @keyframes floatUp {
            0% {
                bottom: -10%;
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                bottom: 110%;
                opacity: 0;
            }
        }
        .balloon {
            position: fixed;
            bottom: -10%;
            width: 80px;
            animation: floatUp 8s linear infinite;
        }
        /* Message Animations */
        .message {
            position: fixed;
            top: 30%;
            left: 50%;
            transform: translateX(-50%);
            font-size: 2em;
            text-align: center;
            font-weight: bold;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
            opacity: 0;
            animation: fadeInOut 5s ease-in-out forwards;
        }
        .congrats-message {
            color: #ff0000;
        }
        .average-message {
            color: #1e90ff;
        }
        .weak-message {
            color: #ff4500;
        }
        .hidden {
            display: none;
        }
        @keyframes fadeInOut {
            0% {
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Balloon Container for Bright Students -->
    <div id="balloon-container"></div>

    <!-- Messages for Students -->
    <div id="congrats-message" class="message congrats-message hidden">
        🎉 Congrats! You did an amazing job! 🎉<br>
        Keep up the great work and reach for the stars! 🌟
    </div>
    <div id="average-message" class="message average-message hidden">
        👍 Good effort! You're doing well!<br>
        Keep practicing, and you'll get even better! 🌟
    </div>
    <div id="weak-message" class="message weak-message hidden">
        💪 Don't give up! You can do this!<br>
        Keep trying, and you'll improve with every step! 🌱
    </div>

    <div class="container">
        <h1>Quiz Results</h1>
        <div class="summary">
            <p>You got <?php echo $correct_count; ?> out of <?php echo $total_questions; ?> questions correct</p>
            <p>Total Time Taken: <?php echo gmdate("i:s", $time_taken); ?> minutes</p>
            <?php if ($timeout) { ?>
                <p><strong>Time's up! You didn't finish the quiz in time.</strong></p>
            <?php } ?>
            <p>Your Level: <strong><?php echo $student_level; ?></strong></p>
        </div>
        <?php foreach ($question_results as $result) { ?>
            <div class="question-result">
                <p><strong>Question No:</strong> <?php echo $result['question_id']; ?></p>
                <p><strong>Your Answer:</strong> <?php echo htmlspecialchars($result['student_answer'], ENT_QUOTES, 'UTF-8'); ?> (<?php echo $result['correct'] ? '<span class="correct">Correct</span>' : '<span class="incorrect">Incorrect</span>'; ?>)</p>
                <?php if (!$result['correct']) { ?>
                    <p><strong>Correct Answer:</strong> <?php echo htmlspecialchars($result['correct_answer'], ENT_QUOTES, 'UTF-8'); ?></p>
                <?php } ?>
            </div>
        <?php } ?>
        <div class="btn-group">
            <form action="quizhome.php" method="post">
                <button type="submit" onclick="resetTimer()">Go to Quiz Home</button>
            </form>
        </div>
    </div>

    <script>
        window.onload = function() {
            var studentLevel = "<?php echo $student_level; ?>"; // Get student level from PHP

            // Initially hide the results container
            document.querySelector('.container').style.display = 'none';

            // Show appropriate message based on student level
            if (studentLevel === 'Bright') {
                createBalloons(20); // Show balloons for bright students
                document.getElementById('congrats-message').classList.remove('hidden');
            } else if (studentLevel === 'Average') {
                document.getElementById('average-message').classList.remove('hidden');
            } else if (studentLevel === 'Weak') {
                document.getElementById('weak-message').classList.remove('hidden');
            }

            setTimeout(function() {
                document.getElementById('balloon-container').innerHTML = ''; // Clear balloons
                document.getElementById('congrats-message').classList.add('hidden'); // Hide congrats message
                document.getElementById('average-message').classList.add('hidden'); // Hide average message
                document.getElementById('weak-message').classList.add('hidden'); // Hide weak message
                document.querySelector('.container').style.display = 'block'; // Show results
            }, 5000); // Adjust time to match animation length for balloons
        };

        // Function to create balloons
        function createBalloons(count) {
            var container = document.getElementById('balloon-container');
            for (var i = 0; i < count; i++) {
                var balloon = document.createElement('img');
                balloon.src = 'balloon.png'; // Replace with the correct path
                balloon.className = 'balloon';
                balloon.style.left = Math.random() * 100 + 'vw'; // Random horizontal position
                balloon.style.animationDuration = 4 + Math.random() * 4 + 's'; // Random speed
                container.appendChild(balloon);
            }
        }

        function resetTimer() {
            <?php
            // Reset timer session variables
            unset($_SESSION['start_time']);
            unset($_SESSION['time_left']);
            ?>
        }
    </script>
</body>
</html>
