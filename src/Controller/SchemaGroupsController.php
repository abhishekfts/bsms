<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SchemaGroups Controller
 *
 * @property \App\Model\Table\SchemaGroupsTable $SchemaGroups
 * @method \App\Model\Entity\SchemaGroup[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SchemaGroupsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $schemaGroups = $this->paginate($this->SchemaGroups);

        $this->set(compact('schemaGroups'));
    }

    /**
     * View method
     *
     * @param string|null $id Schema Group id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $schemaGroup = $this->SchemaGroups->get($id, [
            'contain' => ['VendorTemps'],
        ]);

        $this->set(compact('schemaGroup'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $flash = [];
        $schemaGroup = $this->SchemaGroups->newEmptyEntity();
        if ($this->request->is('post')) {
            $schemaGroup = $this->SchemaGroups->patchEntity($schemaGroup, $this->request->getData());
            if ($this->SchemaGroups->save($schemaGroup)) {
                $flash = ['type'=>'success', 'msg'=>'The schema group has been saved'];
                $this->set('flash', $flash);
                return $this->redirect(['action' => 'index']);
            }
            $flash = ['type'=>'error', 'msg'=>'The schema group could not be saved. Please, try again'];
            $this->set('flash', $flash);
        }
        $this->set(compact('schemaGroup'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Schema Group id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $flash = [];
        $schemaGroup = $this->SchemaGroups->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $schemaGroup = $this->SchemaGroups->patchEntity($schemaGroup, $this->request->getData());
            if ($this->SchemaGroups->save($schemaGroup)) {
                $flash = ['type'=>'success', 'msg'=>'The schema group has been saved'];
                $this->set('flash', $flash);
                return $this->redirect(['action' => 'index']);
            }
            $flash = ['type'=>'error', 'msg'=>'The schema group could not be saved. Please, try again'];
            $this->set('flash', $flash);
        }
        $this->set(compact('schemaGroup'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Schema Group id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $flash = [];
        $this->request->allowMethod(['post', 'delete']);
        $schemaGroup = $this->SchemaGroups->get($id);
        if ($this->SchemaGroups->delete($schemaGroup)) {
            $flash = ['type'=>'success', 'msg'=>'The schema group has been deleted'];
        } else {
            $flash = ['type'=>'error', 'msg'=>'The schema group could not be deleted. Please, try again'];
        }
        $this->set('flash', $flash);
        return $this->redirect(['action' => 'index']);
    }
}
