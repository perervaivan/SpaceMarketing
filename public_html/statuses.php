<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <title>Статусы лидов</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
    <nav>
        <a href="addlead.php">Форма</a>
        <a href="statuses.php">Статусы лидов</a>
    </nav>
</header>

<main>
    <h1>Статусы лидов</h1>
    <form method="GET">
        <label for="filterDate">Фильтр по дате:</label>
        <input type="date" id="filterDate" name="filterDate">
        <button type="submit">Фильтровать</button>
    </form>

    <table>
        <thead>
        <tr>
            <th>Date</th>
            <th>ID</th>
            <th>Email</th>
            <th>Status</th>
            <th>FTD</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (isset($_GET['filterDate'])&&$_GET['filterDate']!=null) {
            $date = $_GET['filterDate'];
        } else {
            $date = null;
        }

        include 'api.php';
        $leads_response = getStatuses($date);
        //var_dump($leads_response);
        if($leads_response['status']=='success') {
            if(count($leads_response['leads'])>0) {
                $leads = $leads_response['leads'];
                $i = 1;//id мы берем как порядковый номер строки, а не ид из БД
                foreach ($leads as $lead) {
                    $lead['status'] = 'new';//так как у нас нету способа изменения или получения статуса,
                    //и у нас все лиды сейчас имеют статусы new, то пропишим это статично
                    echo "<tr>
                              <td>{$lead['date']}</td>
                            <td>{$i}</td>
                            <td>{$lead['email']}</td>
                            <td>{$lead['status']}</td>
                            <td>{$lead['status']}</td>
                            </tr>";

                    $i++;
                }
            }else{
                echo $leads_response['message'];
            }
        }elseif ($leads_response['status']=='error') {
            echo $leads_response['message'];
        }
        ?>
        </tbody>
    </table>
</main>
</body>
</html>
