<?php

/*
 * Conteúdo privado da disciplina INE5413, utilizada para fins de avaliação.
 * Trabalho: Implementação de uma estrutura de grafos.
 * @user: pizzinatto <pizzinatto22@gmail.com>
 */

require_once './GrafoDirecionado.class.php';
require_once './CFC.php';
require_once './Trecho2.php';

/**
 * Description of GrafoMinimo
 * Grafo que pode ser criado a partir de um grafo direcionado, onde os vértices são as componentes 
 * fortemente conexas. Todas as arestas entre vértices de CFC diferentes são mantida
 * @author pizzinatto <pizzinatto22@gmail.com>
 */
class GrafoMinimo extends GrafoDirecionado {

    private $verticesEmCFC = array();
    private $CFCPorVertice = array();

    /**
     * O Grafo que será usado como base para criação desse grafo mínimo.
     * @param GrafoDirecionado $grafo
     * @param array $isolados Vértices que ficarão isolados, mesmo que serão forcados a ficarem isolados
     */
    public function __construct($grafo, $isolados) {
        $vertices = $grafo->vertices();

        $i = 1;

        $isolados2 = array();
        foreach ($isolados as $isolado) {
            $nomeIsolado = $isolado->obterNome();
            $nomeCFC = "C" . $i++;
            $cfc = new CFC($nomeCFC);
            $this->adicionaVertice($cfc);

            $this->verticesEmCFC[$nomeCFC] = array($isolado);
            $this->CFCPorVertice[$nomeIsolado] = $cfc;
            $isolados2[$nomeIsolado] = $isolado;

            unset($vertices[$nomeIsolado]);
        }

        //montagem dos vértices que representam as CFCs desse grafo
        while (count($vertices) > 0) {
            $v = array_shift($vertices); //pega um elemento qualquer dos vértices

            $ftd = $grafo->fechoTransitivoDireto($v);
            $fti = $grafo->fechoTransitivoInverso($v);

            //interseccao entre ftd e fti
            $verticesCFC = array();
            foreach ($ftd as $key => $value)
                if (isset($fti[$key]) && !isset($isolados2[$key]))
                    $verticesCFC[$key] = $value;

            $nomeCFC = "C" . $i++;

            //crio um vértice dentro desse grafo que representa a CFC
            $cfc = new CFC($nomeCFC);
            $this->adicionaVertice($cfc);

            //guardo quais vértices do grafo original fazem parte dessa CFC
            $this->verticesEmCFC[$nomeCFC] = $verticesCFC;

            //removo os vertices dessa CFC da lista original e 
            //vinculo cada um à sua CFC para fazer uma lista inversa
            foreach ($verticesCFC as $key => $value) {
                $this->CFCPorVertice[$key] = $cfc;
                unset($vertices[$key]);
            }
        }

        //fazer a ligação entre as CFC desse grafo
        $vertices = $this->vertices();
        foreach ($vertices as $nomeCFC => $cfc) {
            $verticesCFC = $this->verticesEmCFC[$nomeCFC];

            foreach ($verticesCFC as $nomeVertice => $v) {
                //pego todos os destinos desse vertice no grafo original
                $destinos = $grafo->sucessores($v);

                //para cada destino, vejo quais deles pertencem à outras CFCs.
                //quando forem de outra, as arestas precisam ser ligadas adicionadas à este
                foreach ($destinos as $nomeDestino => $d) {
                    if (!isset($verticesCFC[$nomeDestino])) { //o destino não fizer parte da CFC
                        $cfcDestino = $this->CFCPorVertice[$nomeDestino];

                        $listaArestas = $grafo->arestas($v, $d);

                        foreach ($listaArestas as $aresta) {
                            $a = new Trecho2($v, $d, $aresta);
                            $this->conecta($cfc, $cfcDestino, $a);
                        }
                    }
                }
            }
        }
    }

    /**
     * @param DateInterval $diferenca
     */
    private function converterDiferencaEmHoras($diferenca) {
        return ($diferenca->y * 12 * 30 * 24 + $diferenca->m * 30 * 24 + $diferenca->d * 24 + $diferenca->h + $diferenca->m / 60.0 + $diferenca->s / (60.0 * 60.0));
    }

    /**
     * Calcula os dados de custo + duração de uma rota
     */
    private function calcularDadosRota($rota) {
        $primeira = $rota[0];
        $conexoes = count($rota) - 1;
        $ultima = $rota[$conexoes];

        $horas = $this->converterDiferencaEmHoras($primeira->obterDataHoraPartida()->diff($ultima->obterDataHoraChegada()));
        $total = 0;

        $bilhetesUsados = array();

        foreach ($rota as $aresta) {
            $valor = $aresta->obterValor();
            $bilhete = $aresta->obterNumeroBilhete();

            //se o bilhete ainda nao foi usado na rota, conta seu valor
            if (!isset($bilhetesUsados[$bilhete])) {
                $total = $total + $valor;
                $bilhetesUsados[$bilhete] = 1;
            }
        }

        return array(
            'valor' => $total,
            'duracao' => $horas,
            'conexao' => $conexoes
        );
    }

