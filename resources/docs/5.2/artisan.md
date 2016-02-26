# Консоль Artisan

- [Введение](#introduction)
- [Команды записи](#writing-commands)
    - [Структура команд](#command-structure)
- [Команды ввода/вывода](#command-io)
    - [Определение ожидаемых данных](#defining-input-expectations)
    - [Получение входных данных](#retrieving-input)
    - [Запрос на ввод данных](#prompting-for-input)
    - [Вывод данных](#writing-output)
- [Регистрация команд](#registering-commands)
- [Вызов команд через код](#calling-commands-via-code)

<a name="introduction"></a>
## Введение

Artisan - это имя интерфейса командной строки, включенной в состав Laravel. Он предоставляет ряд полезных команд для использования при разработке Вашего приложения и приводится в действие мощным компонентом Symfony Console. Для просмотра всех доступных команд, Вы можете использовать `list` команду:

    php artisan list

Каждая команда также включает в себя экран "помощи", которая выводит на экран и описывает команды, доступные аргументы и опции. Для просмотра справки, просто используйте `help` перед именем команды:

    php artisan help migrate

<a name="writing-commands"></a>
## Команды записи

В дополнение к командам, обеспеченным Artisan, Вы также можете создавать свои собственные пользовательские команды для работы с приложением. Хранить такие команды можно в папке `app/Console/Commands`. Тем не менее, Вы можете выбрать свое собственное место хранения до тех пор, пока Ваши команды могут автоматически выполняться на основе Ваших настроек в `composer.json`.

Для создания новой команды используйте команду `make:console`, генерирующую команду-заглушку для упрощения начала работы:

    php artisan make:console SendEmails

Вышеуказанная команда сгенерирует класс в `app/Console/Commands/SendEmails.php`. При создании команды можно использовать опцию `--command` для присвоения имени команды:

    php artisan make:console SendEmails --command=emails:send

<a name="command-structure"></a>
### Структура команд

После генерации команды, Вы должны заполнить свойства `signature` и `description` класса, который будет использоваться при отображении Вашей команды на экране `list`.

Метод `handle` будет вызываться при запуске Вашей команды. В нем Вы можете разместить любую командную логику. Давайте посмотрим пример.

Обратите внимание, что мы можем внедрить любые зависимости в конструктор команды. [Сервис-контейнер](/docs/{{version}}/container) Laravel автоматически внедрит все указанные зависимости в конструктор. Для большего повторного использования кода, хорошей практикой будет написание "легких" команд и выполнение всех необходимых действий в сервисах Вашего приложения.

    <?php

    namespace App\Console\Commands;

    use App\User;
    use App\DripEmailer;
    use Illuminate\Console\Command;

    class SendEmails extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'email:send {user}';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Send drip e-mails to a user';

        /**
         * The drip e-mail service.
         *
         * @var DripEmailer
         */
        protected $drip;

        /**
         * Create a new command instance.
         *
         * @param  DripEmailer  $drip
         * @return void
         */
        public function __construct(DripEmailer $drip)
        {
            parent::__construct();

            $this->drip = $drip;
        }

        /**
         * Execute the console command.
         *
         * @return mixed
         */
        public function handle()
        {
            $this->drip->send(User::find($this->argument('user')));
        }
    }

<a name="command-io"></a>
## Команды ввода/вывода

<a name="defining-input-expectations"></a>
### Определение ожидаемых данных

При написании консольных команд стандартной практикой является получение данных от пользователя при помощи аргументов и опций. Laravel предоставляет удобный способ определения аргументов, ожидаемых от пользователя, путем использования свойства `signature` команды. Это свойство позволяет Вам определить название, аргументы и опции команды при помощи простого и понятного синтаксиса.

Все ожидаемые аргументы и опции от пользователя обрамляются в фигурные скобки. Например, в следующем примере команда требует один обязательный аргумент `user`:

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send {user}';

Также Вы можете сделать необязательные аргументы и определить для них значения по-умолчанию:

    // Optional argument...
    email:send {user?}

    // Optional argument with default value...
    email:send {user=foo}

Опции, как и аргументы, - еще один способ получения данных от пользователя. Они отделяются двумя дефисами (`--`) при указании их в строке названия команды. Вы можете определить их так:

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send {user} {--queue}';

In this example, the `--queue` switch may be specified when calling the Artisan command. If the `--queue` switch is passed, the value of the option will be `true`. Otherwise, the value will be `false`:
В этом примере опция `--queue` может быть указана при вызове команды. Если опция будет указана, то ее значение будет `true`, иначе - `false`:

    php artisan email:send 1 --queue

Также Вы можете указать вводимое значение для опций при помощи знака "равно" (`=`) после опции:

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send {user} {--queue=}';

В этом примере Вы можете передать значение параметра так:

    php artisan email:send 1 --queue=default

Также Вы можете назначить для опций значения по-умолчанию:

    email:send {user} {--queue=default}

Чтобы назначить ярлык при определении опции, Вы можете указать его перед именем параметра и использовать разделитель для разделения ярлыка от полного имени опции:

    email:send {user} {--Q|queue}

Если Вы хотите определить аргументы или опции для массива, можно использовать символ `*`:

    email:send {user*}

    email:send {user} {--id=*}

#### Описание входных данных

Для входных аргументов и опций Вы можете указать описание, отделяя параметр из описания двоеточием:

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send
                            {user : The ID of the user}
                            {--queue= : Whether the job should be queued}';

<a name="retrieving-input"></a>
### Получение входных данных

Очевидно, что во время выполнения команды у Вас должен быть доступ к введенным пользователем значениям. Для их получения Вы можете воспользоваться методами `argument` и `option`:

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $userId = $this->argument('user');

        //
    }

Если Вам нужно получить все аргументы в виде массива, вызовите `argument` без указания параметров:

    $arguments = $this->argument();

При помощи метода `option` опции можно получить также просто, как и аргументы. Как и метод `argument`, Вы можете вызвать `option` без параметров для получения массива опций:

    // Retrieve a specific option...
    $queueName = $this->option('queue');

    // Retrieve all options...
    $options = $this->option();

Если аргумент или опция не существует, вернется `null`.

<a name="prompting-for-input"></a>
### Запрос на ввод данных

В дополнение к отображению вывода, Вы также можете запрашивать у пользователя дополнительные данные во время выполнения команды. Метод `ask` задаст пользователю указанный вопрос и получит введенные в ответ данные, возвращая их Вашей команде:

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->ask('What is your name?');
    }

Метод `secret` похож на `ask`, только вводимые пользователем данные не будут отображаться в консоли. Этот метод полезен при запросе конфиденциальной информации, например, пароля:

    $password = $this->secret('What is the password?');

#### Запрос подтверждения

Если Вам необходимо выдать пользователю стандартное подтверждение (`Y/n`), то можете использовать метод `confirm`. По-умолчанию этот метод возвращает `false`. Тем не менее, если пользователь введет `Y` в ответ на вопрос, то метод вернет `true`.

    if ($this->confirm('Do you wish to continue? [y|N]')) {
        //
    }

#### Предоставление выбора пользователю

Метод `anticipate` может использоваться для обеспечения автозаполнения возможных вариантов. Пользователь по-прежнему может выбрать любой ответ, независимо от подсказок:

    $name = $this->anticipate('What is your name?', ['Taylor', 'Dayle']);

Для вывода пользователю заранее подготовленного набора вариантов, используйте метод `choise`. Пользователь выбирает индекс варианта ответа, но Вам будет возвращено значение ответа. Вы можете установить значение по-умолчанию, которое будет возвращено, если пользователь ничего не выбрал.

    $name = $this->choice('What is your name?', ['Taylor', 'Dayle'], $default);

<a name="writing-output"></a>
### Вывод данных

Для вывода информации в консоль используйте методы `line`, `info`, `comment`, `question` и `error`. Каждый из этих методов будет использовать соответствующий цвет кодировки ANSI.

Для вывода пользователю информационного сообщения, используйте метод `info`. Как правило, такие сообщения в консоли отображаются зеленым цветом:

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Display this on the screen');
    }

Для вывода сообщения об ошибке, испольщуйте метод `error`, отображающийся красным цветом:

    $this->error('Something went wrong!');

Для вывода в консоль обычного текста, используйте метод `line`, не использующего цвет:

    $this->line('Display this on the screen');

#### Таблицы

Метод `table` позволяет легко отформатировать несколько строк и столбцов. Просто передайте в заголовки и строки в метод. Ширина и высота будет динамически вычисляться на основании полученных данных:

    $headers = ['Name', 'Email'];

    $users = App\User::all(['name', 'email'])->toArray();

    $this->table($headers, $users);

#### Прогресс-бар

Для продолжительных задач может быть полезным отображение прогресс-бара. При выводе объекта будет отображено начало, продвижение и завершение работы на прогресс-баре. Перед началом Вам необходимо определить количество шагов для выполнения, после чего самостоятельно увеличивать индикатор после выполнения каждого шага:

    $users = App\User::all();

    $bar = $this->output->createProgressBar(count($users));

    foreach ($users as $user) {
        $this->performTask($user);

        $bar->advance();
    }

    $bar->finish();

Для получения более полных данных, прочтите [документацию по компоненту Symfony Progress Bar](http://symfony.com/doc/2.7/components/console/helpers/progressbar.html).

<a name="registering-commands"></a>
## Регистрация команд

По завершении написания Вашей команды, Вы должны зарегистрировать еге с помощью Artisan. Без этого выполнение команды будет невозможным. Регистрация команды делается в файле `app/Console/Kernel.php`.

В этом файле Вы найдете список команд и их свойства. Для регистрации команды просто добавьте имя Вашего класса в список. Все перечисленные в этом списке команды будут проверены [сервис-контейнером](/docs/{{version}}/container) и зарегистрируются в Artisan:

    protected $commands = [
        Commands\SendEmails::class
    ];

<a name="calling-commands-via-code"></a>
## Вызов команд из кода

Иногда возникает необходимость выполнения команды Artisan вне консоли. Например, Вам необходимо удалить команду Artisan из маршрута и контроллера. Для этого нужно использовать метод `call` в фасаде Artisan. Метод `call` принимает имя команды в качестве первого аргумента и массив параметров в качестве второго. По завершении будет возвращен код:

    Route::get('/foo', function () {
        $exitCode = Artisan::call('email:send', [
            'user' => 1, '--queue' => 'default'
        ]);

        //
    });

Используя метод `queue` фасада `Artisan`, Вы можете задать очередь команд для их выполнения в фоновом режиме Вашим [воркером очередей](/docs/{{version}}/queues):

    Route::get('/foo', function () {
        Artisan::queue('email:send', [
            'user' => 1, '--queue' => 'default'
        ]);

        //
    });

Если Вам необходимо указать значение опции не принимающей строковые значения, такие как флаг `--force` в команде `migrate:refresh`, Вы можете передавать логическое значение `true` или `false`:

    $exitCode = Artisan::call('migrate:refresh', [
        '--force' => true,
    ]);

### Вызов команд из других команд

Для вызова команды из другой команды, используйте метод `call`, принимающий имя команды и массив ее параметров:

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('email:send', [
            'user' => 1, '--queue' => 'default'
        ]);

        //
    }

Если Вы хотите вызвать другую команду в консоли, скрывая свою, можно вызвать ее методом `callSilent`. Метод `callSilent` имеет такую же подпись, что и метод `call`:

    $this->callSilent('email:send', [
        'user' => 1, '--queue' => 'default'
    ]);
