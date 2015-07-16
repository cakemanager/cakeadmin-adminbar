# AdminBar plugin for CakeAdmin and CakePHP

This plugin generates an easy-to-use admin-bar on top of your application when you are logged in as administrator.

> Note: This is a non-stable plugin for CakePHP 3.x at this time. It is currently under development and should be 
considered experimental.

## Installation
You can install this plugin into your CakePHP application using composer.

The recommended way to install composer packages is:

    composer require cakemanager/cakeadmin-adminbar:dev-master
    
Now load the plugin with the command:

    $ bin/cake plugin load -r -b AdminBar

The last thing you need to do is to load the `AdminBar.AdminBar`-Component using:

    $this->loadComponent('AdminBar.AdminBar');

## Settings
You can activate or deactivate the AdminBar in the settings-page in the backend.

## Adding new items
Adding items is done via the `Configure`-class of CakePHP. Look at this example:

    Configure::write('AdminBar.goto_backend', [
        'on' => [
            'prefix' => ['!admin', '*'],
            'controller' => '*',
            'action' => '*',
        ],
        'label' => 'CakeAdmin Panel',
        'url' => '/admin'
    ]);
    
Explanation:
- `goto_backend` - The name of the item. Should be unique (because of overriding in the Configure-class).
- `on` - The `on`-key is used to validate if the item should be shown looking at the current request. See docs below.
- `label` - A string wich is the label of your item.
- `url` - A string or array to create the url. For all available options, see docs below.

### On-key
Via the `on`-key you can validate if the item should be shown.

- When using a `!` before the used key (like `'prefix' => '!admin'`), the current prefix should NOT be `admin`.
- When using a name (like `'prefix' => 'admin'`) the current prefix has to be equal to `admin`.
- When using `*` (like `'prefix' => '*'`) the current prefix can be anything.
- When you want to validate on multiple names you should use an array like `'prefix' => ['!admin', '*'],`

You can validate on `plugin`, `prefix`, `controller`, `action` and any other parameter you want to validate on. So this
means when you defined a parameter `type` in your routes, you can validate on `type` by using:

    Configure::write('AdminBar.custom_type', [
        'on' => [
            'controller' => '*',
            'action' => '*',
            'type' => 'specific'
        ],
    ]);

### Url-key
The `url`-key can be an string, or array to create an url. You can get parameters of the request using `:`:

    Configure::write('AdminBar.read_blog', [
        'label' => 'Read Blog',
        'url' => [
            'prefix' => false,
            'plugin' => 'Cms',
            'controller' => 'Blogs',
            'action' => 'view',
            ':pass.1'
        ]
    ]);

The `:pass.1` is used to get a specific value of the request-parameters. When these are nested, use a `.` to go into them.
Looking back on our `type`-example, you could use this:

    Configure::write('AdminBar.custom_type', [
        'url' => [
            'prefix' => false,
            'plugin' => 'Cms',
            'controller' => 'Blogs',
            'action' => 'view',
            ':type'
        ]
    ]);

## Keep in touch
If you need some help or got ideas for this plugin, feel free to chat at 
[Gitter](https://gitter.im/cakemanager/cakeadmin-adminbar).

Pull Requests are always more than welcome!
