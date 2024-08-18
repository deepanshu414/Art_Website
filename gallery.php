<?php
session_start();
require_once 'db_connect.php';
// Check if user is not logged in, redirect to login page
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            /* background: grey; */
            /* background:url(https://www.chromethemer.com/download/hd-wallpapers/blue-space-3840x2160.jpg); */
            background: #005f73;
            color: white;
            background-size: cover;
            /* overflow: hidden; */
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

        *::-webkit-scrollbar {
            width: 0px;
        }
        * {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        .row {
        display: -ms-flexbox; /* IE10 */
        display: flex;
        -ms-flex-wrap: wrap; /* IE10 */
        flex-wrap: wrap;
        padding: 0 4px;
        }

        /* Create four equal columns that sits next to each other */
        .column {
        -ms-flex: 25%; /* IE10 */
        flex: 25%;
        max-width: 25%;
        padding: 0 4px;
        }

        .column img {
        margin-top: 8px;
        vertical-align: middle;
        width: 100%;
        cursor: pointer;
        transform: scale(1);
        }
        .column img:hover{
            transform: scale(1.05);
        }

        /* Responsive layout - makes a two column-layout instead of four columns */
        @media screen and (max-width: 800px) {
        .column {
            -ms-flex: 50%;
            flex: 50%;
            max-width: 50%;
        }
        }

        /* Responsive layout - makes the two columns stack on top of each other instead of next to each other */
        @media screen and (max-width: 600px) {
        .column {
            -ms-flex: 100%;
            flex: 100%;
            max-width: 100%;
        }
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            overflow: auto;
            backdrop-filter: blur(5px);
        }

        .modal-content {
            display: flex;
            margin: 5% auto;
            width: 80%;
            height: 80%;
            background-color: #fefefe;
            border-radius: 10px;
            overflow: hidden;
        }

        .modal-image {
            flex: 2;
            max-width: 70%;
            object-fit: contain;
            background-color: black;
        }

        .modal-info {
            flex: 1;
            padding: 20px;
            background-color: #fff;
            color: #333;
            overflow-y: auto;
            width: 20%;
            height: 80%;    
        }
        h2#imageTitle{
            width: 100%;
            height: 8%;
            overflow-y: auto;
            overflow-x: hidden;
            word-wrap: break-word;
            white-space: pre-wrap;
        }
        p#imageDescription{
            width: 100%;
            height: 80%;
            overflow-y: auto;
            overflow-x: hidden;
            word-wrap: break-word;
            white-space: pre-wrap;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none;
        }
        p#imageDescription::-webkit-scrollbar { 
            display: none;  /* WebKit browsers (Safari, Chrome) */
        }
        .close {
            color: red;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            border: none; /* Remove any border if present */
            transform: translate3d(15px, 10px, 15px);
            transition: background-color 0.3s ease;
            width: 0%;
        }

        .close:hover,
        .close:focus {
            color: #d70000;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<header>
        <div class="container">
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
<?php
$uploadDir = 'uploads/'; 
$images = glob($uploadDir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
$c = getDbConnection();
echo '<div class="row" id="imageGallery">';

$columnCount = 0;
$imageCount = 0;

foreach ($images as $image) {
    if ($imageCount % 1 == 0) {
        if ($columnCount > 0) {
            echo '</div>';
        }
        echo '<div class="column">';
        $columnCount++;
    }
        $idcheck=1;
        if (preg_match('/~-~-~-~-~-(.+)\.\w+$/', basename($image), $matches)) {
            $idcheck = $matches[1]; 
        } else {
            $idcheck=1;
        }
        $e='select * from imagedata where id ='. $idcheck;
        $r=mysqli_query($c,$e);
        $co=mysqli_fetch_assoc($r);
        echo '<img src="' . $image . '" alt="' .$co['Title'] . '" class="image" title="' .$co['Artist_Name'] . '" onclick="openModal(this.src, \'' . basename($image) . '\')"><br>';        
        echo "<input type='hidden' name='title' id='title' value='" . $co['Title'] . "'>";
        echo "<input type='hidden' name='des' id='des' value='" . $co['Description'] . "'>";
        echo "<input type='hidden' name='title' id='artname' value='" . $co['Artist_Name'] . "'>";
        echo "<input type='hidden' name='des' id='dim' value='" . $co['Dimensions'] . "'>";
        echo "<input type='hidden' name='title' id='orie' value='" . $co['Orientation'] . "'>";
        echo "<input type='hidden' name='des' id='size' value='" . $co['Size'] . "'>";
        echo "<input type='hidden' name='des' id='arttype' value='" . $co['ArtType'] . "'>";
        echo "<input type='hidden' name='title' id='sell' value='" . $co['SellingPrice'] . "'>";
        echo "<input type='hidden' name='des' id='phone' value='" . $co['Phonenumber'] . "'>";
        echo "<input type='hidden' name='title' id='status' value='" . $co['Status'] . "'>";
        echo "<input type='hidden' name='des' id='date' value='" . $co['Date'] . "'>";
        echo "<input type='hidden' name='cout' id='cout' value='" . $co['Country'] . "'>";
    }
    $imageCount++;
if ($imageCount % 1 != 0) {
    echo '</div>';
}
echo '</div>';
?>
<div id="imageModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <img src="" alt="Modal Image" class="modal-image" id="modalImage">
        <div class="modal-info" id="modalInfo">
        <h2 id="imageTitle"></h2>
        <p id="imageDescription">  </p>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.column').forEach(section => {
    section.querySelector('.image').addEventListener('click', function() {
        const title=document.getElementById('imageTitle');
        const desc=document.getElementById('imageDescription');
        const hiddentitle = section.querySelector('#title').value;
        const hiddendis = section.querySelector('#des').value;
        const hiddenartname = section.querySelector('#artname').value;
        const hiddendim = section.querySelector('#dim').value;
        const hiddenori = section.querySelector('#orie').value;
        const hiddensize = section.querySelector('#size').value;
        const hiddenarttype = section.querySelector('#arttype').value;
        const hiddensell = section.querySelector('#sell').value;
        const hiddenphone = section.querySelector('#phone').value;
        const hiddenstatus = section.querySelector('#status').value;
        const hiddendate = section.querySelector('#date').value;
        const hiddencout = section.querySelector('#cout').value;
        title.innerText=hiddentitle;
        desc.innerHTML="Artist_Name : "+hiddenartname+"<br>Date : "+hiddendate+"<br>Status : "+hiddenstatus+"<br>Dimensions : "+hiddendim+"<br>Orientation : "+hiddenori+"<br>Size : "+hiddensize+"<br>Art_Type : "+hiddenarttype+"<br>Country : "+hiddencout+"<br>Selling_Price : "+hiddensell+"<br>Phone_Number : "+hiddenphone+"<br>Discription : "+hiddendis;
    });
    });
