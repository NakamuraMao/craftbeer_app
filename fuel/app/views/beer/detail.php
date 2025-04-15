<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Beer Detail</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

    <div class="header">
        <h1>My <span class="highlight">Beer Journal</span></h1>
    </div>

    <div class="detail-container">
        <div class="detail-left">
            <!--<button onclick="location.href='/beer/index'" class="back-arrow">←</button>-->
            <h2 data-bind="text: name" class="beer-title">List 1</h2>

            <div class="detail-image">
                <img data-bind="attr: {src: image_url() || '/assets/img/no-image.png'}" alt="Beer image">
            </div>

            <div class="detail-info">
                <p><strong>Name</strong> <span data-bind="text: name"></span></p>
                <p><strong>Brewery</strong> <span data-bind="text: brewery"></span></p>
                <p><strong>Type/Style</strong> <span data-bind="text: type"></span></p>
                <p><strong>IBU</strong> <span data-bind="text: IBU"></span></p>
                <p><strong>ABV(%)</strong> <span data-bind="text: ABV"></span></p>
                <p><strong>Origin</strong> <span data-bind="text: origin"></span></p>
                <p><strong>Sampled Date</strong> <span data-bind="text: sampled_date"></span></p>
            </div>
        </div>

        <div class="detail-right">
            <div class="rating-section">
                <p><strong>Appearance:</strong> <span data-bind="text: appearance"></span> / 5</p>
                <p><strong>Aroma:</strong> <span data-bind="text: aroma"></span> / 5</p>
                <p><strong>Taste:</strong> <span data-bind="text: taste"></span> / 5</p>
                <p><strong>Mouthfeel:</strong> <span data-bind="text: mouthfeel"></span> / 5</p>
                <p><strong>Overall:</strong> <span data-bind="text: overall"></span> / 5</p>
            </div>
        </div>
    </div>

    <div class="detail-actions">
        <button onclick="location.href='/beer/index'">Back</button>
        <a data-bind="attr: { href: '/beer/edit?id=' + id() }" class="edit-button">Update</a>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.1/knockout-latest.min.js"></script>
    <script src="/assets/js/detailBeer.js"></script>
</body>
</html>
