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

        fetchBeers()
            .then(data => {
                applyBeerList(self, data);
            })
            .catch(err => {
                console.error('Failed to load beers:', err);
                alert('Error loading craft beers.');
            });
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
        //  入力チェックを追加 
        if (!beer || isNaN(beer.id) || parseInt(beer.id) <= 0) {
            alert('Invalid Beer ID. Cannot proceed with deletion.');
            return;
        }

        if (!confirm(`You would like to delete ${beer.name()}?`)) {
            return;
        }
        deleteBeerFromServer(beer)
            .then(data => {
                handleBeerDeleteSuccess(self, beer, data);
            })
            .catch(err => {
                handleBeerDeleteError(err);
            });
    };

    self.loadBeers(); // 初期化時に呼び出し
}

// APIからビール一覧を取得
function fetchBeers() {
    return fetch('/api/beer')
        .then(res => res.json());
}

// ビールリストをViewModelにセット
function applyBeerList(vm, data) {
    const mapped = data.map(item => new BeerModel(item));
    vm.beers(mapped);
}

// サーバーに削除リクエストを送る
function deleteBeerFromServer(beer) {
    return fetch(`/api/beer/${beer.id}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ csrf_token: CSRF_TOKEN })
    }).then(res => res.json());
}

// 削除成功時
function handleBeerDeleteSuccess(vm, beer, data) {
    if (data.success) {
        vm.beers.remove(beer);
        alert('Successfully deleted!');
    } else {
        alert('Failed to delete...');
        console.error(data.error);
    }
}

// 削除エラー時
function handleBeerDeleteError(error) {
    alert('An error occurred during deletion...');
    console.error(error);
}

// Knockoutとバインド
ko.applyBindings(new BeerListViewModel());
        