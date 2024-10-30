<?php
// decrypt_qr.php
session_start();
require_once('config.php');

// Check if doctor is logged in
if (!isset($_SESSION['dname'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['encrypted_data'])) {
    $encrypted_data = $_POST['encrypted_data'];
    
    try {
        // Decrypt the data (using your encryption key from admin panel)
        $encryption_key = "your_encryption_key"; // Use the same key as in admin panel
        $decryption_method = "AES-256-CBC";
        
        // Split the encrypted data into IV and encrypted content
        list($encrypted_data, $iv) = explode('::', base64_decode($encrypted_data), 2);
        
        // Decrypt the data
        $decrypted_data = openssl_decrypt(
            $encrypted_data,
            $decryption_method,
            $encryption_key,
            0,
            $iv
        );
        
        // Parse the decrypted JSON data
        $patient_data = json_decode($decrypted_data, true);
        
        // Verify the data in database
        $pid = mysqli_real_escape_string($con, $patient_data['pid']);
        $query = "SELECT * FROM appointmenttb WHERE pid = '$pid' LIMIT 1";
        $result = mysqli_query($con, $query);
        
        if (mysqli_num_rows($result) > 0) {
            $db_data = mysqli_fetch_assoc($result);
            
            // Return the verified data
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'decrypted_data' => [
                    'pid' => $db_data['pid'],
                    'fname' => $db_data['fname'],
                    'lname' => $db_data['lname'],
                    'email' => $db_data['email'],
                    'contact' => $db_data['contact'],
                    'doctor' => $db_data['doctor'],
                    'appdate' => $db_data['appdate'],
                    'apptime' => $db_data['apptime']
                ]
            ]);
        } else {
            throw new Exception("Patient data not found");
        }
        
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Error decrypting QR code: ' . $e->getMessage()
        ]);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>