<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

$nid = $_SESSION['user_id'];  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor or Recipient</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.1/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-7xl mx-auto mt-10 bg-white shadow-lg rounded-lg overflow-hidden relative">
        
        <!--Logout History Section-->
        <div class="flex justify-between px-6 py-4 bg-gray-900 text-white">
            <div class="text-2xl font-bold uppercase">Choose Your Role</div>
            <!--Logoutlink-->
            <a href="logout.php" class="text-white font-bold hover:text-gray-400">Logout</a>
        </div>

        <!--Main-->
        <div class="w-3/4 py-4 px-8">
            <form class="py-4 px-6" method="post" action="user_landing.php">
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">
                        <input type="radio" name="user_type" value="donor" required> Are you a Donor?
                    </label>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">
                        <input type="radio" name="user_type" value="recipient" required> Are you a Recipient?
                    </label>
                </div>
                <div class="flex items-center justify-center mb-4">
                    <button
                        class="bg-gray-900 text-white py-2 px-4 rounded hover:bg-gray-800 focus:outline-none focus:shadow-outline"
                        type="submit" name="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <?php
    include('connection.php');
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_type'])) {
        $user_type = $_POST['user_type'];

        if ($user_type == 'donor') {
            echo '<div class="max-w-7xl mx-auto mt-10 bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="text-2xl py-4 px-6 bg-gray-900 text-white text-center font-bold uppercase">
                    Donor Form
                </div>
                <form class="py-4 px-6" method="post" action="user_landing.php">
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="last_donation_date">Date of Donation</label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            type="date" id="last_donation_date" name="last_donation_date" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="amount_of_blood">Amount of Blood Donation (Bag)</label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            type="number" id="amount_of_blood" name="amount_of_blood" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="blood_group">Blood Group</label>
                        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                            id="blood_group" name="blood_group" required>
                            <option value="">Select your blood group</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                    <input type="hidden" name="user_type" value="donor">
                    <input type="hidden" name="donate_button" value="1">
                    <div class="flex items-center justify-center mb-4">
                        <button
                            class="bg-gray-900 text-white py-2 px-4 rounded hover:bg-gray-800 focus:outline-none focus:shadow-outline"
                            type="submit" name="donate_button">Submit</button>
                    </div>
                </form>
            </div>';
        } elseif ($user_type == 'recipient') {
            echo '<div class="max-w-7xl mx-auto mt-10 bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="text-2xl py-4 px-6 bg-gray-900 text-white text-center font-bold uppercase">
                    Recipient Form
                </div>
                <form class="py-4 px-6" method="post" action="user_landing.php">
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="amount_required">Amount Required (Bag)</label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            type="number" id="amount_required" name="amount_required" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="blood_group">Blood Group</label>
                        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                            id="blood_group" name="blood_group" required>
                            <option value="">Select your blood group</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="medical_history">Medical History</label>
                        <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="medical_history" name="medical_history" required></textarea>
                    </div>
                    <input type="hidden" name="user_type" value="recipient">
                    <input type="hidden" name="recieve_button" value="1">
                    <div class="flex items-center justify-center mb-4">
                        <button
                            class="bg-gray-900 text-white py-2 px-4 rounded hover:bg-gray-800 focus:outline-none focus:shadow-outline"
                            type="submit" name="recieve_button">Submit</button>
                    </div>
                </form>
            </div>';
        }
    }

    #Display submitted data
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['donate_button'])) {
        $user_type = $_POST['user_type'];

        if ($user_type == 'donor') {
            $last_donation_date = $_POST['last_donation_date'];
            $amount_of_blood = $_POST['amount_of_blood'];
            $blood_group = $_POST['blood_group'];

            echo "<div class='max-w-4xl mx-auto mt-10 bg-white shadow-lg rounded-lg overflow-hidden'>
                    <div class='text-2xl py-4 px-6 bg-gray-900 text-white text-center font-bold uppercase'>Donor Information Submitted</div>
                    <div class='py-4 px-6'>
                        <p>Date of Donation: " . htmlspecialchars($last_donation_date) . "</p>
                        <p>Amount of Blood Donation: " . htmlspecialchars($amount_of_blood) . " bag</p>
                        <p>Blood Group: " . htmlspecialchars($blood_group) . "</p>
                    </div>
                  </div>";
        } elseif ($user_type == 'recipient') {
            $amount_required = $_POST['amount_required'];
            $blood_group = $_POST['blood_group'];
            $medical_history = $_POST['medical_history'];

            echo "<div class='max-w-4xl mx-auto mt-10 bg-white shadow-lg rounded-lg overflow-hidden'>
                    <div class='text-2xl py-4 px-6 bg-gray-900 text-white text-center font-bold uppercase'>Recipient Information Submitted</div>
                    <div class='py-4 px-6'>
                        <p>Amount Required: " . htmlspecialchars($amount_required) . " bag</p>
                        <p>Blood Group: " . htmlspecialchars($blood_group) . "</p>
                        <p>Medical History: " . htmlspecialchars($medical_history) . "</p>
                    </div>
                  </div>";
        }
    }
    ?>

