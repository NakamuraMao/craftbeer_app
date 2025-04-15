<?php
use Fuel\Core\Security; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

    <div class="header">
        <h1>My <span class="highlight">Beer Journal</span></h1>
    </div>

    <div class="container">
        <h2>Register</h2>
        <p class="subheading">Let’s get started! <span class="small">Create an account</span></p>

        <p data-bind="text: registerMessage" class="message"></p>

        <form data-bind="submit: register">
            <label for="username">Username</label>
            <input type="text" id="username" placeholder="Username" data-bind="value: registerUsername" required>

            <label for="email">E-mail</label>
            <input type="email" id="email" placeholder="Email" data-bind="value: registerEmail" required>

            <label for="password">Password</label>
            <input type="password" id="password" placeholder="Password" data-bind="value: registerPassword" required>

            <label for="confirm">Confirm Password</label>
            <input type="password" id="confirm" placeholder="Confirm Password" data-bind="value: registerConfirmPassword" required>

            <button type="submit">Register</button>
        </form>
    </div>

    <script>
        const CSRF_TOKEN = "<?= Security::fetch_token() ?>";
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.1/knockout-latest.min.js"></script>
    <script src="/assets/js/user.js"></script>
</body>
</html>
