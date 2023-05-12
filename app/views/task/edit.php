<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Редактировать задачу</title>
</head>
<body>
<h1>Редактировать задачу "<?php echo $task->getTheme(); ?>"</h1>

<form method="POST" action="/tasks/update/<?php echo $task->getId(); ?>">
    <input type="hidden" name="id" value="<?php echo $task->getId(); ?>">

    <label for="theme">Тема:</label>
    <input type="text" name="theme" id="theme" value="<?php echo $task->getTheme(); ?>">

    <label for="type">Тип:</label>
    <select name="type" id="type">
        <option value="meeting"<?php if ($task->getType() == 'meeting') { echo ' selected'; } ?>>Встреча</option>
        <option value="call"<?php if ($task->getType() == 'call') { echo ' selected'; } ?>>Звонок</option>
        <option value="conference"<?php if ($task->getType() == 'conference') { echo ' selected'; } ?>>Совещание</option>
        <option value="task"<?php if ($task->getType() == 'task') { echo ' selected'; } ?>>Дело</option>
    </select>

    <label for="location">Место:</label>
    <input type="text" name="location" id="location" value="<?php echo $task->getLocation(); ?>">

    <label for="start_date">Дата начала:</label>
    <input type="datetime-local" name="start_date" id="start_date" value="<?php echo $task->getStartDate(); ?>">

    <label for="duration">Длительность (в часах):</label>
    <input type="number" name="duration" id="duration" value="<?php echo $task->getDuration(); ?>">

    <label for="comment">Комментарий:</label>
    <textarea name="comment" id="comment"><?php echo $task->getComment(); ?></textarea>

    <label for="status">Статус:</label>
    <select name="status" id="status">
        <option value="todo"<?php if ($task->getStatus() == 'todo') { echo ' selected'; } ?>>Не выполнена</option>
        <option value="in_progress"<?php if ($task->getStatus() == 'in_work') { echo ' selected'; } ?>>Выполняется</option>
        <option value="done"<?php if ($task->getStatus() == 'done') { echo ' selected'; } ?>>Выполнена</option>
    </select>

    <button type="submit">Сохранить</button>
</form>

</body>
</html>
