<ul class="collection with-header">
    <li class="collection-header"><h4>Пролог</h4></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'releases']) }}">Примечания</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'upgrade']) }}">Руководство по обновлению</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'contributions']) }}">Участие в разработке</a></li>
    <li class="collection-item"><a href="https://laravel.com/api/5.2" target="_blank">Документация API</a></li>

    <li class="collection-header"><h4>Настройка</h4></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'installation']) }}">Установка</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'configuration']) }}">Конфигурация</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'homestead']) }}">Homestead</a></li>

    <li class="collection-header"><h4>Учебники</h4></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'quickstart']) }}">Базовый список задач</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'quickstart-intermediate']) }}">Промежуточный список задач</a></li>

    <li class="collection-header"><h4>Основы</h4></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'routing']) }}">Маршрутизация</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'middleware']) }}">Посредники</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'controllers']) }}">Контроллеры</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'requests']) }}">Запросы</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'responses']) }}">Ответы</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'views']) }}">Шаблоны</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'blade']) }}">Шаблонизатор Blade</a></li>

    <li class="collection-header"><h4>Архитектура фреймворка</h4></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'lifecycle']) }}">Жизненный цикл запроса</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'structure']) }}">Структура приложения</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'providers']) }}">Поставщики услуг</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'container']) }}">Контейнеры услуг</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'facades']) }}">Фасады</a></li>

    <li class="collection-header"><h4>Сервисы</h4></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'authentication']) }}">Аутентификация</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'authorization']) }}">Авторизация</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'artisan']) }}">Консоль Artisan</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'billing']) }}">Биллинг</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'cache']) }}">Кэш</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'collections']) }}">Коллекции</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'elixir']) }}">Эликсир</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'encryption']) }}">Шифрование</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'errors']) }}">Ошибки и логирование</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'events']) }}">Мероприятия</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'filesystem']) }}">Файловая система / Облачные хранилища</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'hashing']) }}">Хэширование</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'helpers']) }}">Помощники</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'localization']) }}">Локализация</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'mail']) }}">Почта</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'packages']) }}">Разработка пакетов</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'pagination']) }}">Нумерация страниц</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'queues']) }}">Очереди</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'redis']) }}">Redis</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'session']) }}">Сессии</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'envoy']) }}">Задачи SSH</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'scheduling']) }}">Планировщик задач</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'testing']) }}">Тестирование</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'validation']) }}">Проверка</a></li>

    <li class="collection-header"><h4>Базы данных</h4></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'database']) }}">Начало</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'queries']) }}">Конструктор запросов</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'migrations']) }}">Миграции</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'seeding']) }}">Сиды</a></li>

    <li class="collection-header"><h4>Eloquent ORM</h4></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'eloquent']) }}">Начало</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'eloquent-relationships']) }}">Отношения</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'eloquent-collections']) }}">Коллекции</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'eloquent-mutators']) }}">Мутаторы</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'eloquent-serialization']) }}">Сериализация</a></li>
</ul>