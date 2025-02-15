    
<?php
#Database connection
$host = "localhost";  
$dbname = "bbms"; 
$username = "root"; 
$password = "";       

#PDO connection
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    #PDO error mode
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    #If error show the message
    echo "Connection failed: " . $e->getMessage();
}
?>
