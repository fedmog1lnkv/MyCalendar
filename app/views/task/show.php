<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $task->getTheme(); ?></title>
</head>
<body>

<p><strong>Тема:</strong> <?php echo $task->getTheme(); ?></p>
<p><strong>Тип:</strong> <?php echo $task->getNormalType(); ?></p>
<p><strong>Местоположение:</strong> <?php echo $task->getLocation(); ?></p>
<p><strong>Дата начала:</strong> <?php echo $task->getStartDate(); ?></p>
<p><strong>Продолжительность:</strong> <?php echo $task->getDuration(); ?></p>
<p><strong>Комментарий:</strong> <?php echo $task->getComment(); ?></p>
<p><strong>Статус:</strong> <?php echo $task->getNormalStatus(); ?></p>

<a href="/tasks/edit/<?php echo $task->getID(); ?>">Редактировать задачу</a>

<form action="/tasks/delete/<?php echo $task->getID(); ?>" method="POST">
    <input type="hidden" name="_method" value="DELETE">
    <button type="submit">Удалить задачу</button>
</form>
</body>
</html>
