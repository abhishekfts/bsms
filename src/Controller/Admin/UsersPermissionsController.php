<?php
declare(strict_types=1);

namespace App\Controller\Admin;

/**
 * UsersPermissions Controller
 *
 * @property \App\Model\Table\UsersPermissionsTable $UsersPermissions
 * @method \App\Model\Entity\UsersPermission[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersPermissionsController extends AdminAppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $usersPermissions = $this->paginate($this->UsersPermissions);

        $this->set(compact('usersPermissions'));
    }

    /**
     * View method
     *
     * @param string|null $id Users Permission id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $usersPermission = $this->UsersPermissions->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('usersPermission'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $usersPermission = $this->UsersPermissions->newEmptyEntity();
        if ($this->request->is('post')) {
            $usersPermission = $this->UsersPermissions->patchEntity($usersPermission, $this->request->getData());
            if ($this->UsersPermissions->save($usersPermission)) {
                $this->Flash->success(__('The users permission has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The users permission could not be saved. Please, try again.'));
        }
        $this->set(compact('usersPermission'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Users Permission id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $usersPermission = $this->UsersPermissions->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $usersPermission = $this->UsersPermissions->patchEntity($usersPermission, $this->request->getData());
            if ($this->UsersPermissions->save($usersPermission)) {
                $this->Flash->success(__('The users permission has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The users permission could not be saved. Please, try again.'));
        }
        $this->set(compact('usersPermission'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Users Permission id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $usersPermission = $this->UsersPermissions->get($id);
        if ($this->UsersPermissions->delete($usersPermission)) {
            $this->Flash->success(__('The users permission has been deleted.'));
        } else {
            $this->Flash->error(__('The users permission could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
