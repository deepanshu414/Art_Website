<?php
session_start();
require_once 'db_connect.php';
// Check if user is not logged in, redirect to login page
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("location: login.php");
    exit;
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // error_reporting(0);
    $a=$_POST['name'];
    $b=$_POST['email'];
    $j=$_POST['phone'];
    $k=$_POST['country'];
    $d=$_POST['message'];
    $c= getDbConnection();
    $insert="INSERT INTO Contact(Name,Email,Phone,Country,Message) VALUES('$a','$b','$j','$k','$d')";
    if($c->query($insert) === TRUE){
        $success="Submitted successfully...";
    } else {
        $error="Error: " . $c->error;
    }
    $c->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            /* background: url('https://t3.ftcdn.net/jpg/05/77/87/74/360_F_577877489_oQBPZV8680CWLSWDbBkfs6hC7dUgAQrR.jpg') no-repeat center center fixed; */
            background:url(image/background.jpg) no-repeat center center/cover;
            background-size: cover;
            color: #fff;
            margin: 0;
            padding: 0;
            opacity: 1px;
            overflow: hidden; /* Hide the scrollbar on the body */
        }
        .container1 {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            /* background: linear-gradient(135deg, #6e8efb, #a777e3); */
            color: white;
            padding: 20px 0;
            position: sticky;
            width: 100%;
            top: 0;
            z-index: 1;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: 600;
        }

        .nav-links {
            display: flex;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .nav-links a:hover {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }
        .main{
            width:100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            width: 90%;
            max-width: 800px;
            /* background-color: white; */
            /* background: rgba(255, 255, 255, 0.1); */
            padding: 20px;
            backdrop-filter: blur(20px);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            animation: slideIn 1s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        h1 {
            text-align: center;
            margin-bottom: 5px;
            animation: fadeIn 2s ease-in;
            text-transform: capitalize;
        }
        .subtitle {
            text-align: center;
            font-style: italic;
            margin-bottom: 20px;
            animation: fadeIn 2s ease-in;
        }
        .content {
            display: flex;
            justify-content: space-between;
            animation: fadeIn 2s ease-in;
        }
        .form-section {
            width: 60%;
            animation: fadeIn 2s ease-in;
        }
        .contact-section {
            width: 35%;
            animation: fadeIn 2s ease-in;
        }
        form {
            display: flex;
            flex-direction: column;
            animation: fadeIn 2s ease-in;
        }
        input, textarea,select {
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        textarea {
            height: 70px;
            resize: vertical;
        }
        button {
            background-color: #005f73;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        .contact-info {
            margin-top: 20px;
        }
        .social-icons {
            margin-top: 30px;
            display: flex;
            justify-content: left;
            gap: 20px;
        }
        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: #fff;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .facebook{
            background-color: #3b5998;;
        }
        .twitter{
            background-color:  #1da1f2;;
        }
        .linkedin{
            background-color: #0077b5;;
        }
        .instagram{
            background-color:  #e1306c;;
        }
        .social-icons a:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        @media (max-width: 768px) {
            .content {
                flex-direction: column;
            }
            .form-section, .contact-section {
                width: 100%;
            }
        }
        p#error, p#success {
            color: #ff3b2d;
            font-weight: bold;
            text-align: left;
        }
        p#success {
            color: #4caf50;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        *::-webkit-scrollbar {
            width: 0px;
        }
        * {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        textarea{
            resize: none;
        }
    </style>
</head>
<body>

<header>
        <div class="container1">
            <nav>
                <div class="logo">ArtStore</div>
                <div class="nav-links">
                    <a href="index.php">Home</a>
                    <a href="index.php">Features</a>
                    <a href="upload.php">Upload</a>
                    <a href="gallery.php">Gallery</a>
                    <a href="contact.php">Contact</a>
                    <a href="logout.php">
                        Logout
                        <!-- <img src="image/log.png" alt="Logout"> -->
                    </a>
                </div>
            </nav>
        </div>
    </header>
<div class="main">
<div class="container">
        <h1>contact</h1>
        <p class="subtitle">we want to hear from you</p>
        <div class="content">
            <div class="form-section">
                <!-- <h3>Send us an Email</h3> -->
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="text" placeholder="Name" name="name" autocomplete="off" required>
                    <input type="email" placeholder="Email Address" name="email" autocomplete="off" required>
                    <input type="tel" placeholder="Phone number" name="phone" autocomplete="off" max=11 required>
                    <select id="country" name="country" required>
                        <option value="" disabled selected>--Please choose a country--</option>
                    </select>
                    <textarea placeholder="Message" name="message" autocomplete="off" required></textarea>
                    <button type="submit">SEND</button>
                </form>
            </div>
            <div class="contact-section">
                <div class="contact-info">
                    <h3>Contact Details</h3>
                    <p>+91 9992132438</p>
                    <p>example@gamil.com</p>
                    <div class="social-icons">
                    <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="linkedin"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="instagram"><i class="fab fa-instagram"></i></a>
                    </div>
                    <?php if(isset($error)) echo "<p id='error'>$error</p>"; ?>
                    <?php if(isset($success)) echo "<p id='success'>$success</p>"; ?>
                </div>
            </div>
        </div>
        </div>
</body>
<script >
        document.addEventListener('DOMContentLoaded', () => {
    const selectElement = document.getElementById('country');

    fetch('https://restcountries.com/v3.1/all')
        .then(response => response.json())
        .then(data => {
            // Sort countries alphabetically by name
            data.sort((a, b) => a.name.common.localeCompare(b.name.common));

            data.forEach(country => {
                const option = document.createElement('option');
                option.value = country.cca2; // 2-letter country code
                option.textContent = country.name.common;
                selectElement.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching countries:', error));
});
    </script>
</html>
