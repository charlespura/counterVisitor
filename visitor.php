<?php
$projectId = "YOUR_PROJECT_ID";
$documentPath = "projects/$projectId/databases/(default)/documents/visitors/counter";
$apiKey = "YOUR_WEB_API_KEY";

$today = date('Y-m-d');

// Read current counter
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://firestore.googleapis.com/v1/$documentPath?key=$apiKey");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

$totalViews = $data['fields']['totalViews']['integerValue'] ?? 0;
$todayViews = $data['fields']['todayViews']['integerValue'] ?? 0;
$lastVisitDay = $data['fields']['lastVisitDay']['stringValue'] ?? $today;

// Check for reset
if(isset($_GET['reset']) && $_GET['reset'] == 'true'){
    $totalViews = 0;
    $todayViews = 0;
    $lastVisitDay = $today;
}

if($lastVisitDay !== $today) $todayViews = 0;

// Increment counters if not reset
if(!isset($_GET['reset'])) $totalViews++; $todayViews++;

$lastVisitDay = $today;
$lastVisit = date('Y-m-d H:i:s');

// Update Firestore
$updateData = [
    "fields" => [
        "totalViews" => ["integerValue" => $totalViews],
        "todayViews" => ["integerValue" => $todayViews],
        "lastVisitDay" => ["stringValue" => $lastVisitDay],
        "lastVisit" => ["stringValue" => $lastVisit]
    ]
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://firestore.googleapis.com/v1/$documentPath?key=$apiKey");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($updateData));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_exec($ch);
curl_close($ch);

// Return JSON
header('Content-Type: application/json');
echo json_encode([
    'totalViews' => $totalViews,
    'todayViews' => $todayViews,
    'lastVisit' => $lastVisit
]);
?>
