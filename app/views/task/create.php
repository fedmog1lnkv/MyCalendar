<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Создать новую задачу</title>
</head>
<body>
<h1>Создать новую задачу</h1>

<form action="/tasks" method="post">
    <label for="theme">Тема:</label>
    <input type="text" id="theme" name="theme"><br>

    <label for="type">Тип:</label>
    <select id="type" name="type">
        <option value="meeting">Встреча</option>
        <option value="call">Звонок</option>
        <option value="conference">Совещание</option>
        <option value="task">Дело</option>
    </select><br>

    <label for="location">Место:</label>
    <input type="text" id="location" name="location"><br>

    <label for="start_date">Дата и время начала:</label>
    <input type="datetime-local" id="start_date" name="start_date"><br>

    <label for="duration">Продолжительность (в минутах):</label>
    <input type="number" id="duration" name="duration"><br>

    <label for="comment">Комментарий:</label><br>
    <textarea id="comment" name="comment"></textarea><br>

    <input type="submit" value="Создать задачу">
</form>
</body>
</html>
