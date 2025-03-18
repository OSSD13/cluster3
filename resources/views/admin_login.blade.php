<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('public\css\style.css') }}">
    <title>Admin - Login</title>
</head>

<body>
    <div class="container">
        <div class="login-box">
            <img src="{{ asset('public\image\logo wrs full.png') }}" alt="Website Logo">
            <!--<h1>Dash UI</h1>-->
            <p>Please enter your user information.</p>
            <form action="#" method="post">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username here" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="***************" required>

                <button type="submit">Login</button>
            </form>
            <p1>Login for Admins</p1>
        </div>
    </div>
</body>

</html>
