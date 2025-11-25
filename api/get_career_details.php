<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit();
}

if (!isset($_GET['career_id'])) {
    echo json_encode(['success' => false, 'message' => 'Career ID required']);
    exit();
}

$career_id = $_GET['career_id'];

try {
    // Get career details
    $stmt = $pdo->prepare("SELECT * FROM careers WHERE career_id = ?");
    $stmt->execute([$career_id]);
    $career = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$career) {
        echo json_encode(['success' => false, 'message' => 'Career not found']);
        exit();
    }

    // Get user's match percentage for this career
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("
        SELECT match_percentage 
        FROM user_career_matches 
        WHERE user_id = ? AND career_id = ?
        ORDER BY suggested_at DESC
        LIMIT 1
    ");
    $stmt->execute([$user_id, $career_id]);
    $match = $stmt->fetch(PDO::FETCH_ASSOC);

    // Parse skills_required (assuming it's stored as comma-separated)
    $skills = explode(',', $career['skills_required']);
    $skills = array_map('trim', $skills);

    echo json_encode([
        'success' => true,
        'career' => [
            'career_id' => $career['career_id'],
            'career_name' => $career['career_name'],
            'description' => $career['description'],
            'category' => $career['category'],
            'avg_salary' => $career['avg_salary'],
            'job_growth' => $career['job_growth'],
            'required_education' => $career['required_education'],
            'skills_required' => $skills,
            'match_percentage' => $match ? $match['match_percentage'] : 0
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching career details: ' . $e->getMessage()
    ]);
}
?>