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
- [Добавление другийх провайдеров пользователя](#adding-custom-user-providers)
- [Мероприятия](#events)

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

If you are using Laravel's built-in `AuthController` class, the `Illuminate\Foundation\Auth\ThrottlesLogins` trait may be used to throttle login attempts to your application. By default, the user will not be able to login for one minute if they fail to provide the correct credentials after several attempts. The throttling is unique to the user's username / e-mail address and their IP address:

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

Of course, you are not required to use the authentication controllers included with Laravel. If you choose to remove these controllers, you will need to manage user authentication using the Laravel authentication classes directly. Don't worry, it's a cinch!

We will access Laravel's authentication services via the `Auth` [facade](/docs/{{version}}/facades), so we'll need to make sure to import the `Auth` facade at the top of the class. Next, let's check out the `attempt` method:

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

The `attempt` method accepts an array of key / value pairs as its first argument. The values in the array will be used to find the user in your database table. So, in the example above, the user will be retrieved by the value of the `email` column. If the user is found, the hashed password stored in the database will be compared with the hashed `password` value passed to the method via the array. If the two hashed passwords match an authenticated session will be started for the user.

The `attempt` method will return `true` if authentication was successful. Otherwise, `false` will be returned.

The `intended` method on the redirector will redirect the user to the URL they were attempting to access before being caught by the authentication filter. A fallback URI may be given to this method in case the intended destination is not available.

#### Specifying Additional Conditions

If you wish, you also may add extra conditions to the authentication query in addition to the user's e-mail and password. For example, we may verify that user is marked as "active":

    if (Auth::attempt(['email' => $email, 'password' => $password, 'active' => 1])) {
        // The user is active, not suspended, and exists.
    }

> **Note:** In these examples, `email` is not a required option, it is merely used as an example. You should use whatever column name corresponds to a "username" in your database.

#### Accessing Specific Guard Instances

You may specify which guard instance you would like to utilize using the `guard` method on the `Auth` facade. This allows you to manage authentication for separate parts of your application using entirely separate authenticatable models or user tables.

The guard name passed to the `guard` method should correspond to one of the guards configured in your `auth.php` configuration file:

    if (Auth::guard('admin')->attempt($credentials)) {
        //
    }

#### Logging Out

To log users out of your application, you may use the `logout` method on the `Auth` facade. This will clear the authentication information in the user's session:

    Auth::logout();

<a name="remembering-users"></a>
### Запоминание пользователей

If you would like to provide "remember me" functionality in your application, you may pass a boolean value as the second argument to the `attempt` method, which will keep the user authenticated indefinitely, or until they manually logout. Of course, your `users` table must include the string `remember_token` column, which will be used to store the "remember me" token.

    if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
        // The user is being remembered...
    }

If you are "remembering" users, you may use the `viaRemember` method to determine if the user was authenticated using the "remember me" cookie:

    if (Auth::viaRemember()) {
        //
    }

<a name="other-authentication-methods"></a>
### Другие методы аутентификации

#### Authenticate A User Instance

If you need to log an existing user instance into your application, you may call the `login` method with the user instance. The given object must be an implementation of the `Illuminate\Contracts\Auth\Authenticatable` [contract](/docs/{{version}}/contracts). Of course, the `App\User` model included with Laravel already implements this interface:

    Auth::login($user);

#### Authenticate A User By ID

To log a user into the application by their ID, you may use the `loginUsingId` method. This method simply accepts the primary key of the user you wish to authenticate:

    Auth::loginUsingId(1);

#### Authenticate A User Once

You may use the `once` method to log a user into the application for a single request. No sessions or cookies will be utilized, which may be helpful when building a stateless API. The `once` method has the same signature as the `attempt` method:

    if (Auth::once($credentials)) {
        //
    }

<a name="http-basic-authentication"></a>
## HTTP Basic Authentication

[HTTP Basic Authentication](http://en.wikipedia.org/wiki/Basic_access_authentication) provides a quick way to authenticate users of your application without setting up a dedicated "login" page. To get started, attach the `auth.basic` [middleware](/docs/{{version}}/middleware) to your route. The `auth.basic` middleware is included with the Laravel framework, so you do not need to define it:

    Route::get('profile', ['middleware' => 'auth.basic', function() {
        // Only authenticated users may enter...
    }]);

Once the middleware has been attached to the route, you will automatically be prompted for credentials when accessing the route in your browser. By default, the `auth.basic` middleware will use the `email` column on the user record as the "username".

#### A Note On FastCGI

If you are using PHP FastCGI, HTTP Basic authentication may not work correctly out of the box. The following lines should be added to your `.htaccess` file:

    RewriteCond %{HTTP:Authorization} ^(.+)$
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

<a name="stateless-http-basic-authentication"></a>
### Базовая аутентифицация Stateless HTTP

You may also use HTTP Basic Authentication without setting a user identifier cookie in the session, which is particularly useful for API authentication. To do so, [define a middleware](/docs/{{version}}/middleware) that calls the `onceBasic` method. If no response is returned by the `onceBasic` method, the request may be passed further into the application:

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

Next, [register the route middleware](/docs/{{version}}/middleware#registering-middleware) and attach it to a route:

    Route::get('api/user', ['middleware' => 'auth.basic.once', function() {
        // Only authenticated users may enter...
    }]);

<a name="resetting-passwords"></a>
## Сброс паролей

<a name="resetting-database"></a>
### Настройка базы данных

Most web applications provide a way for users to reset their forgotten passwords. Rather than forcing you to re-implement this on each application, Laravel provides convenient methods for sending password reminders and performing password resets.

To get started, verify that your `App\User` model implements the `Illuminate\Contracts\Auth\CanResetPassword` contract. Of course, the `App\User` model included with the framework already implements this interface, and uses the `Illuminate\Auth\Passwords\CanResetPassword` trait to include the methods needed to implement the interface.

#### Generating The Reset Token Table Migration

Next, a table must be created to store the password reset tokens. The migration for this table is included with Laravel out of the box, and resides in the `database/migrations` directory. So, all you need to do is migrate:

    php artisan migrate

<a name="resetting-routing"></a>
### Настройка маршрутизации

Laravel includes an `Auth\PasswordController` that contains the logic necessary to reset user passwords. All of the routes needed to perform password resets may be generated using the `make:auth` Artisan command:

    php artisan make:auth

<a name="resetting-views"></a>
### Настройка шаблонов

Again, Laravel will generate all of the necessary views for password reset when the `make:auth` command is executed. These views are placed in `resources/views/auth/passwords`. You are free to customize them as needed for your application.

<a name="after-resetting-passwords"></a>
### Действия после сброса пароля

Once you have defined the routes and views to reset your user's passwords, you may simply access the route in your browser at `/password/reset`. The `PasswordController` included with the framework already includes the logic to send the password reset link e-mails as well as update passwords in the database.

After the password is reset, the user will automatically be logged into the application and redirected to `/home`. You can customize the post password reset redirect location by defining a `redirectTo` property on the `PasswordController`:

    protected $redirectTo = '/dashboard';

> **Note:** By default, password reset tokens expire after one hour. You may change this via the password reset `expire` option in your `config/auth.php` file.

<a name="password-customization"></a>
### Настройка

#### Authentication Guard Customization

In your `auth.php` configuration file, you may configure multiple "guards", which may be used to define authentication behavior for multiple user tables. You can customize the included `PasswordController` to use the guard of your choice by adding a `$guard` property to the controller:

    /**
     * The authentication guard that should be used.
     *
     * @var string
     */
    protected $guard = 'admins';

#### Password Broker Customization

In your `auth.php` configuration file, you may configure multiple password "brokers", which may be used to reset passwords on multiple user tables. You can customize the included `PasswordController` to use the broker of your choice by adding a `$broker` property to the controller:

    /**
     * The password broker that should be used.
     *
     * @var string
     */
    protected $broker = 'admins';

<a name="adding-custom-guards"></a>
## Добавление пользовательской защиты

You may define your own authentication guards using the `extend` method on the `Auth` facade. You should place this call to `provider` within a [service provider](/docs/{{version}}/providers):

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

As you can see in the example above, the callback passed to the `extend` method should return an implementation of `Illuminate\Contracts\Auth\Guard`. This interface contains a few methods you will need to implement to define a custom guard.

Once your custom guard has been defined, you may use the guard in your `guards` configuration:

    'guards' => [
        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
    ],

<a name="adding-custom-user-providers"></a>
## Добавление другийх провайдеров пользователя

If you are not using a traditional relational database to store your users, you will need to extend Laravel with your own authentication user provider. We will use the `provider` method on the `Auth` facade to define a custom user provider. You should place this call to `provider` within a [service provider](/docs/{{version}}/providers):

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

After you have registered the provider with the `provider` method, you may switch to the new user provider in your `config/auth.php` configuration file. First, define a `provider` that uses your new driver:

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

### The User Provider Contract

The `Illuminate\Contracts\Auth\UserProvider` implementations are only responsible for fetching a `Illuminate\Contracts\Auth\Authenticatable` implementation out of a persistent storage system, such as MySQL, Riak, etc. These two interfaces allow the Laravel authentication mechanisms to continue functioning regardless of how the user data is stored or what type of class is used to represent it.

Let's take a look at the `Illuminate\Contracts\Auth\UserProvider` contract:

    <?php

    namespace Illuminate\Contracts\Auth;

    interface UserProvider {

        public function retrieveById($identifier);
        public function retrieveByToken($identifier, $token);
        public function updateRememberToken(Authenticatable $user, $token);
        public function retrieveByCredentials(array $credentials);
        public function validateCredentials(Authenticatable $user, array $credentials);

    }

The `retrieveById` function typically receives a key representing the user, such as an auto-incrementing ID from a MySQL database. The `Authenticatable` implementation matching the ID should be retrieved and returned by the method.

The `retrieveByToken` function retrieves a user by their unique `$identifier` and "remember me" `$token`, stored in a field `remember_token`. As with the previous method, the `Authenticatable` implementation should be returned.

The `updateRememberToken` method updates the `$user` field `remember_token` with the new `$token`. The new token can be either a fresh token, assigned on a successful "remember me" login attempt, or a null when the user is logged out.

The `retrieveByCredentials` method receives the array of credentials passed to the `Auth::attempt` method when attempting to sign into an application. The method should then "query" the underlying persistent storage for the user matching those credentials. Typically, this method will run a query with a "where" condition on `$credentials['username']`. The method should then return an implementation of `UserInterface`. **This method should not attempt to do any password validation or authentication.**

The `validateCredentials` method should compare the given `$user` with the `$credentials` to authenticate the user. For example, this method might compare the `$user->getAuthPassword()` string to a `Hash::make` of `$credentials['password']`. This method should only validate the user's credentials and return a boolean.

### The Authenticatable Contract

Now that we have explored each of the methods on the `UserProvider`, let's take a look at the `Authenticatable` contract. Remember, the provider should return implementations of this interface from the `retrieveById` and `retrieveByCredentials` methods:

    <?php

    namespace Illuminate\Contracts\Auth;

    interface Authenticatable {

        public function getAuthIdentifier();
        public function getAuthPassword();
        public function getRememberToken();
        public function setRememberToken($value);
        public function getRememberTokenName();

    }

This interface is simple. The `getAuthIdentifier` method should return the "primary key" of the user. In a MySQL back-end, again, this would be the auto-incrementing primary key. The `getAuthPassword` should return the user's hashed password. This interface allows the authentication system to work with any User class, regardless of what ORM or storage abstraction layer you are using. By default, Laravel includes a `User` class in the `app` directory which implements this interface, so you may consult this class for an implementation example.

<a name="events"></a>
## Мероприятия

Laravel raises a variety of [events](/docs/{{version}}/events) during the authentication process. You may attach listeners to these events in your `EventServiceProvider`:

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
