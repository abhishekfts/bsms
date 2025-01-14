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
use Cake\ORM\TableRegistry;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\ConnectionManager;

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class DashboardController extends VendorAppController
{

    public function initialize(): void
    {
        parent::initialize();

    //     $session = $this->getRequest()->getSession();

    //     $permissionsTable = $this->getTableLocator()->get('Permissions');
    //     $query = $permissionsTable->find()
    //         ->select(['permission'])
    //         ->where([
    //             'controller' => ':controller', 
    //             'action' => 'index',
    //             'users' => $session->read('id') 
    //         ])->toArray();
            
    //    print_r($query);exit;    
     
    }
    public function index()
    {

        $this->set('headTitle', 'Dashboard');
        $session = $this->getRequest()->getSession();
        $conn = ConnectionManager::get('default');

        $this->loadModel('PoHeaders');
        $this->loadModel('VendorTemps');

        $this->loadModel('RfqDetails');
        $this->loadModel('RfqInquiries');
        $this->loadModel('Products');

        $this->loadModel('PoHeaders');
        $this->loadModel('PoItemSchedules');

        $this->loadModel('DeliveryDetails');


        $rfqnewDetails = $conn->execute("SELECT RfqDetails.*,Products.name product, Uoms.description uom FROM `rfq_details` RfqDetails
        join products Products on Products.id = RfqDetails.product_id
        join uoms Uoms on Uoms.id = RfqDetails.uom_code
        join vendor_temps VendorTemps on RfqDetails.buyer_seller_user_id = VendorTemps.buyer_id
        where RfqDetails.status = 1 and VendorTemps.sap_vendor_code = '" . $session->read('vendor_code') . "' and RfqDetails.id not in (select rfq_item_id from rfq_inquiries where seller_id = " . $session->read('id') . ")");

        $rfqRequested = $conn->execute("SELECT RfqDetails.*, Products.name product, Uoms.description uom FROM `rfq_details` RfqDetails
        join products Products on Products.id = RfqDetails.product_id
        join uoms Uoms on Uoms.id = RfqDetails.uom_code
        join vendor_temps VendorTemps on RfqDetails.buyer_seller_user_id = VendorTemps.buyer_id
        where RfqDetails.status = 1 and VendorTemps.sap_vendor_code = '" . $session->read('vendor_code') . "' and RfqDetails.id in (select rfq_item_id from rfq_inquiries where seller_id = " . $session->read('id') . ")");

        $query = $conn->execute("SELECT po_header_id FROM db_bsms.po_item_schedules GROUP BY po_header_id");
        $totalPos = $query->count();

        $this->loadModel('AsnHeaders');
        
        $intraQry = $this->AsnHeaders->find()
            ->select(['AsnHeaders.id', 'AsnHeaders.invoice_no', 'AsnHeaders.status', 'AsnHeaders.asn_no', 'AsnHeaders.invoice_value', 'PoHeaders.po_no', 'AsnHeaders.added_date', 'AsnHeaders.updated_date'])
            ->contain(['PoHeaders'])
            ->where(['PoHeaders.sap_vendor_code' => $session->read('vendor_code'), 'AsnHeaders.status' => '2']);
        $totalIntransit = $intraQry->count();

        //echo '<pre>';print_r($intraQry); exit;

        //$totalIntransit = $this->DeliveryDetails->find('all', array('conditions'=>array('status'=>0)))->count();

        $totalRfqDetails = $this->RfqDetails->find('all', array('conditions' => array('status' => 1)))->count();


        
       $this->set(compact('totalPos', 'totalIntransit', 'totalRfqDetails', 'rfqnewDetails', 'rfqRequested'));

    }

    public function rfqView($id = null)
    {
        $session = $this->getRequest()->getSession();
        $this->loadModel('RfqDetails');
        $this->loadModel('RfqInquiries');

        $rfqDetails = $this->RfqDetails->get($id, [
            'contain' => ['Products', 'Uoms'],
        ]);

        $inquired = $this->RfqInquiries->exists(['rfq_id' => $id, 'seller_id' => $session->read('id')]);

        $isResponded = 'no';
        if ($inquired) {
            $isResponded = 'yes';
        }

        $userType = 'seller';
        if ($userType == 'seller') {
            $RfqInquiry = $this->RfqInquiries->newEmptyEntity();
            $data = array();
            $data['rfq_id'] = $id;
            $data['seller_id'] = $session->read('id');
            $RfqInquiry = $this->RfqInquiries->patchEntity($RfqInquiry, $data);
            $results = $this->RfqInquiries->save($RfqInquiry);
        }

        $this->set(compact('rfqDetails', 'userType', 'results', 'isResponded'));
    }

    public function getlist()
    {


        $this->autoRender = false;
        $this->loadModel('PoHeaders');
        $this->loadModel('VendorTemps');


        $query = $this->PoHeaders->find();
        $query->join(['PoFooters' => 'po_footers'])
            ->leftJoin(
                ['VendorTemps' => 'vendor_temps'],
                ['VendorTemps.sap_vendor_code = PoHeaders.sap_vendor_code']
            )->toArray();



        print_r($query);
    }

    public function clearMessageCount()
    {
        $response = array();
        $response['status'] = 0;
        $response['message'] = '';
    
        $this->loadModel('Notifications');
        $this->Notifications->updateAll(['message_count' => 0], ['notification_type' => 'create_schedule']);
    
        $response['status'] = 1;
        $response['message'] = 'clear Notification';
    
        echo json_encode($response);
        exit();
    }
}
