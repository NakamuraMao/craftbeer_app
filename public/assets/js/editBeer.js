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
//PUTメソッドでビールデータを更新するAPIへリクエスト送信
    fetch('/api/beer', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(beerData)//JSONに変換
    })
        .then(res => res.json())//responseをJSONに変換
        .then(data => {
            if (data.success) {
                alert("Completed!");
                window.location.href = "/beer/detail?id=" + this.id(); // 編集後に詳細ページへ戻る
            } else {
                alert("Failed to update...");
            }
        })
        .catch(err => {
            alert("An error occured!");
            console.error(err);
        });
};
//HTMLが完全に読み込まれたら実行される関数
document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);
    const beerId = params.get("id");

    if (!beerId) {
        alert("ID is not selected...");
        return;
    }

    const vm = new BeerFormViewModel();

    fetch(`/api/beer/${beerId}`)
        .then(res => res.json())
        .then(data => {
            vm.loadFromData(data);
            ko.applyBindings(vm);
        })
        .catch(err => {
            alert("Error to load...");
            console.error(err);
        });
});
