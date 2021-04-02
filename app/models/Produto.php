<?php

class Produto extends \Phalcon\Mvc\Model
{

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
    public $nome_produto;

    /**
     *
     * @var integer
     */
    public $quantidade;

    /**
     *
     * @var integer
     */
    public $preco;

    /**
     *
     * @var string
     */
    public $foto;

    /**
     *
     * @var string
     */
    public $descricao;

    /**
     *
     * @var string
     */
    public $adicionado_em;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("web_store");
        $this->setSource("Produtos");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'Produtos';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Produtos[]|Produtos|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Produtos|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function adicionarImagem($img) {

    }


    public function listarPorId($id) {
        $result = [];
        $query = $this->di->getDb()->query("SELECT * FROM produtos JOIN usuarios WHERE produtos.id_usuario = $id");
        $result = $query->fetchALL(PDO::FETCH_ASSOC);
        return $result;
    }

    public function excluir($id) {
        try {
            $query = $this->di->getDb()->prepare('DELETE FROM produtos WHERE id_produto = :id');
            $query->bindValue(':id_usuario', $id);
            return $query->execute();
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

}
