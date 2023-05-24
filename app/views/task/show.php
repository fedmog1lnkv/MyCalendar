<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $task->getTheme(); ?></title>
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
            <li class="nav-item active">
                <a href="/tasks/edit/<?php echo $task->getID(); ?>" class="nav-link">Редактировать задачу</a>
            </li>
        </ul>
        <form action="/logout" method="GET" class="form-inline ml-auto">
            <button class="btn btn-primary btn-block" type="submit">Logout</button>
        </form>
    </nav>
    <div class="content-wrapper">
        <h1 style="margin-left: 30px;"><?php echo $task->getTheme(); ?></h1>
        <div style="margin-left: 50px;">
            <p><strong>Тема:</strong> <?php echo $task->getTheme(); ?></p>
            <p><strong>Тип:</strong> <?php echo $task->getNormalType(); ?></p>
            <p><strong>Местоположение:</strong> <?php echo $task->getLocation(); ?></p>
            <p><strong>Дата начала:</strong> <?php echo $task->getStartDate(); ?></p>
            <p><strong>Продолжительность:</strong> <?php echo $task->getDuration(); ?></p>
            <p><strong>Комментарий:</strong> <?php echo $task->getComment(); ?></p>
            <p><strong>Статус:</strong> <?php echo $task->getNormalStatus(); ?></p>

            <!--        <a href="/tasks/edit/--><?php //echo $task->getID(); ?><!--">Редактировать задачу</a>-->

            <?php
            if ($task->getNormalStatus() !== 'Выполнена') {
                echo '<form action="/tasks/mark_done/' . $task->getID() . '" method="POST" class="w-400 mw-full">
              <input type="hidden" name="_method" value="DELETE">
              <button class="btn btn-primary btn-block" style="margin-top: 10px;" type="submit">Выполнено</button>
              </form>';
            }
            ?>

            <form action="/tasks/delete/<?php echo $task->getID(); ?>" method="POST" class="w-400 mw-full">
                <input type="hidden" name="_method" value="DELETE">
                <button class="btn btn-danger btn-block" style="margin-top: 10px;" type="submit">Удалить задачу</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
