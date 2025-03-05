<?php

class Usuario {

private $username;
private $password;

// constroi inicialização das propriedades de usuário

public function __construct($username, $password) {
    $this->username = $username;
    $this->password = $password;
}

// obtém o nome de usuário e senha

public function getUsername() {
    return $this->username;
}

public function getPassword() {
    return $this->password;
}

public static function autenticar($username, $password) {
    $usuarios = self::carregarUsuarios(); 
    foreach ($usuarios as $usuario) {

        if ($usuario->getUsername() === $username && $usuario->getPassword() === $password) {
            return true; // Retorna verdadeiro se o usuário for autenticado
        }
    }
    return false;
}

// varrega usuário do arquivo

private static function carregarUsuarios() {
    $usuarios = [];
    if (file_exists('login.txt')) { 
        $lines = file('login.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); // le todas as linhas do arquivo
        foreach ($lines as $line) {
            list($username, $password) = explode(',', $line); // divide em nome, usuário e senha a linha
            $usuarios[] = new Usuario(trim($username), trim($password));
        }
    }
    return $usuarios; 
}
}

?>