//一つのビール情報を表すモデル（個別データ）
function BeerModel(data) {
    this.id = data.id;
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
//ビールのリスト全体を管理　ViewModel(画面全体)
function BeerListViewModel() {
    const self = this;

    self.beers = ko.observableArray([]);

    // 新規登録用フォームデータ
    //self.newName = ko.observable('');
    //self.newBrewery = ko.observable('');

    // 初期データの読み込み
    //ビール一覧をAPIから取得して配列にセットする関数
    self.loadBeers = function () {
        //const currentUserId = localStorage.getItem('user_id');

        fetch(`/api/beer`)
            .then(res => res.json())
            .then(data => {
                const mapped = data.map(item => new BeerModel(item));//各アイテムをBeerModelに変換してKnockout用にする
                self.beers(mapped);//beers配列にセットして画面に反映
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
        if (!confirm(`You would like to delete ${beer.name()}?`)) {
            return;
        }
        //ビールのIDをURLに指定してDELETEをリクエストする
        fetch(`/api/beer/${beer.id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ csrf_token: CSRF_TOKEN }) // CSRF対策トークンを送信
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                self.beers.remove(beer);// 成功したらbeers配列から該当のBeerを削除（画面からも消える）
                alert('Success to delete!');
            } else {
                alert('Failed to delete...');
                console.error(data.error);
            }
        })
        .catch(err => {
            alert('An error occured...');
            console.error(err);
        });
    };
    //ページ読み込み時にビール一覧を取得して表示
    self.loadBeers(); // 初期化時に呼ぶ

}

ko.applyBindings(new BeerListViewModel());