<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.html");
    exit();
}

?>
<?php
include('connection.php');

#Fetch
$query = $db->prepare("SELECT blood_group, SUM(amount) as total_units FROM blood_stock WHERE approval_status = 'Approved' GROUP BY blood_group");
$query->execute();
$bloodStocks = $query->fetchAll(PDO::FETCH_OBJ);

#Fetch other summary data
$totalDonorsQuery = $db->prepare("SELECT COUNT(DISTINCT donor_id) as total_donors FROM blood_stock");
$totalDonorsQuery->execute();
$totalDonors = $totalDonorsQuery->fetch(PDO::FETCH_OBJ);

$totalRequestsQuery = $db->prepare("SELECT COUNT(*) as total_requests FROM request");
$totalRequestsQuery->execute();
$totalRequests = $totalRequestsQuery->fetch(PDO::FETCH_OBJ);

$approvedRequestsQuery = $db->prepare("SELECT COUNT(*) as approved_requests FROM request WHERE approval_status = 'Approved'");
$approvedRequestsQuery->execute();
$approvedRequests = $approvedRequestsQuery->fetch(PDO::FETCH_OBJ);

$totalBloodUnitsQuery = $db->prepare("SELECT SUM(amount) as total_blood_units FROM blood_stock WHERE approval_status = 'Approved'");
$totalBloodUnitsQuery->execute();
$totalBloodUnits = $totalBloodUnitsQuery->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Bank Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100">

    <!--Navigation-->
    <nav class="bg-blue-500 p-4 flex justify-between items-center">
        <h1 class="text-white text-2xl font-bold">Blood Bank Management System</h1>
        <a href="logout.php" class="text-white hover:underline">Logout</a>
    </nav>

    <div class="flex">
        <!--Sidebar-->
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

        <!--Main-->
        <div class="w-4/5 p-6">
            <!--Blood Stock-->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <?php foreach ($bloodStocks as $stock): ?>
                    <div class="bg-white shadow-md rounded-lg p-6 text-center">
                        <h2 class="text-red-500 text-3xl font-bold"><?= htmlspecialchars($stock->blood_group); ?></h2>
                        <p class="text-gray-700">Total: <?= htmlspecialchars($stock->total_units); ?> Bags </p>
                    </div>
                <?php endforeach; ?>
            </div>

            <!--Summary-->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white shadow-md rounded-lg p-6 text-center">
                    <h2 class="text-blue-500 text-xl font-bold">Total Donors</h2>
                    <p class="text-gray-700 text-2xl"><?= htmlspecialchars($totalDonors->total_donors); ?></p>
                </div>
                <div class="bg-white shadow-md rounded-lg p-6 text-center">
                    <h2 class="text-blue-500 text-xl font-bold">Total Requests</h2>
                    <p class="text-gray-700 text-2xl"><?= htmlspecialchars($totalRequests->total_requests); ?></p>
                </div>
                <div class="bg-white shadow-md rounded-lg p-6 text-center">
                    <h2 class="text-blue-500 text-xl font-bold">Approved Requests</h2>
                    <p class="text-gray-700 text-2xl"><?= htmlspecialchars($approvedRequests->approved_requests); ?></p>
                </div>
                <div class="bg-white shadow-md rounded-lg p-6 text-center">
                    <h2 class="text-blue-500 text-xl font-bold">Total Blood Bags</h2>
                    <p class="text-gray-700 text-2xl"><?= htmlspecialchars($totalBloodUnits->total_blood_units); ?></p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
