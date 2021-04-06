<?php

class Saldo extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_saldo;

    /**
     *
     * @var integer
     */
    public $id_usuario;

    /**
     *
     * @var integer
     */
    public $saldo;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("web_store");
        $this->setSource("saldos");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'saldos';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Saldos[]|Saldos|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Saldos|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
