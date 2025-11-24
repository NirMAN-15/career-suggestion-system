<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

// Check authentication
if(!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

// Get search query
$query = isset($_GET['q']) ? trim($_GET['q']) : '';

// Validate query length
if(strlen($query) < 2) {
    echo json_encode([
        'success' => false,
        'error' => 'Search query must be at least 2 characters'
    ]);
    exit;
}

try {
    // Search in title, description, and career name
    $stmt = $pdo->prepare("
        SELECT lm.*, c.career_name
        FROM learning_materials lm
        LEFT JOIN careers c ON lm.career_id = c.career_id
        WHERE lm.title LIKE ? 
           OR lm.description LIKE ?
           OR c.career_name LIKE ?
        ORDER BY lm.created_at DESC
        LIMIT 50
    ");
    
    $searchTerm = "%$query%";
    $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'query' => $query,
        'results' => $results,
        'count' => count($results)
    ]);
    
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
?>