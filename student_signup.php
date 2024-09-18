<?php include('server2.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Registration System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .header {
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
            color: #000000;
            background: rgba(0, 0, 0, 0);
            padding: 20px;
            border-radius: 15px;
        }

        form {
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 15px;
            width: 80%;
            max-width: 400px;
        }

        .input-group {
            margin: 10px 0;
        }

        .input-group label {
            display: block;
            font-size: 1.2em;
            margin-bottom: 5px;
        }

        .input-group input {
            width: calc(100% - 20px);
            height: 40px;
            padding: 10px;
            font-size: 1em;
            border-radius: 10px;
            border: 1px solid #dddddd;
            color: #000000;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .btn {
            background-color: #1E90FF;
            border: none;
            color: white;
            padding: 15px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 1.2em;
            margin: 10px 0;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            animation: float 3s ease-in-out infinite; /* Add this line for floating effect */
        }

        .btn:hover {
            background-color: #87CEEB;
            transform: scale(1.05);
        }

        p {
            text-align: center;
            color: #ffffff;
        }

        a {
            color: #87CEEB;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Student Registration</h2>
    </div>

    <form method="post" action="student_signup.php">
        <?php include('errormsg.php'); ?>

        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <div class="input-group">
            <label>Name</label>
            <input type="text" name="name" required>
        </div>

        <div class="input-group">
            <label>Tel. Number</label>
            <input type="text" name="tel" required>
        </div>

        <div class="input-group">
            <label>E-mail Address</label>
            <input type="text" name="email" required>
        </div>

        <div class="input-group">
            <label>School</label>
            <input type="text" name="school">
        </div>

        <div class="input-group">
            <label>Age</label>
            <input type="text" name="age">
        </div>

        <div class="input-group">
            <button type="submit" name="s_signup" class="btn">Signup</button>
        </div>

        <p>
            Already a Student? <a href="student_login.php">Login</a>
        </p>
        <p>
            <a href="home.php">Home</a>
        </p>
    </form>
</body>
</html>
