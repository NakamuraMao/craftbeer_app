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
        //サーバー /api/beerにPOST送信
        fetch('/api/beer', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'//JSON形式で送る宣言
            },
            body: JSON.stringify(beerData)//実際に送るデータの指定
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Craftbeer successfully added!');
                location.href = "/beer/index";
            } else {
                alert('Failed to add craftbeer,,,');
            }
        })
        .catch(error => {
            alert('Error occured');
            console.error(error);
        });
    };
}

ko.applyBindings(new BeerFormViewModel());//HTMLとJavaScriptを双方向で繋ぐ