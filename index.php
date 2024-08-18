<?php
session_start();

// Check if user is not logged in, redirect to login page
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArtStore - Your Digital Art Gallery</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f0f0;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            /* background: linear-gradient(135deg, #6e8efb, #a777e3); */
            background:url(image/background.jpg) no-repeat center center/cover;
            color: white;
            padding: 20px 0;
            position: sticky;
            width: 100%;
            top: 0;
            z-index: 1;
            overflow:scroll;
        }
        header::-webkit-scrollbar {
            width: 0px;
        }
        header {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
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
        .nav-links a img{
            width:50%;
            float: right;
        }
        .nav-links a img:hover{
            background: rgba(255, 255, 255, 0.1);
            border-radius: 100%;
        }
        .nav-links a:hover {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }

        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            /* background: url('https://source.unsplash.com/random/1920x1080?art') no-repeat center center/cover; */
            background:url(image/background.jpg) no-repeat center center/cover;
            position: relative;
            overflow: hidden;
            z-index: 0;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        .hero-content {
            position: relative;
            z-index: 1;
            color: white;
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 1s ease forwards;
        }

        .hero p {
            font-size: 20px;
            margin-bottom: 30px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 1s ease 0.5s forwards;
        }

        .btn {
            display: inline-block;
            background: #6e8efb;
            color: white;
            padding: 10px 30px;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 1s ease 1s forwards;
        }

        .btn:hover {
            background: #a777e3;
        }
        *::-webkit-scrollbar {
            width: 0px;
        }
        * {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .features {
            padding: 80px 0;
            background: white;
        }

        .features h2 {
            text-align: center;
            margin-bottom: 40px;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .feature-item {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .feature-item i {
            font-size: 40px;
            color: #6e8efb;
            margin-bottom: 20px;
        }

        footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 20px 0;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <div class="logo">ArtStore</div>
                <div class="nav-links">
                    <a href="index.php">Home</a>
                    <a href="#features">Features</a>
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
    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Welcome to ArtStore</h1>
            <p>Discover and collect unique digital artworks</p>
            <a href="gallery.php" class="btn">Explore Gallery</a>
        </div>
    </section>

    <section class="features" id="features">
        <div class="container">
            <h2>Our Features</h2>
            <div class="feature-grid">
                <div class="feature-item">
                    <i class="fas fa-palette"></i>
                    <h3>Unique Artworks</h3>
                    <p>Discover one-of-a-kind digital masterpieces.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-user-shield"></i>
                    <h3>Secure Transactions</h3>
                    <p>Buy and sell with confidence on our platform.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-globe"></i>
                    <h3>Global Community</h3>
                    <p>Connect with artists and collectors worldwide.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-coins"></i>
                    <h3>NFT Support</h3>
                    <p>Trade and collect NFTs with ease.</p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2024 ArtStore. All rights reserved.</p>
        </div>
    </footer>

    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>