<?php
try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        #Donor form submission
        if (isset($_POST['donate_button'])) {
            $last_donation_date = htmlspecialchars($_POST['last_donation_date']);
            $amount_of_blood = (int)$_POST['amount_of_blood'];
            $blood_group = htmlspecialchars($_POST['blood_group']);

            #Check donor exists in donor table on NID
            $query = $db->prepare("SELECT donor_id, amount_donated FROM donor WHERE NID = :nid");
            $query->bindParam(':nid', $nid);
            $query->execute();
            $donor = $query->fetch(PDO::FETCH_OBJ);

            if ($donor) {
                #Donor exists update total amount donated last donation date
                $donor_id = $donor->donor_id;
                $new_total_amount = $donor->amount_donated + $amount_of_blood;

                $updateDonor = $db->prepare("UPDATE donor SET amount_donated = :new_total_amount, last_date_of_donation = :last_donation_date WHERE donor_id = :donor_id");
                $updateDonor->bindParam(':new_total_amount', $new_total_amount);
                $updateDonor->bindParam(':last_donation_date', $last_donation_date);
                $updateDonor->bindParam(':donor_id', $donor_id);
                $updateDonor->execute();
            } else {
                #Donor doesn't exist insert new donor record
                $insertDonor = $db->prepare("INSERT INTO donor (NID, last_date_of_donation, amount_donated) 
                                             VALUES (:nid, :last_donation_date, :amount_donated)");
                $insertDonor->bindParam(':nid', $nid);
                $insertDonor->bindParam(':last_donation_date', $last_donation_date);
                $insertDonor->bindParam(':amount_donated', $amount_of_blood);
                $insertDonor->execute();

                #Getting new inserted donor id
                $donor_id = $db->lastInsertId();
            }

            #Insert blood donation details in blood stock table
            $insertBloodStock = $db->prepare("INSERT INTO blood_stock (blood_group, date_of_collection, amount, donor_id, approval_status) 
                                              VALUES (:blood_group, :date_of_collection, :amount, :donor_id, 'Pending')");
            $insertBloodStock->bindParam(':blood_group', $blood_group);
            $insertBloodStock->bindParam(':date_of_collection', $last_donation_date);
            $insertBloodStock->bindParam(':amount', $amount_of_blood);
            $insertBloodStock->bindParam(':donor_id', $donor_id);

            if ($insertBloodStock->execute()) {
                echo "<p>Donor information and donation submitted successfully!</p>";
            } else {
                echo "<p>Error submitting donor information. Please try again.</p>";
            }
        }

        #Recipientform submission
        elseif (isset($_POST['recieve_button'])) {
            #Get form data
            $blood_group = $_POST['blood_group'];
            $medical_history = $_POST['medical_history'];
            $amount_required = $_POST['amount_required'];

            #Inserting recipient data in recipient table
            $insertRecipient = $db->prepare("INSERT INTO recipient (NID, medical_history, amount_required, blood_group) 
                                             VALUES (:nid, :medical_history, :amount_required, :blood_group)");
            $insertRecipient->bindParam(':nid', $nid);
            $insertRecipient->bindParam(':medical_history', $medical_history);
            $insertRecipient->bindParam(':amount_required', $amount_required);
            $insertRecipient->bindParam(':blood_group', $blood_group);
            $insertRecipient->execute();

            #Retriv last inserted recipient id
            $recipient_id = $db->lastInsertId();

            #Find available matching blood in bloodstock
            $queryBloodStock = $db->prepare("SELECT * FROM blood_stock WHERE blood_group = :blood_group AND amount >= :amount_required AND approval_status = 'Approved' LIMIT 1");
            $queryBloodStock->bindParam(':blood_group', $blood_group);
            $queryBloodStock->bindParam(':amount_required', $amount_required);
            $queryBloodStock->execute();
            $blood_stock = $queryBloodStock->fetch(PDO::FETCH_OBJ);

            if ($blood_stock) {
                #Blood available insert in request table
                $serial_no = $blood_stock->serial_no;
                $donor_id = $blood_stock->donor_id;

                $insertRequest = $db->prepare("INSERT INTO request (serial_no, donor_id, recipient_id, approval_status) 
                                               VALUES (:serial_no, :donor_id, :recipient_id, 'Pending')");
                $insertRequest->bindParam(':serial_no', $serial_no);
                $insertRequest->bindParam(':donor_id', $donor_id);
                $insertRequest->bindParam(':recipient_id', $recipient_id);

                if ($insertRequest->execute()) {
                    echo "<p>Recipient and request created successfully!</p>";
                } else {
                    echo "<p>Error creating the request.</p>";
                }
            } else {
              
                echo "<p>No matching blood available.</p>";
            }
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

</body>
</html>
