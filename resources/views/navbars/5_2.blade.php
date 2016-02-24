<ul class="collection with-header">
    <li class="collection-header"><h4>Prologue</h4></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'releases']) }}">Release Notes</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'upgrade']) }}">Upgrade Guide</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'contributions']) }}">Contribution Guide</a></li>
    <li class="collection-item"><a href="https://laravel.com/api/5.2">API Documentation</a></li>

    <li class="collection-header"><h4>Setup</h4></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'installation']) }}">Installation</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'configuration']) }}">Configuration</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'homestead']) }}">Homestead</a></li>

    <li class="collection-header"><h4>Tutorials</h4></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'quickstart']) }}">Basic Task List</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'quickstart-intermediate']) }}">Intermediate Task List</a></li>

    <li class="collection-header"><h4>The Basics</h4></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'routing']) }}">Routing</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'middleware']) }}">Middleware</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'controllers']) }}">Controllers</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'requests']) }}">Requests</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'responses']) }}">Responses</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'views']) }}">Views</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'blade']) }}">Blade Templates</a></li>

    <li class="collection-header"><h4>Architecture Foundations</h4></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'lifecycle']) }}">Request Lifecycle</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'structure']) }}">Application Structure</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'providers']) }}">Service Providers</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'container']) }}">Service Container</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'facades']) }}">Facades</a></li>

    <li class="collection-header"><h4>Services</h4></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'authentication']) }}">Authentication</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'authorization']) }}">Authorization</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'artisan']) }}">Artisan Console</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'billing']) }}">Billing</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'cache']) }}">Cache</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'collections']) }}">Collections</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'elixir']) }}">Elixir</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'encryption']) }}">Encryption</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'errors']) }}">Errors & Logging</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'events']) }}">Events</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'filesystem']) }}">Filesystem / Cloud Storage</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'hashing']) }}">Hashing</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'helpers']) }}">Helpers</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'localization']) }}">Localization</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'mail']) }}">Mail</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'packages']) }}">Package Development</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'pagination']) }}">Pagination</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'queues']) }}">Queues</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'redis']) }}">Redis</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'session']) }}">Session</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'envoy']) }}">SSH Tasks</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'scheduling']) }}">Task Scheduling</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'testing']) }}">Testing</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'validation']) }}">Validation</a></li>

    <li class="collection-header"><h4>Database</h4></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'database']) }}">Getting Started</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'queries']) }}">Query Builder</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'migrations']) }}">Migrations</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'seeding']) }}">Seeding</a></li>

    <li class="collection-header"><h4>Eloquent ORM</h4></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'eloquent']) }}">Getting Started</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'eloquent-relationships']) }}">Relationships</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'eloquent-collections']) }}">Collections</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'eloquent-mutators']) }}">Mutators</a></li>
    <li class="collection-item"><a href="{{ route('docs', ['version'=>$version, 'page'=>'eloquent-serialization']) }}">Serialization</a></li>
</ul>