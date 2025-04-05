<h2 data-bind="text: name"></h2>

<p><strong>Brewery:</strong> <span data-bind="text: brewery"></span></p>

<p><strong>Type:</strong> <span data-bind="text: type"></span></p>

<p><strong>ABV:</strong> <span data-bind="text: ABV"></span>%</p>
<p><strong>IBU:</strong> <span data-bind="text: IBU"></span></p>
<p><strong>Origin:</strong> <span data-bind="text: origin"></span></p>
<p><strong>Sampled Date:</strong> <span data-bind="text: sampled_date"></span></p>
<p><strong>Appearance:</strong> <span data-bind="text: appearance"></span></p>
<p><strong>Aroma:</strong> <span data-bind="text: aroma"></span></p>
<p><strong>Taste:</strong> <span data-bind="text: taste"></span></p>
<p><strong>Mouthfeel:</strong> <span data-bind="text: mouthfeel"></span></p>
<p><strong>Overall:</strong> <span data-bind="text: overall"></span></p>

<div data-bind="if: image_url">
    <img data-bind="attr: {src: image_url() || '/assets/img/no-image.png'}">
</div>
<button type="button"  onclick="location.href='/beer/index'" style="margin-top: 20px;">Go back to main</button>
<a data-bind="attr: { href: '/beer/edit?id=' + id() }" class="edit-button">Edit this craft beer</a>


<script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.1/knockout-latest.min.js"></script>
<script src="/assets/js/detailBeer.js"></script>