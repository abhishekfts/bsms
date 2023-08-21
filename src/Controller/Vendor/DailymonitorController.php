<?php

declare(strict_types=1);

namespace App\Controller\Vendor;

class DailymonitorController extends VendorAppController
{
    public function initialize(): void
    {
        parent::initialize();
        $flash = [];  
        $this->set('flash', $flash);
    }
    
    public function index()
    {
        $session = $this->getRequest()->getSession();
        $vendorId = $session->read('id');
        $this->loadModel("Materials");
        $this->loadModel("ProductionLines");

        $dailymonitor = $this->Dailymonitor->find('all', ['conditions' => ['Dailymonitor.sap_vendor_code' => $session->read('vendor_code')]])
        ->contain(['ProductionLines','ProductionLines.LineMasters', 'Materials']);
        $this->set(compact('dailymonitor'));
        
    }

    /**
     * View method
     *
     * @param string|null $id Dailymonitor id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $dailymonitor = $this->Dailymonitor->get($id);
        $this->set(compact('dailymonitor'));
    }

    public function confirmedproduction($id=null, $confirm_production=null)
    {
        $this->loadModel("StockUploads");
        $session = $this->getRequest()->getSession();

        $response = ['status'=>0,'message'=>''];
        $dailymonitor = $this->Dailymonitor->get($id);
        $dailymonitor->confirm_production = $confirm_production;
        $dailymonitor->status= 3;
        
        if ($this->Dailymonitor->save($dailymonitor)) { 
            
            $stockUpload = $this->StockUploads->find()
                ->where([
                    'sap_vendor_code' => $session->read('vendor_code'),
                    'material_id' => $dailymonitor->material_id
                ])
                ->first();

            $stockUpload->current_stock = $stockUpload->current_stock + $confirm_production;
            $this->StockUploads->save($stockUpload);

            $response = ['status' => 1, 'message' => $dailymonitor];
        } else {
            $response = ['status' => 0, 'message' => 'Failed'];
        }
        echo json_encode($response);
        exit;
    }

    public function dailyentry()
    {
        $session = $this->getRequest()->getSession();
        $vendorId = $session->read('id');
        $this->loadModel("Materials");
        $this->loadModel("ProductionLines");

        $dailymonitor = $this->Dailymonitor->find('all', ['conditions' => ['Dailymonitor.sap_vendor_code' => $session->read('vendor_code'), 'Dailymonitor.plan_date <=' => date('y-m-d')]])
            ->contain(['ProductionLines', 'ProductionLines.LineMasters', 'Materials'])
            ->order(['Dailymonitor.plan_date' => 'DESC']);
        $this->set(compact('dailymonitor'));
    }

    public function upload()
    {
        $this->loadModel("Materials");
        $this->loadModel("ProductionLines");
        $this->loadModel("LineMasters");
        $response['status'] = 0;
        $response['message'] = 'upload fail';
        $this->autoRender = false;
        $session = $this->getRequest()->getSession();

        if ($this->request->is(['patch', 'post', 'put', 'ajax'])) {
            try {
                $uploadData = [];
                if (isset($_FILES['upload_file']) && $_FILES['upload_file']['name'] != "" && isset($_FILES['upload_file']['name'])) {
                    $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($_FILES['upload_file']['tmp_name']);
                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                    $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
                    $worksheet = $spreadsheet->getActiveSheet();
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5

                    $tmp = [];
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $tmp['sap_vendor_code']  = $session->read('vendor_code');
                        $status = true;
                        for ($col = 1; $col <= $highestColumnIndex; $col++) {
                            $value = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                            if ($col == 1) {
                                $lm = $this->LineMasters->find()
                                    ->where([
                                        'sap_vendor_code' => $session->read('vendor_code'),
                                        'name' => $value
                                    ])->first();
                                if ($lm) {
                                    $pl = $this->ProductionLines->find()
                                        ->where([
                                            'sap_vendor_code' => $session->read('vendor_code'),
                                            'line_master_id' => $lm->id
                                        ])->first();
                                    if ($pl) {
                                        $tmp['production_line_id'] = $pl->id;
                                    } else {
                                        break;
                                    }
                                }
                            } else if ($col == 2) {
                                $mat = $this->Materials->find()
                                    ->where([
                                        'sap_vendor_code' => $session->read('vendor_code'),
                                        'description' => $value
                                    ])->first();
                                if ($mat) {
                                    $tmp['material_id'] = $mat->id;
                                } else {
                                    break;
                                }
                            } else if ($col == 3) {
                                if ($value < 1 || $value == "" || $value == null) {
                                    break;
                                } else {
                                    $tmp['target_production'] = $value;
                                }
                            } else {
                                $mat = $this->Dailymonitor->find()
                                    ->where([
                                        'sap_vendor_code' => $session->read('vendor_code'),
                                        'production_line_id' => $tmp['production_line_id'],
                                        'material_id' => $tmp['material_id'],
                                        'target_production' => $tmp['target_production'],
                                        'plan_date' => date('y-m-d')
                                    ])->first();
                                $mat->confirm_production = $value;
                                $mat->status = 3;
                                if ($this->Dailymonitor->save($mat)) {
                                    $response['status'] = 1;
                                    $response['message'] = 'uploaded Successfully';
                                } else {
                                    $status = false;
                                    $response['status'] = 0;
                                    $response['message'] = 'file not uploaded';
                                    break;
                                }
                            }
                        }
                    }
                } else {
                    $response['status'] = 0;
                    $response['message'] = 'file not uploaded';
                }
            } catch (\Exception $e) {
                $response['status'] = 0;
                $response['message'] = $e->getMessage();
            }
        }

        echo json_encode($response);
    }

    public function add()
    {
        $flash = [];
        $this->loadModel("Materials");
        $this->loadModel("LineMasters");
        $this->loadModel("Dailymonitor");
        $this->loadModel('VendorFactories');
        $factory = $this->VendorFactories->find('list',['keyField' => 'id', 'valueField' => 'factory_code']);


        $dailymonitor = $this->Dailymonitor->newEmptyEntity();
        $session = $this->getRequest()->getSession();
        $vendorId = $session->read('id');
        if ($this->request->is('post')) {
            try {
                $requestData = $this->request->getData();
                $requestData['sap_vendor_code'] = $session->read('vendor_code');
                $requestData['status'] = 1;
                
                $dailymonitor = $this->Dailymonitor->patchEntity($dailymonitor, $requestData);
                //echo '<pre>';  print_r($dailymonitor);exit;

                if ($this->Dailymonitor->save($dailymonitor)) {
                  
                    $flash = ['type' => 'success', 'msg' => 'The dailymonitor has been saved'];
                    $this->set('flash', $flash);
                    return $this->redirect(['action' => 'index']);
                }
                $flash = ['type' => 'error', 'msg' => 'The dailymonitor could not be saved. Please, try again'];
                $this->set('flash', $flash);
            
            } catch (\Exception $e) {

            }catch (\Exception $e) {
                $flash['msg'] = 0;
                $flash['type'] = $e->getMessage();
            }
        }

        

        $this->set(compact('dailymonitor', 'factory'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Dailymonitor id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $session = $this->getRequest()->getSession();
        $flash = [];
        $this->loadModel("Materials");
        $this->loadModel("LineMasters");
        $dailymonitor = $this->Dailymonitor->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $dailymonitor = $this->Dailymonitor->patchEntity($dailymonitor, $this->request->getData());
            if ($this->Dailymonitor->save($dailymonitor)) {
                $flash = ['type' => 'success', 'msg' => 'The dailymonitor has been saved'];
                $this->set('flash', $flash);
                return $this->redirect(['action' => 'index']);
            }
            $flash = ['type' => 'success', 'msg' => 'The dailymonitor could not be saved. Please, try again'];
            $this->set('flash', $flash);
        }
        $vendor_mateial = $this->Materials->find('list', ['conditions' => ['Materials.sap_vendor_code' => $session->read('vendor_code')], 'keyField' => 'id', 'valueField' => 'description'])->all();
        $productionline = $this->LineMasters->find('list', ['conditions' => ['sap_vendor_code' => $session->read('vendor_code')], 'keyField' => 'id', 'valueField' => 'name'])->all();
        $this->set(compact('dailymonitor', 'vendor_mateial', 'productionline'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Dailymonitor id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $flash = [];
        $this->request->allowMethod(['post', 'delete']);
        $dailymonitor = $this->Dailymonitor->get($id);
        if ($this->Dailymonitor->delete($dailymonitor)) {
            $flash = ['type' => 'success', 'msg' => 'The dailymonitor has been deleted'];
        } else {
            $flash = ['type' => 'error', 'msg' => 'The dailymonitor could not be deleted. Please, try again'];
        }

        $this->set('flash', $flash);
        return $this->redirect(['action' => 'index']);
    }

    public function changeStatus($action = null, $id = null)
    {
        $this->autoRender = false;
        $this->loadModel("Dailymonitor");

        $status = 1;
        if ($action && $action == 'cancel') {
            $status = 2;
        }

        $response = ['status' => 0, 'message' => ''];
        $dailymonitor = $this->Dailymonitor->get($id);
        $dailymonitor = $this->Dailymonitor->patchEntity($dailymonitor, ['status' => $status]);
        if ($this->Dailymonitor->save($dailymonitor)) {
            $response = ['status' => 1, 'message' => 'plant Successgully cancelled'];
        } else {
            $response = ['status' => 0, 'message' => 'Something went wrong'];
        }

        echo json_encode($response);
    }
}
