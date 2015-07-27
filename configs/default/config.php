<?php

/***
* Почта получателей, через запятую
* Пример:  'email@example.com, add_email@example.com' или просто 'email@example.com'
***/
$config['to'] = '';
/***
* Заголовок письма.
* Пример: 'Сообщение из формы связи example.com'
***/
$config['subject'] = '';
/***
* Почта, которая будет указана в качестве адреса отправителя.
* Пример:  'email@example.com'
***/
$config['from_email'] = '';
/***
* Опционально. Имя или название источника отправителя.
* Пример: 'Иванов Иван' или 'Из example.com'.
***/
$config['from_name'] = '';
/***
* Поля обязательные для заполнения.
* Пример: 'name,email,phone'
* Где, например, phone — это значение атрибута 'name' тега <input>.
***/
$config['required_field'] = 'name,phone';
/***
* локализация
***/
$config['used_lang'] = 'ru';
/***
* Типы проверяемых ошибок.
* capcha - проверяет капчу;
* spam - защита от спама, csrf;
* required_field - проверка на пустые поля, заполненные в параметре - 'need_field';
* Пример: 'capcha,spam,required_field'.
***/
$config['error_type'] = 'spam,required_field'; 
/***
* Оправлять почту или нет, по умолчанию [1] - отправлять, [0] - не отправлять.
***/
$config['mail_send'] = 1; 