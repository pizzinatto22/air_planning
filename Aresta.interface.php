<?php

/*
 * Conteúdo privado da disciplina INE5413, utilizada para fins de avaliação.
 * Trabalho: Implementação de uma estrutura de grafos.
 * @user: pizzinatto <pizzinatto22@gmail.com>
 */

/**
 *
 * @author pizzinatto <pizzinatto22@gmail.com>
 */
interface Aresta {
    /**
     * @return DateTime
     */
    function obterDataHoraChegada();
    
    /**
     * @return DateTime
     */
    function obterDataHoraPartida();
    
    /**
     * @return int
     */
    function obterNumeroBilhete();
    
    /**
     * @return String
     */
    function obterCompanhia();
    
    /**
     * @return float
     */
    function obterValor();
}
