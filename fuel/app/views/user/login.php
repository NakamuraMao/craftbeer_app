<?php
use Fuel\Core\Security; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

    <div class="header">
        <h1>My <span class="highlight">Beer Journal</span></h1>
    </div>

    <div class="container">
        <h2>Login</h2>
        <p class="subheading">Let’s get started!</p>

        <p class="message" data-bind="text: loginMessage"></p>

        <form data-bind="submit: login">
            <label for="email">E-mail</label>
            <input type="email" id="email" placeholder="Email" data-bind="value: loginEmail" required>

            <label for="password">Password</label>
            <input type="password" id="password" placeholder="Password" data-bind="value: loginPassword" required>

            <button type="submit">Login</button>
        </form>
    </div>

    <script>
        const CSRF_TOKEN = "<?= Security::fetch_token() ?>";
        const REMEMBERED_EMAIL = "<?= isset($remember_email) ? addslashes($remember_email) : '' ?>";
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.1/knockout-latest.min.js"></script>
    <script src="/assets/js/user.js"></script>

</body>
</html>
