<?php

/***
* Почта получателей, через запятую
* Пример:  'email@example.com, add_email@example.com' или просто 'email@example.com'
***/
$config['to'] = 'rugoals@gmail.com';
/***
* Поля обязательные для заполнения.
* Пример: 'name,email,phone'
* Где, например, phone — это значение атрибута 'name' тега <input>.
***/
$config['need_field'] = 'name,phone';
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
* локализация
***/
$config['used_lang'] = 'ru';
/***
* Типы проверяемых ошибок.
* capcha - проверяет капчу;
* spam - защита от спама, csrf;
* empty_field - проверка на пустые поля, заполненные в параметре - 'need_field';
* Пример: 'capcha,spam,empty_field'.
***/
$config['error_type'] = 'spam,empty_field';

