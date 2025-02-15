<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://cdn.tailwindcss.com"></script>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="dark:bg-gradient-to-l from-gray-900 to-gray-600 flex justify-center items-center w-screen h-screen p-5">
    <div class="bg-white shadow-md dark:shadow-gray-600 rounded px-8 pt-6 pb-8 mb-4 flex flex-col w-full md:w-1/3 dark:bg-gray-800">
        <h1 class="text-2xl font-semibold mb-4 text-center text-gray-900 dark:text-gray-200">Login</h1>
        <form action="" method="post">
          <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-400 text-sm font-bold mb-2" for="email">
                    Email <span class="text-red-500">*</span>
              </label>
            <span class="mb-6">
                <input class="shadow appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" name="un" id="email" type="email" placeholder="Email">
            </span></div>
          <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-400 text-sm font-bold mb-2" for="password">
                    Password <span class="text-red-500">*</span>
              </label>
            <span class="mb-4">
            <input class="shadow appearance-none border border-red-500 rounded-md w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" name="ps" id="password" type="password" placeholder="******************">
          </span></div>
            <div class="flex items-center justify-between">
            	<input class="bg-green-500 hover:bg-green-700 text-white w-full font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline dark:bg-green-600" type="submit"  value="Login" name="sub"> 
            </div>
        </form>
        
        <div class="mt-4 text-center">
            <a href="register.php" class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">Don't have an account? Register here</a>
        </div>
    </div>
</div>      
<?php
session_start();
include('connection.php');

if (isset($_POST['sub'])) {
    $un = $_POST['un']; 
    $ps = $_POST['ps'];

    #Checking email pass
    $q = $db->prepare("SELECT * FROM user WHERE email = :un");
    $q->bindParam(':un', $un);
    $q->execute();
    $user = $q->fetch(PDO::FETCH_OBJ);

    #if user exists
    if ($user) {
        if (password_verify($ps, $user->password_hash)) {
            # check if admin
            $q = $db->prepare("SELECT * FROM admin WHERE NID = :nid");
            $q->bindParam(':nid', $user->NID);
            $q->execute();
            $admin = $q->fetch(PDO::FETCH_OBJ);

            if ($admin) {
                echo "Login successful!";
                #session var admin
                $_SESSION['admin_id'] = $admin->admin_id;
                $_SESSION['username'] = $user->username;

                header("Location: admin_dashboard.php");
                exit();
            } else {
                echo "You do not have admin privileges.";
                #session var admin
                $_SESSION['user_id'] = $user->NID;
                $_SESSION['username'] = $user->username;

                header("Location: user_landing.php");
                exit();
            }
        } else {
            echo "Incorrect password.";
        }
    } else {

        echo "User not found.";
    }
}
?>
</body>
</html>