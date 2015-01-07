<?php

/***
* Почта получателей, через запятую
* Пример:  'email@example.com, add_email@example.com' или просто 'email@example.com'
***/
$conf['to'] = 'to@gmail.com';
/***
* Почта, которая будет указана в качестве адреса отправителя 
* Пример:  'email@example.com'
***/
$conf['from_email'] = 'from@example.com';
/***
* Опционально. Имя или название источника отправителя.
* Пример: 'Иванов Иван' или 'Из example.com'
***/
$conf['from_name'] = 'Из example.com';
/***
* Заголовок письма.
* Пример: 'Сообщение из формы связи example.com'
***/
$conf['subject'] = 'Сообщение из формы связи example.com';
/***
* Обязательные поля
* Пример: 'name,email,phone'
* Где, например, phone — это значение атрибута 'name' тега <input>
***/
$conf['need_field'] = 'name,phone';
/***
* Использовать капчу 1 - да, 0 - нет.
***/
$conf['capcha'] = 0;
/***
* локализация
***/
$conf['used_lang'] = 'ru';

