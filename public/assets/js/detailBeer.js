function BeerFormViewModel(){
    this.id = ko.observable();
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

    this.sampled_dateFormatted = ko.computed(function () {
        const date = this.sampled_date();
        if (!date) return "";
        return new Date(date).toISOString().slice(0, 10);
    }, this);

    this.loadFromData = function (data) {
        this.id(data.id);
        this.name(data.name);
        this.brewery(data.brewery);
        this.type(data.type);
        this.IBU(data.IBU);
        this.ABV(data.ABV);
        this.origin(data.origin);
        this.sampled_date(data.sampled_date);
        this.appearance(data.appearance);
        this.aroma(data.aroma);
        this.taste(data.taste);
        this.mouthfeel(data.mouthfeel);
        this.overall(data.overall);
        this.image_url(data.image_url);
        if (data.user_id) {
            this.user_id(data.user_id);
        }
    };
    
}

document.addEventListener("DOMContentLoaded", function () {
    const params = new URLSearchParams(window.location.search);
    const beerId = params.get("id");

    if (!beerId) {
        alert("Beer ID is not selected...");
        return;
    }

    const vm = new BeerFormViewModel();

    fetch(`/api/beer?id=${beerId}`)
        .then((res) => res.json())
        .then((data) => {
            if (data.error) {
                alert("cannot find a craftbeer...");
            } else {
                vm.loadFromData(data);
                ko.applyBindings(vm);
            }
        })
        .catch((err) => {
            alert("Failed to get craftbeer information...");
            console.error(err);
        });
});