<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class EmployeesController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for employees
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Employees', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $parameters['conditions'] = (!empty($parameters['conditions'])?'[id] != :id1: AND '.$parameters['conditions']:'[id] != :id1:');
        $parameters['bind'] = (!empty($parameters['bind'])?['id1' => 1]+$parameters['bind']:['id1' => 1]);

        $employees = Employees::find($parameters);
        if (count($employees) == 0) {
            $this->flash->notice("The search did not find any employees");

            $this->dispatcher->forward(array(
                "controller" => "employees",
                "action" => "index"
            ));

            return;
        }

        $paginator = new Paginator(array(
            'data' => $employees,
            'limit'=> 10,
            'page' => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
    }

    /**
     * Edits a employee
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $employee = Employees::findFirstByid($id);

            if (!$employee) {
                $this->flash->error("employee was not found");

                $this->dispatcher->forward(array(
                    'controller' => "employees",
                    'action' => 'index'
                ));

                return;
            }

            $this->view->id = $employee->id;

            $this->tag->setDefault("id", $employee->id);
            $this->tag->setDefault("name", $employee->name);
            $this->tag->setDefault("middle_name", $employee->middle_name);
            $this->tag->setDefault("last_name", $employee->last_name);
            $this->tag->setDefault("post", $employee->post);
            $this->tag->setDefault("email", $employee->email);
            $this->tag->setDefault("phone", $employee->phone);
            $this->tag->setDefault("home_phone", $employee->home_phone);
            $this->tag->setDefault("description", $employee->description);
            $this->tag->setDefault("root", $employee->root);
            $this->tag->setDefault("lft", $employee->lft);
            $this->tag->setDefault("rgt", $employee->rgt);
            $this->tag->setDefault("level", $employee->level);
            
        }
    }

    /**
     * Creates a new employee
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "employees",
                'action' => 'index'
            ));

            return;
        }

        $employee = new Employees();
        $employee->name = $this->request->getPost("name");
        $employee->middle_name = $this->request->getPost("middle_name");
        $employee->last_name = $this->request->getPost("last_name");
        $employee->post = $this->request->getPost("post");
        $employee->email = $this->request->getPost("email", "email");
        $employee->phone = $this->request->getPost("phone");
        $employee->home_phone = $this->request->getPost("home_phone");
        $employee->description = $this->request->getPost("description");
        $employee->root = $this->request->getPost("root");
        
        if(empty($employee->root)){
            $employee->root = 1;
        }

        $root = Employees::findFirst($employee->root);

        if (!$employee->appendTo($root)) {
            foreach ($employee->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "employees",
                'action' => 'new'
            ));

            return;
        }

        $this->flash->success("employee was created successfully");

        $this->dispatcher->forward(array(
            'controller' => "employees",
            'action' => 'index'
        ));

        $this->view->root = ((is_object($employee->getRelated('root_name')) and $employee->root != 1 )?$employee->getRelated('root_name')->name:'');
    }

    /**
     * Saves a employee edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "employees",
                'action' => 'index'
            ));

            return;
        }

        $id = $this->request->getPost("id");
        $employee = Employees::findFirstByid($id);

        if (!$employee) {
            $this->flash->error("employee does not exist " . $id);

            $this->dispatcher->forward(array(
                'controller' => "employees",
                'action' => 'index'
            ));

            return;
        }
        $employee_root = $employee->root;
        $employee->name = $this->request->getPost("name");
        $employee->middle_name = $this->request->getPost("middle_name");
        $employee->last_name = $this->request->getPost("last_name");
        $employee->post = $this->request->getPost("post");
        $employee->email = $this->request->getPost("email", "email");
        $employee->phone = $this->request->getPost("phone");
        $employee->home_phone = $this->request->getPost("home_phone");
        $employee->description = $this->request->getPost("description");
        $employee->root = $this->request->getPost("root");

        if (!$employee->saveNode()) {

            foreach ($employee->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "employees",
                'action' => 'edit',
                'params' => array($employee->id)
            ));

            return;
        }
        $employee = Employees::findFirstByid($id);
        if($employee_root!=$this->request->getPost("root")){
            $root = Employees::findFirst($employee->root);
            $employee->moveAsLast($root);
        }

        

        $this->flash->success("employee was updated successfully");

        $this->dispatcher->forward(array(
            'controller' => "employees",
            'action' => 'index'
        ));

        $this->view->root = ((is_object($employee->getRelated('root_name')) and $employee->root != 1 )?$employee->getRelated('root_name')->name:'');

        
    }

    /**
     * Deletes a employee
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $employee = Employees::findFirstByid($id);
        if (!$employee) {
            $this->flash->error("employee was not found");

            $this->dispatcher->forward(array(
                'controller' => "employees",
                'action' => 'index'
            ));

            return;
        }

        if (!$employee->deleteNode()) {

            foreach ($employee->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "employees",
                'action' => 'search'
            ));

            return;
        }

        $this->flash->success("employee was deleted successfully");

        $this->dispatcher->forward(array(
            'controller' => "employees",
            'action' => "index"
        ));
    }

}
