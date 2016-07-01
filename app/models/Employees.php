<?php

use Phalcon\Mvc\Model\Validator\Email as Email;
use Phalcon\Mvc\Model\Behavior\NestedSet as NestedSetBehavior;

class Employees extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $middle_name;

    /**
     *
     * @var string
     */
    public $last_name;

    /**
     *
     * @var string
     */
    public $post;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $phone;

    /**
     *
     * @var string
     */
    public $home_phone;

    /**
     *
     * @var string
     */
    public $description;

    /**
     *
     * @var integer
     */
    public $root;

    /**
     *
     * @var integer
     */
    public $lft;

    /**
     *
     * @var integer
     */
    public $rgt;

    /**
     *
     * @var integer
     */
    public $level;


    public function initialize()
    {
        $this->addBehavior(new NestedSetBehavior([
            'rootAttribute'  => 'root',
            'leftAttribute'  => 'lft',
            'rightAttribute' => 'rgt',
            'levelAttribute' => 'level'
        ]));
        
        $this->belongsTo('root', // which column
                 'Employees', // referenced table
                 'id', // referenced table column
                 ['alias' => 'root_name']);
    }

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $this->validate(
            new Email(
                array(
                    'field'    => 'email',
                    'required' => true,
                )
            )
        );

        if ($this->validationHasFailed() == true) {
            return false;
        }

        return true;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'employees';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Employees[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Employees
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function root_list(){
        $results = self::find(['columns' =>'id,level,post,name', "conditions" => "id != 1", 'order' => 'lft']);
        $root_list = [];
        foreach ($results as $result) {
            $root_list[$result->id] = str_repeat(' -- ', $result->level-2).$result->name.' должность : '.$result->post ;
        }

        return array('1'=>'') + $root_list;
    }

}
