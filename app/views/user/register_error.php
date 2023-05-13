<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link href="https://cdn.jsdelivr.net/npm/halfmoon@1.1.1/css/halfmoon-variables.min.css" rel="stylesheet"/>
</head>
<body>

<div class="container">
    <div class="card">
        <h2 class="card-title">Регистрация</h2>
        <p>Уже есть аккаунт? <a href="/login">Войдите</a></p>
        <br>
        <div class="w-400 mw-full">
            <form action="/user" method="POST" class="form-inline-sm">
                <input type="email" name="email" class="form-control" placeholder="Email" id="if-1-email"
                       required="required">
                <input type="password" name="password" class="form-control" placeholder="Password"
                       id="if-1-password" required="required">
                <input type="submit" class="btn btn-primary" value="Sign Up">
            </form>
        </div>
        <p class="text-danger">Пользователь уже существует</p>
    </div>
</div>
</body>
</html>