<?php
/**
 * CakeManager (http://cakemanager.org)
 * Copyright (c) http://cakemanager.org
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) http://cakemanager.org
 * @link          http://cakemanager.org CakeManager Project
 * @since         1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Configure;
use Cake\Routing\DispatcherFactory;
use Settings\Core\Setting;

# Configures
Configure::write('AB.Show', true);

Configure::write('Settings.Prefixes.AB', 'AdminBar');

# Settings
Setting::register('AB.Backend', true, [
    'type' => 'select',
    'options' => [
        0 => 'Disabled',
        1 => 'Enabled'
    ]
]);

Setting::register('AB.Frontend', true, [
    'type' => 'select',
    'options' => [
        0 => 'Disabled',
        1 => 'Enabled'
    ]
]);

# AdminBar
Configure::write('AdminBar.goto_backend', [
    'on' => [
        'prefix' => ['!admin', '*'],
        'controller' => '*',
        'action' => '*',
    ],
    'label' => 'CakeAdmin Panel',
    'url' => '/admin'
]);

Configure::write('AdminBar.goto_website', [
    'on' => [
        'prefix' => 'admin',
        'controller' => '*',
        'action' => '*',
    ],
    'label' => 'Go To Website',
    'url' => Configure::read('App.fullBaseUrl')
]);

Configure::write('AdminBar.goto_settings', [
    'on' => [
        'prefix' => 'admin',
        'controller' => '*',
        'action' => '*',
    ],
    'label' => 'Settings',
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'CakeAdmin',
        'controller' => 'Settings',
        'action' => 'index'
    ]
]);

# Dispatcher Filter
DispatcherFactory::add('AdminBar.AdminBar');
