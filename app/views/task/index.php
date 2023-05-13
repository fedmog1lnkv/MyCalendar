<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link href="https://cdn.jsdelivr.net/npm/halfmoon@1.1.1/css/halfmoon-variables.min.css" rel="stylesheet"/>
</head>
<body>
<div class="page-wrapper with-navbar">
    <nav class="navbar">
        <span class="navbar-text text-monospace">MyCalendar</span>

        <ul class="navbar-nav d-none d-md-flex">
            <li class="nav-item active">
                <a href="/tasks/create" class="nav-link">Создать новую задачу</a>
            </li>
            <li class="nav-item active">
                <a href="/tasks/create" class="nav-link text-dark">Добро
                    пожаловать, <?php echo $data['user']->getEmail(); ?></a>
            </li>
        </ul>
        <form action="/logout" method="GET" class="form-inline ml-auto">
            <button class="btn btn-primary btn-block" type="submit">Logout</button>
        </form>
    </nav>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <h1 style="margin-left: 30px;">Список задач</h1>

        <!-- Форма для фильтрации -->
        <form action="/tasks/filter" method="GET" class="w-400 mw-full" style="margin-left: 50px">
            <div class="form-group mr-3">
                <label for="date-filter">Дата:</label>
                <input type="date" name="start_date" id="start_date" class="form-control ml-2" value="<?php echo $_GET['start_date'] ?? '' ?>">
            </div>

            <div class="form-group mr-3">
                <label for="status-filter">Статус:</label>
                <select name="status" id="status-filter" class="form-control ml-2">
                    <option value="">Все</option>
                    <option value="todo" <?php echo ($_GET['status'] ?? '') === 'todo' ? 'selected' : ''; ?>>Не выполнена</option>
                    <option value="in_work" <?php echo ($_GET['status'] ?? '') === 'in_work' ? 'selected' : ''; ?>>Выполняется</option>
                    <option value="done" <?php echo ($_GET['status'] ?? '') === 'done' ? 'selected' : ''; ?>>Выполнена</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Фильтровать</button>
        </form>


        <?php if (count($data['tasks']) > 0): ?>
            <table class="table table-hover">
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
    </div>
</div>
</body>
</html>