<?php

/*
 * Conteúdo privado da disciplina INE5413, utilizada para fins de avaliação.
 * Trabalho: Implementação de uma estrutura de grafos.
 * @user: pizzinatto <pizzinatto22@gmail.com>
 */

require_once './Aresta.interface.php';
/**
 * Description of Trecho
 *
 * @author pizzinatto <pizzinatto22@gmail.com>
 */
class Trecho implements Aresta{
    private $valor;
    private $dataHoraChegada;
    private $dataHoraPartida;
    private $numeroBilhete;
    private $companhiaAerea;
    
    /**
     * 
     * @param float $valor
     * @param DateTime $dataHoraChegada
     * @param DateTime $dataHoraPartida
     * @param int $numeroBilhete
     */
    public function __construct($valor,$dataHoraPartida,$dataHoraChegada,$numeroBilhete,$companhiaAerea) {
        $this->valor = $valor;
        $this->dataHoraChegada = $dataHoraChegada;
        $this->dataHoraPartida = $dataHoraPartida;
        $this->numeroBilhete = $numeroBilhete;
        $this->companhiaAerea = $companhiaAerea;
    }
    
    public function obterDataHoraChegada() {
        return $this->dataHoraChegada;
    }
    
    public function obterDataHoraPartida() {
        return $this->dataHoraPartida;
    }
    
    public function obterNumeroBilhete() {
        return $this->numeroBilhete;
    }
    
    public function obterCompanhia() {
        return $this->companhiaAerea;
    }
    
    public function obterValor() {
        return $this->valor;
    }
    
}
