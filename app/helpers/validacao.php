function isEmailValid( $email ) {
    if ( filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
        return true;
    } else {
        return false;
    }
}

function isNomeValid( $nome ) {
    if ( preg_match( '/[a-zA-Z]+/m', $nome ) ) {
        return true;
    } else {
        return false;
    }
}

function isSenhaValid($senha) {
    if(strlen($senha) >= 6) {
        return true;
    } else {
        return false;
    }
}

function senhasIguais($senha, $senha_2) {
    if($senha === $senha_2) {
        return true;
    } else {
        return false;
    }
}