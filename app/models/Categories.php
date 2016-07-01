<?php

use Phalcon\Mvc\Model\Behavior\NestedSet as NestedSetBehavior;

class Categories extends \Phalcon\Mvc\Model
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
    }


    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'categories';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Categories[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Categories
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
