$(document).ready(function () {
	// Set trigger and container variables
	let trigger = $('.menu__items ul li a'),
		container = $('.page');
	
	// Fire on click
	trigger.on('click', function () {
		// Set $this for re-use. Set target from data attribute
		let $this = $(this),
			target = $this.data('target');
		
		if (target != 'exit') {
			// Load target page into container
			container.load('page/' + target + '.php');
		} else {
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
		data: {id: id, photo: check, name: name},
		success: function (data) {
			if (data == 'success') {
				$('#photo_' + id).hide('slow');
			}
		}
	});
	
}

function open_msg(id) {
	$("#msg_" + id).slideToggle("fast");
	let btn = document.getElementById("btn_" + id).value;
	if (btn == 'Открыть') {
		document.getElementById("btn_" + id).value = 'Закрыть';
	} else {
		document.getElementById("btn_" + id).value = 'Открыть';
	}
}

function open_answer_msg(id) {
	$("#block_msg_" + id).slideToggle("medium");
}

function send_answer_msg(id, id_to, id_from, theme) {
	let msg = document.getElementById('answer_msg_' + id).value;
	let element = document.getElementById("msg" + id);
	$.ajax({
		method: "POST",
		url: "action/send_message.php",
		data: {id_msg: id, id_to: id_to, id_from: id_from, msg: msg, theme: theme},
		success: function (data) {
			if (data == 'true') {
				M.toast({html: 'Сообщения отправлено!', classes: 'success'});
				element.parentNode.removeChild(element);
			} else {
				M.toast({html: 'Сообщения не отпралено!', classes: 'error'});
			}
		}
	});
}

function delete_msg(id) {
	let element = document.getElementById("msg" + id);
	$.ajax({
		method: "POST",
		url: "action/delete_message.php",
		data: {id_msg: id,},
		success: function (data) {
			if (data == 'true') {
				M.toast({html: 'Сообщения удалено!', classes: 'success'});
				element.parentNode.removeChild(element);
			} else {
				M.toast({html: 'Сообщения не удалено!', classes: 'error'});
			}
		}
	});
}

function removeFromBlackList(id) {
	let element = document.getElementById("black_" + id);
	
	$.ajax({
		method: "POST",
		url: "action/black_list.php",
		data: {id: id},
		success: function (data) {
			if (data == 'success') {
				element.parentNode.removeChild(element);
				M.toast({html: 'Пользователь удален из черного списка.', classes: 'success'});
			}
		}
	});
}

function getOptions(self, id) {
	
	let idValue = document.getElementById('action_' + id).value;
	let description;
	
	if (idValue == 'add_black_list') {
		description = prompt('Введите причину');
		if (description) {
			$.ajax({
				method: "POST",
				url: "action/users.php",
				data: {id_user: id, action_id: idValue, description: description},
				success: function (data) {
					if (data == 'block') {
						M.toast({html: 'Пользователь заблокирован!', classes: 'warning'});
					} else if (data == 'black_list') {
						M.toast({html: 'Пользователь уже в черном списке!', classes: 'warning'});
					} else {
						self.parentNode.parentNode.childNodes[11].innerText = 'В черном списке';
						M.toast({html: 'Пользователь добавлен в черный список!', classes: 'success'});
					}
				}
			});
		}
	} else if (idValue == 'block') {
		$.ajax({
			method: "POST",
			url: "action/users.php",
			data: {id_user: id, action_id: idValue},
			success: function (data) {
				if (data != 'true') {
					M.toast({html: 'Пользователь заблокирован!', classes: 'success'});
					self.parentNode.parentNode.childNodes[11].innerText = 'Заблокирован';
					self.parentNode.previousSibling.previousSibling.childNodes[1].childNodes[3].innerText = 'Разблокировать';
					self.parentNode.previousSibling.previousSibling.childNodes[1].childNodes[3].value = 'unblock';
				}
			}
		});
	} else if (idValue == 'unblock') {
		$.ajax({
			method: "POST",
			url: "action/users.php",
			data: {id_user: id, action_id: idValue},
			success: function (data) {
				if (data == 'true') {
					M.toast({html: 'Пользователь разблокирован!', classes: 'success'});
					self.parentNode.parentNode.childNodes[11].innerText = '';
					self.parentNode.previousSibling.previousSibling.childNodes[1].childNodes[3].innerText = 'Заблокировать';
					self.parentNode.previousSibling.previousSibling.childNodes[1].childNodes[3].value = 'block';
				}
			}
		});
	} else if (idValue == 'delete') {
		$.ajax({
			method: "POST",
			url: "action/users.php",
			data: {id_user: id, action_id: idValue},
			success: function () {
				let el = self;
				while ((el = el.parentElement) && !el.classList.contains('user')) ;
				M.toast({html: 'Пользователь удален!', classes: 'success'});
				el.parentNode.removeChild(el);
			},
			error: function () {
				M.toast({html: 'Ошибка при удалении!', classes: 'error'});
			}
		});
	}
}

function openModal(self) {
	self.nextSibling.nextSibling.style.transform = "scale(1)";
	document.body.style.overflow = "hidden";
}

function closeModal(self) {
	self.parentNode.parentNode.parentNode.style.transform = "scale(0)";
	document.body.style.overflow = "visible";
}

function deletePeople(self, id) {
	$.ajax({
		method: "POST",
		url: "action/remove_people.php",
		data: {id: id},
		success: function (data) {
			if (data == 'success') {
				let el = self;
				
				while ((el = el.parentElement) && !el.classList.contains('container-form')) ;
				
				el.childNodes[1].innerText = el.childNodes[1].innerText - 1;
				if (el.childNodes[1].innerText > 0) {
					self.parentNode.parentNode.parentNode.removeChild(self.parentNode.parentNode);
				} else {
					let el = self;
					let newDiv = document.createElement("div");
					newDiv.innerHTML = '<h2 class=\\"d-flex align-items-center justify-content-center\\">У этого пользователя нет анкет для показа</h2>';
					while ((el = el.parentElement) && !el.classList.contains('table')) ;
					el.replaceWith(newDiv);
				}
				M.toast({html: 'Анкета удалена.', classes: 'success'});
			}
		}
	});
}

function showMoreUsers(self, text, filter) {
 
	let $target = $(self);
	let page = $target.attr('data-page');
	page++;
	
	$.ajax({
		url: '/admin/action/add_users.php?page=' + page + '&filter=' + filter + '&text=' + text,
		dataType: 'html',
		success: function (data) {
			$('#users-list').append(data);
		}
	});
	
	
	$target.attr('data-page', page);
	if (page == $target.attr('data-max')) {
		$target.hide();
	}
	
	return false;
}

function searchUsers(self, filter, input) {
	let text;
	
	if (input == 0) {
		text = '';
	} else {
		text = document.getElementById('search-user').value.trim();
	}
	
	if (self.getAttribute('name') == 'search') {
		$.ajax({
			url: '/admin/action/search_users.php?search=' + text + '&filter=' + filter,
			dataType: 'html',
			success: function (data) {
				$('#users-table').replaceWith(data);
			}
		});
	} else {
		$.ajax({
			url: '/admin/page/users.php?search=' + text + '&filter=' + filter,
			dataType: 'html',
			success: function (data) {
				$('#users-container').replaceWith(data);
			}
		});
	}
}

function changeBalance(self, id) {
	let balance = self.previousSibling.previousSibling.value;
	let el = self;
	while ((el = el.parentElement) && !el.classList.contains('container-form')) ;
	$.ajax({
		method: "POST",
		url: "action/change_balance.php",
		data: {id_user: id, balance_value: balance},
		success: function (data) {
			if (data =='success') {
				self.parentNode.parentNode.parentNode.parentNode.style.transform = "scale(0)";
				document.body.style.overflow = "visible";
				el.childNodes[1].innerText = balance + ' ₽';
				M.toast({html: 'Баланс изменен!', classes: 'success'});
			} else {
				M.toast({html: 'Пустое значение!', classes: 'warning'});
			}
		},
		error: function () {
			M.toast({html: 'Ошибка при изменении!', classes: 'error'});
		}
	});
}