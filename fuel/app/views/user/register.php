<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>

    <p data-bind="text: registerMessage" style="color: green;"></p>

    <input type="text" placeholder="Username" data-bind="value: registerUsername"><br>
    <input type="email" placeholder="Email" data-bind="value: registerEmail"><br>
    <input type="password" placeholder="Password" data-bind="value: registerPassword"><br>
    <input type="password" placeholder="Confirm Password" data-bind="value: registerConfirmPassword"><br>

    <button data-bind="click: register">Register</button>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.1/knockout-latest.min.js"></script>
    <script src="/assets/js/user.js"></script>
</body>
</html>
