<?php

/*
 * Conteúdo privado da disciplina INE5413, utilizada para fins de avaliação.
 * Trabalho: Implementação de uma estrutura de grafos.
 * @user: pizzinatto <pizzinatto22@gmail.com>
 */

require_once './Aresta.interface.php';
/**
 *
 * @author pizzinatto <pizzinatto22@gmail.com>
 */
interface ArestaGrafoMinimo extends Aresta{
    /**
     * @return Vertice
     */
    function verticeOrigemGrafroOriginal();
    
    /**
     * @return Vertice
     */
    function verticeDestinoGrafoOriginal();
}
