<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

include('connection.php');

#approval or rejection
if (isset($_POST['approve'])) {
    $request_id = $_POST['request_id'];
    $quantity_requested = $_POST['quantity_requested'];
    $serial_no = $_POST['serial_no'];

    #Deduct blood quantity from the stock
    $updateStock = $db->prepare("UPDATE blood_stock SET amount = amount - :amount WHERE serial_no = :serial_no");
    $updateStock->bindParam(':amount', $quantity_requested);
    $updateStock->bindParam(':serial_no', $serial_no);
    $updateStock->execute();

    #Update request status to Approved
    $approveRequest = $db->prepare("UPDATE request SET approval_status = 'Approved' WHERE request_id = :request_id");
    $approveRequest->bindParam(':request_id', $request_id);
    $approveRequest->execute();
}

if (isset($_POST['reject'])) {
    $request_id = $_POST['request_id'];
    #Update the request Rejected
    $rejectRequest = $db->prepare("UPDATE request SET approval_status = 'Rejected' WHERE request_id = :request_id");
    $rejectRequest->bindParam(':request_id', $request_id);
    $rejectRequest->execute();
}

#Fetch
$query = $db->prepare("
    SELECT r.request_id, r.serial_no, r.donor_id, r.recipient_id, r.approval_status, bs.blood_group, rec.amount_required
    FROM request r
    JOIN blood_stock bs ON r.serial_no = bs.serial_no
    JOIN recipient rec ON r.recipient_id = rec.recipient_id
	WHERE r.approval_status != 'Pending'
");
$query->execute();
$requests = $query->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request History</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navigation -->
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

    <!--Main-->
    <div class="container mx-auto mt-10">
        <h2 class="text-2xl font-bold text-center mb-6">Request History</h2>

        <!--Blood Request Table-->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="py-2 px-4 border">Request ID</th>
                        <th class="py-2 px-4 border">Donor ID</th>
                        <th class="py-2 px-4 border">Recipient ID</th>
                        <th class="py-2 px-4 border">Blood Group</th>
                        <th class="py-2 px-4 border">Quantity Required (Bags)</th>
						<th class="py-2 px-4 border">Approval Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($requests as $request): ?>
                    <tr class="text-center">
                        <td class="py-2 px-4 border"><?= htmlspecialchars($request->request_id); ?></td>
                        <td class="py-2 px-4 border"><?= htmlspecialchars($request->donor_id); ?></td>
                        <td class="py-2 px-4 border"><?= htmlspecialchars($request->recipient_id); ?></td>
                        <td class="py-2 px-4 border"><?= htmlspecialchars($request->blood_group); ?></td>
                        <td class="py-2 px-4 border"><?= htmlspecialchars($request->amount_required); ?> Bags</td>
						<td class="py-2 px-4 border"><?= htmlspecialchars($request->approval_status); ?></td>
                   <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
