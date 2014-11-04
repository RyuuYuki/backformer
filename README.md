#Backformer

Ajax форма обратной связи, легко интегрируемая абсолютно в любую CMS.

##Достоинства
* Поддержка капчи.
* Поддержка прикрепления к письму нескольких файлов.
* Защита от спама, CSRF.
* Поддержка работы с несколькими формами на одной странице

## Как подключить

###1. Подключить скрипты в указанной последовательности

Для работы формы потребуется jquery:

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
 
Опционально, [галерея fancyBox](https://github.com/fancyapps/fancyBox) для модальных окон:

    <!-- Add fancyBox main JS and CSS files -->
    <script type="text/javascript" src="/backformer/components/fancybox_2.1.5/source/jquery.fancybox.js?v=2.1.5">
    </script>
    <link rel="stylesheet" type="text/css" href="/backformer/components/fancybox_2.1.5/source/jquery.fancybox.css?v=2.1.5" media="screen" />
    <!-- // end add fancyBox -->

Плагин jquery для отправки форм [jquery.form.js](https://github.com/malsup/form):

    <!-- ajax jquery form -->
    <script src="/backformer/components/jquery.form.js"></script>
    <!-- // end ajax jquery form -->

Собственно сам скрипт:

    <!-- back form -->
    <link href="/backformer/components/backformer/backformer.css" type="text/css" rel="stylesheet" />
    <script src="/backformer/components/backformer/backformer.js"></script>
    <!-- // end back form -->

###2. Пример вызова формы

	<div class="backformer" id="demo">
		<div class="bf-header">
			Форма отправки сообщения!
		</div>
		<div class="bf-status"></div>
		<div class="bf-content">
			<form action="/backformer/index.php" method="post">
				<input class="bf-token" name="bf-token" type="hidden" value="" /> 
				<input name="config" type="hidden" value="demo" />
				<div class="bf-row">
					<div class="bf-info-text">Имя:</div>
					<input required="required" name="name" placeholder="Обязательное поле" type="text" value="" />
				</div>
				<div class="bf-row">
					<div class="bf-info-text">Телефон:</div>
					<input required="required" placeholder="Обязательное поле"  name="phone" placeholder="Обязательное поле" type="text" value="" />
				</div>
				<div class="bf-row">
					<div class="bf-info-text">Комментарий:</div>
					<textarea cols="40" rows="10" name="comment"></textarea>
				</div>
				<div class="bf-row">
					<div class="bf-info-text">Прикрепить файлы:</div>
					<input multiple="multiple" name="upload_file[]" type="file" />
				</div>
				<div class="bf-row">
					<div class="bf-info-img"> 
						<img title="Обновить картинку" class="img-capcha" src="/backformer/model/kcaptcha/index.php" alt="" />
					</div>
					<input class="capcha"  name="capcha" placeholder="Код с картинки" type="text" value="" />
				</div>
				<div class="bf-submit">
					<input class="btn" name="submit" type="submit" value="Отправить"/>
				</div>
			</form>
		</div>
	</div>

####Что из этого нужно знать

	<input name="config" type="hidden" value="demo" />

Это поле используется для выбора конфигурации отправки сообщения. В данном случае конфигурация будет лежать в папке **config/demo**. Можно создать сколько угодно конфигураций, просто копируя эту папку с другим названием. 

####Что внутри

* config.inc.php - конфигурационный файл
* report.html - шаблон отправки на почту. В качестве шаблона для полей используется конструкция **[+название_поля+]** 

###3. Пример вывоза всплывающего окна Fancybox

Для создания всплывающего окна достаточно присвоить в атрибут **href** тега **<****a****>** ссылку **#demo**. 

	<a href="#demo" class="fancybox">Форма связи</a>

И установить идентификатор **demo** на форму.

	<div class="backformer" id="demo">

