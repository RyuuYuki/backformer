#Backformer 2.3.0

Простая, гибкая Ajax форма обратной связи, легко интегрируемая в любую CMS.

* [Скачать](https://github.com/Rugoals/backformer/archive/2.3.0.zip)
* [Сайт](http://rugoals.github.io/backformer)
* [Старые версии](https://github.com/Rugoals/backformer/wiki)

##Достоинства
* Возможность отправки через ajax любых форм.
* Поддержка капчи.
* Поддержка прикрепления к письму нескольких файлов.
* Защита от спама, CSRF.
* Поддержка работы с несколькими формами на одной странице.
* Поддержка локализаций.
* Поддержка всплывающих окон (ie7+).

##Системные требования

* PHP5 >= 5.2.0
* Jquery >= 1.7

## Как подключить

###1. Подключить скрипты в указанной последовательности

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    
    <!-- backformer -->
    <link href="/backformer/core/themes/default/bf.css" type="text/css" rel="stylesheet" />
    <script src="/backformer/core/components/jquery.form.min.js"></script> 
    <script src="/backformer/core/components/backformer.js"></script>
    <!-- // backformer -->

###2. Вызов для встроенной формы на странице

Для подключения достаточно навесить на форму атрибут **data-bf-config=""** и передать ему название конфигурации.
 
По умолчанию, при пустом вызове конфигурации, будет браться из папки **/configs/default**. Можно создать сколько угодно конфигураций, просто копируя папку **default** с другим названием.  

Поддерживается наследование конфигураций. Например в новой можно не указывать почту получателя, она возьмётся из папки - **default**.

###3. Вызов всплывающего окна

Нужно навесить атрибут **data-bf-config=""** на любой тег, кроме формы, по нажатию на который ожидается вызов всплывающего окна.

###4. Что внутри

* config.php - конфигурационный файл. Внутри него комментарии для настройки.
* /templates/report.html - шаблон отправки на почту. В качестве шаблона для полей используется конструкция **{{название_поля}}**. Работает с использованием шаблонизатора Twig.
* /templates/form.html - форма в всплывающем окне fancybox.

###2. Пример вызова формы

    <div class="bf-content-inline">
    <div class="bf-header">
        Форма отправки сообщения!
    </div>
    <form enctype="multipart/form-data" data-bf-config="phone" action="" method="post">
        <div class="bf-row">
            <label>Имя:</label>
            <input required="required" name="name" placeholder="Обязательное поле" type="text" value="" />
        </div>
        <div class="bf-row">
            <label>Телефон:</label>
            <input required="required" name="phone" placeholder="Обязательное поле" type="text" value="" />
        </div>
        <div class="bf-row">
            <label>Комментарий:</label>
            <textarea cols="40" rows="10" name="comment"></textarea>
        </div>
        <div class="bf-row">
            <label>Прикрепить файлы:</label>
            <input multiple="multiple" name="upload_file[]" type="file" />
        </div>
        <div class="bf-row">
            <div class="bf-info-img">
                <img title="Обновить картинку" class="bf-img-capcha" src="/backformer/captcha.php" alt="" />
            </div>
            <input class="capcha" name="capcha" placeholder="Код с картинки" type="text" value="" />
        </div>
        <div class="bf-submit">
            <input class="bf-button" name="submit" type="submit" value="Отправить" />
        </div>
    </form>
</div>
 

 
 
