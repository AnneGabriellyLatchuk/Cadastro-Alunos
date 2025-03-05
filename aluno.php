<?php

class Aluno {
// armazena dados do aluno

private $nome;
private $matricula;
private $curso;

// inicializa as propriedades do aluno

public function __construct($nome, $matricula, $curso) {
    $this->nome = $nome;
    $this->matricula = $matricula;
    $this->curso = $curso;
}

// método para retornar o nome do aluno, matricula e curso

public function getNome() {
    return $this->nome;
}

public function getMatricula() {
    return $this->matricula;
}

public function getCurso() {
    return $this->curso;
}
}

?>