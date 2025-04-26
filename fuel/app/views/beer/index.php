<?php
use Fuel\Core\Security; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Craft Beer History</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

    <div class="header">
        <h1><?= html_entity_decode($site_name); ?></h1>
    </div>

    <div class="container">
        <h2>Your Craft beer History</h2>

        <div class="actions">
            <button onclick="location.href='/beer/create'" class="action-button">create a new craft beer journal ➤</button>
            <button onclick="location.href='/logout'" class="action-button">logout ➤</button>
        </div>

        <ul class="beer-list" data-bind="foreach: beers">
            <li class="beer-item">
                <div class="beer-avatar">
                    <span data-bind="text: name().charAt(0).toUpperCase()">A</span>
                </div>
                <div class="beer-info">
                    <strong data-bind="text: name"></strong> <span data-bind="text: brewery"></span><br>
                    Type: <span data-bind="text: type"></span> /
                    ABV: <span data-bind="text: ABV"></span>% /
                    IBU: <span data-bind="text: IBU"></span><br>
                    Origin: <span data-bind="text: origin"></span><br>
                    Sampled on: <span data-bind="text: sampled_date"></span><br>
                    Appearance: <span data-bind="text: appearance"></span> /
                    Aroma: <span data-bind="text: aroma"></span> /
                    Taste: <span data-bind="text: taste"></span> /
                    Mouthfeel: <span data-bind="text: mouthfeel"></span> /
                    <strong>Overall: <span data-bind="text: overall"></span></strong>
                </div>
                <div class="beer-actions">
                    <button class="icon-button trash" data-bind="click: $parent.deleteBeer" title="Delete">🗑</button>
                    <a data-bind="attr: { href: '/beer/detail?id=' + id }" class="icon-button play" title="Details">➤</a>
                </div>
            </li>
        </ul>
    </div>

    <script>
        const CSRF_TOKEN = "<?= Security::fetch_token() ?>";
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.1/knockout-latest.min.js"></script>
    <script src="/assets/js/listBeer.js"></script>
</body>
</html>
