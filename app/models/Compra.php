<?php

class Compra extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $id_usuario;

    /**
     *
     * @var integer
     */
    public $id_produto;

    /**
     *
     * @var string
     */
    public $data_compra;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("web_store");
        $this->setSource("compras");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'compras';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Compras[]|Compras|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Compras|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function listarCompraUsuario($id_usuario) {
        $query = $this->di->getDb()->query("SELECT compras.id_compra, compras.id_produto, compras.id_comprador, compras.id_vendedor, data_compra, produtos.nome_produto AS produto, usuarios.nome as vendedor FROM compras JOIN produtos ON compras.id_produto = produtos.id_produto AND compras.id_comprador = $id_usuario JOIN usuarios ON compras.id_vendedor <> $id_usuario AND usuarios.id_usuario = produtos.id_usuario");

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

}
