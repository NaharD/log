Логування помилок
=================
Додаток дозволяє в зручному режимі переглядати помилки, що виникають під час роботи вашої аплікації

Встановлення
------------

Встановлення відбувається за допомогою [composer](http://getcomposer.org/download/).

Додайте залежність в композер

```
php composer.phar require --prefer-dist nahard/log "*"
```

або додайте в секцію `require` файлу `composer.json`

```
"nahard/log": "*"
```

В секцію `repositories` додайте наступний блок

```
{
    "type": "git",
    "url": "https://github.com/NaharD/log.git"
},
```

Виконайте міграцію

```
yii migrate --migrationPath=@vendor/nahard/log/migrations/m171003_173213_create_log_table.php
```

або скопіюйте її до головної директорії `migrations` та виконайте команду `yii migrate`

На цьому етапі встановлення завершено.
Переходимо до конфігурування.

Конфігурування
--------------

В головний файл конфігувацій, зазвичай це `web.php` додаємо наступну ціль для логування

```
'components' => [
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
				[
					'class' => 'nahard\log\components\DbTarget',
					'levels' => ['error', 'warning'],
					'logVars' => [],
//					'except' => [                       // Не логувати 404 помилки. На початкових етапах краще додавати такого виключення
//						'yii\web\HttpException:404',
//					],
				],
			],
		],
    ],
],
```

Якщо компонент `log` не додано до автозавантаження, додаємо

```
'bootstrap' => ['log'],
```

З цього моменту всі помилку вже пишуться в базу.

Додаємо можливість переглядати помилки через веб інтерфейс.

В головний файл конфігурування, додаємо новий модуль. Цей модуть використовує макет [adminLTE](https://github.com/dmstr/yii2-adminlte-asset)
Якщо ж ви використовуєте інший макет, тоді доведеться розробити власний модуть, використовуючи моделі `nahard\log\models\Log` та `nahard\log\models\LogSearch`

```
'modules' => [
    'log' => [
        'class' => 'nahard\log\Module',
        'layout' => '@app/modules/control/views/layouts/main',          // шлях до вашого макету
        'accessRules' => [
            [
                'actions' => ['view'],
                'allow' => true,
                'roles' => ['@'],                                      // Якщо маєте більш об'ємну систему ролей, змініть це
            ],
            [
                'actions' => ['index'],
                'allow' => true,
                'roles' => ['@'],
            ],
            [
                'actions' => ['create'],
                'allow' => true,
                'roles' => ['@'],
            ],
            [
                'actions' => ['update'],
                'allow' => true,
                'roles' => ['@'],
            ],
            [
                'actions' => ['delete'],
                'allow' => true,
                'roles' => ['@'],
            ],
        ]
    ],
],
```

Для зручного використання створіть свіджет, додавши наступний код до макету `header.php`

```
<li class="dropdown notifications-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-exclamation-triangle text-red"></i>
        <?if ($freshInformCount= Log::getFreshLogCount()):?>
            <span class="label label-warning"><?=$freshInformCount?></span>
        <?endif;?>
    </a>
    <ul class="dropdown-menu">
        <li class="header">Маємо <?=Log::getFreshLogCount()?> системні помилки</li>
        <li>
            <ul class="menu">
                <?foreach (Log::getFreshLogMessages(10) as $log):?>
                    <li>
                        <a href="<?=Url::to(['/log/log/view', 'id'=>$log->id])?>">
                            <i class="fa fa-warning text-yellow"></i>
                            <?=Html::encode($log->message)?>
                        </a>
                    </li>
                <?endforeach;?>
            </ul>
        </li>
        <li class="footer">
            <?=Html::a('Переглянути всі повідомлення', ['/control/log/index'])?>
        </li>
    </ul>
</li>
```