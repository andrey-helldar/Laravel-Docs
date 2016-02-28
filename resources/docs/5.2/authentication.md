# Аутентификация

- [Введение](#introduction)
    - [Обсуждение базы данных](#introduction-database-considerations)
- [Быстрый старт](#authentication-quickstart)
    - [Маршрутизация](#included-routing)
    - [Шаблоны](#included-views)
    - [Аутентификация](#included-authenticating)
    - [Получение идентифицированного пользователя](#retrieving-the-authenticated-user)
    - [Защита маршрутов](#protecting-routes)
    - [Регулирование аутентификацией](#authentication-throttling)
- [Ручная аутентификация пользователей](#authenticating-users)
    - [Запоминание пользователей](#remembering-users)
    - [Другие методы аутентификации](#other-authentication-methods)
- [Базовая аутентификация HTTP](#http-basic-authentication)
    - [Базовая аутентифицация Stateless HTTP](#stateless-http-basic-authentication)
- [Сброс паролей](#resetting-passwords)
    - [Настройка базы данных](#resetting-database)
    - [Настройка маршрутизации](#resetting-routing)
    - [Настройка шаблонов](#resetting-views)
    - [Действия после сброса пароля](#after-resetting-passwords)
    - [Настройка](#password-customization)
- [Аутентификация через социальные сети](https://github.com/laravel/socialite)
- [Добавление пользовательской защиты](#adding-custom-guards)
- [Добавление других провайдеров пользователя](#adding-custom-user-providers)
- [События](#events)

<a name="introduction"></a>
## Введение

Laravel делает очень простую реализацию аутентификации. Почти все уже настроено и доступно "из коробки". Файл конфигурации находится в `config/auth.php`, который содержит документированные варианты тонкой настройки службы аутентификации.

По своей сути, средства аутентификации Laravel состоят из "охранников" и "поставщиков". Охранники проверают подлинность каждого запроса пользователя. Например, Laravel защищает сессию, проверяя сохраняя и проверяя состояние куки сессии и токена пользователя, передаваемых с каждым запросом.

Поставщики определяют, каким образом пользователи извлекаются из постоянного хранилища. Laravel поддерживает получение пользователей через Eloquent и конструктор запросов к базе данных. Тем не менее, при необходимости, Вы можете определить дополнительные провайдеры.

Не беспокойтест, если это вводит Вас в заблуждение! Большинству приложений не нужно изменять конфигурацию аутентификации, так как используются настройки по-умолчанию.

<a name="introduction-database-considerations"></a>
### Обсуждение базы данных

По-умолчанию, Laravel включает в себя [модель Eloquent](/docs/{{version}}/eloquent) `App\User` в директории `app`. Эта модель может использоваться с базовым драйвером аутентификации Eloquent. Если Ваше приложение не использует Eloquent, Вы можете использовать драйвер аутентификации базы данных, использующий конструктор запросов Laravel.

При построении модели `App\User` в базе данных убедитесь, что длина колонки пароля равна 60 символам.

Так что, Вы должны убедиться, что Ваша таблица `users` (или эквивалент) содержит обнуляемую (`nullable`) колонку `remember_token` типа `string` длиной 100 символов. Этот столбец используется приложением для хранения значения при необходимости "запоминания" статуса аутентификации пользователя ("запромнить меня").

<a name="authentication-quickstart"></a>
## Быстрый старт

Из коробки Laravel содержит два контроллера, расположенных в пространстве имен `App\Http\Controllers\Auth`. `AuthController` обрабатывает регистрацию нового пользователя и аутентификацию в то время, как `PasswordController` содержит логику для восстановления паролей учетных записей. Для многих приложений эти контроллеры изменять не нужно.

<a name="included-routing"></a>
### Маршрутизация

Laravel обеспечивает быстрое создание всех необходимых маршрутов, контроллеров и шаблонов, необходимых для управления аутентификацией. Это делается с помощью одной простой команды:

    php artisan make:auth

Эту команду нужно использовать на новых приложениях с необходимостью регистрации и авторизации пользователей. Контроллер `HomeController` будет создан автоматически, в шаблонах которого имеется привязка к аутентификации пользователей. Вы можете изменить или удалить этот контроллер на свое усмотрение.

<a name="included-views"></a>
### Шаблоны

Как упоминалось в предыдущем разделе, команда `php artisan make:auth` автоматически создает необходимые шаблоны в папке `resources/views/auth`.

Команда `make:auth` также создаст папку `resources/views/layouts`, содержащую базовый макет для Вашего приложения. Все эти представления используют CSS фреймворк [Twitter Bootstrap](http://getbootstrap.com). При желании, Вы можете заменить его на другой.

<a name="included-authenticating"></a>
### Аутентификация

Теперь, когда у Вас есть маршруты и шаблоны настройки для внедрения контроллеров аутентификации, Вы готовы регистрировать и аутентифицировать новых пользователей! Можете проверить в браузере насколько это просто. Контроллеры аутентификации уже содержат логику (через трейты) для аутентификации существующих пользователей и сохранения новых в базе данных.

#### Настройка пути

Когда пользователь успешно аутентифицирован, он будет перенаправлен на страницу `/home`. Вы можете изменить адрес перенаправления после аутентификации путем определения свойства `redirectTo` в `AuthController`:

    protected $redirectTo = '/home';

В случае ошибки авторизации, пользователь будет перенаправлен на страницу входа.

#### Настройка защиты

Вы также можете настроить защиту, используемую при аутентификации. Для начала, определите свойство `guard` в контроллере `AuthController`. Значение этого свойства должно соответствовать одному из доступных средств, настроенных в файле конфигурации `auth.php`:

    protected $guard = 'admin';

#### Проверка / Настройка хранения

Для изменения полей формы и/или колонок в таблице, необходимых для регистрации нового пользователя, Вы можете изменить класс `AuthController`. Этот класс отвечает за проверку и создание пользователей.

Метод `validator` контроллера `AuthController` содержит правила проверки новых пользователей. Вы можете изменять этот метод.

Метод `create` контроллера `AuthController` отвечает за созание новых записей `App\User` в базе данных при помощи [Eloquent ORM](/docs/{{version}}/eloquent). Вы можете изменить этот метод в соответствии с Вашими потребностями.

<a name="retrieving-the-authenticated-user"></a>
### Получение идентифицированного пользователя

Получить доступ к аутентифицированному пользователю можно используя фасад `Auth`:

    $user = Auth::user();

В качестве альтернативы, как только пользователь пройдет проверку подлинности, Вы можете получить доступ к введенным пользователем данным через `Illuminate\Http\Request`. Помните, что классы будут автоматически внедрены в методы контроллера:

    <?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;

    class ProfileController extends Controller
    {
        /**
         * Update the user's profile.
         *
         * @param  Request  $request
         * @return Response
         */
        public function updateProfile(Request $request)
        {
            if ($request->user()) {
                // $request->user() returns an instance of the authenticated user...
            }
        }
    }

#### Проверка статуса авторизации пользователя

Для проверки статуса авторизации необходимо использовать метод `check` фасада `Auth`. Если пользователь авторизован, метод вернет `true`:

    if (Auth::check()) {
        // The user is logged in...
    }

Вы можете использовать посредников, чтобы убедиться в аутентифицированности пользователя прежде, чем разрешить доступ к определенным маршрутам и/или контроллерам. Узнать больше Вы можете в документации о [защите маршрутов](/docs/{{version}}/authentication#protecting-routes).

<a name="protecting-routes"></a>
### Защита маршрутов

[Маршруты посредников](/docs/{{version}}/middleware) могут использоваться для проверки аутентификации пользователя перед разрешением доступа к маршруту. Laravel поставляется с посредником `auth`, определенного в `app\Http\Middleware\Authenticate.php`. Все, что Вам нужно сделать, это указать имя посредника в маршруте:

    // Using A Route Closure...

    Route::get('profile', ['middleware' => 'auth', function() {
        // Only authenticated users may enter...
    }]);

    // Using A Controller...

    Route::get('profile', [
        'middleware' => 'auth',
        'uses' => 'ProfileController@show'
    ]);

Конечно, если Вы используете [классы контроллера](/docs/{{version}}/controllers), можно вызвать метод `middleware` прямо из контроллера, а не при определении маршрута:

    public function __construct()
    {
        $this->middleware('auth');
    }

#### Специфика защиты

При указании посредника `auth` в маршруте, Вы также можете указать какую защиту использовать при выполнении аутентификации:

    Route::get('profile', [
        'middleware' => 'auth:api',
        'uses' => 'ProfileController@show'
    ]);

Защитник должен соответствовать одному из перечисленных в массиве `guards` конфигурационного файла `auth.php`.

<a name="authentication-throttling"></a>
### Регулирование аутентификацией

Если Вы используете встроенный в Laravel класс `AuthController`, трейт `Illuminate\Foundation\Auth\ThrottlesLogins` может быть использован для контроля попытками входа. По-умолчанию, пользователь не сможет авторизоваться в течение одной минуты, если учетные данные были неверно введены несколько раз. Контроль входа уникален для логина / email / IP-адреса пользователя:

    <?php

    namespace App\Http\Controllers\Auth;

    use App\User;
    use Validator;
    use App\Http\Controllers\Controller;
    use Illuminate\Foundation\Auth\ThrottlesLogins;
    use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

    class AuthController extends Controller
    {
        use AuthenticatesAndRegistersUsers, ThrottlesLogins;

        // Rest of AuthController class...
    }

<a name="authenticating-users"></a>
## Ручная аутентификация пользователей

Конечно, Вы не обязаны использовать контроллеры аутентификации, включенных в Laravel. Если Вы решили удалить эти контроллеры, для управления аутентификацией пользователей Вам нужно будет использовать классы непосредственно Laravel. Не волнуйтесь, это не сложно!

Для получения доступа к сервисам аутентификации Laravel, [фасад](/docs/{{version}}/facades) `Auth` должен быть импортирован в верхней части класса. Затем проверьте метод `attempt`:

    <?php

    namespace App\Http\Controllers;

    use Auth;

    class AuthController extends Controller
    {
        /**
         * Handle an authentication attempt.
         *
         * @return Response
         */
        public function authenticate()
        {
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                // Authentication passed...
                return redirect()->intended('dashboard');
            }
        }
    }

Метод `attempt` принимает массив пар ключей и значений в качестве первого аргумента. Значения в массиве будут использоваться, чтобы найти пользователя в таблице базы данных. Таким образом, в приведенном выше примере, пользователь будет извлечен по значению из колонки `email`. Если пользователь найден, произойдет сравнение хэшированного пароля из базы данных с захэшированным паролем, введенным пользователем. Если два хэша совпадут, сессия пользователя будет считаться авторизованной.

Если пользователь успешно аутентифицирован, метод `attempt` вернет `true`, иначе - `false`.

Метод `intended` будет перенаправлять пользователя на URL, к которому пользователь пытается получить доступ. Можно указать резервный URL, если основной недоступен.

#### Дополнительные условия

При желании, Вы также можете добавить дополнительные условия при аутентификации помимо email и пароля. Например, мы можем проверить помечен ли пользователь как "активный":

    if (Auth::attempt(['email' => $email, 'password' => $password, 'active' => 1])) {
        // The user is active, not suspended, and exists.
    }

> **Примечание:** В этих примерах `email` является необязательной опцией, используемой в качестве примера. Вы должны использовать любую колонку, отвечающую за логин пользователя в Вашей базе данных.

#### Защита доступа к определенным экземплярам

Вы можете указать какого бы защитника хотите использовать с помощью метода `guard` в фасаде `Auth`. Это позволит управлять проверкой подлинности для отдельных частей приложения с использованием совершенно разных моделей или таблиц пользователей.

Имя защитника передается в метод `guard`, который должен соответствовать одному из настроенных в конфигурационном файле `auth.php`:

    if (Auth::guard('admin')->attempt($credentials)) {
        //
    }

#### Выход из системы

Для отмены регистрации пользователя используйте метод `logout` фасада `Auth`:

    Auth::logout();

<a name="remembering-users"></a>
### Запоминание пользователей

Для реализации функционала "запомнить меня", Вы можете передать логическое значение в качестве аргумента в метод `attempt`, который "запомнит" пользователя на неопределенный срок, либо до выхода из системы вручную. Таблица `users` должна содержать столбец `remember_token` для хранения маркера авторизации.

    if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
        // The user is being remembered...
    }

Если Вы "запоминаете" пользователей, то можете использовать метод `viaRemember` для проверки кук на наличие маркера "запомнить меня":

    if (Auth::viaRemember()) {
        //
    }

<a name="other-authentication-methods"></a>
### Другие методы аутентификации

#### Аутентификация пользователя

При необходимости ручной авторизации пользователя, Вы можете вызвать метод `login` с указанием логина. Данный объект реализуется из [контрактов](/docs/{{version}}/contracts) `Illuminate\Contracts\Auth\Authenticatable`. Конечно, модель `App\User` включена в Laravel и реализует эту возможность:

    Auth::login($user);

#### Аутентификация пользователя по ID

Для аутентификации пользователя по идентификатору (`ID`), нужно использовать метод `loginUsingId`. Этот метод принимает первичный ключ пользователя:

    Auth::loginUsingId(1);

#### Аутентификация пользователя после того, как

Вы можете использовать метод `once` для аутентификации пользователя в приложении. Сессии или куки не будут использоваться. Метод `once` имеет ту же подпись, что и метод `attempt`:

    if (Auth::once($credentials)) {
        //
    }

<a name="http-basic-authentication"></a>
## Простая аутентификация HTTP

[Базовая аутентификация HTTP](http://en.wikipedia.org/wiki/Basic_access_authentication) обеспечивает быструю аутентификацию пользователя Вашего приложения без создания специальной страницы входа. Для начала, укажите [посредника](/docs/{{version}}/middleware) `auth.basic` в маршруте. Посредник `auth.basic` входит в состав фреймворка Laravel, так что его можно использовать сразу:

    Route::get('profile', ['middleware' => 'auth.basic', function() {
        // Only authenticated users may enter...
    }]);

После того, как посредник прикреплен к маршруту, автоматически будет предложено ввести учетные данные при получении доступа к маршруту в браузере. По-умолчанию, посредник `auth.basic` использует колонку `email` в качестве логина.

#### Обратите внимание на FastCGI

Если Вы используете PHP FastCGI, простая аутентификация HTTP может работать некорректно "из коробки". Вам необходимо добавить следующие строки в файл `.htaccess`:

    RewriteCond %{HTTP:Authorization} ^(.+)$
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

<a name="stateless-http-basic-authentication"></a>
### Базовая аутентифицация Stateless HTTP

Также можно использовать простую аутентификацию HTTP без записи идентификатора пользователя в куки сессии, что особенно полезно для аутентификации в API. Для этого определяют [посредника](/docs/{{version}}/middleware), вызывающего метод `onceBasic`. Если ответ метода не возвращается (`false`), то запрос будет передан дальше:

    <?php

    namespace Illuminate\Auth\Middleware;

    use Auth;
    use Closure;

    class AuthenticateOnceWithBasicAuth
    {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle($request, Closure $next)
        {
            return Auth::onceBasic() ?: $next($request);
        }

    }

Ждалее, [зарегистрируйте маршрут посредника](/docs/{{version}}/middleware#registering-middleware) и прикрепите его к маршруту:

    Route::get('api/user', ['middleware' => 'auth.basic.once', function() {
        // Only authenticated users may enter...
    }]);

<a name="resetting-passwords"></a>
## Сброс паролей

<a name="resetting-database"></a>
### Настройка базы данных

Большинство приложений позволяют пользователям с легкостью восстанавливать забытые пароли. Вместо постоянной реализации этого механизма вручную, Laravel содержит эти методы "из коробки".

Для начала, проверьте модель `App\User` для реализации `Illuminate\Contracts\Auth\CanResetPassword`. Конечно, модель `App\User` уже поддерживается фреймворком, а также использует трейт `Illuminate\Auth\Passwords\CanResetPassword` для его реализации.

#### Генерация тококена сброса в таблице миграции

Теперь необходимо создать таблицу для сброса паролей. Миграция для этой таблицы включена в Laravel "из коробки" и расположена в папке `database/migrations`. Так что, все что нужно сделать, это:

    php artisan migrate

<a name="resetting-routing"></a>
### Настройка маршрутизации

Контроллер `Auth\PasswordController` фреймворка содержит логику сброса паролей. Все необходимые маршруты могут быть созданы, выполнив одну команду:

    php artisan make:auth

<a name="resetting-views"></a>
### Настройка шаблонов

Опять же, Laravel создаст все необходимые шаблоны для сброса пароля, когда Вы выполните команду `make:auth`. Шаблоны будут размещены в `resources/views/auth/passwords`. Вы можете изменить их при желании.

<a name="after-resetting-passwords"></a>
### Действия после сброса пароля
Определив маршруты и шаблоны сброса пароля, Вы можете перейти на страницу `/password/reset` в браузере. Контроллер `PasswordController` включен в фреймворк и содержит всю необходимую логику для сброса пароля путем отправки специально сгенерированной ссылки на email-адрес пользователя.

После сброса пароля, пользователь будет перенаправлен на страницу `/home`. Вы можете изменить путь для переадресации изменив свойство `redirectTo` контроллера `PasswordController`:

    protected $redirectTo = '/dashboard';

> **Примечание:** По-умолчанию, токен сброса пароля действует один час. Вы можете изменить продолжительность жизни токена, изменив опцию `expire` в конфигурационном файле `config/auth.php`.

<a name="password-customization"></a>
### Настройка

#### Настройка защиты аутентификации

В конфигурационном файле `auth.php` можно настроить несколько "защитников", которые могут использоваться для контроля аутентификации нескольких пользовательских таблиц (что-то вроде разделения на группы). Вы можете настроить контроллер `PasswordController` для использования конкретного защитника, указав свойство `$guard` в контроллере:

    /**
     * The authentication guard that should be used.
     *
     * @var string
     */
    protected $guard = 'admins';

#### Настройка брокеров паролей

В конфигурационном файле `auth.php` можно настроить несколько "брокеров" паролей, которые могут использоваться для сброса паролей в нескольких таблицах пользователей. Вы можете настроить входящий в фреймворк `PasswordController` для использования "брокера", добавив к нему свойство `$broker`:

    /**
     * The password broker that should be used.
     *
     * @var string
     */
    protected $broker = 'admins';

<a name="adding-custom-guards"></a>
## Добавление пользовательской защиты

Вы можете задать своих защитников аутентификации, используя метод `extend` фасада `Auth`. Для этого необходимо разместить вызов `поставщика` (`provider`) в [поставщика услуг](/docs/{{version}}/providers):

    <?php

    namespace App\Providers;

    use Auth;
    use App\Services\Auth\JwtGuard;
    use Illuminate\Support\ServiceProvider;

    class AuthServiceProvider extends ServiceProvider
    {
        /**
         * Perform post-registration booting of services.
         *
         * @return void
         */
        public function boot()
        {
            Auth::extend('jwt', function($app, $name, array $config) {
                // Return an instance of Illuminate\Contracts\Auth\Guard...

                return new JwtGuard(Auth::createUserProvider($config['provider']));
            });
        }

        /**
         * Register bindings in the container.
         *
         * @return void
         */
        public function register()
        {
            //
        }
    }

Как Вы можете видеть в приведенном выше примере, обратный вызов передается методом `extend`, возвращающим `Illuminate\Contracts\Auth\Guard`. Этот интерфейс содержит несколько методов, нуобходимых для реализации определения "защитника".

После того, как "защитник" определен, Вы можете определить его в конфигурации `guards`:

    'guards' => [
        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
    ],

<a name="adding-custom-user-providers"></a>
## Добавление другийх провайдеров пользователя

Если Вы не используете традиционную реляционную базу данных для хранения пользователей, то Вам необходимо расширить функциональность Laravel Вашим поставщиком для проверки подлинности пользователя. Мы будем использовать метод `provider` фасада `Auth` для определения пользовательского поставщика. Необходимо поместить вызов `поставщика` в [поставщика услуг](/docs/{{version}}/providers):

    <?php

    namespace App\Providers;

    use Auth;
    use App\Extensions\RiakUserProvider;
    use Illuminate\Support\ServiceProvider;

    class AuthServiceProvider extends ServiceProvider
    {
        /**
         * Perform post-registration booting of services.
         *
         * @return void
         */
        public function boot()
        {
            Auth::provider('riak', function($app, array $config) {
                // Return an instance of Illuminate\Contracts\Auth\UserProvider...
                return new RiakUserProvider($app['riak.connection']);
            });
        }

        /**
         * Register bindings in the container.
         *
         * @return void
         */
        public function register()
        {
            //
        }
    }

После того, как Вы зарегистрировали поставщика услуг в методе `provider`, Вы можете переключиться на него в конфигурационном файле `config/auth.php`. Сперва определив какой драйвер он будет использовать:

    'providers' => [
        'users' => [
            'driver' => 'riak',
        ],
    ],

Then, you may use this provider in your `guards` configuration:

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

### Договор поставщика пользователя

`Illuminate\Contracts\Auth\UserProvider` отвечает только за вызов `Illuminate\Contracts\Auth\Authenticatable` из постоянной системы хранения данных, таких как MySQL, Riak, etc. Эти два интерфейса позволяют механизмам фреймворка функционировать независимо от типа класса, используемого для его представления.

Взглянем на `Illuminate\Contracts\Auth\UserProvider`:

    <?php

    namespace Illuminate\Contracts\Auth;

    interface UserProvider {

        public function retrieveById($identifier);
        public function retrieveByToken($identifier, $token);
        public function updateRememberToken(Authenticatable $user, $token);
        public function retrieveByCredentials(array $credentials);
        public function validateCredentials(Authenticatable $user, array $credentials);

    }

Функция `retrieveById` получает пользователя по идентификатору, например, авто-инкрементный идентификатор из базы данных MySQL. `Authenticatable` должен соответствовать идентификатору и возвращаться методом.

Функция `retrieveByToken` получает пользователя по уникальному идентификатору (`$identifier`) и токену "запомнить меня", записанному в поле `remember_token`. Как и в предыдущем методе, реализация `Authenticatable` должна быть возвращена.

Метод `updateRememberToken` обновляет поле `remember_token` новым токеном (`$token`) у пользователя `$user`. Новый токен будет получен при успешном входе с включенным маркером "запомнить меня" или когда пользователь выходит из системы.

Метод `retrieveByCredentials` получает массив данных, передаваемых в метод `Auth::attempt` при попытке авторизации. Метод должен отправить запрос в хранилище данных, найдя в нем необходимого пользователя. Как правило, этот метод будет работать только указав `$credentials['username']` в блоке "where". Метод должен вернуть запись пользователя `UserInterface`. **Этот метод не должен проверять пароль пользователя или его аутентификацию.**

Метод `validateCredentials` должен сравнить значение `$user` с `$credentials` для аутентификации пользователя. Например, этот метод может сравнить строку `$user->getAuthPassword()` с `Hash::make` из `$credentials['password']`. Этот метод должен только подтвердить соответствие данных пользователя и вернуть логическое значение `true` в случае успеха, или `false` в случае отказа.

### Договор аутентификации

Теперь, когда мы исследовали каждый из методов `UserProvider`, взглянем на договор `Authenticatable`. Запомните, что поставщик должен возвращать реализации этого интерфейса из методов `retrieveById` и `retrieveByCredentials`:

    <?php

    namespace Illuminate\Contracts\Auth;

    interface Authenticatable {

        public function getAuthIdentifier();
        public function getAuthPassword();
        public function getRememberToken();
        public function setRememberToken($value);
        public function getRememberTokenName();

    }

Этот интерфейс прост. Метод `getAuthIdentifier` должен возвращать первичный ключ пользователя (`ID`). В бэкенде MySQL, опять же, этот ключ будет авто-инкрементным. `getAuthPassword` должен возвращать зашифрованный пароль пользователя (кэш пароля). Этот интерфейс позволяет системе аутентификации работать с любым классом пользователей независимо от того, какой ORM или уровень абстрактного хранилища Вы используете. По-умолчанию, фреймворк Laravel содержит класс `User` в папке `app`, так что Вы можете взять его за основу.

<a name="events"></a>
## События

Laravel запускает множество [событий](/docs/{{version}}/events) во время процесса аутентификации. Вы можете прикрепить к ним "слушателей" в файле `EventServiceProvider`:

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Illuminate\Auth\Events\Attempting' => [
            'App\Listeners\LogAuthenticationAttempt',
        ],

        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LogSuccessfulLogin',
        ],

        'Illuminate\Auth\Events\Logout' => [
            'App\Listeners\LogSuccessfulLogout',
        ],

        'Illuminate\Auth\Events\Lockout' => [
            'App\Listeners\LogLockout',
        ],
    ];
