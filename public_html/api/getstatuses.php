<?php
$filePath = 'leads.txt';
$dateFilter = isset($_GET['filterDate']) ? $_GET['filterDate'] : null;

if (!file_exists($filePath)) {
    echo json_encode([
        "status" => "error",
        "message" => "Файл с заявками не найден"
    ]);
    exit;
}

$fileData = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
if (!$fileData) {
    echo json_encode([
        "status" => "error",
        "message" => "Файл пуст"
    ]);
    exit;
}
if ($dateFilter && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateFilter)) {
    echo json_encode([
        "status" => "error",
        "message" => "Некорректный формат даты. Используйте формат YYYY-MM-DD."
    ]);
    exit;
}

$leads = [];
foreach ($fileData as $line) {
    $parts = explode('${', $line, 2);
    if (count($parts) !== 2) {
        continue;
    }

    $leadDate = trim($parts[0]);
    $leadDataJson = '{' . trim($parts[1]); // Добавляем открывающую скобку, удаленную в explode
    $leadData = json_decode($leadDataJson, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        continue;
    }

    // Добавляем дату в массив заявки
    $leadData['date'] = $leadDate;

    // Если фильтр по дате указан, пропускаем заявки не из указанной даты
    if ($dateFilter && strpos($leadDate, $dateFilter) !== 0) {
        continue;
    }

    // Добавляем заявку в список
    $leads[] = $leadData;
}

// Проверяем, есть ли подходящие заявки
if (empty($leads)) {
    echo json_encode([
        "status" => "success",
        "message" => "Нет заявок для указанной даты",
        "leads" => []
    ]);
    exit;
}
echo json_encode([
    "status" => "success",
    "leads" => $leads
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

?>