<?php

session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

include('connection.php');

#Fetch
$query = $db->prepare("SELECT * FROM donor");
$query->execute();
$donors = $query->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!--Navigation-->
    <nav class="bg-blue-500 p-4 flex justify-between items-center">
        <h1 class="text-white text-2xl font-bold">Blood Bank Management System</h1>
        <a href="logout.php" class="text-white hover:underline">Logout</a>
    </nav>

    <div class="flex">
        <!-- Sidebar-->
        <div class="w-1/5 bg-gray-800 text-white h-screen p-4">
            <ul class="space-y-4">
                <li><a href="admin_dashboard.php" class="flex items-center space-x-2"><i class="fas fa-home"></i><span>Home</span></a></li>
                <li><a href="donor_list.php" class="flex items-center space-x-2"><i class="fas fa-user"></i><span>Donor</span></a></li>
                <li><a href="patient_list.php" class="flex items-center space-x-2"><i class="fas fa-user"></i><span>Patient</span></a></li>
                <li><a href="donations.php" class="flex items-center space-x-2"><i class="fas fa-donate"></i><span>Donations</span></a></li>
                <li><a href="blood_request.php" class="flex items-center space-x-2"><i class="fas fa-burn"></i><span>Blood Requests</span></a></li>
                <li><a href="request_history.php" class="flex items-center space-x-2"><i class="fas fa-history"></i><span>Request History</span></a></li>
            </ul>
        </div>

    <!--Main -->
    <div class="container mx-auto mt-10">
        <h2 class="text-2xl font-bold text-center mb-6">Donor List</h2>
        
        <!--Donor Table-->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="py-2 px-4 border">Donor ID</th>
                        <th class="py-2 px-4 border">Last Date of Donation</th>
                        <th class="py-2 px-4 border">Amount Donated (Bags)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($donors as $donor): ?>
                    <tr class="text-center">
                        <td class="py-2 px-4 border"><?= htmlspecialchars($donor->donor_id); ?></td>
                        <td class="py-2 px-4 border"><?= htmlspecialchars($donor->last_date_of_donation); ?></td>
                        <td class="py-2 px-4 border"><?= htmlspecialchars($donor->amount_donated); ?> </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
