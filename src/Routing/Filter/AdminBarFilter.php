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
namespace AdminBar\Routing\Filter;

use Cake\Event\Event;
use Cake\Routing\DispatcherFilter;
use Cake\Routing\Router;
use Settings\Core\Setting;

class AdminBarFilter extends DispatcherFilter
{

    public function beforeDispatch(Event $event)
    {
        $request = $event->data['request'];
        $response = $event->data['response'];
    }

    public function afterDispatch(Event $event)
    {
        $request = $event->data['request'];
        $response = $event->data['response'];

        if ($request->param('plugin') === 'DebugKit' || $request->is('requested')) {
            return;
        }

        if ($request->param('plugin') === 'AdminBar' || $request->is('requested')) {
            return;
        }

        if ($request->param('prefix') === 'admin') {
            if(!Setting::read('AB.Backend')) {
                return;
            }
        }

        if ($request->param('prefix') !== 'admin') {
            if(!Setting::read('AB.Frontend')) {
                return;
            }
        }

        $this->_injectScripts($request, $response);
    }

    protected function _injectScripts($request, $response)
    {
        if (strpos($response->type(), 'html') === false) {
            return;
        }
        $body = $response->body();
        $pos = strrpos($body, '</body>');
        if ($pos === false) {
            return;
        }

        $url = $request->url;
        $baseUrl = Router::url('/', true);
        $script = "<script>var __admin_bar_url = '${url}', __admin_bar_base_url = '${baseUrl}';</script>";
        $script .= '<link rel="stylesheet" href="/admin_bar/css/adminbar.css">';
        $script .= '<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>';
        $script .= '<script src="' . Router::url('/admin_bar/js/adminbar.js') . '"></script>';
        $body = substr($body, 0, $pos) . $script . substr($body, $pos);
        $response->body($body);
    }
}