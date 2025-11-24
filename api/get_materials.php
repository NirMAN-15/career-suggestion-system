<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

// Check authentication
if(!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

// Get filter parameters
$career_id = isset($_GET['career_id']) ? intval($_GET['career_id']) : null;
$type = isset($_GET['type']) ? $_GET['type'] : '';
$level = isset($_GET['level']) ? $_GET['level'] : '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

try {
    // Build dynamic query
    $sql = "SELECT lm.*, c.career_name 
            FROM learning_materials lm
            LEFT JOIN careers c ON lm.career_id = c.career_id
            WHERE 1=1";
    $params = [];
    
    // Filter by career
    if($career_id) {
        $sql .= " AND lm.career_id = ?";
        $params[] = $career_id;
    }
    
    // Filter by type
    if($type && in_array($type, ['video', 'article', 'course', 'book'])) {
        $sql .= " AND lm.material_type = ?";
        $params[] = $type;
    }
    
    // Filter by difficulty level
    if($level && in_array($level, ['beginner', 'intermediate', 'advanced'])) {
        $sql .= " AND lm.difficulty_level = ?";
        $params[] = $level;
    }
    
    // Search filter
    if($search) {
        $sql .= " AND (lm.title LIKE ? OR lm.description LIKE ?)";
        $searchTerm = "%$search%";
        $params[] = $searchTerm;
        $params[] = $searchTerm;
    }
    
    // Order by newest first
    $sql .= " ORDER BY lm.created_at DESC";
    
    // Prepare and execute
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $materials = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'materials' => $materials,
        'count' => count($materials)
    ]);
    
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
?>