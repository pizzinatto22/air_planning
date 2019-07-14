<?php

/*
 * Conteúdo privado da disciplina INE5413, utilizada para fins de avaliação.
 * Trabalho: Implementação de uma estrutura de grafos.
 * @user: pizzinatto <pizzinatto22@gmail.com>
 */
require_once './ArestaGrafoMinimo.php';
/**
 * Description of Trecho2
 *
 * @author pizzinatto <pizzinatto22@gmail.com>
 */
class Trecho2 implements ArestaGrafoMinimo{
    
    private $origem;
    private $destino;
    
    /**
     * @var Aresta
     */
    private $arestaOriginal;
    
    public function __construct($origem,$destino,$arestaOriginal) {
        $this->origem = $origem;
        $this->destino = $destino;
        $this->arestaOriginal = $arestaOriginal;
    }
    
    public function verticeDestinoGrafoOriginal() {
        return $this->destino;
    }
    
    public function verticeOrigemGrafroOriginal() {
        return $this->origem;
    }
    
    public function obterDataHoraChegada() {
        return $this->arestaOriginal->obterDataHoraChegada();
    }
    
    public function obterDataHoraPartida() {
        return $this->arestaOriginal->obterDataHoraPartida();
    }
    
    public function obterNumeroBilhete() {
        return $this->arestaOriginal->obterNumeroBilhete();
    }
    
    public function obterCompanhia() {
        return $this->arestaOriginal->obterCompanhia();
    }
    
    public function obterValor() {
        return $this->arestaOriginal->obterValor();
    }
}
