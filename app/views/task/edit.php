<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать задачу</title>
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
        <h1 style="margin-left: 30px;">Редактировать задачу "<?php echo $task->getTheme(); ?>"</h1>

        <form action="/tasks/update/<?php echo $task->getId(); ?>" method="post" class="w-400 mw-full" style="margin-left: 50px;">
            <input type="hidden" name="id" value="<?php echo $task->getId(); ?>">

            <label for="theme">Тема:</label>
            <input type="text" id="theme" name="theme" class="form-control" value="<?php echo $task->getTheme(); ?>">

            <label for="type">Тип:</label>
            <select class="form-control" id="type" name="type">
                <option value="meeting"<?php if ($task->getType() == 'meeting') { echo ' selected'; } ?>>Встреча</option>
                <option value="call"<?php if ($task->getType() == 'call') { echo ' selected'; } ?>>Звонок</option>
                <option value="conference"<?php if ($task->getType() == 'conference') { echo ' selected'; } ?>>Совещание</option>
                <option value="task"<?php if ($task->getType() == 'task') { echo ' selected'; } ?>>Дело</option>
            </select>

            <label for="location">Место:</label>
            <input type="text" name="location" id="location" class="form-control" value="<?php echo $task->getLocation(); ?>">

            <label for="start_date">Дата и время начала:</label>
            <input type="datetime-local" name="start_date" id="start_date" class="form-control" value="<?php echo $task->getStartDate(); ?>">

            <label for="duration">Продолжительность (в днях):</label>
            <input type="number" name="duration" id="duration" class="form-control" value="<?php echo $task->getDuration(); ?>">

            <label for="comment">Комментарий:</label><br>
            <textarea name="comment" id="comment" class="form-control"><?php echo $task->getComment(); ?></textarea>

            <label for="status">Статус:</label>
            <select class="form-control" id="status" name="status">
                <option value="todo"<?php if ($task->getStatus() == 'todo') { echo ' selected'; } ?>>Не выполнена</option>
                <option value="in_work"<?php if ($task->getStatus() == 'in_work') { echo ' selected'; } ?>>Выполняется</option>
                <option value="done"<?php if ($task->getStatus() == 'done') { echo ' selected'; } ?>>Выполнена</option>
            </select>

            <button class="btn btn-primary btn-block" style="margin-top: 10px;" type="submit">Принять изменения</button>

        </form>
    </div>
</div>
</body>
</html>
