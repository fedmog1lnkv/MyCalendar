<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создать новую задачу</title>
    <link href="https://cdn.jsdelivr.net/npm/halfmoon@1.1.1/css/halfmoon-variables.min.css" rel="stylesheet"/>
</head>
<body>

<div class="page-wrapper with-navbar">
    <nav class="navbar">
        <span class="navbar-text text-monospace">MyCalendar</span>

        <ul class="navbar-nav d-none d-md-flex">
            <li class="nav-item active">
                <a href="/" class="nav-link">На главную</a>
            </li>
        </ul>
        <form action="/logout" method="GET" class="form-inline ml-auto">
            <button class="btn btn-primary btn-block" type="submit">Logout</button>
        </form>
    </nav>
    <div class="content-wrapper">
        <h1 style="margin-left: 30px;">Создать новую задачу</h1>

        <form action="/tasks" method="post" class="w-400 mw-full" style="margin-left: 50px;">
            <label for="theme">Тема:</label>
            <input type="text" id="theme" name="theme" class="form-control" placeholder="Theme">

            <label for="type">Тип:</label>
            <select class="form-control" id="type" name="type">
                <option value="meeting">Встреча</option>
                <option value="call">Звонок</option>
                <option value="conference">Совещание</option>
                <option value="task">Дело</option>
            </select>

            <label for="location">Место:</label>
            <input type="text" id="location" name="location" class="form-control" placeholder="Location">

            <label for="start_date">Дата и время начала:</label>
            <input type="datetime-local" id="start_date" name="start_date" class="form-control">

            <label for="duration">Продолжительность (в днях):</label>
            <input type="number" id="duration" name="duration" class="form-control" placeholder="Days">


            <label for="comment">Комментарий:</label><br>
            <textarea id="comment" name="comment" class="form-control" placeholder="Tell about your task"></textarea>

            <button class="btn btn-primary btn-block" style="margin-top: 10px;" type="submit">Создать задачу</button>

        </form>
    </div>
</div>
</body>
</html>
