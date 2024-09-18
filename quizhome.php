<!DOCTYPE html>
<html lang="en">
<head>
    <title>MathSup</title>
    
    <style>
        body {
            background-color: #000000;
            color: #ffffff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        
        .btn-group {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            gap: 20px;
        }

        .btn-group button {
            background-color: #1E90FF;
            border: none;
            color: black;
            padding: 25px 50px;
            cursor: pointer;
            border-radius: 20px;
            width: 200px;
            height: 100px;
            font-size: 1.5em;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s, box-shadow 0.2s;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: float 3s ease-in-out infinite;
        }

        .btn-group button:hover {
            background-color: #87CEEB;
        }

        .top-buttons {
            position: fixed;
            top: 10px;
            left: 10px;
            display: flex;
            gap: 10px;
        }

        .top-buttons button {
            background-color: #1E90FF;
            border: none;
            color: black;
            padding: 15px 30px;
            cursor: pointer;
            border-radius: 20px;
            width: 120px;
            height: 60px;
            font-size: 1.2em;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s, box-shadow 0.2s;
            animation: float 3s ease-in-out infinite;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .top-buttons button:hover {
            background-color: #87CEEB;
        }

        .title {
            font-size: 5.00em;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
            position: fixed;
            top: 20%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-shadow: 2px 2px 10px #000000;
        }

        .title2 {
            font-size: 2em;
            font-weight: bold;
            text-align: center;
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-shadow: 2px 2px 10px #000000;
        }

        .clock {
            position: fixed;
            top: 5%;
            right: 2%;
            font-size: 1.0em;
            font-weight: bold;
            border: 2px solid #000000;
            border-radius: 10px;
            padding: 10px;
            color: #000000;
            text-align: center;
            background-color: transparent;
        }

        .footer {
            position: fixed;
            bottom: 5%;
            color: #000000;
            left: 90%;
            transform: translateX(-50%);
        }

        .background-img {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.8;
        }

        @keyframes float {
            0% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
            100% {
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <img src="background3.jpg" alt="Background" class="background-img"> <!-- Replace with your local image path -->
    <form method="post" action="server3.php">
        <div class="top-buttons">
            <button type="submit" name="home">Home</button>
            <button type="submit" name="back">Back</button>
        </div>
        <div class="btn-group">
            <button type="submit" name="algebra">Algebra</button>
            <button type="submit" name="differentiation">Differentiation</button>
            <button type="submit" name="integration">Integration</button>
        </div>
        <div class="title">MathSup</div>
        <div class="title2">Choose a lesson</div>
        <div class="clock" id="clock"></div>
        <div class="footer">Copyright © NNP & RDT</div>
    </form>

    <script>
        function updateClock() {
            const clockElement = document.getElementById('clock');
            const now = new Date();
            const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            const day = days[now.getDay()];
            const date = now.getDate().toString().padStart(2, '0');
            const month = months[now.getMonth()];
            const year = now.getFullYear();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');

            const dateTimeString = `${day}, ${month} ${date}, ${year}<br>${hours}:${minutes}:${seconds}`;
            clockElement.innerHTML = dateTimeString;
        }

        setInterval(updateClock, 1000);
        updateClock(); // initial call to display clock immediately
    </script>
</body>
</html>
