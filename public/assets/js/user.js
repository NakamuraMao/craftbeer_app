function UserViewModel(){
    const self = this;

    self.registerUsername = ko.observable('');
    self.registerEmail = ko.observable('');
    self.registerPassword = ko.observable('');
    self.registerConfirmPassword = ko.observable('');
    self.registerMessage = ko.observable('');

    self.register = function(){
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

        fetch('/api/user/register', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success'){
                self.registerMessage('Registration successful! You can now log in.');
                setTimeout(() => {
                    location.href = '/login'; 
                }, 1000);
            }else{
                self.registerMessage(data.message);

            }

        })
        .catch(err => {
            self.registerMessage('An error occured during registration.');
            console.error(err);
        });
    };


    self.loginEmail = ko.observable(typeof REMEMBERED_EMAIL !== 'undefined' ? REMEMBERED_EMAIL : '');
    self.loginPassword = ko.observable('');
    self.loginMessage = ko.observable('');

    self.login = function(){
        const payload = {
            email: self.loginEmail(),
            password: self.loginPassword(),
            csrf_token: CSRF_TOKEN
        };

        fetch('/api/user/login', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success'){
                self.loginMessage('Login successful! Welcome, '+ data.username);
                //localStorage.setItem('user_id', data.user_id);
                location.href = '/beer/index';
            }else{
                self.loginMessage(data.message);
            }
        })
        .catch(err => {
            if (err.status === 409) {
                self.registerMessage('This email is already registered.');
            } else {
                self.registerMessage('An error occurred during registration.');
            }
            console.error(err);
        });
        
    };
}
    
ko.applyBindings(new UserViewModel());