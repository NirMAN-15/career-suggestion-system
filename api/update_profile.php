<?php
session_start();
header('Content-Type: application/json');
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['user_id'];
$full_name = $_POST['full_name'] ?? '';
$phone = $_POST['phone'] ?? '';
$dob = $_POST['date_of_birth'] ?? null;
$education = $_POST['education_level'] ?? '';
$interests = $_POST['interests'] ?? '';

try {
    // Handle Image Upload
    $profile_pic_path = null;
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === 0) {
        $upload_dir = '../uploads/profiles/';
        if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);
        
        $file_ext = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));
        $valid_exts = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($file_ext, $valid_exts)) {
            $new_filename = "user_" . $user_id . "_" . time() . "." . $file_ext;
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $upload_dir . $new_filename)) {
                $profile_pic_path = $new_filename;
            }
        }
    }

    // Build Query dynamically
    $sql = "UPDATE users SET full_name=?, phone=?, date_of_birth=?, education_level=?, interests=?";
    $params = [$full_name, $phone, $dob, $education, $interests];

    if ($profile_pic_path) {
        $sql .= ", profile_picture=?";
        $params[] = $profile_pic_path;
    }

    $sql .= " WHERE user_id=?";
    $params[] = $user_id;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    echo json_encode([
        'success' => true, 
        'message' => 'Profile updated successfully!',
        'new_image' => $profile_pic_path ? "uploads/profiles/$profile_pic_path" : null
    ]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Update failed: ' . $e->getMessage()]);
}
?>