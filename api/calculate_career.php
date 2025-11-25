<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    // Get all user answers
    $stmt = $pdo->prepare("
        SELECT ua.question_id, ua.answer, q.category 
        FROM user_answers ua
        JOIN questions q ON ua.question_id = q.question_id
        WHERE ua.user_id = ?
    ");
    $stmt->execute([$user_id]);
    $answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($answers)) {
        echo json_encode(['success' => false, 'message' => 'No answers found']);
        exit();
    }

    // Define the IT career matching matrix based on the document
    $careerScores = [
        'Software Developer' => 0,
        'Web Developer' => 0,
        'UI/UX Designer' => 0,
        'QA Tester' => 0,
        'Mobile App Developer' => 0,
        'Cloud Engineer' => 0,
        'DevOps Engineer' => 0,
        'Cybersecurity Analyst' => 0,
        'Data Analyst' => 0,
        'AI/ML Engineer' => 0,
        'IT Support Technician' => 0,
        'Network Engineer' => 0,
        'Business Analyst' => 0,
        'Project Manager' => 0,
        'Database Administrator' => 0
    ];

    // Question to career mapping weights (based on the matrix document)
    $questionMapping = [
        'Q1' => [ // Work Location
            'Remote' => ['Web Developer' => 70, 'Data Analyst' => 70, 'AI/ML Engineer' => 70],
            'On-site' => ['IT Support Technician' => 50, 'Network Engineer' => 55],
            'Hybrid' => ['DevOps Engineer' => 95, 'Project Manager' => 95, 'Cloud Engineer' => 90],
            'Flexible' => ['Web Developer' => 95, 'UI/UX Designer' => 95, 'Software Developer' => 90]
        ],
        'Q2' => [ // Working Style
            'Alone' => ['Software Developer' => 85, 'Web Developer' => 85, 'Data Analyst' => 85, 'AI/ML Engineer' => 85],
            'Partner' => ['UI/UX Designer' => 80, 'Cloud Engineer' => 80],
            'Small Group' => ['QA Tester' => 85, 'DevOps Engineer' => 85, 'Cloud Engineer' => 85],
            'Large Team' => ['Project Manager' => 98, 'Business Analyst' => 95, 'IT Support Technician' => 90, 'Network Engineer' => 90, 'DevOps Engineer' => 90]
        ],
        'Q3' => [ // Work Speed
            'Fast-paced' => ['DevOps Engineer' => 90, 'Project Manager' => 85, 'IT Support Technician' => 80],
            'Moderate' => ['Data Analyst' => 80, 'AI/ML Engineer' => 80, 'QA Tester' => 80],
            'Slow and steady' => ['AI/ML Engineer' => 40, 'Database Administrator' => 40],
            'Varies' => ['DevOps Engineer' => 98, 'Project Manager' => 98, 'Business Analyst' => 95]
        ],
        'Q4' => [ // Problem Solving
            'Independent' => ['AI/ML Engineer' => 95, 'Data Analyst' => 90, 'Software Developer' => 85],
            'With guidance' => ['IT Support Technician' => 60],
            'Team brainstorming' => ['Business Analyst' => 95, 'UI/UX Designer' => 90, 'Project Manager' => 90],
            'Research first' => ['Cybersecurity Analyst' => 98, 'AI/ML Engineer' => 98, 'Cloud Engineer' => 95]
        ],
        'Q5' => [ // Task Types
            'Creative' => ['UI/UX Designer' => 98, 'Web Developer' => 70],
            'Logical' => ['AI/ML Engineer' => 99, 'Data Analyst' => 99, 'Cybersecurity Analyst' => 98],
            'Organizing' => ['Project Manager' => 98, 'Business Analyst' => 95, 'DevOps Engineer' => 90],
            'Helping others' => ['IT Support Technician' => 95, 'Business Analyst' => 85]
        ],
        'Q11' => [ // Working with Technology
            'Always' => ['Cloud Engineer' => 99, 'DevOps Engineer' => 99, 'Cybersecurity Analyst' => 99, 'AI/ML Engineer' => 99, 'Network Engineer' => 99]
        ],
        'Q13' => [ // Analyzing
            'Yes' => ['Cybersecurity Analyst' => 99, 'Data Analyst' => 99, 'AI/ML Engineer' => 99, 'QA Tester' => 95]
        ],
        'Q14' => [ // Coding
            'Love it' => ['AI/ML Engineer' => 95, 'Software Developer' => 90, 'Mobile App Developer' => 90],
            'Like it' => ['Web Developer' => 85, 'UI/UX Designer' => 60, 'QA Tester' => 60, 'Data Analyst' => 60],
            'Neutral' => ['Project Manager' => 60, 'Business Analyst' => 50, 'IT Support Technician' => 50],
            'Don\'t like' => ['IT Support Technician' => 30]
        ],
        'Q15' => [ // Designing
            'Yes' => ['UI/UX Designer' => 95, 'Software Developer' => 90, 'AI/ML Engineer' => 90, 'Cloud Engineer' => 90]
        ],
        'Q16' => [ // Planning
            'Yes' => ['Project Manager' => 98, 'Business Analyst' => 95, 'Cloud Engineer' => 90, 'DevOps Engineer' => 90, 'Network Engineer' => 90]
        ],
        'Q17' => [ // Task Handling
            'One at a time' => ['AI/ML Engineer' => 75, 'Software Developer' => 65],
            'Multitasking' => ['Project Manager' => 98, 'IT Support Technician' => 95, 'Business Analyst' => 90, 'Network Engineer' => 90]
        ],
        'Q18' => [ // Helping Users
            'Yes' => ['IT Support Technician' => 98, 'Business Analyst' => 95, 'Project Manager' => 90, 'UI/UX Designer' => 90]
        ]
    ];

    // Calculate scores based on user answers
    foreach ($answers as $answer) {
        $questionId = $answer['question_id'];
        $userAnswer = $answer['answer'];
        
        // Map question_id to Q format (assuming question_id corresponds to question number)
        $qKey = 'Q' . $questionId;
        
        if (isset($questionMapping[$qKey]) && isset($questionMapping[$qKey][$userAnswer])) {
            foreach ($questionMapping[$qKey][$userAnswer] as $career => $weight) {
                $careerScores[$career] += $weight;
            }
        }
    }

    // Normalize scores to percentage (0-100)
    $maxScore = max($careerScores);
    if ($maxScore > 0) {
        foreach ($careerScores as $career => $score) {
            $careerScores[$career] = round(($score / $maxScore) * 100, 2);
        }
    }

    // Sort careers by score (highest first)
    arsort($careerScores);

    // Get top 5 careers
    $topCareers = array_slice($careerScores, 0, 5, true);

    // Get career details from database
    $careerList = array_keys($topCareers);
    $placeholders = str_repeat('?,', count($careerList) - 1) . '?';
    
    $stmt = $pdo->prepare("SELECT * FROM careers WHERE career_name IN ($placeholders)");
    $stmt->execute($careerList);
    $careerDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Merge scores with details
    $results = [];
    foreach ($careerDetails as $career) {
        $careerName = $career['career_name'];
        $results[] = [
            'career_id' => $career['career_id'],
            'career_name' => $careerName,
            'match_percentage' => $topCareers[$careerName],
            'description' => $career['description'],
            'category' => $career['category'],
            'avg_salary' => $career['avg_salary'],
            'job_growth' => $career['job_growth'],
            'required_education' => $career['required_education'],
            'skills_required' => $career['skills_required']
        ];
    }

    // Sort results by match percentage
    usort($results, function($a, $b) {
        return $b['match_percentage'] <=> $a['match_percentage'];
    });

    // Save matches to database
    foreach ($results as $result) {
        $stmt = $pdo->prepare("
            INSERT INTO user_career_matches (user_id, career_id, match_percentage)
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE match_percentage = ?, suggested_at = CURRENT_TIMESTAMP
        ");
        $stmt->execute([
            $user_id,
            $result['career_id'],
            $result['match_percentage'],
            $result['match_percentage']
        ]);
    }

    echo json_encode([
        'success' => true,
        'careers' => $results,
        'total_analyzed' => count($answers)
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error calculating careers: ' . $e->getMessage()
    ]);
}
?>