<?php

/*
 * Conteúdo privado da disciplina INE5413, utilizada para fins de avaliação.
 * Trabalho: Implementação de uma estrutura de grafos.
 * @user: pizzinatto <pizzinatto22@gmail.com>
 */

require_once './Vertice.inteface.php';
require_once './Aresta.interface.php';

/**
 * Description of GrafoBase
 * Estrutura genérica de um grafo direcionado
 * @author pizzinatto <pizzinatto22@gmail.com>
 */
class GrafoDirecionadoBase {

    private $vertices = array();
    private $verticesObjetos = array();

    /**
     * Adiciona um vértice ao grafo. Se já existir um vértice com o mesmo nome,
     * o antigo é substituido. O(1)
     * @param Vertice $vertice
     */
    function adicionaVertice($vertice) {
        $nome = $vertice->obterNome();
        
        //lista que armazena os objetos que representam os vértices
        $this->verticesObjetos[$nome] = $vertice;
        
        //posição para guardar os vertices alcancaveis a partir do vértice em
        //questão
        $this->vertices[$nome]['destinos'] = array(); //usado para controle das arestas de partem deste vértice e deixar o método "sucessores" com a possibilidade O(1).
        $this->vertices[$nome]['destinos_objetos'] = array(); //guarda as referências para os vertices de destino
        $this->vertices[$nome]['grau_emissao'] = 0; //conta quantas arestas partem deste vértice
        
        
        //posicao para guardar os vertices que conseguem alcançar o vértice
        //em questão
        $this->vertices[$nome]['origens'] = array(); //usado para controle das arestas que chegam à este vértice e deixar o método "antecessores" com a possibilidade O(1).
        $this->vertices[$nome]['origens_objetos'] = array(); //guarda as referências dos vértices de origem
        $this->vertices[$nome]['grau_recepcao'] = 0; //conta quantas arestas chegam neste vértice
    }

    /**
     * Conecta dois vértices através da aresta $aresta. Permite múltiplas arestas para cada par de vértices.
     * O(1).
     * @param Vertice $origem
     * @param Vertice $destino
     * @param Aresta $aresta
     */
    function conecta($origem,$destino,$aresta) {
        $nomeOrigem = $origem->obterNome();
        $nomeDestino = $destino->obterNome();
        
        //Coloco o vertice de $destino na lista de destinos da $origem
        //e também os dados da aresta
        $this->vertices[$nomeOrigem]['destinos'][$nomeDestino][] = $aresta;
        $this->vertices[$nomeOrigem]['destinos_objetos'][$nomeDestino] = $destino;
        $this->vertices[$nomeOrigem]['grau_emissao']++;
        
        //Coloco o vertice de $origem como uma das origens do $destino e 
        //também coloco os dados da aresta
        $this->vertices[$nomeDestino]['origens'][$nomeOrigem][] = $aresta;
        $this->vertices[$nomeDestino]['origens_objetos'][$nomeOrigem] = $origem;
        $this->vertices[$nomeDestino]['grau_recepcao']++;
        
    }

    /**
     * Desconecta completamente os dois vértices passados por parâmetro, i.e. exclui todas as arestas em ambas
     * direções. O(1).
     * @param Vertice $origem
     * @param Vertice $destino
     */
    function desconecta($v1,$v2) {
        $nomeV1 = $v1->obterNome();
        $nomeV2 = $v2->obterNome();
        
        //Remove todas as arestas que vão de V1 para V2
        $qt = count($this->vertices[$nomeV1]['destinos'][$nomeV2]);
        unset($this->vertices[$nomeV1]['destinos'][$nomeV2]); //tudo em V1 que VAI até V2
        unset($this->vertices[$nomeV1]['destinos_objetos'][$nomeV2]); //V2 não é mais um dos destinos
        unset($this->vertices[$nomeV2]['origens'][$nomeV1]) ; //tudo em V2 que VEM de V1
        unset($this->vertices[$nomeV2]['origens_objetos'][$nomeV1]); //V1 não é mais uma das origens
        
        $this->vertices[$nomeV1]['grau_emissao'] -= $qt; //removo o nr de arestas totais
        $this->vertices[$nomeV2]['grau_recepcao'] -= $qt; //removo o nr de arestas totais
        
        //remove todas as arestas que vão de V2 para V1
        $qt = count($this->vertices[$nomeV2]['destinos'][$nomeV1]);
        unset($this->vertices[$nomeV2]['destinos'][$nomeV1]); //tudo em V2 que VAI até V1
        unset($this->vertices[$nomeV2]['destinos_objetos'][$nomeV1]); //V1 não é mais um destino
        unset($this->vertices[$nomeV1]['origens'][$nomeV2]) ; //tudo em V1 que VEM de V2
        unset($this->vertices[$nomeV1]['origens_objetos'][$nomeV2]) ; //V2 não é mais uma das origens
        
        
        $this->vertices[$nomeV2]['grau_emissao'] -= $qt; //removo o nr de arestas totais
        $this->vertices[$nomeV1]['grau_recepcao'] -= $qt; //removo o nr de arestas totais
        
    }

