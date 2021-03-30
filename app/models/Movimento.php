<?php

class Movimento extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_movimento;

    /**
     *
     * @var integer
     */
    public $id_produto;

    /**
     *
     * @var string
     */
    public $data;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("web_store");
        $this->setSource("movimentos");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'movimentos';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Movimentos[]|Movimentos|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Movimentos|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
