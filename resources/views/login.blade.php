<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dash UI - Login</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .btn-primary {
            background-color: #6c4cf5;
            border: none;
        }
        .btn-primary:hover {
            background-color: #5633d6;
        }
    </style>
</head>

<body>
    <div class="card p-4" style="width: 400px;">
        <div class="text-center mb-4">
            <img src="C:\xampp\htdocs\cluster3\public\image\logo wrs full.png" alt="Logo" >
            <p class="text-muted">Please enter your user information.</p>
        </div>
        <form>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input
                    type="email"
                    class="form-control"
                    id="username"
                    placeholder="Enter your username here"
                />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                    type="password"
                    class="form-control"
                    id="password"
                    placeholder="****************"
                />
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    ></script>
</body>
</html>
