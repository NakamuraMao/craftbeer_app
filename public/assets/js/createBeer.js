function BeerFormViewModel(){
    this.name = ko.observable("");
    this.brewery = ko.observable("");
    this.type = ko.observable("");
    this.IBU = ko.observable(0);
    this.ABV = ko.observable(0);
    this.origin = ko.observable("");
    this.sampled_date = ko.observable(null);
    this.appearance = ko.observable(0);
    this.aroma = ko.observable(0);
    this.taste = ko.observable(0);
    this.mouthfeel = ko.observable(0);
    this.overall = ko.observable(0);
    this.image_url = ko.observable("");
    this.user_id = ko.observable(3);

    this.sampled_dateFormatted = ko.computed(function() {
        var date = this.sampled_date();
        if (!date) {
            return '';  
        }
        return date.toISOString().slice(0, 10);  
    }, this);
}

BeerFormViewModel.prototype.submitForm = function() {
    //event.preventDefault();

    const beerData = {
        name: this.name(),
        brewery: this.brewery(),
        type: this.type(),
        IBU: this.IBU(),
        ABV: this.ABV(),
        origin: this.origin(),
        sampled_date: this.sampled_date(),
        appearance: this.appearance(),
        aroma: this.aroma(),
        taste: this.taste(),
        mouthfeel: this.mouthfeel(),
        overall: this.overall(),
        image_url: this.image_url(),
        user_id: this.user_id()
    };

    fetch('/api/beer', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(beerData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Craftbeer successfully added!');
        } else {
            alert('Failed to add craftbeer,,,');
        }
    })
    .catch(error => {
        alert('Error occured');
        console.error(error);
    });
};

ko.applyBindings(new BeerFormViewModel());