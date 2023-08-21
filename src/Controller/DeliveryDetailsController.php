<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * DeliveryDetails Controller
 *
 * @property \App\Model\Table\DeliveryDetailsTable $DeliveryDetails
 * @method \App\Model\Entity\DeliveryDetail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DeliveryDetailsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['PoHeaders', 'PoFooters'],
        ];
        $deliveryDetails = $this->paginate($this->DeliveryDetails);

        $this->set(compact('deliveryDetails'));
    }

    /**
     * View method
     *
     * @param string|null $id Delivery Detail id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $deliveryDetail = $this->DeliveryDetails->get($id, [
            'contain' => ['PoHeaders', 'PoFooters'],
        ]);

        $this->set(compact('deliveryDetail'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $flash = [];
        $deliveryDetail = $this->DeliveryDetails->newEmptyEntity();
        if ($this->request->is('post')) {
            $deliveryDetail = $this->DeliveryDetails->patchEntity($deliveryDetail, $this->request->getData());
            if ($this->DeliveryDetails->save($deliveryDetail)) {
                $flash = ['type'=>'success', 'msg'=>'The delivery detail has been saved'];
                $this->set('flash', $flash);
                return $this->redirect(['action' => 'index']);
            }
            $flash = ['type'=>'error', 'msg'=>'The delivery detail could not be saved. Please, try again'];
            $this->set('flash', $flash);
        }
        $poHeaders = $this->DeliveryDetails->PoHeaders->find('list', ['limit' => 200])->all();
        $poFooters = $this->DeliveryDetails->PoFooters->find('list', ['limit' => 200])->all();
        $this->set(compact('deliveryDetail', 'poHeaders', 'poFooters'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Delivery Detail id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $flash = [];
        $deliveryDetail = $this->DeliveryDetails->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $deliveryDetail = $this->DeliveryDetails->patchEntity($deliveryDetail, $this->request->getData());
            if ($this->DeliveryDetails->save($deliveryDetail)) {
                $flash = ['type'=>'success', 'msg'=>'The delivery detail has been saved'];
                $this->set('flash', $flash);
                return $this->redirect(['action' => 'index']);
            }
            $flash = ['type'=>'error', 'msg'=>'The delivery detail could not be saved. Please, try again'];
            $this->set('flash', $flash);
        }
        $poHeaders = $this->DeliveryDetails->PoHeaders->find('list', ['limit' => 200])->all();
        $poFooters = $this->DeliveryDetails->PoFooters->find('list', ['limit' => 200])->all();
        $this->set(compact('deliveryDetail', 'poHeaders', 'poFooters'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Delivery Detail id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $flash = [];
        $this->request->allowMethod(['post', 'delete']);
        $deliveryDetail = $this->DeliveryDetails->get($id);
        if ($this->DeliveryDetails->delete($deliveryDetail)) {
            $flash = ['type'=>'success', 'msg'=>'The delivery detail has been deleted'];
            $this->set('flash', $flash);
        } else {
            $flash = ['type'=>'error', 'msg'=>'The delivery detail could not be deleted. Please, try again'];
            $this->set('flash', $flash);
        }

        return $this->redirect(['action' => 'index']);
    }
}
