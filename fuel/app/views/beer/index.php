<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Craft Beer History</title>
    <style>
        img { max-height: 100px; margin-right: 10px; }
        li { margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>🍺 Your Craft Beer History</h1>
    <button onclick="location.href='/beer/create'" style="margin-bottom: 20px;">＋ Create new craftbeer</button>
    <button onclick="location.href='/logout'">Logout</button>

    <!-- Beer List -->
    <ul data-bind="foreach: beers">
        <li>
            <img data-bind="attr: { src: image_url }" alt="No image available"><br>

            <strong data-bind="text: name"></strong>
            (<span data-bind="text: brewery"></span>)<br>

            Type: <span data-bind="text: type"></span> /
            ABV: <span data-bind="text: ABV"></span>% /
            IBU: <span data-bind="text: IBU"></span><br>

            Origin: <span data-bind="text: origin"></span><br>
            Sampled on: <span data-bind="text: sampled_date"></span><br>

            Appearance: <span data-bind="text: appearance"></span> /
            Aroma: <span data-bind="text: aroma"></span> /
            Taste: <span data-bind="text: taste"></span> /
            Mouthfeel: <span data-bind="text: mouthfeel"></span> /
            <strong>Overall: <span data-bind="text: overall"></span></strong><br>
            <a data-bind="attr: { href: '/beer/detail?id=' + id }" class="detail-button">Details</a>
            <button data-bind="click: $parent.deleteBeer">Delete</button>
        </li>
    </ul>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.1/knockout-latest.min.js"></script>
    <script src="/assets/js/listBeer.js"></script>
</body>
</html>
