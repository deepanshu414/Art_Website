<?php
session_start();
require_once 'db_connect.php';
// Redirect if already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: index.php");
    exit;
}



// Function to safely get POST data
function getPostData($key) {
    return isset($_POST[$key]) ? trim($_POST[$key]) : '';
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = getPostData('email');
    $password = getPostData('password');

    $conn = getDbConnection();
    // $query = "SELECT MAX(id) as last_id FROM loggin";
    // $result = $conn->query($query);

    // if ($result) {
    //     $row = $result->fetch_assoc();
    //     $lastId = $row['last_id'];
    //     $id=0;
    //     if ($lastId !== null) {
    //         $id=$lastId;
    //     } else {
    //         $id=0;
    //     }
    //     $_SESSION=
    // }
    // Check if user exists
    $stmt = $conn->prepare("SELECT * FROM login WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // User exists, attempt login
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['Password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php");
            exit;
        } else {
            $firstname = getPostData('firstname');
            $lastname = getPostData('lastname');
            if ($firstname==null && $lastname==null) {
                $error = "Invalid email or password. Fill all fields to signup";
        }
        else{
            $fullname = $firstname . " " . $lastname;
            // User doesn't exist, create new account
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO login (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $fullname, $email, $hashed_password);
            if ($stmt->execute()) {
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $conn->insert_id;
                header("Location: index.php");
                exit;
            } else {
                $error = "Error creating account: " . $conn->error;
            }
        }
        }
    } else {
        $firstname = getPostData('firstname');
        $lastname = getPostData('lastname');
        if ($firstname==null && $lastname==null) {
            $error = "Invalid email or password. Fill all fields to signup";
        }
        else{
            $fullname = $firstname . " " . $lastname;
            // User doesn't exist, create new account
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO login (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $fullname, $email, $hashed_password);
            if ($stmt->execute()) {
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $conn->insert_id;
                header("Location: index.php");
                exit;
            } else {
                $error = "Error creating account: " . $conn->error;
            }
        }
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Sign Up</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            /* background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab); */
            background:url(image/login_backgroung.jpeg) no-repeat center center/cover;
            background-size: 400% 400%;
            color:black;
            /* animation: gradient 15s ease infinite; */
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        .container {
            width: 380px;
            padding: 30px;
            background-color: #272b33;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 1s ease forwards;
        }
        h1 {
            font-size: 14px;
            color: #a0a0a0;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
            
        }
        h2 {
            font-size: 32px;
            margin-top: 0;
            margin-bottom: 5px;
            font-weight: 600;
            color: white;
            font-family: auto;
            animation: fadeInUp 1s ease forwards;
        }
        p {
            font-size: 14px;
            color: #a0a0a0;
            margin-bottom: 25px;
            animation: fadeInUp 1s ease forwards;
        }
        .log-in {
            color: #3498db;
            text-decoration: none;
            font-weight: 600;
        }
        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            background-color: #2c3038;
            border: 1px solid #3a3f48;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            box-sizing: border-box;
            animation: fadeInUp 1s ease forwards;
        }
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .name-inputs {
            display: flex;
            justify-content: space-between;
        }
        .name-inputs input {
            width: 48%;
        }
        .password-input {
            position: relative;
        }
        .password-input input {
            padding-right: 40px;
        }
        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            color: #a0a0a0;
            cursor: pointer;
            user-select: none;
            transform: translateY(-20px);
        }
        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
        }
        button {
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .change-method {
            background-color: #3a3f48;
            color: white;
        }
        .change-method:hover {
            background-color: #4a5058;
        }
        .create-account {
            background-color: #3498db;
            color: white;
        }
        .create-account:hover {
            background-color: #2980b9;
        }
        #error {
            color: #ff4444;
            text-align: center;
            margin-top: 1rem;
            cursor:progress; 
        }
        a{
            cursor:pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h2>Login / Sign Up</h2>
            <p>New user? Fill all fields to sign up. Existing user? Enter email and password to log in.</p>
            <div class="name-inputs">
                <input type="text" placeholder="First name" name="firstname" value="">
                <input type="text" placeholder="Last name" name="lastname" value="">
            </div>
            <input type="email" placeholder="Email" name="email" required>
            <div class="password-input">
                <input type="password" id="password" placeholder="Password" name="password" required>
                <span class="password-toggle" onclick="togglePassword()">👁️</span>
            </div>
            <div class="buttons">
                <button type="submit" class="create-account">Login / Sign Up</button>
            </div>
            <?php if(!empty($error)) echo "<p id='error'>$error</p>"; ?>
        </form>
    </div>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordToggle = document.querySelector('.password-toggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordToggle.textContent = '👁️‍🗨️';
            } else {
                passwordInput.type = 'password';
                passwordToggle.textContent = '👁️';
            }
        }
    </script>
</body>
</html>