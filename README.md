Логування помилок
=================
Додаток дозволяє створювати переглядати помилки, що виникають під час роботи вашої аплікації

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist nahard/log "*"
```

or add

```
"nahard/log": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \nahard\log\AutoloadExample::widget(); ?>```