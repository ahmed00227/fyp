<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/bootstrap/CSS/bootstrap-4.0.0-dist/css/bootstrap.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            min-width: 500px;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body style="background-image: url('{{ asset('images/login.jpg') }}');">
<div class="login-container">
    <h2 class="text-center">Login</h2>
    @if(session('error')!=null||!$errors->isEmpty())
        <p class="alert-danger p-2">{{session('error') ?? $errors->first()}}</p>
    @elseif(session('notice'))
        <p class="alert-success p-2">{{session('notice')}}</p>
    @endif
    <form method="post">
        @csrf
        <div class="form-group">
            <label for="username">Username(Email)</label>
            <input type="text" class="form-control" name="email" id="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>
</div>
</body>
</html>
