$(document).ready(function(){
    // Set trigger and container variables
    let trigger = $('.menu__items ul li a'),
        container = $('.page');

    // Fire on click
    trigger.on('click', function(){
        // Set $this for re-use. Set target from data attribute
        let $this = $(this),
            target = $this.data('target');

        if (target != 'exit') {
            // Load target page into container
            container.load('page/' + target + '.php');
        }
        else {
            location.href = 'page/login.php';
        }

        // Stop normal link behavior
        return false;
    });
});

function check_photo(id, check, name) {
    //ajax
    $.ajax({
        method: "POST",
        url: "action/confirm_photo.php",
        data: {id:id, photo:check, name:name},
        success:function (data){
           if (data == 'success') {
               $('#photo_'+id).hide('slow');
           }
        }
    });

}


function open_msg(id){
    $( "#msg_"+id ).slideToggle( "fast" );
    let btn =  document.getElementById("btn_"+id).value;
    if (btn == 'Открыть') {
        document.getElementById("btn_"+id).value = 'Закрыть';
    }
    else {
        document.getElementById("btn_"+id).value = 'Открыть';
    }
}

function open_answer_msg(id) {
    $( "#block_msg_"+id ).slideToggle( "medium" );
}

function send_answer_msg(id, id_to, id_from, theme) {
    let msg = document.getElementById('answer_msg_'+id).value;
    $.ajax({
        method: "POST",
        url: "action/message.php",
        data: {id_to:id_to, id_from:id_from, msg:msg, theme:theme},
        success:function (data){
            if (data == 'true') {
                $('#block_msg_'+id).slideToggle('slow');
                M.toast({html: 'Сообщения отправлено!', classes: 'success'});
                document.getElementById('answer_msg_'+id).value = '';
            }
            else {
                M.toast({html: 'Сообщения не отпралено!', classes: 'error'});
            }
        }
    });
}


function removeFromBlackList(id) {
    let element = document.getElementById("black_"+id);

    $.ajax({
        method: "POST",
        url: "action/black_list.php",
        data:{id:id},
        success:function (data) {
            if (data == 'success') {
                element.parentNode.removeChild(element);
                M.toast({html: 'Пользователь удален из черного списка.', classes: 'success'});
            }
        }
    });
}

function getOptions(id) {
    let idValue = document.getElementById('action_'+id).value;
    let description;
    if (idValue == 'add_black_list') {
        description = prompt('Введите причину');
        if (description) {
            $.ajax({
                method: "POST",
                url: "action/users.php",
                data: {id_user:id, action_id:idValue, description:description},
                success:function (data){
                    if (data == 'block') {
                        M.toast({html: 'Пользователь заблокирован!', classes: 'warning'});
                    }
                    else if (data == 'black_list') {
                        M.toast({html: 'Пользователь уже в черном списке!', classes: 'warning'});
                    }
                    else {
                        $('#status_'+id).load('/admin/page/users.php' + ' #status_'+id);
                        M.toast({html: 'Пользователь добавлен в черный список!', classes: 'success'});
                    }
                }
            });
        }
    }
    else if (idValue == 'block') {
        $.ajax({
            method: "POST",
            url: "action/users.php",
            data: {id_user:id, action_id:idValue, description:description},
            success:function (data){
                if (data == 'true') {
                    M.toast({html: 'Пользователь уже заблокирован!', classes: 'warning'})
                }
                else {
                    M.toast({html: 'Пользователь заблокирован!', classes: 'success'});
                    $('#status_'+id).load('/admin/page/users.php' + ' #status_'+id);
                }
            }
        });
    }
    else {
        $.ajax({
            method: "POST",
            url: "action/users.php",
            data: {id_user:id, action_id:idValue, description:description},
            success:function (data){
                M.toast({html: 'Пользователь удален!', classes: 'success'});
                $('#user_'+id).hide('slow');
            }
        });
    }
}