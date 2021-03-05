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
    let element = document.getElementById("msg"+id);
    $.ajax({
        method: "POST",
        url: "action/send_message.php",
        data: {id_msg:id, id_to:id_to, id_from:id_from, msg:msg, theme:theme},
        success:function (data){
            if (data == 'true') {
                M.toast({html: 'Сообщения отправлено!', classes: 'success'});
                element.parentNode.removeChild(element);
            }
            else {
                M.toast({html: 'Сообщения не отпралено!', classes: 'error'});
            }
        }
    });
}

function delete_msg(id) {
    let element = document.getElementById("msg"+id);
    $.ajax({
        method: "POST",
        url: "action/delete_message.php",
        data: {id_msg:id, },
        success:function (data){
            if (data == 'true') {
                M.toast({html: 'Сообщения удалено!', classes: 'success'});
                element.parentNode.removeChild(element);
            }
            else {
                M.toast({html: 'Сообщения не удалено!', classes: 'error'});
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

function getOptions(self, id) {
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
                        self.parentNode.parentNode.childNodes[11].innerText='В черном списке';
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
            data: {id_user:id, action_id:idValue},
            success:function (data){
                if (data != 'true') {
                    M.toast({html: 'Пользователь заблокирован!', classes: 'success'});
                    self.parentNode.parentNode.childNodes[11].innerText='Заблокирован';
                    self.parentNode.previousSibling.previousSibling.childNodes[1].childNodes[3].innerText='Разблокировать';
                    self.parentNode.previousSibling.previousSibling.childNodes[1].childNodes[3].value='unblock';
                }
            }
        });
    }
    else if (idValue == 'unblock') {
        $.ajax({
            method: "POST",
            url: "action/users.php",
            data: {id_user:id, action_id:idValue},
            success:function (data){
                if (data == 'true') {
                    M.toast({html: 'Пользователь разблокирован!', classes: 'success'});
                    self.parentNode.parentNode.childNodes[11].innerText='';
                    self.parentNode.previousSibling.previousSibling.childNodes[1].childNodes[3].innerText='Заблокировать';
                    self.parentNode.previousSibling.previousSibling.childNodes[1].childNodes[3].value='block';
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

function openModal(self) {
    self.nextSibling.nextSibling.style.transform="scale(1)";
    document.body.style.overflow="hidden";
}

function closeModal(self) {
    self.parentNode.parentNode.parentNode.style.transform="scale(0)";
    document.body.style.overflow="visible";
}

function deletePeople(self, id) {
    $.ajax({
        method: "POST",
        url: "action/remove_people.php",
        data:{id:id},
        success:function (data) {
            if (data == 'success') {
                self.parentNode.parentNode.parentNode.removeChild(self.parentNode.parentNode);
                M.toast({html: 'Анкета удалена.', classes: 'success'});
            }
        }
    });
}