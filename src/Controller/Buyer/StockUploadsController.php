<?php

declare(strict_types=1);

namespace App\Controller\Buyer;

use App\Model\Table\VendorMaterialTable;


/**
 * Stockupload Controller
 *
 * @property \App\Model\Table\StockuploadTable $Stockupload
 * @method \App\Model\Entity\Stockupload[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StockUploadsController extends BuyerAppController
{
    public function initialize(): void
    {
        parent::initialize();
        $flash = [];  
        $this->set('flash', $flash);
    }
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->loadModel("StockUploads");
        $session = $this->getRequest()->getSession();
        $vendorId = $session->read('id');
        $sapVendor = $session->read('vendor_code');
        print_r($sapVendor);
        $stockupload = $this->StockUploads->find('all', [
            'conditions' => ['StockUploads.sap_vendor_code' => $session->read('vendor_code')]
        ])->select([
            'id', 'opening_stock', 'material_id', 'sap_vendor_code', 'added_date', 'updated_date',
            'vm_description' => 'vm.description', 'vm_vendor_code' => 'vm.code', 'vm.uom',
        ])->join([
            'table' => 'materials',
            'alias' => 'vm',
            'type' => 'LEFT',
            'conditions' => 'vm.id = StockUploads.material_id',
        ])->toArray();
        // echo '<pre>';print_r($stockupload);exit;


        $this->set(compact('stockupload'));
    }

    /**
     * View method
     *
     * @param string|null $id Stockupload id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $stockupload = $this->StockUploads->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('stockupload'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $this->loadModel('Uoms');

        $flash = [];
        $this->loadModel("Materials");
        $this->loadModel("StockUploads");
        $stockupload = $this->StockUploads->newEmptyEntity();

        $stockUpload = [];
        $stockView = [];
        $flash = [];
        $session = $this->getRequest()->getSession();
        $vendorId = $session->read('id');
        $sapVendor = $session->read('vendor_code');

        if ($this->request->is('post')) {

            $importFile = $this->request->getData('vendor_code');
            if (isset($_FILES['vendor_code']) && $_FILES['vendor_code']['name'] != "" && $importFile !== null && isset($_FILES['vendor_code']['name'])) {
                $destination = "uploads/";
                $filename = $_FILES['vendor_code']['name'];
                $path = $destination . $filename;
                move_uploaded_file($_FILES['vendor_code']['tmp_name'], $path);
                $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($path);
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                $spreadsheet = $reader->load($path);
                $worksheet = $spreadsheet->getActiveSheet();

                foreach ($worksheet->getRowIterator(2) as $row) {
                    $minivendor = [];
                    foreach ($row->getCellIterator() as $cell) {
                        $cellval = $cell->getValue();
                        if (!empty($cellval)) {
                            $minivendor[] = $cellval;
                        }
                    }

                    array_push($stockUpload, $minivendor);
                }
            }



            if (empty($minivendor)) {
                $minivendor = [];
                $res = $this->request->getData();
                //  print_r($res);exit;

                if ($res["code"] && $res["description"] && $res["opening_stock"] && $res["uom"]) {

                    $VendorMaterials = $this->paginate($this->Materials->find('all', [
                        'conditions' => ['Materials.id' => $res['code']]
                    ]))->first();
                    array_push($minivendor, $VendorMaterials->code);
                    array_push($minivendor, $res["opening_stock"]);
                    array_push($stockUpload, $minivendor);
                }
            }


            foreach ($stockUpload as $stockuploads) {
                if (!empty($stockuploads)) {
                    $materialCode = $stockuploads[0];
                    $VendorMaterials = $this->paginate($this->Materials->find('all', [
                        'conditions' => ['Materials.code' => $materialCode]
                    ]))->first();

                    $stockData = array();
                    $stockData['sap_vendor_code'] = $sapVendor;
                    $stockData['material_id'] = $VendorMaterials->id;
                    $stockData['opening_stock'] = $stockuploads[1];
                    $stockData['desc'] =  $VendorMaterials->description;
                    $stockData['material_code'] =  $VendorMaterials->code;
                    $stockData['uoms'] =  $VendorMaterials->uom;



                    $existingStockUpload = $this->StockUploads->find('all', [
                        'conditions' => [
                            'StockUploads.material_id' => $VendorMaterials->id,
                        ]
                    ])->first();

                 if (!$existingStockUpload) {
                    $stockupload = $this->StockUploads->newEmptyEntity();
                    $stockupload = $this->StockUploads->patchEntity($stockupload, $stockData);
                    if ($this->StockUploads->save($stockupload)) {
                        $flash = ['type' => 'success', 'msg' => 'The stock Upload has been saved'];
                        $this->set('flash', $flash);
                        array_push($stockView, ['status' => true, 'msg' => "The vendor material has been saved.", 'data' => $stockData]);
                    } else {
                        array_push($stockView, ['status' => false, 'msg' => "The vendor material could not be saved. Please, try again.", 'data' => $stockData]);
                    }
                    } 
                    else {
                        array_push($stockView, ['status' => false, 'msg' => "Vendor material code already exits in stock upload", 'data' => $stockData]);
                    }
                }
            }

            $this->set('stockuploadData', $stockView);
        }

        $vendor_mateial = $this->Materials->find('list', ['keyField' => 'id', 'valueField' => 'code'])->all();
        $this->set(compact('stockupload', 'vendor_mateial'));
    }


    public function material($id = null)
    {
        $response = array();
        $response['status'] = 0;
        $response['message'] = '';
        $this->autoRender = false;

        if ($this->request->is(['patch', 'get', 'put'])) {
            $this->loadModel("Materials");
            $vendorMaterial = $this->Materials->find('all')
                ->select([
                    'id', 'sap_vendor_code', 'code', 'description', 'minimum_stock',
                    'uom'
                ])
                ->where(['Materials.id' => $id])
                ->first();

            $response['status'] = 1;
            $response['message'] = 'success';
            $response['data'] = $vendorMaterial;
        } else {
            $response['message'] = 'error';
        }

        echo json_encode($response);
    }



    /**
     * Edit method
     *
     * @param string|null $id Stockupload id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $flash = [];
        $this->loadModel("Materials");
        $stockupload = $this->StockUploads->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $stockupload = $this->StockUploads->patchEntity($stockupload, $this->request->getData());
            if ($this->StockUploads->save($stockupload)) {
                $flash = ['type' => 'success', 'msg' => 'The stockupload has been saved'];
                $this->set('flash', $flash);

                return $this->redirect(['action' => 'index']);
            }
            $flash = ['type' => 'success', 'msg' => 'The stockupload could not be saved. Please, try again'];
            $this->set('flash', $flash);
        }
        $session = $this->getRequest()->getSession();
        $sapVendor = $session->read('vendor_code');
      //  print_r($sapVendor);

        $vendor_mateial = $this->Materials->find('list', ['conditions' => ['sap_vendor_code' => $sapVendor],'keyField' => 'id', 'valueField' => 'code'])->all();
    
        $this->set(compact('stockupload', 'vendor_mateial'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Stockupload id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $flash = [];
        $this->request->allowMethod(['post', 'delete']);
        $stockupload = $this->Stockupload->get($id);
        if ($this->Stockupload->delete($stockupload)) {
            $flash = ['type' => 'success', 'msg' => 'The stockupload has been deleted'];
        } else {
            $flash = ['type' => 'success', 'msg' => 'The stockupload could not be deleted. Please, try again'];
        }
        $this->set('flash', $flash);

        return $this->redirect(['action' => 'index']);
    }

    public function upload()
    {
        $response['status'] = 0;
        $response['message'] = 'upload fail';
        $this->autoRender = false;
       
        if ($this->request->is(['patch', 'post', 'put', 'ajax'])) {
            try {
            

                $uploadData = [];
                $stockData =[];
                if (isset($_FILES['upload_file']) && $_FILES['upload_file']['name'] != "" && isset($_FILES['upload_file']['name'])) {

                    $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($_FILES['upload_file']['tmp_name']);
                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                    $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
                    $worksheet = $spreadsheet->getActiveSheet();
                    $highestRow = $worksheet->getHighestRow(); 
                    $highestColumn = $worksheet->getHighestColumn();
                    $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5
                    $this->loadModel("Materials");
                    $this->loadModel("VendorFactories");

                    $tmp = [];
                    $datas = [];
                    

                    // echo "<pre>";
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $facError = false;
                        $matError = false;
                        for ($col = 1; $col <= $highestColumnIndex; ++$col) {
                            
                            $value = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                            if($col == 1) {
                                $tmp['sap_vendor_code'] =$value;
                                $datas['sap_vendor_code'] = $value;
                            }
                            else if($col == 2) {
                                $factory = $this->VendorFactories->find('list')
                                ->select(['id'])
                                ->where(['factory_code' => $value])
                                ->first();

                                //echo '<pre>';  print_r($factory); exit;
                                $tmp['factory_id'] = $factory ? $factory : null;
                                $datas['factory_code'] = $value;
                                if(!$factory) {
                                    $facError = true;
                                }
                            } else if($col == 3) {
                                $datas['po_no'] = $value;
                            }
                            else if($col == 4) {
                                $datas['line_item'] = $value;
                            }
                             else if ($col == 5) {
                                $materials = $this->Materials->find('all')
                                ->select(['id', 'code'])
                                ->where(['code IN' => $value])->first();
    
                               $tmp['material_id'] = $materials['id'] ? $materials['id'] : null;
                               $datas['material'] = $value;
                               if(!$materials['id']) {
                                $matError = true;
                                $datas['error'] = 'Invalid material';
                            }
                            }
                            else if($col == 6) {
                            
                                $datas['description'] = $value;
                            }
                            else if($col == 7) {
                                $tmp['opening_stock'] = $value;
                                $datas['opening_stock'] = $value;
                                $tmp['current_stock'] = $value;
                            }
                            else if($col == 8) {
                                $datas['uom'] = $value;
                            }
                            
                        }

                        $datas['error'] = '';
                        if($facError) {
                            $datas['error'] = 'Invalid factory code';
                        } else if($matError) {
                            $datas['error'] = 'Invalid Material';
                        }

                        $stockData[] = $datas;
                        $tmp['asn_stock'] = 0;
                        if(!isset($datas['error'])) {
                            $uploadData[] = $tmp;   
                        }
                    }

      
                    if(!empty($uploadData)) {
                        $columns = array_keys($uploadData[0]);
                        $upsertQuery = $this->StockUploads->query();
                        $upsertQuery->insert($columns);
                        foreach ($uploadData as $data) {
                            $upsertQuery->values($data);
                        }
                        $upsertQuery->epilog('ON DUPLICATE KEY UPDATE `material_id`=VALUES(`material_id`),`opening_stock`=VALUES(`opening_stock`)')
                            ->execute();
                    }


                        $response['status'] = 1;
                        $response['data'] = $stockData;
                        $response['message'] = 'uploaded Successfully';
                } else {
                    $response['status'] = 0;
                    $response['message'] = 'file not uploaded';
                }

                
            } catch (\PDOException $e) {
                $response['status'] = 0;
                $response['message'] = $e->getMessage();
            } catch (\Exception $e) {
                $response['status'] = 0;
                $response['message'] = $e->getMessage();
            }
        }

        echo json_encode($response); exit;
    }

}
