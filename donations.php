<?php
session_start();

#is admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

include('connection.php');

#approval or rejection is submitted
if (isset($_POST['approve']) || isset($_POST['reject'])) {
    $serial_no = $_POST['serial_no'];
    $status = isset($_POST['approve']) ? 'Approved' : 'Rejected';

    $updateStatus = $db->prepare("UPDATE blood_stock SET approval_status = :status WHERE serial_no = :serial_no");
    $updateStatus->bindParam(':status', $status);
    $updateStatus->bindParam(':serial_no', $serial_no);
    $updateStatus->execute();
}

#Fetch
$query = $db->prepare("SELECT * FROM blood_stock");
$query->execute();
$blood_stocks = $query->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dnations</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navigation-->
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

  <!-- Main -->
    <div class="container mx-auto mt-10">
        <h2 class="text-2xl font-bold text-center mb-6">Donations</h2>

        <!-- Blood Stock Table-->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="py-2 px-4 border">Serial No</th>
                        <th class="py-2 px-4 border">Blood Group</th>
                        <th class="py-2 px-4 border">Date of Collection</th>
                        <th class="py-2 px-4 border">Amount (Bags)</th>
                        <th class="py-2 px-4 border">Donor ID</th>
                        <th class="py-2 px-4 border">Approval Status</th>
                        <th class="py-2 px-4 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($blood_stocks as $blood_stock): ?>
                        <tr class="text-center">
                            <td class="py-2 px-4 border"><?= htmlspecialchars($blood_stock->serial_no); ?></td>
                            <td class="py-2 px-4 border"><?= htmlspecialchars($blood_stock->blood_group); ?></td>
                            <td class="py-2 px-4 border"><?= htmlspecialchars($blood_stock->date_of_collection); ?></td>
                            <td class="py-2 px-4 border"><?= htmlspecialchars($blood_stock->amount); ?> Bags</td>
                            <td class="py-2 px-4 border"><?= htmlspecialchars($blood_stock->donor_id); ?></td>
                            <td class="py-2 px-4 border"><?= htmlspecialchars($blood_stock->approval_status); ?></td>
                            <td class="py-2 px-4 border">
                                <?php if ($blood_stock->approval_status == 'Pending'): ?>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="serial_no" value="<?= $blood_stock->serial_no; ?>">
                                        <button type="submit" name="approve" class="bg-green-500 hover:bg-green-700 text-white py-1 px-2 rounded">Approve</button>
                                    </form>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="serial_no" value="<?= $blood_stock->serial_no; ?>">
                                        <button type="submit" name="reject" class="bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded">Reject</button>
                                    </form>
                                <?php else: ?>
                                    <?= htmlspecialchars($blood_stock->approval_status); ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
