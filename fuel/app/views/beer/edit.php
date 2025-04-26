<?php
use Fuel\Core\Security; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit a craft beer journal</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

    <div class="header">
        <h1><?= html_entity_decode($site_name); ?></h1>
    </div>

    <div class="detail-container">
        <form id="editBeerForm" data-bind="submit: submitForm" class="detail-left">
            <label for="name">Name</label>
            <input type="text" id="name" data-bind="value: name" required>

            <label for="brewery">Brewery</label>
            <input type="text" id="brewery" data-bind="value: brewery" required>

            <label for="type">Type/Style</label>
            <input type="text" id="type" data-bind="value: type">

            <label for="ABV">ABV(%)</label>
            <input type="number" id="ABV" data-bind="value: ABV" step="0.1">

            <label for="IBU">IBU</label>
            <input type="number" id="IBU" data-bind="value: IBU">

            <label for="origin">Origin</label>
            <input type="text" id="origin" data-bind="value: origin">

            <label for="sampled_date">Sampled Date</label>
            <input type="date" id="sampled_date" data-bind="value: sampled_dateFormatted">

            <label for="image_url">Photo URL</label>
            <input type="text" id="image_url" data-bind="value: image_url" placeholder="https://...">

            <input type="hidden" id="user_id" data-bind="value: user_id">
        </form>

        <div class="detail-right">
            <label for="appearance">Appearance (1-5)</label>
            <input type="number" id="appearance" data-bind="value: appearance" min="1" max="5">

            <label for="aroma">Aroma (1-5)</label>
            <input type="number" id="aroma" data-bind="value: aroma" min="1" max="5">

            <label for="taste">Taste (1-5)</label>
            <input type="number" id="taste" data-bind="value: taste" min="1" max="5">

            <label for="mouthfeel">Mouthfeel (1-5)</label>
            <input type="number" id="mouthfeel" data-bind="value: mouthfeel" min="1" max="5">

            <label for="overall">Overall Rating (1-5)</label>
            <input type="number" id="overall" data-bind="value: overall" min="1" max="5">
        </div>
    </div>

    <div class="detail-actions">
        <button type="button" onclick="location.href='/beer/index'">Back</button>
        <button type="submit" form="editBeerForm">Update</button>
    </div>

    <script>
        const CSRF_TOKEN = "<?= Security::fetch_token() ?>";
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.1/knockout-latest.min.js"></script>
    <script src="/assets/js/editBeer.js"></script>
</body>
</html>
