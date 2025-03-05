<?php

class CadastroAlunos {
    
private $alunos = [];

// cadastro novo aluno
public function cadastrarAluno($aluno) {
$this->alunos[] = $aluno; // adiciona o aluno 
$this->salvarAlunos(); 
}

public function listarAlunos() {
return $this->alunos; 
}

// remove aluno cadastrado
public function removerAluno($matricula) {
foreach ($this->alunos as $key => $aluno) {
    if ($aluno->getMatricula() === $matricula) { // verifica matrícula 
        unset($this->alunos[$key]); // remove aluno 
        $this->alunos = array_values($this->alunos); 
        $this->salvarAlunos(); 
        return true; 
    }
}
return false;
}

// salvar os alunos no arquivo
private function salvarAlunos() {
$data = serialize($this->alunos); /
file_put_contents('alunos.txt', $data); 
}

// carrega os alunos do arquivo
public function carregarAlunos() {
if (file_exists('alunos.txt')) { /
    $data = file_get_contents('alunos.txt'); 
    $alunos = @unserialize($data); 
    if ($alunos !== false) {
        $this->alunos = $alunos; 
    }
}
}
}

?>