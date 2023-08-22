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

    public function stateByCountryID($id = null)
    {
        $this->autoRender = false;
        $this->loadModel("Countries");
        $this->loadModel("States");
        $states = $this->States->find('all')->innerJoin(['Countries'=>'Countries'],['Countries.country_code = States.country_code'])->where(['Countries.id' => $id])->toArray();
        $response = ["status"=> 1, 'message' =>$states];
        echo json_encode($response);
    }

    public function stateByCountryCode($country_code = null)
    {
        $this->autoRender = false;
        $this->loadModel("Countries");
        $this->loadModel("States");
        $states = $this->States->find('all')->innerJoin(['Countries'=>'Countries'],['Countries.country_code = States.country_code'])->where(['Countries.country_code' => $country_code])->toArray();
        $response = ["status"=> 1, 'message' =>$states];
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
                        }

                        $poItemsInstance = $this->PoFooters->newEntities($footerData);
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

    public function countries()
    {
        $this->autoRender = false;
        $this->loadModel("Countries");
        $countries = $this->Countries->find('all')->toArray();
        $response = array('status'=>1, 'message'=>$countries);
        echo json_encode($response); exit;
    }

    public function getCountryCodeById($country_code=null)
    {
        $this->autoRender = false;
        $this->loadModel("Countries");
        $countries = $this->Countries->find('all')->where(['id' => $country_code])->toArray()[0];
        $response = array('status'=>1, 'message'=>$countries);
        echo json_encode($countries->country_code); exit;
    }

    public function getStateRegioncodeById($region_code=null)
    {
        $this->autoRender = false;
        $this->loadModel("States");
        $states = $this->States->find('all')->where(['id' => $region_code])->toArray()[0];
        $response = array('status'=>1, 'message'=>$states);
        echo json_encode($states->region_code); exit;
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
        $vendortemp[0]['factory'] = $this->VendorFactories->find('all')->contain(['VendorCommencements'])->where(['vendor_temp_id' => $id])->toArray();
        $vendortemp[0]['questionnaire'] = $this->VendorQuestionnaires->find('all')->where(['vendor_temp_id' => $id])->toArray();
        
        $income_tax = $this->VendorIncometaxes->find('all')->where(['vendor_temp_id' => $id])->toArray();
        if(count($income_tax) > 0){$vendortemp[0]['income_tax']= $income_tax[0]; } else {$vendortemp[0]['income_tax']=[];}
        
        $other_details =$this->VendorOtherdetails->find('all')->where(['vendor_temp_id' => $id])->toArray();
        if(count($other_details) > 0){$vendortemp[0]['other_details']= $other_details[0]; } else {$vendortemp[0]['other_details']=[];}
        
        $registered_office = $this->VendorRegisteredOffices->find('all')->where(['vendor_temp_id' => $id])->toArray();
        if(count($registered_office) > 0){$vendortemp[0]['registered_office']= $registered_office[0]; } else {$vendortemp[0]['registered_office']=[];}
        
        $small_scale = $this->VendorSmallScales->find('all')->where(['vendor_temp_id' => $id])->toArray();
        if(count($small_scale) > 0){$vendortemp[0]['small_scale']= $small_scale[0]; } else {$vendortemp[0]['small_scale']=[];}

        $turnover = $this->VendorTurnovers->find('all')->where(['vendor_temp_id' => $id])->toArray();
        if(count($turnover) > 0){$vendortemp[0]['turnover']= $turnover[0]; } else {$vendortemp[0]['turnover']=[];}

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
        
        set_time_limit(300);
        $response = array();
        $response['message'] = [];

        $matStock = [];
        
        $ftpConn = $this->Ftp->connection();
        $data  = $this->Ftp->downloadFile($ftpConn, "MATERIAL_MIN_STOCK.JSON");
        if($data) {
            $data = trim(preg_replace('/\s+/', ' ', $data));
            $d = json_decode($data);

            foreach($d->MIN_STOCK as $key => $row) {
                $temp = [];
                $temp['sap_vendor_code'] = $row->LIFNR;
                $temp['code'] = $row->MATNR;
                $temp['minimum_stock'] = $row->MIN_STOCK;
                $temp['uom'] = $row->MEINS;
                $matStock[] = $tmp;
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
        }

        echo json_encode($response);
    }

}