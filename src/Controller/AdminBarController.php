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
namespace AdminBar\Controller;

use AdminBar\Controller\AppController as BaseController;
use Cake\Routing\Router;

class AdminBarController extends BaseController
{

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('AdminBar.AdminBar');
    }

    public function index()
    {
        if ($this->request->is('ajax')) {
            if ($this->request->is('post')) {

                $request = $this->request->data('request');

                $requestParams = Router::parse($request);

                $this->AdminBar->createAdminBar($requestParams);

                $this->layout = 'AdminBar.ajax';
            }
        }
    }

}