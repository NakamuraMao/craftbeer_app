<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        input { margin: 5px 0; display: block; }
        .message { color: red; margin-top: 10px; }
    </style>
</head>
<body>
    <h1>Login</h1>

    <!-- ログインフォーム -->
    <input type="email" placeholder="Email" data-bind="value: loginEmail">
    <input type="password" placeholder="Password" data-bind="value: loginPassword">
    <button data-bind="click: login">Login</button>

    <!-- メッセージ表示 -->
    <p class="message" data-bind="text: loginMessage"></p>

    <!-- JS読み込み -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.1/knockout-latest.min.js"></script>
    <script src="/assets/js/user.js"></script>
</body>
</html>
