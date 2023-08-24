<?php

declare(strict_types=1);

namespace App\Controller\Buyer;

use Cake\Mailer\Email;
use Cake\Mailer\Mailer;
use Cake\Mailer\TransportFactory;
use Cake\Routing\Router;
use Cake\Http\Client;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Cake\Datasource\ConnectionManager;
use SebastianBergmann\Environment\Console;

/**
 * VendorTemps Controller
 *
 * @property \App\Model\Table\VendorTempsTable $VendorTemps
 * @method \App\Model\Entity\VendorTemp[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class VendorTempsController extends BuyerAppController
{
    public function initialize(): void
    {
        parent::initialize();
        $flash = [];  
        $this->set('flash', $flash);
        $this->loadComponent('Ftp');
    }
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        
        $this->set('headTitle', 'Vendor List');
        $this->loadModel("VendorTemps");
        $this->loadModel("Users");
        $vendorTemps = $this->VendorTemps
        ->find('all')
        ->contain(['PurchasingOrganizations', 'AccountGroups', 'SchemaGroups'])
        ->where(['update_flag' => 0])
        ->order(['VendorTemps.added_date' => 'DESC'])
        ->toArray();
        $user_id = $this->getRequest()->getSession()->read('id');
        $usr = $this->Users->get($user_id);
        $this->set('user_id', $usr);
        $this->set(compact('vendorTemps'));

        //$this->getRequestedVendor();
        //$this->getCreatedVendor();

    }

    public function getList($term = null)
    {
        $this->autoRender = false;
        $list = array();
        $term = isset($_GET['term']) ? $_GET['term'] : null;

        $response['status'] = 0;
        $response['message'] = 'no records';
        if ($term != null) {
            $this->loadModel("VendorTemps");

            $vendors = $this->VendorTemps->find()
                ->select(['id', 'name', 'city', 'email', 'mobile'])
                ->where(["name like '%$term%'"])
                ->order(['name asc'])->all();

            foreach ($vendors as $vendor) {
                $tmp = array();
                $tmp['id'] = $vendor->id;
                $tmp['value'] = $vendor->name . ' (' . $vendor->city . ')';
                //$tmp['email'] = $vendor->email;
                //$tmp['mobile'] = $vendor->mobile;
                $list[] = $tmp;
            }
        }

        if (count($list)) {
            $response['status'] = 1;
            $response['message'] = 'success';
            $response['data'] = $list;
        }

        echo json_encode($list);
    }

    /**
     * View method
     *
     * @param string|null $id Vendor Temp id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->loadModel("VendorTemps");

        $vendorTemp = $this->VendorTemps->get($id);
        /*$vendorTemp = $this->VendorTemps->get($id, [
            'contain' => ['PurchasingOrganizations', 'AccountGroups', 'SchemaGroups', 'PaymentTerms', 'CompanyCodes', 'States', 'Countries', 'VendorBranchOffices'],
        ]);*/

        //echo '<pre>'; print_r($vendorTemp); exit;
        $this->set('headTitle', 'Vendor Details');

       
        $this->set('vendorTemp', $vendorTemp);
    }


    public function update($id = null)
    {
        $flash = [];
        $this->loadModel("VendorTemps");
        $oldrecord = $this->VendorTemps->get($id);
        $newrecord = $this->VendorTemps->find('all')->where(['update_flag' => $id])->first();
        if ($this->request->is('post')) {
            $status = $this->request->getData('status');
            if ($status == 1){
                $newrecord->update_flag = '0';
                $oldrecord->update_flag = '-1';
                if ($this->VendorTemps->save($newrecord)) {
                    if ($this->VendorTemps->save($oldrecord)) {
                        $flash = ['type'=>'success', 'msg'=>'Vendor Details Updated'];
                    }
                        $flash = ['type'=>'error', 'msg'=>'Failed'];
                    }
                }
                else {
                    $newrecord->update_flag = '-2';
                    if ($this->VendorTemps->save($newrecord)) {
                        $flash = ['type'=>'success', 'msg'=>'Vendor Details Rejected'];
                    // } else { $this->Flash->error(__('Failed'));
                        $flash = ['type'=>'error', 'msg'=>'Failed']; }
                    }
                $this->set('flash', $flash);
        }
        return $this->redirect(['action' => 'view', $id]);
    }



    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */

    public function sapView($id = null)
    {
        $this->loadModel("VendorTemps");
        $vendorTemp = $this->VendorTemps->get($id, [
            'contain' => ['PurchasingOrganizations', 'AccountGroups', 'SchemaGroups'],
        ]);
        $this->set('headTitle', 'Vendor Details');


        $this->set(compact('vendorTemp'));
    }
    
    public function masterByCompanyCode($id = null)
    {
        $this->autoRender = false;
        $response = ["status"=>0, 'message' =>'Empty request'];
        $this->loadModel("CompanyCodes");
        $this->loadModel("PurchasingOrganizations");
        $this->loadModel("ReconciliationAccounts");
        //$this->loadModel("AccountGroups");
        //$this->loadModel("PaymentTerms");
        //$this->loadModel("SchemaGroups");
        
        $po = $this->PurchasingOrganizations->find()->select(['id', 'name'])->where(['company_code_id =' => $id])->toArray();
        $ra = $this->ReconciliationAccounts->find()->select(['id', 'name'])->where(['company_code_id =' => $id])->toArray();
        //$ag = $this->AccountGroups->find()->select(['id', 'name'])->where(['company_code_id =' => $id])->toArray();
        
        //$pt = $this->PaymentTerms->find()->select(['id', 'description'])->where(['company_code_id =' => $id])->toArray();
        //$sg = $this->SchemaGroups->find()->select(['id', 'name'])->where(['company_code_id =' => $id])->toArray();
        $response = ["status"=>1, 'message' =>['PurchasingOrganizations'=>$po, 'ReconciliationAccounts' => $ra]];
        echo json_encode($response);
    }
    

    public function add()
    {
        $flash = [];
        $session = $this->getRequest()->getSession();

        $this->set('headTitle', 'Create Vendor');
        $this->loadModel("Titles");
        $this->loadModel("VendorTemps");
        $this->loadModel("VendorStatus");
        $this->loadModel("PaymentTerms");
        $this->loadModel("CompanyCodes");
        $this->loadModel('AccountGroups');
        $this->loadModel('SchemaGroups');
        $this->loadModel("ReconciliationAccounts");
        $this->loadModel("PurchasingOrganizations");

        $latestVendors = $this->VendorTemps
        ->find('all')
        ->contain(['PurchasingOrganizations', 'AccountGroups', 'SchemaGroups'])
        ->order(['VendorTemps.added_date' => 'DESC'])
        ->limit(5);

        //echo '<pre>'; print_r($latestVendors); exit;

        $vendorTemp = $this->VendorTemps->newEmptyEntity();
        $vendorCodes = [];
        if ($this->request->is('post')) {

            $importFile = $this->request->getData('vendor_code');
            if ($_FILES['vendor_code']['name'] != "") {
                if ($importFile !== null && isset($_FILES['vendor_code']['name'])) {
                    // echo '<pre>';
                    $destination = "uploads/";
                    $filename = $_FILES['vendor_code']['name'];
                    $path = $destination . $filename;
                    move_uploaded_file($_FILES['vendor_code']['tmp_name'], $path);
                    $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($path);
                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                    $spreadsheet = $reader->load($path);
                    $worksheet = $spreadsheet->getActiveSheet();

                    try{
                        foreach ($worksheet->getRowIterator(2) as $row) {
                            $minivendor = [];
                            foreach ($row->getCellIterator() as $cell) {
                                $cellval = $cell->getValue();
                                array_push($minivendor, $cellval);
                            }
                            if (1 < count($minivendor) && count($minivendor) == 7){
                                // print_r($minivendor);exit;
                                $vendorTemp = $this->VendorTemps->newEmptyEntity();
        
                                // Check if mobile exist
                                if ($this->VendorTemps->exists(['VendorTemps.mobile' => $minivendor[2]])){
                                    array_push($vendorCodes, ['status'=>false, 'msg'=>"Mobile Already Exist", 'data'=>$minivendor]); continue;
                                } else { $vendorTemp->mobile = $minivendor[2]; }
        
                                // Check if email exist
                                if ($this->VendorTemps->exists(['VendorTemps.email' => $minivendor[3]])){
                                    array_push($vendorCodes, ['status'=>false, 'msg'=>"Email Already Exist", 'data'=>$minivendor]); continue;
                                } else { $vendorTemp->email = $minivendor[3]; }
        
                                // Check if Payment Term exist
                                if ($minivendor[4]){
                                    if ($minivendor[4] && !$this->PaymentTerms->exists(['PaymentTerms.code' => $minivendor[4]])){
                                        array_push($vendorCodes, ['status'=>false, 'msg'=>"Payment Terms not found", 'data'=>$minivendor]); continue;
                                    } else { 
                                        $payment_term = $this->PaymentTerms->find('all')->where(['code =' => $minivendor[4]])->limit(1)->toArray();
                                        if($payment_term[0]->id){$vendorTemp->payment_term = $payment_term[0]->id;}
                                    }
                                }
        
                                // Check if Purchase Organisation exist
                                // print_r($minivendor[4]); exit;
                                if ($minivendor[5]){
                                    if (!$this->PurchasingOrganizations->exists(['PurchasingOrganizations.name' => $minivendor[5]])){
                                        array_push($vendorCodes, ['status'=>false, 'msg'=>"Purchasing Organizations not found", 'data'=>$minivendor]); continue;
                                    } else { 
                                        $purchasing_org = $this->PurchasingOrganizations->find('all')->where(['name =' => $minivendor[5]])->limit(1)->toArray();
                                        if($purchasing_org[0]->id){$vendorTemp->purchasing_organization_id = $purchasing_org[0]->id;}
                                    }
                                }

                                // Check if Account Group exist
                                if($minivendor[6]){
                                    if (!$this->AccountGroups->exists(['AccountGroups.name' => $minivendor[6]])){
                                        array_push($vendorCodes, ['status'=>false, 'msg'=>"Account Groups not found", 'data'=>$minivendor]); continue;
                                    } else { 
                                        $account_group = $this->AccountGroups->find('all')->where(['name =' => $minivendor[6]])->limit(1)->toArray();
                                        if($account_group[0]->id){$vendorTemp->account_group_id = $account_group[0]->id;}
                                    }
                                }
                                
                                // Check if Schema Group exist
                                if ($minivendor[7]){
                                    if (!$this->SchemaGroups->exists(['SchemaGroups.name' => $minivendor[7]])){
                                        array_push($vendorCodes, ['status'=>false, 'msg'=>"Schema Groups not found", 'data'=>$minivendor]); continue;
                                    } else { 
                                        $schema_grp = $this->SchemaGroups->find('all')->where(['name =' => $minivendor[7]])->limit(1)->toArray();
                                        if($schema_grp[0]->id){ $vendorTemp->schema_group_id = $schema_grp[0]->id;}
                                    }
                                }
                                
                                $vendorTemp->buyer_id = $this->getRequest()->getSession()->read('id');
                                $vendorTemp->name = $minivendor[1];
                                $vendorTemp->valid_date = date('Y-m-d h:i:s');
                                $vendorTemp->status = 3;
                                
                                try {
                                    if($this->VendorTemps->save($vendorTemp)){
                                        $id = $vendorTemp->toArray();
                                        array_push($vendorCodes, ['status'=>true, 'msg'=>"Vendor Add Successful", 'data'=>$minivendor]);
                                    } else { array_push($vendorCodes, ['status'=>false, 'msg'=>"Vendor Add Failed", 'data'=>$minivendor]); }
                                } catch (\Exception $e) { array_push($vendorCodes, ['status'=>false, 'msg'=>$e->getMessage(), 'data'=>$minivendor]); }
                            }
                        }
                        $tempvendor = [];
                        foreach ($vendorCodes as $ven) { 
                            if (!$ven['status']){
                                array_push($tempvendor, $ven);
                            }
                        }
                        foreach ($vendorCodes as $ven) { 
                            if ($ven['status']){
                                array_push($tempvendor, $ven);
                            }
                        }
        
                        $this->set('results', $tempvendor);
                    } catch (\Exception $e) {
                        $flash = ['type'=>'error', 'msg'=>'Invalid Excel File'];
                        $this->set('flash', $flash);
                    }
                } else {
                    $flash = ['type'=>'error', 'msg'=>'SAP Vendor Code or Excel File Required'];
                    $this->set('flash', $flash);
                }
            } else {
                $flash = ['type'=>'error', 'msg'=>'SAP Vendor Code or Excel File Required'];
                $this->set('flash', $flash);
            }
        }
        $titles = $this->Titles->find('list', ['keyField' => 'name', 'valueField' => 'name'])->all();
        $purchasingOrganizations = $this->VendorTemps->PurchasingOrganizations->find('list', ['limit' => 200])->all();
        $accountGroups = $this->VendorTemps->AccountGroups->find('list', ['limit' => 200])->all();
        $schemaGroups = $this->VendorTemps->SchemaGroups->find('list', ['limit' => 200])->all();
        $payment_term = $this->PaymentTerms->find('list', ['keyField' => 'id', 'valueField' => 'description'])->all();
        $company_codes = $this->CompanyCodes->find('list', ['keyField' => 'id', 'valueField' => 'name'])->all();
        $reconciliation_account = $this->ReconciliationAccounts->find('list', ['keyField' => 'code', 'valueField' => 'name'])->all();

        $this->set(compact('vendorTemp','titles', 'purchasingOrganizations', 'accountGroups', 'schemaGroups', 'payment_term', 'reconciliation_account', 'company_codes', 'latestVendors'));
    }

    public function sapAdd()
    {
        $flash = [];
        $this->set('headTitle', 'Import SAP Vendor');
        $this->loadModel("VendorTemps");

        if ($this->request->is('post')) {

            $inputCode = trim($this->request->getData('sap_vendor_code'));
            $importFile = $this->request->getData('vendor_code');
            $this->loadModel("Users");
            $vendorView = [];
            $vendorCodes = [$inputCode];
            // Incase of Excel input
            if ($inputCode == "") { $vendorCodes = []; }

            if ($_FILES['vendor_code']['name'] != "") {
                if ($importFile !== null && isset($_FILES['vendor_code']['name'])) {
                    $destination = "uploads/";
                    $filename = $_FILES['vendor_code']['name'];
                    $path = $destination . $filename;
                    move_uploaded_file($_FILES['vendor_code']['tmp_name'], $path);
                    $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($path);
                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                    $spreadsheet = $reader->load($path);
                    $worksheet = $spreadsheet->getActiveSheet();
                    // Copy cell data to vendorCodes array
                    foreach ($worksheet->getRowIterator(2) as $row) {
                        foreach ($row->getCellIterator() as $cell) {
                            $cellval = $cell->getValue();
                            if (!empty($cellval)) {
                                $vendorCodes[] = $cellval;
                            }
                            break;
                        }
                    }
                }
            }
            
            foreach ($vendorCodes as $vendorCode) {
                if (!empty($vendorCode)) {
                    if (!$this->VendorTemps->exists(['sap_vendor_code' => str_pad($vendorCode, 10, "0", STR_PAD_LEFT)])) {
                        $data = [];
                        $data['LIFNR'] = $vendorCode;
                        $uploadFileContent = json_encode($data);
                        $uploadfileName = 'VENDOR_GET_('.$vendorCode.')_REQ.JSON';
                        $ftpConn = $this->Ftp->connection();
                        if($this->Ftp->uploadFile($ftpConn, $uploadFileContent, $uploadfileName)) {
                            $flash = ['type'=>'success', 'msg'=>' Request sent to SAP, please check after sometime.'];
                        } else {
                            $flash = ['type'=>'error', 'msg'=>' Something went wrong, please retry.'];
                        }
                    } else {
                        array_push($vendorView, ['status' => false, 'msg' => "Vendor for SAP code Exist", 'data' => ['sap_vendor_code' => $vendorCode]]);
                    }
                } else {
                    array_push($vendorView, ['status' => false, 'msg' => "Invalid SAP Vendor Code", 'data' => ['sap_vendor_code' => $vendorCode]]);
                }
            }
            // print_r($vendorView); exit;
            $this->set('vendorData', $vendorView);
            return $this->redirect(['action' => 'index']);
        }
    }


    /**
     * Edit method
     *
     * @param string|null $id Vendor Temp id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $flash = [];
        $this->loadModel("VendorTemps");
        $vendorTemp = $this->VendorTemps->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $vendorTemp = $this->VendorTemps->patchEntity($vendorTemp, $this->request->getData());
            if ($this->VendorTemps->save($vendorTemp)) {
                $flash = ['type'=>'success', 'msg'=>'The vendor has been saved'];
                $this->set('flash', $flash);

                return $this->redirect(['action' => 'index']);
            }
            $flash = ['type'=>'error', 'msg'=>'The vendor temp could not be saved. Please, try again'];
            $this->set('flash', $flash);
        }
        $purchasingOrganizations = $this->VendorTemps->PurchasingOrganizations->find('list', ['limit' => 200])->all();
        $accountGroups = $this->VendorTemps->AccountGroups->find('list', ['limit' => 200])->all();
        $schemaGroups = $this->VendorTemps->SchemaGroups->find('list', ['limit' => 200])->all();
        $this->set(compact('vendorTemp', 'purchasingOrganizations', 'accountGroups', 'schemaGroups'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Vendor Temp id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $flash = [];
        $this->request->allowMethod(['post', 'delete']);
        $vendorTemp = $this->VendorTemps->get($id);
        if ($this->VendorTemps->delete($vendorTemp)) {
            $flash = ['type'=>'success', 'msg'=>'The vendor temp has been deleted'];
        } else {
            $flash = ['type'=>'error', 'msg'=>'The vendor temp could not be deleted. Please, try again'];
        }
        $this->set('flash', $flash);
        
        return $this->redirect(['action' => 'index']);
    }

    public function approveVendor($id = null, $action = null)
    {
        $flash = [];
        $this->loadModel("VendorTemps");
        $vendor = $this->VendorTemps->get($id, ['contain' => ['CompanyCodes','SchemaGroups','PurchasingOrganizations','AccountGroups', 'ReconciliationAccounts', 'States', 'Countries', 'PaymentTerms']]);

        if ($action == 'rej') {
            if ($this->request->is(['patch', 'post', 'put'])) {
                $remarks = $this->request->getData('remarks');
                $vendor->status = 4;
                $vendor->remark = $remarks;
                $this->VendorTemps->save($vendor);
                $quryString = $vendor->email . '||' . $vendor->id;
               
                $visit_url = Router::url(['prefix'=>false, 'controller' => 'vendor/onboarding', 'action' => 'verify', base64_encode($quryString), '_full' => true, 'escape' => true]);
                $mailer = new Mailer('default');
                $mailer
                    ->setTransport('smtp')
                    ->setViewVars([ 'subject' => 'Hi ' . $vendor->name, 'mailbody' => 'Your form has been rejected. Kindly Resubmit. <br/> <br/>Please find below the buyers remarks <br/>'.$remarks, 'link' => $visit_url, 'linktext' => 'Click Here' ])
                    ->setFrom(['vekpro@fts-pl.com' => 'FT Portal'])
                    ->setTo($vendor->email)
                    ->setEmailFormat('html')
                    ->setSubject('Vendor Portal - Vendor KYC Process')
                    ->viewBuilder()
                        ->setTemplate('mail_template');
                $mailer->deliver();

                $flash = ['type'=>'success', 'msg'=>'The Vendor successfully rejected'];
            } else {
                $flash = ['type'=>'success', 'msg'=>'Issue in vendor rejection'];
            }
            $this->set('flash', $flash);

            return $this->redirect(['action' => 'view', $id]);
        }

        if ($action == 'app') { $vendor->status = 2; }

        if ($this->VendorTemps->save($vendor)) {

            $data['DATA'] = array();

            $data['DATA']['VENDOR_PORTAL_ID'] = $vendor->id;
            $data['DATA']['LIFNR'] = $vendor->sap_vendor_code;
            $data['DATA']['BUKRS'] = $vendor->company_code->code;
            $data['DATA']['EKORG'] = $vendor->purchasing_organization->code;
            $data['DATA']['KTOKK'] = $vendor->account_group->code;
            $data['DATA']['TITLE_MEDI'] = $vendor->title;
            $data['DATA']['NAME1'] = $vendor->name;
            $data['DATA']['NAME2'] = $vendor->address;
            $data['DATA']['NAME3'] = $vendor->address_2;
            $data['DATA']['NAME4'] = $vendor->city;

            $data['DATA']['SORT1'] = $vendor->name;
            $data['DATA']['STREET'] = $vendor->address;
            $data['DATA']['CITY1'] = $vendor->city;
            $data['DATA']['POST_CODE1'] = $vendor->pincode;

            $data['DATA']['REGION'] = $vendor->state->region_code;
            $data['DATA']['COUNTRY'] = $vendor->country->country_code;
            $data['DATA']['SMTP_ADDR'] = $vendor->email;
            $data['DATA']['MOB_NUMBER'] = $vendor->mobile;

            $data['DATA']['AKONT'] = $vendor->reconciliation_account->code;
            $data['DATA']['ZUAWA'] = '';
            $data['DATA']['SPRAS'] = '';
            $data['DATA']['TAXTYPE'] = '';
            $data['DATA']['KALSK'] = $vendor->schema_group->code;
            $data['DATA']['GSIN'] = $vendor->gst_no;
            $data['DATA']['PAN'] = $vendor->pan_no;
            $data['DATA']['ZTERM'] = $vendor->payment_term->code;
            $data['DATA']['WAERS'] = $vendor->order_currency;


            $uploadFileContent = json_encode($data);
            $uploadfileName = 'VENDOR_CR_('.$vendor->id.')_REQ.JSON';
            $ftpConn = $this->Ftp->connection();
            if($this->Ftp->uploadFile($ftpConn, $uploadFileContent, $uploadfileName)) {
                $flash = ['type'=>'success', 'msg'=>' Vendor sent to SAP for approval'];
            } else {
                $flash = ['type'=>'error', 'msg'=>' Vendor sent to SAP fail'];
            }

            /*
            $http = new Client();
            $response = $http->post(
                'http://123.108.46.252:8000/sap/bc/sftmob/VENDER_UPD/?sap-client=300',
                json_encode($data),
                ['type' => 'json', 'auth' => ['username' => 'vcsupport1', 'password' => 'aarti@123']]
            );

            
            if ($response->isOk()) {
                $result = json_decode($response->getStringBody());

                if ($result->RESPONSE->SUCCESS) {

                    $resultResponse = json_decode($result->RESPONSE->DATA);
                    $newVendorCode = trim($resultResponse->DATA->LIFNR);

                    if (!empty($newVendorCode)) {
                        $this->loadModel("Users");
                        $adminUser = $this->Users->newEmptyEntity();
                        // echo '<pre>';
                        // print_r($adminUser);

                        $data = array();
                        $data['first_name'] = $vendor->name;
                        $data['last_name'] = $vendor->name;
                        $data['username'] = $vendor->email;
                        $data['mobile'] = $vendor->mobile;
                        $data['password'] = $vendor->mobile;
                        $data['group_id'] = 3;

                        $adminUser = $this->Users->patchEntity($adminUser, $data);

                        if ($this->Users->save($adminUser)) {
                           
                            $visit_url = Router::url(['prefix' => false, 'controller' => 'users', 'action' => 'login', '_full' => true, 'escape' => true]);
                            $mailer = new Mailer('default');
                            $mailer
                                ->setTransport('smtp')
                                ->setViewVars([ 'subject' => 'Hi ' . $data['first_name'], 'mailbody' => 'Welcome to Vendor portal. <br/> <br/> Username: ' . $data['username'] .
                                '<br/>Password:' . $data['password'], 'link' => $visit_url, 'linktext' => 'Click Here' ])
                                ->setFrom(['vekpro@fts-pl.com' => 'FT Portal'])
                                ->setTo($data['username'])
                                ->setEmailFormat('html')
                                ->setSubject('Vendor Portal - Account created')
                                ->viewBuilder()
                                ->setTemplate('mail_template');
                            $mailer->deliver();
                        }
                    }

                    $vendor->status = 3; //Approved by SAP
                    $vendor->sap_vendor_code = $newVendorCode;
                    $this->VendorTemps->save($vendor);



                    $this->redirect(['action' => 'index',]);
                    $flash = ['type'=>'success', 'msg'=>__('The Vendor successfully approved', array('action' => 'index'), 30)];
                }
            } else {
                $flash = ['type'=>'success', 'msg'=>' Vendor sent to SAP for approval'];
            } */
        } else {
            $flash = ['type'=>'error', 'msg'=>'The Vendor detail could not be updated. Please, try again'];
        }
        $this->set('flash', $flash);

        return $this->redirect(['action' => 'view', $id]);
    }


    public function addvendor()
    {
        $response = array();
        $response['status'] = 'fail';
        $response['message'] = '';
        $this->autoRender = false;
        $this->loadModel("VendorTemps");
        
        $this->loadModel("Notifications");

        // echo '<pre>'; print_r($this->request->getData()); exit;
        if ($this->request->is(['patch', 'post', 'put'])) {
            try {
                $VendorTemp = $this->VendorTemps->newEmptyEntity();
                $data = $this->request->getData();
                $data['buyer_id'] = $this->getRequest()->getSession()->read('id');
                $data['valid_date'] = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +1 day'));
                $VendorTemp = $this->VendorTemps->patchEntity($VendorTemp, $data);

                $result = $this->VendorTemps->find('all')
                ->select(['title','name', 'mobile', 'email','purchasing_organization_id', 'status'])
                ->where([
                    'OR' => [
                        ['name' => trim($data['name'])],
                        ['mobile' => $data['mobile']],
                        ['email' => $data['email']],
                    ]
                    ])->toArray();

                $response['status'] = 'fail';
                if(count($result)) {
                    $response['message'] = 'Vendor already exists';
                    //$response['data'] = $result;
                }else if ($this->VendorTemps->exists(['VendorTemps.mobile' => $data['mobile']])) {
                    $response['message'] = 'Mobile Number Exist';
                } else if ($this->VendorTemps->exists(['VendorTemps.email' => $data['email']])) {
                    $response['message'] = 'Email ID Exist';
                } else if ($this->VendorTemps->save($VendorTemp)) {
                    $response['status'] = 'success';
                    $response['message'] = 'Record save successfully';
                    $quryString = $data['email'] . '||' . $VendorTemp->id;

                    // $link = Router::url(['prefix'=>false, 'controller' => 'vendor/onboarding', 'action' => 'verify', base64_encode($quryString), '_full' => true, 'escape' => true]);
                    // $mailer = new Mailer('default');
                    // $mailer
                    //     ->setTransport('smtp')
                    //     ->setFrom(['vekpro@fts-pl.com' => 'FT Portal'])
                    //     ->setTo($data['email'])
                    //     ->setEmailFormat('html')
                    //     ->setSubject('Verify New Account')
                    //     ->deliver('Hi ' . $data['name'] . '<br/>Welcome to Vendor portal. <br/>' . $link);

                    $visit_url = Router::url(['prefix'=>false, 'controller' => 'vendor/onboarding', 'action' => 'verify', base64_encode($quryString), '_full' => true, 'escape' => true]);
                    $mailer = new Mailer('default');
                    $mailer
                        ->setTransport('smtp')
                        ->setViewVars([ 'subject' => 'Hi ' . $data['name'], 'mailbody' => 'Welcome to Vendor portal', 'link' => $visit_url, 'linktext' => 'Click Here for Onboarding' ])
                        ->setFrom(['vekpro@fts-pl.com' => 'FT Portal'])
                        ->setTo($data['email'])
                        ->setEmailFormat('html')
                        ->setSubject('Vendor Portal - Verify New Account')
                        ->viewBuilder()
                            ->setTemplate('mail_template');
                    $mailer->deliver();
                }
            } catch (\Exception $e) {
                $response['status'] = 'fail';
                $response['message'] = 'Contact Administrator';
                if ($e->getMessage()) {
                    $response['message'] = $e->getMessage();
                }
            }
        }

        echo json_encode($response);
    }

    public function sapEdit($id = null)
    {

        $response = array();
        $response['status'] = '0';
        $response['message'] = '';
        $this->autoRender = false;


        $this->loadModel("VendorTemps");
        $vendorTemp = $this->VendorTemps->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            try {
                // $vendorTemp = $this->VendorTemps->newEmptyEntity();

                $data = $this->request->getData();


                $query = $this->VendorTemps->find('all')
                    ->where(['VendorTemps.id' => $id])
                    ->first();

                if ($query) {
                    if ($query['email'] != $data['email']) {
                        $emailCount = $this->VendorTemps->find()
                            ->where(['VendorTemps.email' => $data["email"]])
                            ->count();

                        if ($emailCount > 0) {
                            throw new \Exception('Already Exits Email ID');
                        }
                    } else if ($query['mobile'] != $data['mobile']) {
                        $mobileCount = $this->VendorTemps->find()
                            ->where(['VendorTemps.mobile' => $data["mobile"]])
                            ->count();

                        if ($mobileCount > 0) {
                            throw new \Exception('Already Exits Mobile No.');
                        }
                    }

                    $vendorTemp = $this->VendorTemps->patchEntity($query, $data);

                    if ($this->VendorTemps->save($vendorTemp)) {
                        $response['status'] = '1';
                        $response['message'] = 'Update Successfully';
                    } else {
                        throw new \Exception('Failed to Add User');
                    }
                } else {
                    throw new \Exception('Invalid ID');
                }
            } catch (\Exception $e) {
                $response['status'] = '0';
                $response['message'] = $e->getMessage();
            }
        }


        echo json_encode($response);
    }

    public function userCredentials($id = null)
    {
        $response = array();
        $response['status'] = 0;
        $response['message'] = '';
        $this->autoRender = false;

        $this->loadModel("Users");
        $this->loadModel("VendorTemps");


        $vendorTemp = $this->VendorTemps->get($id);

        if ($this->request->is(['patch', 'get', 'put'])) {

            $query = $this->Users->find()
                ->select(['first_name', 'mobile', 'username'])
                ->where(['username' => $vendorTemp->email])
                ->toList();

            if (count($query)) {
                foreach ($query as $val) {
                    $vendorTemp->status = 3;
                    if($this->VendorTemps->save($vendorTemp)) {
                        $visit_url = Router::url(['prefix' => false, 'controller' => 'users', 'action' => 'login', '_full' => true, 'escape' => true]);
                        $mailer = new Mailer('default');
                        $mailer
                            ->setTransport('smtp')
                            ->setViewVars([ 'subject' => 'Hi ' . $val->first_name, 'mailbody' => 'Welcome to Vendor portal. <br/> <br/> Username: ' . $val->username .
                            '<br/>Password:' . $val->mobile, 'link' => $visit_url, 'linktext' => 'Click Here' ])
                            ->setFrom(['vekpro@fts-pl.com' => 'FT Portal'])
                            ->setTo($val->username)
                            ->setEmailFormat('html')
                            ->setSubject('Vendor Portal - Account created')
                            ->viewBuilder()
                                ->setTemplate('mail_template');
                        $mailer->deliver();
                        $response['status'] = 1;
                        $response['message'] = 'Credentials Mail Send successfully';
                    } else {
                        $response['status'] = 0;
                        $response['message'] = 'Issue in sending credentials details';
                    }
                }
            } else {
                $response['status'] = 0;
                $response['message'] = 'Credentials Not Send.';
            }
        }


        
        echo json_encode($response);
    }

    public function bulkupdate($status_id = null, $user_arr = array()){
        if ($this->request->is(['patch', 'post', 'put'])) {
            try {
                $data = $this->request->getData();
                echo '<pre>'; print_r($data);exit;
            } catch (\Exception $e) {
                $response['status'] = '0';
                $response['message'] = $e->getMessage();
            }
        }
    }

    function getRequestedVendor() {
        $ftpConn = $this->Ftp->connection();
        $list = $this->Ftp->getList($ftpConn);
        foreach($list as $fileKey => $val) {
            if(str_starts_with($fileKey, 'VENDOR_GET_')) {
                $data  = $this->Ftp->downloadFile($ftpConn, $fileKey);
                if($data) {
                    $this->loadModel("VendorTemps");
        
                    $data = trim(preg_replace('/\s+/', ' ', $data));
                    $d = json_decode($data);
        
                    foreach($d->VENDOR_LIST as $key => $row) {
                        $companyCode = $this->VendorTemps->CompanyCodes->findByCode($row->BUKRS)->first();
                        $puOrg = $this->VendorTemps->PurchasingOrganizations->findByCode($row->EKORG)->first();
                        $accGrp = $this->VendorTemps->AccountGroups->findByCode($row->KTOKK)->first();
                        $reconAccount = $this->VendorTemps->ReconciliationAccounts->findByCode($row->AKONT)->first();
                        $companyCode = $this->VendorTemps->CompanyCodes->findByCode($row->BUKRS)->first();
                        $schemaGroup = $this->VendorTemps->SchemaGroups->findByCode($row->KALSK)->first();
                        $region = $this->VendorTemps->States->findByRegionCode($row->REGION)->first();
                        $country = $this->VendorTemps->Countries->findByCountryCode($row->COUNTRY)->first();
                        $payTerm = $this->VendorTemps->PaymentTerms->findByCode($row->ZTERM)->first();
                        
                        if($row->SUCCESS == "0") { continue; }
                        $vendorExists = false;
                        if($this->VendorTemps->exists(['sap_vendor_code' => str_pad($row->LIFNR, 10, "0", STR_PAD_LEFT)])) {
                            $vendor = $this->VendorTemps->find()->where(['sap_vendor_code' => str_pad($row->LIFNR, 10, "0", STR_PAD_LEFT)])->first();
                            $vendorExists = true;
                        } else {
                            $vendor = $this->VendorTemps->newEmptyEntity();
                            $vendor->status = 5;
                            $vendorExists = false;
                        }
        
                        $vendor->sap_vendor_code = $row->LIFNR;
                        $vendor->company_code_id = $companyCode->id;
                        $vendor->purchasing_organization_id = $puOrg->id;
                        $vendor->account_group_id = $accGrp->id;
                        $vendor->reconciliation_account_id = $reconAccount->id;
                        $vendor->payment_term_id = $payTerm->id;
                        if($schemaGroup) {
                            $vendor->schema_group_id = $schemaGroup->id;
                        }
                        if($region) {
                            $vendor->state_id = $region->id;
                        }
                        if($country) {
                            $vendor->country_id = $country->id;
                        }
                        $vendor->title = $row->TITLE_MEDI;
                        $vendor->name = $row->NAME1;
                        $vendor->address = $row->NAME2;
                        $vendor->address_2 = $row->NAME3;
                        $vendor->city = $row->CITY1;
                        $vendor->pincode = $row->POST_CODE1;
                        $vendor->email = $row->SMTP_ADDR;
                        $vendor->mobile = $row->MOB_NUMBER;
                        $vendor->gst_no = $row->GSIN;
                        $vendor->pan_no = $row->PAN;
                        $vendor->buyer_id = 8;
        
                        if($this->VendorTemps->save($vendor)) {
                            $response['message'][] = 'Vendor '.$row->LIFNR.' saved successfully!';
                            if(!$vendorExists) {
                                $this->loadModel("Users");
                                $user = $this->Users->newEmptyEntity();
                                
                                $data = array();
                                $data['first_name'] = $vendor->name;
                                $data['last_name'] = $vendor->name;
                                $data['username'] = $vendor->email;
                                $data['mobile'] = $vendor->mobile;
                                $data['password'] = $vendor->mobile;
                                $data['group_id'] = 3;
        
                                $user = $this->Users->patchEntity($user, $data);
        
                                if ($this->Users->save($user)) {
                                    $response['message'][] = 'Vendor '.$row->LIFNR.' save fail';
                                    $this->Ftp->removeFile($ftpConn, $fileKey);
                                }
                            } else {
                                $this->Ftp->removeFile($ftpConn, $fileKey);
                            }
                        } else {
                            $response['message'][] = 'Vendor '.$row->LIFNR.' save fail';
                        }
                    }
                }
            }
        }
    }


    function getCreatedVendor() {
        $ftpConn = $this->Ftp->connection();
        $list = $this->Ftp->getList($ftpConn);
        foreach($list as $fileKey => $val) {
            if(str_starts_with($fileKey, 'VENDOR_CR_')) {
                $data  = $this->Ftp->downloadFile($ftpConn, $fileKey);
                if($data) {
                    $this->loadModel("VendorTemps");
        
                    $data = trim(preg_replace('/\s+/', ' ', $data));
                    $d = json_decode($data);
        
                    foreach($d->VENDOR_LIST as $key => $row) {
                        $companyCode = $this->VendorTemps->CompanyCodes->findByCode($row->BUKRS)->first();
                        $puOrg = $this->VendorTemps->PurchasingOrganizations->findByCode($row->EKORG)->first();
                        $accGrp = $this->VendorTemps->AccountGroups->findByCode($row->KTOKK)->first();
                        $reconAccount = $this->VendorTemps->ReconciliationAccounts->findByCode($row->AKONT)->first();
                        $companyCode = $this->VendorTemps->CompanyCodes->findByCode($row->BUKRS)->first();
                        $schemaGroup = $this->VendorTemps->SchemaGroups->findByCode($row->KALSK)->first();
                        $region = $this->VendorTemps->States->findByRegionCode($row->REGION)->first();
                        $country = $this->VendorTemps->Countries->findByCountryCode($row->COUNTRY)->first();
                        $payTerm = $this->VendorTemps->PaymentTerms->findByCode($row->ZTERM)->first();
                        
                        if($row->SUCCESS == "0") { continue; }
                        
                        $vendor = $this->VendorTemps->get($row->VENDOR_PORTAL_ID);
                        $vendor->status = 5;
                        $vendor->sap_vendor_code = $row->LIFNR;
                        $vendor->company_code_id = $companyCode->id;
                        $vendor->purchasing_organization_id = $puOrg->id;
                        $vendor->account_group_id = $accGrp->id;
                        $vendor->reconciliation_account_id = $reconAccount->id;
                        $vendor->payment_term_id = $payTerm->id;
                        if($schemaGroup) {
                            $vendor->schema_group_id = $schemaGroup->id;
                        }
                        if($region) {
                            $vendor->state_id = $region->id;
                        }
                        if($country) {
                            $vendor->country_id = $country->id;
                        }
                        $vendor->title = $row->TITLE_MEDI;
                        $vendor->name = $row->NAME1;
                        $vendor->address = $row->NAME2;
                        $vendor->address_2 = $row->NAME3;
                        $vendor->city = $row->CITY1;
                        $vendor->pincode = $row->POST_CODE1;
                        $vendor->email = $row->SMTP_ADDR;
                        $vendor->mobile = $row->MOB_NUMBER;
                        $vendor->gst_no = $row->GSIN;
                        $vendor->pan_no = $row->PAN;
                        $vendor->buyer_id = 8;
        
                        if($this->VendorTemps->save($vendor)) {
                            $response['message'][] = 'Vendor '.$row->LIFNR.' saved successfully!';
                            
                            $this->loadModel("Users");
                            $user = $this->Users->newEmptyEntity();
                            
                            $data = array();
                            $data['first_name'] = $vendor->name;
                            $data['last_name'] = $vendor->name;
                            $data['username'] = $vendor->email;
                            $data['mobile'] = $vendor->mobile;
                            $data['password'] = $vendor->mobile;
                            $data['group_id'] = 3;
    
                            $user = $this->Users->patchEntity($user, $data);
    
                            if ($this->Users->save($user)) {
                                $response['message'][] = 'Vendor '.$row->LIFNR.' save fail';
                                $this->Ftp->removeFile($ftpConn, $fileKey);
                            }
                        } else {
                            $response['message'][] = 'Vendor '.$row->LIFNR.' save fail';
                        }
                    }
                }
            }
        }
    }
}

function importVendor($vendorCode)
{
    // $result = false;
    if (!empty($vendorCode) == "") {
        $data['DATA'] = array();
        $data['DATA']['LIFNR'] = $vendorCode;

        $http = new Client();
        $response = $http->post(
            'http://123.108.46.252:8000/sap/bc/sftmob/VENDER_UPD/?sap-client=300',
            json_encode($data),
            ['type' => 'json', 'auth' => ['username' => 'vcsupport1', 'password' => 'aarti@123']]
        );

        if ($response->isOk()) {
            $result = json_decode($response->getStringBody());
            if ($result->RESPONSE->SUCCESS) {
                $result = $resultResponse->DATA;
            }
        }
    }
    return $result;
}