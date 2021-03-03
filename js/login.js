$(document).ready(function (){
    $('button#btn-login').on('click', function (){
        let loginValue = $('input#login').val();
        let passValue = $('input#pass').val();
        let msg = $('.msg-login');

        $.ajax({
            method: "POST",
            url: "../action/login.php",
            data: {login:loginValue, pass:passValue},
            success:function (data){

                if (data == 'login') {
                    msg.html('<div class="alert alert-warning">Введите логин!</div>');
                    console.log('hi');
                }
                else if (data == 'pass') {
                    msg.html('<div class="alert alert-warning">Введите пароль!</div>');
                }
                else if (data == 'true') {
                    location.href = '../index.php';
                }
                else {
                    msg.html('<div class="alert alert-danger">Неправильный логин или пароль!</div>');
                }
            }
        })
    });
});