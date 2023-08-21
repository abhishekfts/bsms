<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Rfqs Controller
 *
 * @property \App\Model\Table\RfqsTable $Rfqs
 * @method \App\Model\Entity\Rfq[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RfqsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['VendorTemps', 'PrHeaders', 'PrFooters'],
        ];
        $rfqs = $this->paginate($this->Rfqs);

        $this->set(compact('rfqs'));
    }

    /**
     * View method
     *
     * @param string|null $id Rfq id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rfq = $this->Rfqs->get($id, [
            'contain' => ['VendorTemps', 'PrHeaders', 'PrFooters', 'RfqInquiries'],
        ]);

        $this->set(compact('rfq'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $flash = [];
        $rfq = $this->Rfqs->newEmptyEntity();
        if ($this->request->is('post')) {
            $rfq = $this->Rfqs->patchEntity($rfq, $this->request->getData());
            if ($this->Rfqs->save($rfq)) {
                $flash = ['type'=>'success', 'msg'=>'The rfq has been saved'];
                $this->set('flash', $flash);
                return $this->redirect(['action' => 'index']);
            }
            $flash = ['type'=>'error', 'msg'=>'The rfq could not be saved. Please, try again'];
            $this->set('flash', $flash);
        }
        $vendorTemps = $this->Rfqs->VendorTemps->find('list', ['limit' => 200])->all();
        $prHeaders = $this->Rfqs->PrHeaders->find('list', ['limit' => 200])->all();
        $prFooters = $this->Rfqs->PrFooters->find('list', ['limit' => 200])->all();
        $this->set(compact('rfq', 'vendorTemps', 'prHeaders', 'prFooters'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Rfq id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $flash = [];
        $rfq = $this->Rfqs->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rfq = $this->Rfqs->patchEntity($rfq, $this->request->getData());
            if ($this->Rfqs->save($rfq)) {
                $flash = ['type'=>'success', 'msg'=>'The rfq has been saved'];
                $this->set('flash', $flash);
                return $this->redirect(['action' => 'index']);
            }
            $flash = ['type'=>'error', 'msg'=>'The rfq could not be saved. Please, try again'];
            $this->set('flash', $flash);
        }
        $vendorTemps = $this->Rfqs->VendorTemps->find('list', ['limit' => 200])->all();
        $prHeaders = $this->Rfqs->PrHeaders->find('list', ['limit' => 200])->all();
        $prFooters = $this->Rfqs->PrFooters->find('list', ['limit' => 200])->all();
        $this->set(compact('rfq', 'vendorTemps', 'prHeaders', 'prFooters'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Rfq id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $flash = [];
        $this->request->allowMethod(['post', 'delete']);
        $rfq = $this->Rfqs->get($id);
        if ($this->Rfqs->delete($rfq)) {
            $flash = ['type'=>'success', 'msg'=>'The rfq has been deleted'];
        } else {
            $flash = ['type'=>'error', 'msg'=>'The rfq could not be deleted. Please, try again'];
        }
        $this->set('flash', $flash);

        return $this->redirect(['action' => 'index']);
    }
}
