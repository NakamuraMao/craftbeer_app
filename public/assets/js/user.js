function UserViewModel(){
    const self = this;

    self.registerUsername = ko.observable('');
    self.registerEmail = ko.observable('');
    self.registerPassword = ko.observable('');
    self.registerConfirmPassword = ko.observable('');
    self.registerMessage = ko.observable('');
    self.loginEmail = ko.observable(typeof REMEMBERED_EMAIL !== 'undefined' ? REMEMBERED_EMAIL : '');
    self.loginPassword = ko.observable('');
    self.loginMessage = ko.observable('');

    self.register = function(){
        // 入力チェック
        if (!self.registerUsername() || self.registerUsername().length > 50) {
            self.registerMessage('Username is required and must be less than 50 characters.');
            return;
        }
        if (!/\S+@\S+\.\S+/.test(self.registerEmail())) {
            self.registerMessage('Invalid email format.');
            return;
        }
        if (!self.registerPassword() || self.registerPassword().length < 6) {
            self.registerMessage('Password must be at least 6 characters long.');
            return;
        }
        if(self.registerPassword() !== self.registerConfirmPassword()){
            self.registerMessage('Password do not match!');
            return;
        }

        const payload = {
            username: self.registerUsername(),
            email: self.registerEmail(),
            password: self.registerPassword(),
            csrf_token: CSRF_TOKEN 
        };
        registerUser(payload);
    };

    self.login = function() {
        // 入力チェック
        if (!/\S+@\S+\.\S+/.test(self.loginEmail())) {
            self.loginMessage('Invalid email format.');
            return;
        }
        if (!self.loginPassword()) {
            self.loginMessage('Password cannot be empty.');
            return;
        }
        const payload = {
            email: self.loginEmail(),
            password: self.loginPassword(),
            csrf_token: CSRF_TOKEN
        };

        loginUser(payload);
    };
}

// 登録APIを叩く
function registerUser(payload) {
    fetch('/api/user/register', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(data => {
        handleRegisterSuccess(data);
    })
    .catch(err => {
        handleRegisterError(err);
    });
}

// 登録成功処理
function handleRegisterSuccess(data) {
    if (data.status === 'success') {
        alert('Registration successful! You can now log in.');
        setTimeout(() => {
            location.href = '/login';
        }, 1000);
    } else {
        alert(data.message || 'Registration failed...');
    }
}

// 登録エラー処理
function handleRegisterError(err) {
    alert('An error occurred during registration.');
    console.error(err);
}

// ログインAPIを叩く
function loginUser(payload) {
    fetch('/api/user/login', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(data => {
        handleLoginSuccess(data);
    })
    .catch(err => {
        handleLoginError(err);
    });
}

// ログイン成功処理
function handleLoginSuccess(data) {
    if (data.status === 'success') {
        alert('Login successful! Welcome, ' + data.username);
        location.href = '/beer/index';
    } else {
        alert(data.message || 'Login failed...');
    }
}

// ログインエラー処理
function handleLoginError(err) {
    alert('An error occurred during login.');
    console.error(err);
}


ko.applyBindings(new UserViewModel());