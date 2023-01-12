<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller\Vendor;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class DashboardController extends AppController
{
    public function index() {

        $this->loadModel('PoHeaders');
        $this->loadModel('VendorTemps');
        

        $query = $this->PoHeaders->find();
        $query->leftJoin(
                ['VendorTemps' => 'vendor_temps'],
                ['VendorTemps.sap_vendor_code = PoHeaders.sap_vendor_code']);

        $po_list = $this->paginate($query);
        $this->set('po_list', $po_list);
    }

    public function getlist() {


        $this->autoRender= false;
        $this->loadModel('PoHeaders');
        $this->loadModel('VendorTemps');
        

        $query = $this->PoHeaders->find();
        $query->join(['PoFooters' => 'po_footers'])
        ->leftJoin(
                ['VendorTemps' => 'vendor_temps'],
                ['VendorTemps.sap_vendor_code = PoHeaders.sap_vendor_code'])->toArray();


        
        print_r($query);
    }
}