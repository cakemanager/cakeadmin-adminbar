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

use Cake\Routing\Router;

?>
<?php if (isset($adminbar)): ?>
    <nav class="adminbar-top">
        <div class="adminbar-container">
            <div class="adminbar-header">
                CakeAdmin

            </div>
            <div class="adminbar-collapse">
                <ul class="adminbar-nav">
                    <?php foreach ($adminbar as $item): ?>
                        <li class="active"><a href="<?= $item['url'] ?>"><?= $item['label'] ?> </a></li>
                    <?php endforeach ?>
                </ul>
            </div>
            <div class="adminbar-collapse pull-right">
                <ul class="adminbar-nav">
                    <li class="active"><a href="http://cakemanager.org" target="_blank">CakeManager.org</a></li>
                    <li class="active"><a href="http://book.cakephp.org/3.0/" target="_blank">Documentation</a></li>
                    <li class="active"><a href="http://api.cakephp.org/3.0/" target="_blank">API</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <?= $this->Html->css('AdminBar.adminbar') ?>
<?php endif; ?>