<?php
declare(strict_types=1);

namespace App\Controller\Vendor;


use App\Model\Table\VendorMaterialTable;

/**
 * Productionline Controller
 *
 * @property \App\Model\Table\ProductionlineTable $Productionline
 * @method \App\Model\Entity\Productionline[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductionLinesController extends VendorAppController
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

       $this->loadModel("ProductionLines");
        $session = $this->getRequest()->getSession();
        
        $productionline = $this->ProductionLines->find('all', [
            'conditions' => ['ProductionLines.sap_vendor_code' => $session->read('vendor_code')]
        ])->contain(['LineMasters', 'Materials'])->toArray();

        $this->set(compact('productionline'));


       //echo '<pre>';  print_r($productionline);exit;


    
        
    }

    /**
     * View method
     *
     * @param string|null $id Productionline id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productionline = $this->Productionline->get($id, [
            'contain' => ['Dailymonitor'],
        ]);

        $this->set(compact('productionline'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $session = $this->getRequest()->getSession();
        $sapVendor = $session->read('vendor_code');
        $this->loadModel('VendorFactories');
        $factory = $this->VendorFactories->find('list',['keyField' => 'id', 'valueField' => 'factory_code']);

        $flash = [];
        $this->loadModel("LineMasters");
        $this->loadModel("Materials");
        $this->loadModel("VendorTemps");
        $this->loadModel('Notifications');
        $this->loadModel('StockUploads');
        
        $productionline = $this->ProductionLines->newEmptyEntity();

        // exit;

        if ($this->request->is('post')) {
            $requestData = $this->request->getData();
            
            $requestData['sap_vendor_code'] = $sapVendor;

            
            $buyer = $this->VendorTemps->find()
            ->select(['buyer_id'])
            ->where(['sap_vendor_code' => $sapVendor])
            ->first();

            $productionline = $this->ProductionLines->patchEntity($productionline, $requestData);
            if ($this->ProductionLines->save($productionline)) {

                if ($this->Notifications->exists(['Notifications.user_id' => $buyer->buyer_id, 'Notifications.notification_type' => 'production_line'])) {
                    $this->Notifications->updateAll(
                        ['message_count' => $this->Notifications->query()->newExpr('message_count + 1')],
                        ['user_id' => $buyer->buyer_id, 'notification_type' => 'production_line']
                    );
                } else {
                    $notification = $this->Notifications->newEmptyEntity();
                    $notification->user_id = $buyer->buyer_id;
                    $notification->notification_type = 'production_line';
                    $notification->message_count = 1;
                    $this->Notifications->save($notification);
                } 

                $flash = ['type'=>'success', 'msg'=>'The productionline has been saved'];
                $this->set('flash', $flash);

                return $this->redirect(['action' => 'index']);
            }
            //echo '<pre>'; print_r($productionline); exit;
            $flash = ['type'=>'success', 'msg'=>'The productionline could not be saved. Please, try again'];
            $this->set('flash', $flash);
        }
        
        $vendor_mateial = [];
        $lineMasterList = [];

        $this->set(compact('productionline','vendor_mateial', 'lineMasterList','factory'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Productionline id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $flash = [];
        $this->loadModel("Materials");
        $productionline = $this->ProductionLines->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productionline = $this->ProductionLines->patchEntity($productionline, $this->request->getData());

            if ($this->ProductionLines->save($productionline)) {
                $flash = ['type'=>'success', 'msg'=>'The productionline has been saved'];
                $this->set('flash', $flash);

                return $this->redirect(['action' => 'index']);
            }
            $flash = ['type'=>'success', 'msg'=>'The productionline could not be saved. Please, try again'];
            $this->set('flash', $flash);
        }

        $session = $this->getRequest()->getSession();
        $vendorId = $session->read('id');

        $vendor_mateial = $this->Materials->find('list', [ 'conditions' => ['sap_vendor_code' => $session->read('vendor_code')],'keyField' => 'id', 'valueField' => 'code'])->all();

        $this->set(compact('productionline','vendor_mateial'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Productionline id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $flash = [];
        $this->request->allowMethod(['post', 'delete']);
        $productionline = $this->Productionline->get($id);
        if ($this->Productionline->delete($productionline)) {
            $flash = ['type'=>'success', 'msg'=>'The productionline has been deleted'];
        } else {
            $flash = ['type'=>'error', 'msg'=>'The productionline could not be deleted. Please, try again'];
        }
        $this->set('flash', $flash);

        return $this->redirect(['action' => 'index']);
    }

    public function checkRecordExists() {
        $this->autoRender = false;
        
        $session = $this->getRequest()->getSession();
        $sapVendor = $session->read('vendor_code');
        
        $response['status'] = 0;
        $response['message'] = 'Empty request';
        
        if ($this->request->is(['patch', 'post', 'put', 'ajax'])) {
            $request = $this->getRequest()->getData();
            if($this->ProductionLines->exists(['sap_vendor_code' => $sapVendor, 'material_id' => $request['material'], 'line_master_id' => $request['line']])) {
                $response['status'] = 0;
                $response['message'] = 'Material already mapped to selected production line';
            } else {
                $response['status'] = 1;
                $response['message'] = 'Valid' ;
            }
        } 
        

        echo json_encode($response);
    }


    public function getLineMaterials($lineMasterId = null) {
        $this->autoRender = false;
        
        $session = $this->getRequest()->getSession();
        $sapVendor = $session->read('vendor_code');
        
        $materialList = $this->ProductionLines->find()
        ->select(['capacity', 'Materials.id', 'Materials.code', 'Materials.description'])
        ->contain(['Materials'])
        ->where(['line_master_id' => $lineMasterId]);

        $materials = [];
        foreach($materialList as $mat) {
            $materials[] = ['id' => $mat->material->id, 'description' => $mat->material->description, 'capacity' => $mat->capacity];
        }

        $response['status'] = 1;
        $response['data']['materials'] = $materials;

        echo json_encode($response);
    }
}
