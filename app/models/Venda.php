<?php

class Venda extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_venda;

    /**
     *
     * @var integer
     */
    public $id_produto;

    /**
     *
     * @var integer
     */
    public $id_usuario;

    /**
     *
     * @var string
     */
    public $data_hora;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("web_store");
        $this->setSource("vendas");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'vendas';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Vendas[]|Vendas|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Vendas|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


    public function listarVendaUsuario($id_usuario) {
        $query = $this->di->getDb()->query("SELECT compras.id_compra, compras.id_produto, compras.id_comprador, compras.id_vendedor, data_compra, produtos.nome_produto AS produto, usuarios.nome AS comprador FROM compras JOIN produtos ON compras.id_produto = produtos.id_produto AND compras.id_comprador <> $id_usuario JOIN usuarios ON compras.id_comprador AND usuarios.id_usuario = compras.id_comprador");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

}

/**
 * 
 * 
 * 
 * Diminuir um item no estoque quando o usuário fizer a compra
 * 
 * 
 * 
 */
