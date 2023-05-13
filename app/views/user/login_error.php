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
<div class="container">
    <div class="card">
        <h2 class="card-title">Авторизация</h2>
        <p>Еще нет аккаунта? <a href="/register">Зарегистрируйтесь</a></p>
        <br>
        <div class="w-400 mw-full">
            <form action="/login" method="POST" class="form-inline-sm">
                <input type="email" name="email" class="form-control" placeholder="Email" id="if-1-email"
                       required="required">
                <input type="password" name="password" class="form-control" placeholder="Password"
                       id="if-1-password" required="required">
                <input type="submit" class="btn btn-primary" value="Sign in">
            </form>
        </div>
        <p class="text-danger">Неправильныё логин или пароль</p>
    </div>
</div>
</body>
</html>