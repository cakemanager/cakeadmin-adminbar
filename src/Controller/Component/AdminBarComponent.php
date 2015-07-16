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
namespace AdminBar\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use Cake\Utility\Text;

/**
 * AdminBar component
 */
class AdminBarComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function beforeRender(\Cake\Event\Event $event)
    {
        $controller = $this->_registry->getController();
    }

    public function createAdminBar($requestParams)
    {
        $controller = $this->_registry->getController();

        if (!$controller->CakeAdmin) {
            return;
        }
        if (!$controller->CakeAdmin->isLoggedIn()) {
            return;
        }

        $items = Configure::read('AdminBar');

//        debug($items);
//        debug($controller->request);

        $result = [];

        foreach ($items as $name => $item) {

            $_item = [
                'on' => [
                    'prefix' => '*',
                    'plugin' => '*',
                    'controller' => '*',
                    'action' => '*',
                ],
                'label' => ucfirst($name),
                'url' => [],
            ];

            $item = Hash::merge($_item, $item);

            $valid = $this->isValid($item, $requestParams);

            if ($valid) {
                $result[$name] = [
                    'label' => $item['label'],
                    'url' => $this->buildUrl($item, $requestParams),
                ];
            }
        }

        $controller->set('adminbar', $result);
    }

    public function isValid($item, $request)
    {
        $on = $item['on'];

        foreach ($on as $pass => $conditions) {
            if (array_key_exists($pass, $request)) {
                $item = $request[$pass];
            } else {
                $item = '*';
            }

            if (!$this->_isAllowed($item, (array)$conditions)) {
                return false;
            }
        }
        return true;
    }

    protected function _isAllowed($item, $list)
    {
//        debug('Current is ' . $item);
//        debug('Looking in');
//        debug($list);
        if (in_array('!' . $item, $list)) {
//            debug('1 return false');
            return false;
        }
        if (in_array('*', $list)) {
//            debug('2 return true');
            return true;
        }
        if (in_array($item, $list)) {
//            debug('3 return true');
            return true;
        }
//        debug('4 return false');
        return false;
    }

    public function buildUrl($item, $request)
    {
        $url = $item['url'];
        $params = Hash::flatten($request);

        $result = [];

        if (is_array($url)) {
            foreach ($url as $key => $value) {
                if (is_string($value)) {
                    if (!is_int($key)) {
                        $result[$key] = Text::insert($value, $params);
                    } else {
                        $result[] = Text::insert($value, $params);
                    }
                } else {
                    $result[$key] = $value;
                }
            }
        } else {
            $result = Text::insert($url, $params);
        }

        return Router::url($result);
    }
}
