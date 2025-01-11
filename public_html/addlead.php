<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <title>Форма отправки данных</title>
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
    <h1>Отправка данных</h1>
    <form action="api.php" method="POST">
        <input type="hidden" name="action" value="addlead">

        <label for="firstName">Имя:</label>
        <input type="text" id="firstName" name="firstName" required>

        <label for="lastName">Фамилия:</label>
        <input type="text" id="lastName" name="lastName" required>

        <label for="phone">Телефон:</label>
        <input type="tel" id="phone" name="phone" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <button type="submit">Отправить</button>
    </form>
</main>
</body>
</html>
