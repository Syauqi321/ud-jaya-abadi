<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UD. Jaya Abadi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f4f4fc;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            display: flex;
            width: 900px;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 16px;
            overflow: hidden;
        }

        .left {
            background: linear-gradient(to bottom right, #3f0fc7, #6743f1);
            color: white;
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .left h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .left p {
            font-size: 14px;
            text-align: center;
            margin-bottom: 30px;
        }

        .left img {
            width: 180px;
            height: auto;
        }

        .right {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right h3 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 24px;
            color: #333;
            border-bottom: 2px solid #6743f1;
            display: inline-block;
            padding-bottom: 5px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        input[type="email"],
        input[type="password"] {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            padding: 12px;
            background-color: #6743f1;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background-color: #5634d1;
        }

        .error {
            color: red;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-box">
            <div class="left">
                <h2>Selamat Datang</h2>
                <p>Silahkan login untuk melanjutkan ke sistem manajemen produksi UD. Jaya Abadi</p>
                <h1 style="margin-top: 20px;">UD. Jaya Abadi</h1>
            </div>
            <div class="right">
                <h3>Login</h3>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div>
                        <label for="email" style="display: block; font-weight: 600; margin-bottom: 6px;">Email:</label>
                        <input type="email" id="email" name="email" placeholder="example@gmail.com"
                            value="{{ old('email') }}" required>
                        @error('email')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="password"
                            style="display: block; font-weight: 600; margin-bottom: 6px;">Password:</label>
                        <input type="password" id="password" name="password" placeholder="your password" required>
                        @error('password')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
