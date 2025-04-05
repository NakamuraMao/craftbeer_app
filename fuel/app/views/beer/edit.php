<h2>Edit a craftbeer</h2>

<form id="editBeerForm" data-bind="submit: submitForm">
    <input type="hidden" data-bind="value: id">

    <label for="name">Beer Name:</label>
    <input type="text" id="name" data-bind="value: name" required>

    <label for="brewery">Brand Name:</label>
    <input type="text" id="brewery" data-bind="value: brewery" required>

    <label for="type">Type:</label>
    <input type="text" id="type" data-bind="value: type">

    <label for="IBU">IBU (Bitterness):</label>
    <input type="number" id="IBU" data-bind="value: IBU">

    <label for="ABV">ABV (%):</label>
    <input type="number" id="ABV" data-bind="value: ABV" step="0.1">

    <label for="origin">Origin:</label>
    <input type="text" id="origin" data-bind="value: origin">

    <label for="sampled_date">Sampled Date:</label>
    <input type="date" id="sampled_date" data-bind="value: sampled_dateFormatted">

    <label for="appearance">Appearance (1-5):</label>
    <input type="number" id="appearance" data-bind="value: appearance" min="1" max="5">

    <label for="aroma">Aroma (1-5):</label>
    <input type="number" id="aroma" data-bind="value: aroma" min="1" max="5">

    <label for="taste">Taste (1-5):</label>
    <input type="number" id="taste" data-bind="value: taste" min="1" max="5">

    <label for="mouthfeel">Mouthfeel (1-5):</label>
    <input type="number" id="mouthfeel" data-bind="value: mouthfeel" min="1" max="5">

    <label for="overall">Overall (1-5):</label>
    <input type="number" id="overall" data-bind="value: overall" min="1" max="5">

    <label for="image_url">Image URL:</label>
    <input type="text" id="image_url" data-bind="value: image_url">

    <button type="submit">Update</button>
    <button type = "button" onclick="location.href='/beer/index'" style="margin-top: 20px;">Go back to main</button>

</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.1/knockout-latest.min.js"></script>
<script src="/assets/js/editBeer.js"></script>
