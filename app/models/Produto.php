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

    public function adicionarImagemProduto($nomeImg) {
        $ultimoId = $this->di->getDb()->query('SELECT MAX(id_produto) as max_id from produtos')->fetch(PDO::FETCH_ASSOC)['max_id'];
        try {
            $imgAtual = $this->di->getDb()->query("SELECT * FROM produtos WHERE id_produto = $ultimoId")->fetch(PDO::FETCH_ASSOC)['foto'];
            $pathImgAtual = dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'produtos'.DIRECTORY_SEPARATOR.$imgAtual;
            if($imgAtual != 'sem_foto.jpg') {
                if(file_exists($pathImgAtual)) {
                    unlink($pathImgAtual);
                }
            }
            $query = $this->di->getDb()->prepare('UPDATE produtos SET foto = :nomeImg WHERE id_produto = :ultimoId');
            $query->bindValue(':nomeImg', $nomeImg);
            $query->bindValue(':ultimoId', $ultimoId);
        
            return $query->execute() ? true : false;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function atualizarImagemProduto($id, $nomeImg) {
        try {
            $imgAtual = $this->di->getDb()->query("SELECT * FROM produtos WHERE id_produto = $id")->fetch(PDO::FETCH_ASSOC)['foto'];
            $pathImgAtual = dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'produtos'.DIRECTORY_SEPARATOR.$imgAtual;
            if($imgAtual != 'sem_foto.jpg') {
                if(file_exists($pathImgAtual)) {
                    unlink($pathImgAtual);
                }
            }
            $query = $this->di->getDb()->prepare('UPDATE produtos SET foto = :nomeImg WHERE id_produto = :id');
            $query->bindValue(':nomeImg', $nomeImg);
            $query->bindValue(':id', $id);
        
            return $query->execute() ? true : false;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function pesquisar($pesquisa, $idUser) {
        $query = $this->di->getDb()->query("SELECT produtos.id_produto, produtos.id_usuario, produtos.nome_produto, produtos.quantidade, produtos.preco, produtos.foto, produtos.descricao, produtos.adicionado_em, usuarios.profile_picture AS foto_vendedor, usuarios.nome AS vendedor FROM produtos JOIN usuarios ON produtos.id_usuario = usuarios.id_usuario WHERE produtos.nome_produto LIKE '$pesquisa%' AND produtos.id_usuario <> $idUser ORDER BY produtos.nome_produto");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function pesquisarPorUsuario($pesquisa, $idUser) {
        $query = $this->di->getDb()->query("SELECT produtos.id_produto, produtos.id_usuario, produtos.nome_produto, produtos.quantidade, produtos.preco, produtos.foto, produtos.descricao, produtos.adicionado_em, usuarios.profile_picture AS foto_vendedor, usuarios.nome AS vendedor FROM produtos JOIN usuarios ON produtos.id_usuario = usuarios.id_usuario WHERE produtos.nome_produto LIKE '$pesquisa%' AND produtos.id_usuario = $idUser ORDER BY produtos.nome_produto");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function adicionar($dados) {
        $query = $this->di->getDb()->prepare('INSERT INTO produtos (id_usuario, nome_produto, quantidade, preco, descricao) VALUES (:id_user, :nome, :quant, :preco, :descricao) ');
        $query->bindValue(':id_user', $dados['id_usuario']);
        $query->bindValue(':nome', $dados['nome_produto']);
        $query->bindValue(':quant', $dados['quant']);
        $query->bindValue(':preco', $dados['preco']);
        $query->bindValue(':descricao', $dados['desc_produto']);
        return $query->execute() ? true : false;
    }


    public function listarPorIdUsuario($id) {
        $result = [];
        $query = $this->di->getDb()->query("SELECT * FROM produtos WHERE id_usuario = $id ORDER BY nome_produto");
        $result = $query->fetchALL(PDO::FETCH_ASSOC);
        return $result;
    }

    public function excluir($id) {
        try {
            $query = $this->di->getDb()->prepare('DELETE FROM produtos WHERE id_produto = :id');
            $query->bindValue(':id', $id);
            return $query->execute();
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function listarTodos($idUser) {
        try {
            $query = $this->di->getDb()->query("SELECT produtos.id_produto, produtos.id_usuario, produtos.nome_produto, produtos.quantidade, produtos.preco, produtos.foto, produtos.descricao, produtos.adicionado_em, usuarios.profile_picture AS foto_vendedor, usuarios.nome AS vendedor FROM produtos JOIN usuarios ON produtos.id_usuario = usuarios.id_usuario WHERE produtos.id_usuario <> $idUser ORDER BY produtos.nome_produto");
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch(\Exception $e) {
            echo $e->getMessage();
        }
    }


    public function atualizarProduto($id, $dados) {
        var_dump($dados);
        $query = $this->di->getDb()->prepare("UPDATE produtos SET nome_produto = :nome, quantidade = :quant, preco = :preco, descricao = :descricao WHERE id_produto = :id");
        $query->bindValue(':nome', $dados['nome_produto']);
        $query->bindValue(':quant', $dados['quant']);
        $query->bindValue(':preco', $dados['preco']);
        $query->bindValue(':descricao', $dados['desc_produto']);
        $query->bindValue(':id', $id);
        return $query->execute();
    }

    public function listarPorIdProduto($id) {
        $query = $this->di->getDb()->query("SELECT produtos.id_produto, produtos.id_usuario, produtos.nome_produto, produtos.quantidade, produtos.preco, produtos.foto, produtos.descricao, produtos.adicionado_em, usuarios.profile_picture AS foto_vendedor, usuarios.nome AS vendedor FROM produtos JOIN usuarios ON usuarios.id_usuario = produtos.id_usuario WHERE id_produto = $id");
        return $query->fetch(PDO::FETCH_ASSOC);
    }


    public function comprarProduto($idUser, $idVendedor, $idProduto) {
        $query = $this->di->getDb()->prepare('INSERT INTO compras (id_comprador, id_produto, id_vendedor) VALUES (:idUser, :idProduto, :idVendedor)');
        $query->bindValue(':idUser', $idUser);
        $query->bindValue(':idProduto', $idProduto);
        $query->bindValue(':idVendedor', $idVendedor);
        if(!$query->execute()) {
            return false;
        }
        $saldoModel = new Saldo();
        $saldoAtual = $saldoModel->findFirstById_usuario($idUser)->saldo;
        $precoProduto = self::findFirstById_produto($idProduto)->preco;
        $precoProduto = str_replace(',', '.', $precoProduto);
        $novoSaldo = $saldoAtual - $precoProduto;

        if(!$this->alterarQuantidade($idProduto, $idUser)) {
            return false;
        }
        
        $saldoModel->atualizarSaldo($novoSaldo, $idUser);
    }

    private function alterarQuantidade($idProduto, $quant) {
        $quantidadeAtual = self::findFirstById_produto($idProduto)->quantidade;
        $quantidadeAposCompra = $quantidadeAtual -= 1;
        $query = $this->di->getDb()->query("UPDATE produtos SET quantidade = $quantidadeAposCompra WHERE id_produto = $idProduto");
        if($query) {
            return true;
        } else {
            return false;
        }
    }
}
