//ViewModelを定義(knockout.jsで使われる)
//リアルタイムで監視、バインドできるオブジェクト
//データを繋げる
function BeerFormViewModel(){
    const self = this; 

    this.name = ko.observable("");//監視可能
    this.brewery = ko.observable("");
    this.type = ko.observable("");
    this.IBU = ko.observable(0);
    this.ABV = ko.observable(0);
    this.origin = ko.observable("");
    this.sampled_date = ko.observable("");
    this.appearance = ko.observable(0);
    this.aroma = ko.observable(0);
    this.taste = ko.observable(0);
    this.mouthfeel = ko.observable(0);
    this.overall = ko.observable(0);
    this.image_url = ko.observable("");
    this.user_id = ko.observable();
    self.sampled_dateFormatted = ko.computed({
        read: () => {
            const date = self.sampled_date();
            return date ? new Date(date).toISOString().slice(0, 10) : "";
        },
        write: (val) => {
            self.sampled_date(val);
        }
    });



    //フォーム送信字に呼ばれる
    self.submitForm = function() {
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
        //event.preventDefault();
        //フォームのデータをbeerData オブジェクトにまとめる
        const beerData = {
            name: this.name(),
            brewery: this.brewery(),
            type: this.type(),
            IBU: this.IBU(),
            ABV: this.ABV(),
            origin: this.origin(),
            sampled_date: this.sampled_dateFormatted(), 
            appearance: this.appearance(),
            aroma: this.aroma(),
            taste: this.taste(),
            mouthfeel: this.mouthfeel(),
            overall: this.overall(),
            image_url: this.image_url(),
            user_id: this.user_id(),
            csrf_token: CSRF_TOKEN
        };
        submitBeerData(beerData);
    };
}
// データ送信だけ担当する関数
function submitBeerData(beerData) {
    fetch('/api/beer', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(beerData)
    })
    .then(response => response.json())
    .then(data => {
        handleBeerSubmitResponse(data);
    })
    .catch(error => {
        handleBeerSubmitError(error);
    });
}

// 成功したときの処理
function handleBeerSubmitResponse(data) {
    if (data.success) {
        alert('Craftbeer successfully added!');
        location.href = "/beer/index";
    } else {
        alert('Failed to add craftbeer...');
    }
}

// エラーが起きたときの処理
function handleBeerSubmitError(error) {
    alert('Error occurred while submitting craftbeer...');
    console.error(error);
}

// KnockoutとViewModelを繋ぐ
ko.applyBindings(new BeerFormViewModel());//HTMLとJavaScriptを双方向で繋ぐ