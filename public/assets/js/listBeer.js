function Beer(data) {
    this.name = ko.observable(data.name);
    this.brewery = ko.observable(data.brewery);
    this.type = ko.observable(data.type);
    this.IBU = ko.observable(data.IBU);
    this.ABV = ko.observable(data.ABV);
    this.origin = ko.observable(data.origin);
    this.sampled_date = ko.observable(data.sampled_date);
    this.appearance = ko.observable(data.appearance);
    this.aroma = ko.observable(data.aroma);
    this.taste = ko.observable(data.taste);
    this.mouthfeel = ko.observable(data.mouthfeel);
    this.overall = ko.observable(data.overall);
    this.image_url = ko.observable(data.image_url);
}

function BeerViewModel() {
    const self = this;

    self.beers = ko.observableArray([]);

    // 新規登録用フォームデータ
    //self.newName = ko.observable('');
    //self.newBrewery = ko.observable('');

    // 初期データの読み込み
    self.loadBeers = function () {
        fetch('/api/beer')
            .then(res => res.json())
            .then(data => {
                const mapped = data.map(item => new Beer(item));
                self.beers(mapped);
            })
            .catch(err => console.error('error:', err));
    };

    // 登録処理
    /*self.addBeer = function () {
        const payload = {
            name: self.newName(),
            brewery: self.newBrewery()
        };

        fetch('/api/beer', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            payload.id = data.id;
            self.beers.unshift(new Beer(payload));
            self.newName('');
            self.newBrewery('');
        })
        .catch(err => console.error('登録エラー:', err));
    };*/

    // 削除処理（APIにDELETEを送る）
    self.deleteBeer = function (beer) {
        fetch(`/api/beer/${beer.id}`, {
            method: 'DELETE'
        })
        .then(() => {
            self.beers.remove(beer);
        })
        .catch(err => console.error('error:', err));
    };

    self.loadBeers(); // 初期化時に呼ぶ
}

ko.applyBindings(new BeerViewModel());