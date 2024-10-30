<?php
// Save this as qr-functions.php

function saveQRCodeData($con, $pid, $data) {
    // Start transaction
    mysqli_begin_transaction($con);
    
    try {
        // Insert patient medical info
        $stmt = $con->prepare("INSERT INTO patients (patient_id, name, gender, phone, emergency_phone, photo) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $pid, $data['name'], $data['gender'], $data['phone'], $data['emergencyPhone'], $data['photo']);
        $stmt->execute();
        
        // Insert medical conditions
        $stmt = $con->prepare("INSERT INTO medical_conditions (patient_id, blood_pressure, diabetes, has_disabilities, disability_details) VALUES (?, ?, ?, ?, ?)");
        $hasDisabilities = $data['disabilities'] !== 'No';
        $stmt->bind_param("iiiss", $pid, $data['bloodPressure'], $data['diabetes'], $hasDisabilities, $data['disabilities']);
        $stmt->execute();
        
        // Insert prescriptions
        if (!empty($data['prescriptions'])) {
            $stmt = $con->prepare("INSERT INTO prescriptions (patient_id, prescription_image) VALUES (?, ?)");
            foreach ($data['prescriptions'] as $prescription) {
                $stmt->bind_param("is", $pid, $prescription);
                $stmt->execute();
            }
        }
        
        // Insert medical documents
        if (!empty($data['scanningDocs'])) {
            $stmt = $con->prepare("INSERT INTO medical_documents (patient_id, document_image) VALUES (?, ?)");
            foreach ($data['scanningDocs'] as $doc) {
                $stmt->bind_param("is", $pid, $doc);
                $stmt->execute();
            }
        }
        
        // Insert insurance information
        $stmt = $con->prepare("INSERT INTO insurance (patient_id, has_insurance, insurance_document) VALUES (?, ?, ?)");
        $hasInsurance = $data['lifeInsurance'] !== 'No';
        $insuranceDoc = $hasInsurance ? $data['lifeInsurance'] : null;
        $stmt->bind_param("iis", $pid, $hasInsurance, $insuranceDoc);
        $stmt->execute();
        
        // Insert QR code record
        $stmt = $con->prepare("INSERT INTO qr_codes (qr_id, patient_id) VALUES (?, ?)");
        $qrId = uniqid();
        $stmt->bind_param("si", $qrId, $pid);
        $stmt->execute();
        
        // Commit transaction
        mysqli_commit($con);
        return true;
        
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($con);
        return false;
    }
}

function getQRCodeData($con, $pid) {
    $data = array();
    
    // Get patient info
    $stmt = $con->prepare("SELECT * FROM patients WHERE patient_id = ?");
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $result = $stmt->get_result();
    $data['patient'] = $result->fetch_assoc();
    
    // Get medical conditions
    $stmt = $con->prepare("SELECT * FROM medical_conditions WHERE patient_id = ?");
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $result = $stmt->get_result();
    $data['conditions'] = $result->fetch_assoc();
    
    // Get prescriptions
    $stmt = $con->prepare("SELECT * FROM prescriptions WHERE patient_id = ? ORDER BY upload_date DESC");
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $result = $stmt->get_result();
    $data['prescriptions'] = $result->fetch_all(MYSQLI_ASSOC);
    
    // Get medical documents
    $stmt = $con->prepare("SELECT * FROM medical_documents WHERE patient_id = ? ORDER BY upload_date DESC");
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $result = $stmt->get_result();
    $data['documents'] = $result->fetch_all(MYSQLI_ASSOC);
    
    // Get insurance info
    $stmt = $con->prepare("SELECT * FROM insurance WHERE patient_id = ?");
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $result = $stmt->get_result();
    $data['insurance'] = $result->fetch_assoc();
    
    return $data;
}

// Add this to handle AJAX request for saving QR data
if (isset($_POST['action']) && $_POST['action'] === 'saveQRCode') {
    $pid = $_POST['pid'];
    $data = json_decode($_POST['data'], true);
    $result = saveQRCodeData($con, $pid, $data);
    echo json_encode(['success' => $result]);
    exit;
}
?>