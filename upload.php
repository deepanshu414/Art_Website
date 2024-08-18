<?php
session_start();
require_once 'db_connect.php';
// Check if user is not logged in, redirect to login page
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("location: login.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $main_user_id=$_SESSION['user_id'];
    // error_reporting(0);
    $a = $_FILES['image']['name'];
    $b = $_POST['title'];
    $j = $_POST['artistname'];
    $k = $_POST['dimensions'];
    $d = $_POST['Orientation'];
    $e = $_POST['description'];
    $f = $_POST['size'];
    $g = $_POST['arttype'];
    $h = $_POST['sellingprice'];
    $i = $_POST['phoneno'];
    $l = $_POST['country'];
    $currentDate = date('Y-m-d');
    $c = getDbConnection();
        $query = "SELECT MAX(id) as last_id FROM imagedata";
        $result = $c->query($query);
    
        if ($result) {
            $row = $result->fetch_assoc();
            $lastId = $row['last_id'];
            $id=0;
            if ($lastId !== null) {
                $id=$lastId;
            } else {
                $id=0;
            }
        $target_dir = "uploads/"; 
        if (!file_exists($target_dir )) {
            mkdir($target_dir , 0777, true);
        } 
        
        $targeted = $target_dir . basename($_FILES["image"]["name"]);
        $path_info = pathinfo($targeted);
        $filename = $path_info['filename']; // The name of the file without extension (e.g., 'example')
        $extension = $path_info['extension']; 
        $main_id="~-~-~-~-~-".$id+1;
        $target_file=$target_dir.$filename.$main_id. "." .$extension;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $error= "File is not an image.";
            $uploadOk = 0;
        }
        // Check file size (limit to 10MB)
        if ($_FILES["image"]["size"] > 10000000) {
            $error= "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if(strtolower($imageFileType) != "jpg" && 
            strtolower($imageFileType) != "png" && 
            strtolower($imageFileType) != "jpeg" && 
            strtolower($imageFileType) != "gif" ) {
                $error ="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
    
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $error ="Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $insert = "INSERT INTO imagedata(Title,Artist_Name,Dimensions,Orientation,Description,Size,ArtType,SellingPrice,Phonenumber,Status,Date,image,Country,main_user_id) VALUES('$b','$j','$k','$d','$e','$f','$g','$h','$i','Active','$currentDate ','$a','$l','$main_user_id')";
                if ($c->query($insert) === TRUE) {
                } else {
                    $error = "Error: " . $c->error;
                }
            } else {
                $error= "Sorry, there was an error uploading your file.";
            }
        }
        } else {
            $error = "Error executing query: " . $c->error;
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload Art</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            /* background: url('https://t3.ftcdn.net/jpg/05/77/87/74/360_F_577877489_oQBPZV8680CWLSWDbBkfs6hC7dUgAQrR.jpg') no-repeat center center fixed; */
            background:url(image/background.jpg) no-repeat center center/cover;
            background-size: cover;
            color: #fff;
            margin: 0;
            opacity: 1px;
            padding: 0;
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
        .scroll-container {
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Align items at the top */
            height: 80vh; /* Full viewport height */
            overflow-y: auto; /* Enable vertical scroll */
            padding: 20px;
            position: relative;
        }
        .container {
            /* background: rgba(0, 0, 0, 0.7); */
            padding: 20px;
            border-radius: 10px;
            width: 100%;
            /* max-width: 600px; */
            /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); */
            animation: slideIn 1s ease-out;
        }
        h2 {
            margin-top: 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            animation: fadeIn 2s ease-in;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
            animation: fadeIn 2s ease-in;
        }
        input[type="text"], input[type="number"], textarea {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 5px 0 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #fff;
            color: #333;
            animation: fadeIn 2s ease-in;
        }
        textarea{
            resize: none;
        }
        input[type="file"] {
            margin: 10px 0;
        }
        input[type="submit"] {
            background: #ff6f61;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            animation: fadeIn 2s ease-in;
            transition: background 0.3s, transform 0.3s;
        }
        input[type="submit"]:hover {
            background: #ff3b2d;
            transform: scale(1.05);
        }
        p#error {
            color: #ff3b2d;
            font-weight: bold;
        }
        .image-preview {
            max-width: 300px;
            max-height: 300px;
            margin-right: 20px;
        }
        .image-details {
            color: #fff;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Hide the scrollbar but keep functionality */
        .scroll-container::-webkit-scrollbar {
            width: 0px;
        }
        .scroll-container {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
                /* Style the select element */
        select {
            width:100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            color: #333;
            font-size: 16px;
            appearance: none; /* Remove default styling in most browsers */
            -webkit-appearance: none; /* For WebKit browsers */
            -moz-appearance: none; /* For Firefox */
        }

        /* Style the select container to add a custom arrow */
        select::after {
            content: "▼";
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none; /* Ignore pointer events */
        }

        /* Style the select container */
        .select-container {
            position: relative;
            width: 100%;
            max-width: 600px; /* Adjust the width as needed */
        }

        /* Style the select container's background */
        .select-container::before {
            content: "";
            display: block;
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #fff;
            border-radius: 5px;
            z-index: -1;
        }

        /* Optional: Style the select dropdown options */
        select option {
            padding: 10px;
            background-color: #fff;
            color: #333;
        }
        *::-webkit-scrollbar {
            width: 0px;
        }
        * {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        /* Style the select element when focused */
        select:focus {
            border-color: #ff6f61;
            outline: none;
        }

        /* Optional: Add custom styles for selected option */
        select option:checked {
            background-color: #ff6f61;
            color: #fff;
        }

        image-preview-container{
            background: rgba(0, 0, 0, 0.7);
                    padding: 20px;
                    border-radius: 10px;
                    width: 100%;
                    max-width: 600px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
                    animation: slideIn 1s ease-out;
                    overflow:scroll;
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
    <div class="scroll-container">
        <div class="container">
            <h2>Upload Art</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" accept="image/*" required onchange="previewImage();"><br><br>
                <label for="title">Title</label>
                <input type="text" name="title" required><br><br>
                <label for="artistname">Artist Name</label>
                <input type="text" name="artistname" required><br><br>
                <input type="hidden" name="dimensions" id="dimensions" required>
                <input type="hidden" name="Orientation"  id="Orientation" required>
                <label>Description</label>
                <textarea name="description" required rows="5" cols="40"></textarea><br><br>
                <input type="hidden" name="size" id="size" required>
                <label>Art Type</label>
                <select name="arttype" id="arttype" required>
                    <option value="" disabled selected>Select an art type</option>
                    <option value="Painting">Painting</option>
                    <option value="Sculpture">Sculpture</option>
                    <option value="Photography">Photography</option>
                    <option value="Digital Art">Digital Art</option>
                    <option value="Printmaking">Printmaking</option>
                    <option value="Drawing">Drawing</option>
                    <option value="Mixed Media">Mixed Media</option>
                    <option value="Installation Art">Installation Art</option>
                    <option value="Collage">Collage</option>
                    <option value="Textile Art">Textile Art</option>
                </select><br><br>
                <label>Country</label>
                <select id="country" name="country" required>
                        <option value="" disabled selected>--Please choose a country--</option>
                    </select><br><br>
                <label>Selling Price</label>
                <input type="text" name="sellingprice" required><br><br>
                <label>Ref_no or Phone_no</label>
                <input type="number" name="phoneno" required><br><br>
                <input type="submit" value="Upload">
            </form>
            <?php if (isset($error)) echo "<p id='error'>$error</p>"; ?>
        </div>
    </div>
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
    <script>
        function previewImage() {
            const fileInput = document.getElementById('image');
            const setsize=document.getElementById("size");
            const setdimensions=document.getElementById("dimensions");
            const setorientation=document.getElementById("Orientation");
            const file = fileInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    setsize.value=(file.size / 1024).toFixed(2) + ' KB';
                    const img = new Image();
                    img.onload = function() {
                        setdimensions.value=this.width + ' x ' + this.height + ' pixels';
                        setorientation.value=(this.width > this.height) ? 'Landscape' : 'Portrait';
                    };
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
