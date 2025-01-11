<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$apiToken = "ba67df6a-a17c-476f-8e95-bcdb75ed3958";
$apiUrl = "https://spacemarketing.pererva.pro/api";


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'addlead') {
    $response = addLead(json_encode($_POST));
    //var_dump($response);
    header('Location: index.php?status='.$response['status'].'&lead_id='.$response['lead_id']);
    exit;
}

function addLead($data) {
    global $apiUrl, $apiToken;
    $data = json_decode($data,true);
    //Можна статические данные принимать из формы, если переписать приём данных, а не вписывать статично как указано в ТЗ
    $api_data = array(
        "firstName" => $data["firstName"],
        "lastName" => $data["lastName"],
        "phone" => $data["phone"],
        "email" => $data["email"],
        "box_id" => 28,
        "offer_id" => 3,
        "countryCode" => "RU",
        "language" => "ru",
        "password" => "qwerty12",
        "ip" => $_SERVER['REMOTE_ADDR'],
        "landingUrl" => $_SERVER['HTTP_REFERER']
    );
    $response = apiRequest("$apiUrl/addlead.php", json_encode($api_data));
    return $response;
}


function getStatuses($date = null) {
    global $apiUrl, $apiToken;

    $data = [];
    if ($date) {
        $data['date'] = $date;
    }

    $response = apiRequest1("$apiUrl/getstatuses.php", $data);
    return $response;
}



function apiRequest($url, $data) {
    global $apiToken;

    //var_dump(json_decode($data,true));
    //var_dump($data);
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => http_build_query(json_decode($data,true)),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
            //'Content-Type: application/json',
            //'Authorization: Bearer $apiToken'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);

}

function apiRequest1($url, $data) {
    global $apiToken;
    if(isset($data['date'])&&$data['date']!=null) {
        $urlRequest = $url.'?filterDate='.$data['date'];
    }else{ $urlRequest = $url.'?filterDate='; }
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $urlRequest,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            //'Content-Type: application/x-www-form-urlencoded'
            'Content-Type: application/json',
            //'Authorization: Bearer $apiToken'
        ),
    ));

    $response = curl_exec($curl);
    //var_dump($response);
    curl_close($curl);
    return json_decode($response, true);

}
