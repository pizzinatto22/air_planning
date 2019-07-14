<?php

/*
 * Conteúdo privado da disciplina INE5413, utilizada para fins de avaliação.
 * Trabalho: Implementação de uma estrutura de grafos.
 * @user: pizzinatto <pizzinatto22@gmail.com>
 */

require_once './Vertice.inteface.php';

/**
 * Description of CFC
 * Descreve uma componente fortemente conexa como um vértice
 * @author pizzinatto <pizzinatto22@gmail.com>
 */
class CFC implements Vertice{
    private $nome;
    
    /**
     * Nome da CFC
     * @param String $nome
     */
    public function __construct($nome) {
        $this->nome = $nome;
    }


    public function obterNome() {
        return $this->nome;
    }
}
