<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;

class Usuario extends \Phalcon\Mvc\Model
{
    /**
     *
     * @var integer
     */
    public $id_usuario;

    /**
     *
     * @var string
     */
    public $profile_picture;

    /**
     *
     * @var string
     */
    public $nome;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $senha;

    /**
     *
     * @var string
     */
    public $criado_em;

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'email',
            new EmailValidator(
                [
                    'model'   => $this,
                    'message' => 'Please enter a correct email address',
                ]
            )
        );

        return $this->validate($validator);
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("web_store");
        $this->setSource("usuarios");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'usuarios';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Usuarios[]|Usuarios|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Usuarios|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


    public function signupArmazenar($dados) {
        $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
        try {
            $query = $this->di
            ->getDb()
            ->prepare('INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)');

            $query->bindValue(':nome', $dados['nome']);
            $query->bindValue(':email', $dados['email']);
            $query->bindValue(':senha', $dados['senha']);
            
            if($query->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo 'ERRO: ' . $e->getMessage();
            return false;
        }
    }


    public function login($dados) {
        $email = $dados['email'];
        $query = $this->di->getDb()->query("SELECT * FROM usuarios WHERE email = '$email'");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        if(count($result) !== 0) {
            if(password_verify($dados['senha'], $result[0]['senha'])) {
                //login efetuado com sucesso
                return true;
            }
        } else {
            return false;
        }
    }


    public function emailExiste($email) {
        $query = $this->di->getDb()->query("SELECT * FROM usuarios WHERE email = '$email'");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return count($result) > 0 ? true : false;
    }

    public function atualizarImagemPerfil($nomeImg, $id_usuario) {
        try {
            $imgAtual = $this->di->getDb()->query("SELECT * FROM usuarios WHERE id_usuario = $id_usuario")->fetch(PDO::FETCH_ASSOC)['profile_picture'];
            $pathImgAtual = dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'usuarios'.DIRECTORY_SEPARATOR.'perfil'.DIRECTORY_SEPARATOR.$imgAtual;
            if($imgAtual != 'default.png') {
                if(file_exists($pathImgAtual)) {
                    unlink($pathImgAtual);
                }
            }
            $query = $this->di->getDb()->prepare('UPDATE usuarios SET profile_picture = :nomeImg WHERE id_usuario = :idUsuario');
            $query->bindValue(':nomeImg', $nomeImg);
            $query->bindValue(':idUsuario', $id_usuario);
        
            return $query->execute() ? true : false;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }












    public function emailValido($email) {
        if ( filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
            return true;
        } else {
            return false;
        }
    }

    public function nomeValido($nome) {
        if ( preg_match( '/[a-zA-Z]+/m', $nome ) ) {
            return true;
        } else {
            return false;
        }
    }

    public function senhaValida($senha) {
        if(strlen($senha) >= 6 ) {
            return true;
        } else {
            return false;
        }
    }

    public function senhasConferem($senha1, $senha2) {
        if($senha1 === $senha2) {
            return true;
        } else {
            return false;
        }
    }
}