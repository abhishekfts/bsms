<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CompanyCodes Controller
 *
 * @property \App\Model\Table\CompanyCodesTable $CompanyCodes
 * @method \App\Model\Entity\CompanyCode[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CompanyCodesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $companyCodes = $this->paginate($this->CompanyCodes);

        $this->set(compact('companyCodes'));
    }

    /**
     * View method
     *
     * @param string|null $id Company Code id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $companyCode = $this->CompanyCodes->get($id, [
            'contain' => ['AccountGroups', 'PaymentTerms', 'PurchasingOrganizations', 'ReconciliationAccounts', 'SchemaGroups'],
        ]);

        $this->set(compact('companyCode'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $companyCode = $this->CompanyCodes->newEmptyEntity();
        if ($this->request->is('post')) {
            $companyCode = $this->CompanyCodes->patchEntity($companyCode, $this->request->getData());
            if ($this->CompanyCodes->save($companyCode)) {
                $this->Flash->success(__('The company code has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The company code could not be saved. Please, try again.'));
        }
        $this->set(compact('companyCode'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Company Code id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $companyCode = $this->CompanyCodes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $companyCode = $this->CompanyCodes->patchEntity($companyCode, $this->request->getData());
            if ($this->CompanyCodes->save($companyCode)) {
                $this->Flash->success(__('The company code has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The company code could not be saved. Please, try again.'));
        }
        $this->set(compact('companyCode'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Company Code id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $companyCode = $this->CompanyCodes->get($id);
        if ($this->CompanyCodes->delete($companyCode)) {
            $this->Flash->success(__('The company code has been deleted.'));
        } else {
            $this->Flash->error(__('The company code could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
