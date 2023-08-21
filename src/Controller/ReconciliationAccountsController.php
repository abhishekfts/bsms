<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ReconciliationAccounts Controller
 *
 * @property \App\Model\Table\ReconciliationAccountsTable $ReconciliationAccounts
 * @method \App\Model\Entity\ReconciliationAccount[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReconciliationAccountsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['CompanyCodes'],
        ];
        $reconciliationAccounts = $this->paginate($this->ReconciliationAccounts);

        $this->set(compact('reconciliationAccounts'));
    }

    /**
     * View method
     *
     * @param string|null $id Reconciliation Account id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $reconciliationAccount = $this->ReconciliationAccounts->get($id, [
            'contain' => ['CompanyCodes'],
        ]);

        $this->set(compact('reconciliationAccount'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $reconciliationAccount = $this->ReconciliationAccounts->newEmptyEntity();
        if ($this->request->is('post')) {
            $reconciliationAccount = $this->ReconciliationAccounts->patchEntity($reconciliationAccount, $this->request->getData());
            if ($this->ReconciliationAccounts->save($reconciliationAccount)) {
                $this->Flash->success(__('The reconciliation account has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reconciliation account could not be saved. Please, try again.'));
        }
        $companyCodes = $this->ReconciliationAccounts->CompanyCodes->find('list', ['limit' => 200])->all();
        $this->set(compact('reconciliationAccount', 'companyCodes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Reconciliation Account id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $reconciliationAccount = $this->ReconciliationAccounts->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reconciliationAccount = $this->ReconciliationAccounts->patchEntity($reconciliationAccount, $this->request->getData());
            if ($this->ReconciliationAccounts->save($reconciliationAccount)) {
                $this->Flash->success(__('The reconciliation account has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reconciliation account could not be saved. Please, try again.'));
        }
        $companyCodes = $this->ReconciliationAccounts->CompanyCodes->find('list', ['limit' => 200])->all();
        $this->set(compact('reconciliationAccount', 'companyCodes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Reconciliation Account id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $reconciliationAccount = $this->ReconciliationAccounts->get($id);
        if ($this->ReconciliationAccounts->delete($reconciliationAccount)) {
            $this->Flash->success(__('The reconciliation account has been deleted.'));
        } else {
            $this->Flash->error(__('The reconciliation account could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
