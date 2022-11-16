<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Datasource\ConnectionManager;

/**
 * Home Controller
 *
 * @method \App\Model\Entity\Home[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HomeController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */

    var $uses = false;
    public function index()
    {
        $session = $this->getRequest()->getSession();
        if($session->check('user.id')) {
            return $this->redirect(array('controller' => 'dealer', 'action' => 'dashboard'));
        }
    }

    public function search()
    {
        $request = $this->request->getData();  
        if ($this->request->is('post')) { 
            $conn = ConnectionManager::get('default');
            $searchData = $conn->execute("select U.*, P.name product_name
            from buyer_seller_users U
            INNER join products P on (P.id in (U.product_deals))
            where U.user_type = 'seller'
            and P.name like '%$request[q]%'"
            );
            
            $total = count($searchData);
            $this->set('total', $total);
            $this->set('type', $request['type']);

        } else {
            return $this->redirect(['action' => 'index']);
        }
    }
}