    /**
     * Remove um vértice do grafo, removendo todas as arestas que chegam ou partem dele. 
     * O(n), pois no pior dos casos está conectado com todos os  vértices (inclusive com ele mesmo) e a 
     * desconexão de 2 vértices leva O(1).
     * @param Vertice $vertice
     */
    function removeVertice($vertice) {
        $nome = $vertice->obterNome();
        
        //primeiro desconecto todos os vértices que são alcançáveis por este vértice
        foreach ($this->vertices[$nome]['destinos'] as $key => $value) {
            //recupero o objeto referente ao destino
            $destino = $this->verticesObjetos[$key];
            $this->desconecta($vertice, $destino);
        }
        
        //depois desconecto todos os vértices que alcançam este vértice
        foreach ($this->vertices[$nome]['origens'] as $key => $value) {
            //recupero o objeto referente a origem
            $origem = $this->verticesObjetos[$key];
            $this->desconecta($vertice, $origem);
        }
        
        //removo o vértice da lista
        unset($this->vertices[$nome]);
        unset($this->verticesObjetos[$nome]);
    }

    /**
     * 
     * @return int A quantidade de vértices nesse grafo. 
     * O(1), pois a linguagem armazena o tamanho do array em uma propriedade.
     */
    function ordem() {
        return count($this->vertices);
    }

    /**
     * @return array Uma lista com todos os vértices, onde cada elemento é um objeto da interface Vertice.
     * O(n), pois a linguagem cria uma cópia do array. Pode ser transformado em O(1) caso seja retornada uma referência,
     * mas não é adequado para a situação.
     */
    function vertices() {
        return $this->verticesObjetos;
    }
    
    /**
     * Busca as arestas que vão de $v1 a $v2. 
     * O(m/n), pois a linguagem faz cópia do array, mas pode ser transformado em O(1) usando sua referência.
     * @param Vertice $v1
     * @param Vertice $v2
     * @return array Uma lista contendo as arestas que vão de $v1 a $v2
     */
    function arestas($v1,$v2){
        $nomeV1 = $v1->obterNome();
        $nomeV2 = $v2->obterNome();
        
        if (isset($this->vertices[$nomeV1]['destinos'][$nomeV2]))
            return $this->vertices[$nomeV1]['destinos'][$nomeV2];
        else 
            return array();
    }

    /**
     * @return Retorna um vértice qualquer, caso haja algum ou FALSE caso o grafo esteja vazio. 
     * O(1), pois reset altera o ponteiro do array para o primeiro elemento e retorna seu valor.
     */
    function umVertice() {        
        return reset($this->verticesObjetos);
    }
    
    
    /**
     * Sucessores.
     * O(n) pois linguagem faz uma cópia antes de retornar o array, mas pode ser reduzido a O(1) se retornar uma referência do array.
     * @param Vertice $vertice o vértice que se deseja saber quem são os sucessores.
     * @return array uma lista com referência para todos os vértices sucessoes.
     */
    function sucessores($vertice){
        $nome = $vertice->obterNome();
        return $this->vertices[$nome]['destinos_objetos'];
    }
    

    /**
     * Antecessores.
     * O(n) pois linguagem faz uma cópia antes de retornar o array, mas pode ser reduzido a O(1) se retornar uma referência do array.
     * @param Vertice $vertice o vértice que se deseja saber quem são os antecessores.
     * @return array uma lista com referência para todos os vértices antecessores.
     */
    function antecessores($vertice){
        $nome = $vertice->obterNome();
        return $this->vertices[$nome]['origens_objetos'];
    }
    
    /**
     * Grau de emissão de um determinado vértice. O(1), pois apenas consulta propriedade.
     * @param Vertice $vertice Vértice que se deseja saber o grau de emissão.
     * @return int Grau de emissão do vértice passado por parâmetro.
     */
    function grauEmissao($vertice){
        $nome = $vertice->obterNome();
        return $this->vertices[$nome]['grau_emissao'];
    }

    /**
     * Grau de recepção de um determinado vértice. O(1), pois apenas consulta propriedade.
     * @param Vertice $vertice Vértice que se deseja saber o grau de recepção.
     * @return int Grau de recepcão do vértice passado por parâmetro.
     */
    function grauRecepcao($vertice){
        $nome = $vertice->obterNome();
        return $this->vertices[$nome]['grau_recepcao'];
    }

}
