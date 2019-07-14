<?php

/*
 * Conteúdo privado da disciplina INE5413, utilizada para fins de avaliação.
 * Trabalho: Implementação de uma estrutura de grafos.
 * @user: pizzinatto <pizzinatto22@gmail.com>
 */

include_once './GrafoDirecionadoBase.class.php';

/**
 * Description of GrafoDirecionado
 * Implementação de algumas especificidades de um grafo
 * @author pizzinatto <pizzinatto22@gmail.com>
 */
class GrafoDirecionado extends GrafoDirecionadoBase{
    
    /**
     * Calcula o fecho transitivo direto de um vértice.
     * @param Vertice $vertice Vértice ao qual se deseja saber o fecho transitivo direto.
     */
    function fechoTransitivoDireto($vertice){
        $ftd = $this->sucessores($vertice);     //todo os sucessores diretos fazem parte do FTD
        $ftd[$vertice->obterNome()] = $vertice; //o proprio vértice faz parte do FTD
        
        
        $v = reset($ftd);
        
        while ($v !== FALSE){
            $sucessores = $this->sucessores($v);
            
            //para os sucessores de V, verifica quem já faz parte do FTD. QUem não faz, adiciona
            foreach ($sucessores as $key => $value) {
                if (!isset($ftd[$key])){
                    $ftd[$key] = $value;
                }
            }
            
            $v = next($ftd);
        }
        
        return $ftd;
    }
    
    /**
     * Calcula o fecho transitivo inverso de um vértice.
     * @param Vertice $vertice Vértice ao qual se deseja saber o fecho transitivo inverso.
     */
    function fechoTransitivoInverso($vertice){
        $fti = $this->antecessores($vertice);     //todo os antecessores diretos fazem parte do FTI
        $fti[$vertice->obterNome()] = $vertice; //o proprio vértice faz parte do FTI
        
        
        $v = reset($fti);
        
        while ($v !== FALSE){
            $antecessores = $this->antecessores($v);
            
            //para os antecessores de V, verifica quem já faz parte do FTI. QUem não faz, adiciona
            foreach ($antecessores as $key => $value) {
                if (!isset($fti[$key])){
                    $fti[$key] = $value;
                }
            }
            
            $v = next($fti);
        }
        
        return $fti;
    }
    
}
