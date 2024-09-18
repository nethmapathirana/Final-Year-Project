<?php
session_start();

// Database connection details
$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'nethma@123';
$db_name = 'fyp';

// Create connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$studentusername = $_SESSION['username'];

if (!isset($_SESSION['id'])) {
    $_SESSION['id'] = 1; // Initialize to first question if not set
}

$query7 = "SELECT * FROM studentdetails WHERE username='$studentusername'";
$result7 = mysqli_query($conn, $query7);
$studentname = mysqli_fetch_assoc($result7)['SName'];

// Initialize timer if not already set
if (!isset($_SESSION['start_time'])) {
    $_SESSION['start_time'] = time();
}

// Set the total quiz duration (10 minutes)
$total_quiz_duration = 600; // 10 minutes in seconds

// Calculate the time left
$elapsed_time = time() - $_SESSION['start_time'];
$_SESSION['time_left'] = $total_quiz_duration - $elapsed_time;

if ($_SESSION['time_left'] <= 0) {
    header("Location: results.php?timeout=1");
    exit();
}

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected_answer_for_question = isset($_POST['answer'][$_SESSION['id']]) ? $_POST['answer'][$_SESSION['id']] : 'no';
    $new_id = $_SESSION['id'];

    $query = "SELECT * FROM student_answers WHERE username='$studentusername' AND id = '$new_id'";
    $result3 = mysqli_query($conn, $query);
    if (mysqli_num_rows($result3) == 1) {
        $sql2 = "UPDATE student_answers SET s_answer = '$selected_answer_for_question' WHERE username='$studentusername' AND id = '$new_id'";
        $result2 = mysqli_query($conn, $sql2);
    } else {
        $sql2 = "INSERT INTO student_answers(username, id, s_answer) VALUES ('$studentusername', '$new_id', '$selected_answer_for_question')";
        $result2 = mysqli_query($conn, $sql2);
    }

    // Check if "Next" button clicked
    if (isset($_POST['next'])) {
        $_SESSION['id']++;
    } elseif (isset($_POST['prev']) && $_SESSION['id'] > 1) {
        $_SESSION['id']--;
    } elseif (isset($_POST['submit'])) {
        $_SESSION['id'] = 1;
        header("Location: results.php");
        exit();
    }
}

// Query to fetch questions from the database
$sql = "SELECT * FROM questions";
$result = mysqli_query($conn, $sql);

// Display questions
if (mysqli_num_rows($result) > 0) {
    $question_id = isset($_SESSION['id']) ? $_SESSION['id'] : 1;
    mysqli_data_seek($result, $question_id - 1); // Move result pointer to current question
    $row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Algebra Quiz</title>
    <style>
        body {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            margin: 0;
            padding: 0;
            background: url('background3.jpg') no-repeat center center fixed; /* Add background image */
            background-size: cover; /* Cover the entire page */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 800px;
            height: 650px; /* Increase the width of the container */
            max-width: 800px; /* Increase max-width for larger screens */
            margin: auto;
            background-color: #ffffff;
            padding: 20px; /* Increase padding for more space */
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border: 2px solid #00008b; /* Teal border */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #00008b; /* Teal color for heading */
        }
        p {
            margin-bottom: 10px;
            font-size: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
            margin-bottom: 20px;
        }
        li {
            margin-bottom: 10px;
        }
        input[type="radio"] {
            margin-right: 10px;
        }
        button {
            padding: 12px 25px;
            background-color: #00008b; /* Teal background */
            color: #ffffff;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.2s;
        }
        button:hover {
            background-color: #1e90ff; /* Darker teal on hover */
            transform: scale(1.05); /* Slight zoom effect */
        }
        .btn-group {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }
        #timer {
            text-align: center;
            font-size: 20px;
            margin-bottom: 5px;
            color: #00008b; /* Teal color for timer */
        }
    </style>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <script>
        function startTimer(duration, display) {
            var timer = duration, minutes, seconds;
            setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    display.textContent = "Time's up!";
                    document.forms["quizForm"].submit(); // Auto-submit the form when time's up
                }
            }, 1000);
        }

        window.onload = function () {
            var timeLeft = <?php echo $_SESSION['time_left']; ?>;
            var display = document.querySelector('#timer');
            startTimer(timeLeft, display);
        };
    </script>
</head>
<body>
    <div class="container">
        <h1>Algebra Quiz</h1>
        <div id="timer"><p> </p></div> <!-- Timer Display -->
        <form name="quizForm" method="post" action="algebraquiz.php">
            <div class="question">
                <p><strong>Name: <?php echo $studentname; ?></strong></p>
                <p><strong>Question <?php echo $row['id']; ?></strong></p>
                <p><?php echo $row['question']; ?></p>
                <p><?php echo '$$' . htmlspecialchars($row['question_2']) . '$$'; ?></p>
            </div>
            <ul>
                <li><input type="radio" name="answer[<?php echo $row['id']; ?>]" value="a"> <?php echo htmlspecialchars($row['ans_a']); ?></li>
                <li><input type="radio" name="answer[<?php echo $row['id']; ?>]" value="b"> <?php echo htmlspecialchars($row['ans_b']); ?></li>
                <li><input type="radio" name="answer[<?php echo $row['id']; ?>]" value="c"> <?php echo htmlspecialchars($row['ans_c']); ?></li>
                <li><input type="radio" name="answer[<?php echo $row['id']; ?>]" value="d"> <?php echo htmlspecialchars($row['ans_d']); ?></li>
            </ul>
            <div class="btn-group">
                <?php if ($question_id > 1) : ?>
                    <button type="submit" name="prev">Previous</button>
                <?php endif; ?>
                <?php if ($question_id < mysqli_num_rows($result)) : ?>
                    <button type="submit" name="next">Next</button>
                <?php else : ?>
                    <button type="submit" name="submit">Submit Answers</button>
                <?php endif; ?>
            </div>
        </form>
        <?php
            $_SESSION['id'] = $question_id; // Update session with current question ID
        } else {
            echo "No questions found.";
        }

        // Close connection
        mysqli_close($conn);
        ?>
    </div>
</body>
</html>
