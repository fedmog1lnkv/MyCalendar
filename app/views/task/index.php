<h1>Список задач</h1>

<p>
    Добро пожаловать, <?php echo $data['user']->getEmail(); ?>
    <br>
    <a href="/tasks/create">Создать новую задачу</a>
    <a href="/logout">Выход</a>
</p>


<?php if (count($data['tasks']) > 0): ?>
    <table>
        <thead>
        <tr>
            <th>Тема</th>
            <th>Тип</th>
            <th>Место</th>
            <th>Дата начала</th>
            <th>Длительность</th>
            <th>Комментарий</th>
            <th>Статус</th>
            <th>
            <th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data['tasks'] as $task): ?>
            <tr>
                <td><a href="/tasks/<?php echo $task->getId(); ?>"><?php echo $task->getTheme(); ?></a></td>
                <td><?php echo $task->getNormalType(); ?></td>
                <td><?php echo $task->getLocation(); ?></td>
                <td><?php echo $task->getStartDate(); ?></td>
                <td><?php echo $task->getDuration(); ?></td>
                <td><?php echo $task->getComment(); ?></td>
                <td><?php echo $task->getNormalStatus(); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php else: ?>
    <p>Нет ни одной задачи.</p>
<?php endif; ?>
