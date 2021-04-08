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

    public function adicionar($valor, $id_usuario) {
        $saldoAtual = $this->di->getDb()->query("SELECT id_usuario, saldo FROM saldos WHERE id_usuario = $id_usuario")->fetch(PDO::FETCH_ASSOC)['saldo']; //pegar o saldo atual
        
        $novoSaldo = $saldoAtual + $valor;
        $query = $this->di->getDb()->prepare("UPDATE saldos SET saldo = :novoSaldo WHERE id_usuario = :id_usuario");
        $query->bindValue(':novoSaldo', $novoSaldo);
        $query->bindValue(':id_usuario', $id_usuario);

        return $query->execute();
    }


    public function saldoUsuario($idUsuario) {
        $query = $this->di->getDb()->query("SELECT * FROM saldos WHERE id_usuario = $idUsuario");
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