function openModal(imageSrc, imageName) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    // const title=document.getElementById('imageTitle');
    // const desc=document.getElementById('imageDescription');
    // const hiddentitle=document.getElementById('title');
    // const hiddendis=document.getElementById('des').value;
    // const hiddenartname=document.getElementById('artname').value;
    // const hiddendim=document.getElementById('dim').value;
    // const hiddenori=document.getElementById('orie').value;
    // const hiddensize=document.getElementById('size').value;
    // const hiddenarttype=document.getElementById('arttype').value;
    // const hiddensell=document.getElementById('sell').value;
    // const hiddenphone=document.getElementById('phone').value;
    // const hiddenstatus=document.getElementById('status').value;
    // const hiddendate=document.getElementById('date').value;
    // const hiddencout=document.getElementById('cout').value;
    modal.style.display = "block";
    modalImg.src = imageSrc;
    // title.innerText=hiddentitle.value;
    // desc.innerHTML="Artist_Name : "+hiddenartname+"<br>Date : "+hiddendate+"<br>Status : "+hiddenstatus+"<br>Dimensions : "+hiddendim+"<br>Orientation : "+hiddenori+"<br>Size : "+hiddensize+"<br>Art_Type : "+hiddenarttype+"<br>Country : "+hiddencout+"<br>Selling_Price : "+hiddensell+"<br>Phone_Number : "+hiddenphone+"<br>Discription : "+hiddendis;
}

function closeModal() {
    document.getElementById('imageModal').style.display = "none";
}

// Close modal when clicking outside of it
window.onclick = function(event) {
    const modal = document.getElementById('imageModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
</body>
</html>
