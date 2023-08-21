<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Cake\Datasource\ConnectionManager;
use Cake\Core\Exception\Exception;

/**
 * Home Controller
 *
 * @method \App\Model\Entity\Home[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ApiController extends ApiAppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */

    var $uses = false;

    public function initialize(): void
    {
        parent::initialize();

        $this->autoRender = false;

        date_default_timezone_set('Asia/Kolkata');

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
    }

    public function countryByState($id = null)
    {
        // $this->autoRender = false;
        $response = ["status"=>0, 'message' =>'Empty request'];
        $this->loadModel("States");
        $this->loadModel("Countries");
        $states = $this->States->find()->select(['id', 'name'])->innerJoin(['Countries'=>'countries'],['Countries.country_code = States.country_code', 'Countries.id' =>$id])->toArray();

        //print_r($states); exit;
        $response = ["status"=> 1, 'message' =>['States'=>$states]];
        echo json_encode($response);
    }

    public function postPo()
    {
        $response = array();
        $response['status'] = 0;
        $response['message'] = 'Empty request';
        $request = $this->request->getData();

        $this->loadModel("PoHeaders");
        $this->loadModel("PoFooters");

        if (!empty($request) && count($request['DATA'])) {

            try {
                foreach ($request['DATA'] as $key => $row) {
                    $hederData = array();
                    $footerData = array();

                    $hederData['sap_vendor_code'] = $row['LIFNR'];
                    $hederData['po_no'] = $row['EBELN'];
                    $hederData['document_type'] = $row['BSART'];
                    $hederData['created_on'] = date("Y-m-d H:i:s", strtotime($row['AEDAT']));
                    $hederData['created_by'] = $row['ERNAM'];
                    $hederData['pay_terms'] = $row['ZTERM'];
                    $hederData['currency'] = $row['WAERS'];
                    $hederData['exchange_rate'] = $row['WKURS'];
                    $hederData['release_status'] = $row['FRGZU'];

                    $poInstance = $this->PoHeaders->newEmptyEntity();
                    $poInstance = $this->PoHeaders->patchEntity($poInstance, $hederData);

                    if ($this->PoHeaders->save($poInstance)) {
                        $po_header_id = $poInstance->id;

                        foreach ($row['ITEMS'] as $no => $item) {
                            $tmp = array();
                            $tmp['po_header_id'] = $po_header_id;
                            $tmp['item'] = $item['EBELP'];
                            $tmp['deleted_indication'] = $item['LOEKZ'];
                            $tmp['material'] = $item['MATNR'];
                            $tmp['short_text'] = $item['TXZ01'];
                            $tmp['po_qty'] = $item['MENGE'];
                            $tmp['grn_qty'] = $item['R_QTY'];
                            $tmp['pending_qty'] = $item['P_QTY'];
                            $tmp['order_unit'] = $item['MEINS'];
                            $tmp['net_price'] = $item['NETPR'];
                            $tmp['price_unit'] = $item['PEINH'];
                            $tmp['net_value'] = $item['NETWR'];
                            $tmp['gross_value'] = $item['BRTWR'];

                            $footerData[] = $tmp;
                            //print_r($footerData);        
                        }

                        $poItemsInstance = $this->PoFooters->newEntities($footerData);
                        #print_r($poItemsInstance);
                        if ($this->PoFooters->saveMany($poItemsInstance)) {
                            $response['status'] = 1;
                            $response['message'] = 'PO saved successfully';
                        } else {
                            $response['status'] = 0;
                            $response['message'] = 'PO Items save fail';
                        }
                    } else {
                        $response['status'] = 0;
                        $response['message'] = 'PO header save fail';
                    }
                    //print_r($hederData);
                }
            } catch (\PDOException $e) {
                $response['status'] = 0;
                $response['message'] = $e->getMessage();
            } catch (\Exception $e) {
                $response['status'] = 0;
                $response['message'] = $e->getMessage();
            }
        }

        echo json_encode($response);
    }

    public function postPr()
    {
        $response = array();
        $response['status'] = 0;
        $response['message'] = 'Empty request';
        $request = $this->request->getData();

        $this->loadModel("PrHeaders");
        $this->loadModel("PrFooters");

        if (!empty($request) && count($request['DATA'])) {

            try {
                foreach ($request['DATA'] as $key => $row) {
                    $hederData = array();
                    $footerData = array();

                    $hederData['pr_no'] = $row['BANFN'];
                    $hederData['description'] = $row['TXZ01'];
                    $hederData['pr_type'] = $row['BSART'];
                    $hederData['purchase_group'] = $row['EKGRP'];

                    $poInstance = $this->PrHeaders->newEmptyEntity();
                    $poInstance = $this->PrHeaders->patchEntity($poInstance, $hederData);


                    if ($this->PrHeaders->save($poInstance)) {
                        $pr_header_id = $poInstance->id;

                        foreach ($row['ITEMS'] as $no => $item) {
                            $tmp = array();
                            $tmp['pr_header_id'] = $pr_header_id;
                            $tmp['item'] = $item['BNFPO'];
                            $tmp['material'] = $item['MATNR'];
                            $tmp['short_text'] = $item['TXZ01'];
                            $tmp['qty'] = $item['MENGE'];
                            $tmp['unit'] = $item['MEINS'];
                            $tmp['delivery_date'] = $item['LFDAT'];
                            $tmp['plant'] = $item['WERKS'];
                            $tmp['material_group'] = $item['MATKL'];
                            $tmp['storage_location'] = $item['LGORT'];
                            $tmp['purchase_group'] = $item['EKGRP'];
                            $tmp['requisitioner'] = $item['AFNAM'];
                            $tmp['total_value'] = $item['RLWRT'];
                            $tmp['price'] = $item['PEINH'];
                            $tmp['purchase_organization'] = $item['EKORG'];

                            $footerData[] = $tmp;
                            //print_r($footerData);        
                        }

                        $poItemsInstance = $this->PrFooters->newEntities($footerData);
                        #print_r($poItemsInstance);
                        if ($this->PrFooters->saveMany($poItemsInstance)) {
                            $response['status'] = 1;
                            $response['message'] = 'PR saved successfully';
                        } else {
                            $response['status'] = 0;
                            $response['message'] = 'PR Items save fail';
                        }
                    } else {
                        $response['status'] = 0;
                        $response['message'] = 'PR header save fail';
                    }
                }
            } catch (\PDOException $e) {
                $response['status'] = 0;
                $response['message'] = $e->getMessage();
            } catch (\Exception $e) {
                $response['status'] = 0;
                $response['message'] = $e->getMessage();
            }
        }

        echo json_encode($response);
    }


    public function notification()
    {
        $response = array();
        $response['status'] = 0;
        $response['message'] = '';
        $session = $this->getRequest()->getSession();


        $userId =  $session->read('id');

        
        $this->loadModel('Notifications');

        $conn = ConnectionManager::get('default');
        $notificationsQuery = $conn->execute("SELECT * FROM notifications WHERE message_count > 0 and user_id = $userId");

        $notifications = $notificationsQuery->fetchAll('assoc');

        $response['status'] = '1';
        $response['message'] = 'success';
        $response['notifications'] = $notifications;


        echo json_encode($response);
    }

    public function vendor($id = null)
    {
        $this->autoRender = false;
        $this->loadModel("VendorBranchOffices");
        $this->loadModel("VendorCommencements");
        $this->loadModel("VendorFacilities");
        $this->loadModel("VendorFactories");
        $this->loadModel("VendorIncometaxes");
        $this->loadModel("VendorOtherdetails");
        $this->loadModel("VendorPartnerAddress");
        $this->loadModel("VendorQuestionnaires");
        $this->loadModel("VendorRegisteredOffices");
        $this->loadModel("VendorReputedCustomers");
        $this->loadModel("VendorSmallScales");
        $this->loadModel("VendorTemps");
        $this->loadModel("VendorTurnovers");
        $this->loadModel("CompanyCodes");
        $this->loadModel("Countries");
        $this->loadModel("States");

        $conn = ConnectionManager::get('default');
        $vendortemp = $conn->execute("select vt.*, cc.name as company_code_name, pz.name as purchasing_organization_name, ag.name as account_group_name, sg.name as schema_group_name, ra.name as reconciliation_account_name, concat(pt.code, ' ', pt.description) as payment_term_name, CONCAT(us.first_name,' ',us.last_name) as buyer_name, vs.description as status_name, ct.country_name as country_name, st.name as state_name
        from vendor_temps vt 
        left join company_codes cc on cc.id=vt.company_code_id
        left join purchasing_organizations pz on pz.id=vt.purchasing_organization_id
        left join account_groups ag on ag.id=vt.account_group_id
        left join schema_groups sg on sg.id=vt.schema_group_id
        left join reconciliation_accounts ra on ra.id=vt.reconciliation_account_id
        left join payment_terms pt on pt.id=vt.payment_term_id
        left join users us on us.id=vt.buyer_id
        left join states st on st.id=vt.state_id
        left join countries ct on ct.id=vt.country_id
        left join vendor_status vs on vs.id=vt.status where vt.id =".$id);
        $vendortemp = $vendortemp->fetchAll('assoc');

        // echo '<pre>'; print_r($vendortemp); exit;
        $query = $conn->execute("select vb.*,st.name as state_name from vendor_branch_offices vb left join states st on st.id=vb.state left join countries ct on ct.country_name=vb.country where vb.vendor_temp_id =".$id);
        $vendortemp[0]['branch_office'] = $query->fetchAll('assoc');

        $query = $conn->execute("select vf.*,st.name as state_name from vendor_factories vf left join states st on st.id=vf.state left join countries ct on ct.country_name=vf.country where vf.vendor_temp_id =".$id);
        $vendortemp[0]['factory'] = $query->fetchAll('assoc');

        $query = $conn->execute("select vf.*,st.name as state_name from vendor_partner_address vf left join states st on st.id=vf.state left join countries ct on ct.country_name=vf.country where vf.vendor_temp_id =".$id);
        $vendortemp[0]['partner_address'] = $query->fetchAll('assoc');

        $query = $conn->execute("select vf.*,st.name as state_name from vendor_reputed_customers vf left join states st on st.id=vf.state left join countries ct on ct.country_name=vf.country where vf.vendor_temp_id =".$id);
        $vendortemp[0]['reputed_customer'] = $query->fetchAll('assoc');
        $vendortemp[0]['commencement'] = $this->VendorCommencements->find('all')->where(['vendor_temp_id' => $id])->toArray();
        $vendortemp[0]['facility'] = $this->VendorFacilities->find('all')->where(['vendor_temp_id' => $id])->toArray();
        $vendortemp[0]['factory'] = $this->VendorFactories->find('all')->where(['vendor_temp_id' => $id])->toArray();
        $vendortemp[0]['income_tax'] = $this->VendorIncometaxes->find('all')->where(['vendor_temp_id' => $id])->toArray();
        $vendortemp[0]['other_details'] = $this->VendorOtherdetails->find('all')->where(['vendor_temp_id' => $id])->toArray();
        $vendortemp[0]['questionnaire'] = $this->VendorQuestionnaires->find('all')->where(['vendor_temp_id' => $id])->toArray();
        $vendortemp[0]['registered_office'] = $this->VendorRegisteredOffices->find('all')->where(['vendor_temp_id' => $id])->toArray();
        // $vendortemp[0]['reputed_customer'] = $this->VendorReputedCustomers->find('all')->where(['vendor_temp_id' => $id])->toArray();
        $vendortemp[0]['small_scale'] = $this->VendorSmallScales->find('all')->where(['vendor_temp_id' => $id])->toArray();
        $vendortemp[0]['turnover'] = $this->VendorTurnovers->find('all')->where(['vendor_temp_id' => $id])->toArray();
        $response = array('status'=>1, 'message'=>$vendortemp);
        echo json_encode($response); exit;
    }

    public function getMaterialMasters()
    {
        $response = array();
        $response['status'] = 0;
        $response['message'] = 'Empty request';
        
        $this->loadModel("Materials");
        $this->loadModel("MaterialHistories");
        $this->loadModel("PrHeaders");
        $this->loadModel("PrFooters");

        $conn = ConnectionManager::get('default');
        $matlist = $conn->execute("select ph.sap_vendor_code as LIFNR, pf.material as MATNR, pf.short_text as MAKTX, 200 as MIN_STOCK, pf.order_unit as MEINS from po_headers ph inner join po_footers pf on ph.id=pf.po_header_id");

        $matlist = $matlist->fetchAll('assoc');

        /*
        $response = $http->get(
            'http://123.108.46.252:8000/sap/bc/sftmob/GET_MAT_MST/?sap-client=300',
            ['type' => 'json', 'auth' => ['username' => 'vcsupport1', 'password' => 'aarti@123']]
        );
        */

        try{

            if (true) { //|| $response->isOk()) 
                //$result = json_decode($response->getStringBody());
                $result = json_decode('{"RESPONSE":{"SUCCESS":1,"MESSAGE":"Success",
                    "MAT_LIST" :[{"LIFNR":"0000100186", "MATNR":"PHFG0411", "MAKTX":"Ethyl-2-(3-hydroxyphenyl)acetate", "MIN_STOCK":1200,"MEINS":"KG"},
                    {"LIFNR":"0000100186", "MATNR":"PHFG0417", "MAKTX":"1-(3-Methyl -1-Phenyl-5-pyrazolyl)piper", "MIN_STOCK":900,"MEINS":"KG"}]
                    }}');

                $result = ['RESPONSE'=>['SUCCESS'=>1, 'MESSAGE'=>"Success", 'MAT_LIST'=>$matlist]];

                if ($result['RESPONSE']['SUCCESS']) {
                // if ($result->RESPONSE->SUCCESS) {
                    $rows = [];
                    foreach($result['RESPONSE']['MAT_LIST'] as $row) {
                    // foreach($result->RESPONSE->MAT_LIST as $row) {
                        $temp = [];
                        // $temp['sap_vendor_code'] = $row->LIFNR;
                        // $temp['code'] = $row->MATNR;
                        // $temp['description'] = $row->MAKTX;
                        // $temp['minimum_stock'] = $row->MIN_STOCK;
                        // $temp['uom'] = $row->MEINS;

                        $temp['sap_vendor_code'] = $row['LIFNR'];
                        $temp['code'] = $row['MATNR'];
                        $temp['description'] = $row['MAKTX'];
                        $temp['minimum_stock'] = $row['MIN_STOCK'];
                        $temp['uom'] = $row['MEINS'];

                        $rows[] = $temp;
                    }

                    $columns = array_keys($rows[0]);
                    $upsertQuery = $this->Materials->query();
                    $upsertQuery->insert($columns);

                    foreach($rows as $row) {
                        $upsertQuery->values($row);
                    }
                    $upsertQuery->epilog('ON DUPLICATE KEY UPDATE `sap_vendor_code`=VALUES(`sap_vendor_code`), `code`=VALUES(`code`),
                        `description`=VALUES(`description`), `minimum_stock`=VALUES(`minimum_stock`), `uom`=VALUES(`uom`)')
                        ->execute();

                    $materialHistories = $this->MaterialHistories->newEntities($rows);
                    $this->MaterialHistories->saveMany($materialHistories);

                    
                    $response['status'] = '1';
                    $response['message'] = 'Success';
                    $response['data'] = $materialHistories;

                } else {
                    $response['status'] = '0';
                    $response['message'] = $result->RESPONSE->MESSAGE;
                }
            }
        } catch (\Exception $e) {
            $response['status'] = '0';
            $response['message'] = $e->getMessage();
        }

        echo json_encode($response);
    }

}