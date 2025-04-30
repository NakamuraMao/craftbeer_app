function BeerFormViewModel() {
    this.id = ko.observable();
    //this.user_id = ko.observable(LOGGED_IN_USER_ID);
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
    

    this.sampled_dateFormatted = ko.computed({
        read: () => {
            const date = this.sampled_date();
            return date ? new Date(date).toISOString().slice(0, 10) : "";
        },
        write: (val) => {
            this.sampled_date(val);
        },
        owner: this
    });
//APUで取得したデータをViewModelに代入するメソッド
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
        //this.user_id(data.user_id);
    };
}
//フォームが送信された時に呼ばれる関数
BeerFormViewModel.prototype.submitForm = function () {
    const self = this;
    // 必須項目のチェック
    if (!self.name() || self.name().length > 255) {
        alert('Name is required and must be less than 255 characters.');
        return;
    }
    if (!self.brewery() || self.brewery().length > 255) {
        alert('Brewery is required and must be less than 255 characters.');
        return;
    }
    if (self.type().length > 100) {
        alert('Type is required and must be less than 100 characters.');
        return;
    }
    if (self.origin().length > 100) {
        alert('Origin is required and must be less than 100 characters.');
        return;
    }

    // 数値のチェック
    if (isNaN(self.IBU()) || self.IBU() < 0) {
        alert('IBU must be a valid non-negative number.');
        return;
    }
    if (isNaN(self.ABV()) || self.ABV() < 0 || self.ABV() > 100) {
        alert('ABV must be between 0 and 100.');
        return;
    }

    // 日付のチェック
    if (self.sampled_date() && isNaN(Date.parse(self.sampled_date()))) {
        alert('Sampled Date must be a valid date.');
        return;
    }
    const beerData = {
        id: this.id(),
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
        //user_id: this.user_id(),
        csrf_token: CSRF_TOKEN// CSRF対策トークン
    };
    submitBeerData(beerData);
};

// IDでビールデータ取得するだけの関数
function fetchBeerDetail(beerId) {
    return fetch(`/api/beer/${beerId}`)
        .then(res => res.json());
}

// データをViewModelに反映するだけの関数
function applyBeerDetail(vm, data) {
    if (data.error) {
        alert("Cannot find the craftbeer...");
    } else {
        vm.loadFromData(data);
        ko.applyBindings(vm);
    }
}

// PUTでビールデータ送信する関数
function submitBeerData(beerData) {
    fetch('/api/beer', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(beerData)
    })
    .then(res => res.json())
    .then(data => {
        handleBeerUpdateResponse(data, beerData.id);
    })
    .catch(err => {
        handleBeerUpdateError(err);
    });
}

// 成功時の処理
function handleBeerUpdateResponse(data, beerId) {
    if (data.success) {
        alert("Completed!");
        window.location.href = `/beer/detail?id=${beerId}`;
    } else {
        alert("Failed to update...");
    }
}

// エラー時の処理
function handleBeerUpdateError(err) {
    alert("An error occurred!");
    console.error(err);
}

// ページロード後の初期処理
document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);
    const beerId = params.get("id");

    if (!beerId) {
        alert("ID is not selected...");
        return;
    }

    const vm = new BeerFormViewModel();

    fetchBeerDetail(beerId)
        .then(data => {
            applyBeerDetail(vm, data);
        })
        .catch(err => {
            alert("Error to load craftbeer...");
            console.error(err);
        });
});