<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="registration_from.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="h-screen w-screen bg-gray-100 pt-10">
    <div class="max-w-xl mx-auto bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
        <form class="flex-col space-y-4">
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Full Name</label>
                <input type="text" name="name" id="name" class="w-full p-2 border border-gray-300 rounded mt-1" required>
            </div>
            <div class="mb-4">
                <label for="username" class="block text-gray-700">Username</label>
                <input type="text" name="username" id="username" class="w-full p-2 border border-gray-300 rounded mt-1" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="w-full p-2 border border-gray-300 rounded mt-1" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="w-full p-2 border border-gray-300 rounded mt-1" required>
            </div>
            <div class="mb-4">
                <label for="age" class="block text-gray-700">Age</label>
                <input type="number" name="age" id="age" class="w-full p-2 border border-gray-300 rounded mt-1" required>
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-gray-700">Phone</label>
                <input type="text" name="phone" id="phone" class="w-full p-2 border border-gray-300 rounded mt-1" required>
            </div>
            <div class="mb-4">
                <label for="fitness_status" class="block text-gray-700">Fitness Status</label>
                <input type="text" name="fitness_status" id="fitness_status" class="w-full p-2 border border-gray-300 rounded mt-1" required>
            </div>
            <div class="mb-4">
                <label for="address" class="block text-gray-700">Address</label>
                <input type="text" name="address" id="address" class="w-full p-2 border border-gray-300 rounded mt-1" required>
            </div>
            <div class="mb-4">
                <label for="nid" class="block text-gray-700">National ID (NID)</label>
                <input type="text" name="nid" id="nid" class="w-full p-2 border border-gray-300 rounded mt-1" required>
            </div>
            <div class="mb-4">
                <input name="register" type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-700" formmethod="POST" value="Register">
            </div>
        </form>
    </div>
</div>
</body>
</html>
<?php
include('connection.php');

if (isset($_POST['register'])) {
    #form data (using post)
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $age = $_POST['age'];
    $phone = $_POST['phone'];
    $fitness_status = $_POST['fitness_status'];
    $address = $_POST['address'];
    $nid = $_POST['nid'];

    #is already registered
    $checkQuery = $db->prepare("SELECT * FROM USER WHERE email = :email OR username = :username");
    $checkQuery->bindParam(':email', $email);
    $checkQuery->bindParam(':username', $username);
    $checkQuery->execute();

    if ($checkQuery->rowCount() > 0) {
        echo "This email or username is already registered. Please use a different email or username.";
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

       
        $query = $db->prepare("INSERT INTO USER (NID, name, age, email, phone, fitness_status, address, username, password_hash) 
                               VALUES (:nid, :name, :age, :email, :phone, :fitness_status, :address, :username, :password_hash)");
        $query->bindParam(':nid', $nid);
        $query->bindParam(':name', $name);
        $query->bindParam(':age', $age);
        $query->bindParam(':email', $email);
        $query->bindParam(':phone', $phone);
        $query->bindParam(':fitness_status', $fitness_status);
        $query->bindParam(':address', $address);
        $query->bindParam(':username', $username);
        $query->bindParam(':password_hash', $password_hash);

        if ($query->execute()) {
            echo "Registration successful!";
            
        } else {
            echo "There was an error during registration. Please try again.";
        }
    }
}
?>