    private function expandir($origem, $destino, $tempoEsperaMinimo, $caminhoAtual, $visitados, &$caminhosValidos) {

        //se origem e destino forem iguais, então cheguei no destino e o caminho expandido em 
        //$caminhoAtual é um caminho válido e deve ser colocado dentro de $caminhosValidos
        if ($origem->obterNome() == $destino->obterNome()) {
            $qt = count($caminhosValidos);
            $caminhosValidos[$qt]['rotas'] = $caminhoAtual;
            $caminhosValidos[$qt]['dados'] = $this->calcularDadosRota($caminhoAtual);
            return;
        } else {
            //se não, preciso continuar caminhando no grafo.

            $sucessoresDoDestino = $this->sucessores($origem);

            //para cada sucessor, vejo quais arestas podem ser utilizadas (que se encaixam no tempo).
            foreach ($sucessoresDoDestino as $nomeSucessor => $sucessor) {
                //se esse sucessor ainda não foi visitado (mesmo no grafo minimo, podem haver ciclos, pois alguns vértices podem ter sido forçados a ficarem isolados)
                if (!isset($visitados[$nomeSucessor])) {
                    $visitados[$nomeSucessor] = $sucessor;
                    
                    //pego o conjunto de arestas que ligam a origem ao sucessor em questao
                    $arestas = $this->arestas($origem, $sucessor);

                    foreach ($arestas as $aresta) {
                        $qtArestas = count($caminhoAtual);

                        //se o array com o caminho está vazio (essa é a primeira aresta) ou se
                        //o horário de saida dessa aresta é maior que $tempoEsperaMinimo da última aresta utilizada
                        //então posso utilizá-la
                        //também posso utilizá-la se o trcho seguinte faz parte da mesma conexão (tem o mesmo número de bilhete).
                        $ultimaAresta = NULL;
                        if ($qtArestas > 0) {
                            $ultimaAresta = $caminhoAtual[$qtArestas - 1];
                        }

                        if ($ultimaAresta == NULL ||
                                (
                                !empty($ultimaAresta->obterNumeroBilhete()) &&
                                $ultimaAresta->obterNumeroBilhete() == $aresta->obterNumeroBilhete()
                                ) ||
                                (
                                $ultimaAresta->obterDataHoraChegada() < $aresta->obterDataHoraPartida() &&
                                $this->converterDiferencaEmHoras($ultimaAresta->obterDataHoraChegada()->diff($aresta->obterDataHoraPartida())) >= $tempoEsperaMinimo
                                )
                        ) {

                            //adiciono a aresta no caminho atual
                            $caminhoAtual[$qtArestas] = $aresta;

                            //faço a expansão a partir dessa aresta+sucessor
                            $this->expandir($sucessor, $destino, $tempoEsperaMinimo, $caminhoAtual,$visitados, $caminhosValidos);

                            //removo a aresta da lista
                            unset($caminhoAtual[$qtArestas]);
                        }
                    }
                }
            }
        }
    }

    /**
     * Expande todos os caminhos possíveis entre os dois vértices indicados.
     * @param Vertice $origem Vértice de origem no grafo original
     * @param Vertice $destino Vértice de destino no grafo orifinal
     * @param float $tempoEsperaMinimo Tempo de espera mínimo quando os voos não são da mesma conexão (mesmo número de bilhete).
     * @return array Uma lista, onde cada posição é um conjunto válido de arestas a serem seguidas no grafo original
     * para que seja atingido o objetivo
     */
    public function expandeCaminhos($origem, $destino, $tempoEsperaMinimo) {
        $caminhos = array();
        $nomeOrigem = $origem->obterNome();
        $nomeDestino = $destino->obterNome();

        $this->expandir($this->CFCPorVertice[$nomeOrigem], $this->CFCPorVertice[$nomeDestino], $tempoEsperaMinimo,array() ,array(), $caminhos);

        return $caminhos;
    }

    /**
     * Descobre o caminho mínimo entre dois vértices do grafo orinal. $tempoEsperaMinimo é usado quando há troca
     * de bilhetes.
     * @param Vertice $origem Vértice de origem no grafo original
     * @param Vertice $destino Vértice de destino no grafo original
     * @param int $tempoEsperaMinimo Tempo de espera mínimo quando os voos não são da mesma conexão (mesmo número de bilhete).
     */
    public function caminhoMinimo($origem, $destino, $tempoEsperaMinimo) {
        $caminhos = $this->expandeCaminhos($origem, $destino, $tempoEsperaMinimo);

        //ordena (com bubble sort mesmo)
        
        $qt = count($caminhos) - 1;
        for ($i = 0; $i <= $qt - 1; $i++) {
            for ($j = $i + 1; $j <= $qt; $j++) {
                if ($caminhos[$i]['dados']['valor'] > $caminhos[$j]['dados']['valor']) {
                    $aux = $caminhos[$i];
                    $caminhos[$i] = $caminhos[$j];
                    $caminhos[$j] = $aux;
                }
            }
        }

        return $caminhos[0];
    }

}
