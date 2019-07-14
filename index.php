<?php

/* 
 * Conteúdo privado da disciplina INE5413, utilizada para fins de avaliação.
 * Trabalho: Implementação de uma estrutura de grafos.
 * @user: pizzinatto <pizzinatto22@gmail.com>
 */

require_once './GrafoDirecionado.class.php';
require_once './GrafoMinimo.php';
require_once './Aeroporto.php';
require_once './Trecho.php';

$g = new GrafoDirecionado();

$poa = new Aeroporto("POA");
$fln = new Aeroporto("FLN");
$cwb = new Aeroporto("CWB");
$vcp = new Aeroporto("VCP");
$cgh = new Aeroporto("CGH");
$gig = new Aeroporto("GIG");
$gru = new Aeroporto("GRU");
$igu = new Aeroporto("IGU");


$g->adicionaVertice($poa);
$g->adicionaVertice($fln);
$g->adicionaVertice($cwb);
$g->adicionaVertice($vcp);
$g->adicionaVertice($cgh);
$g->adicionaVertice($gig);
$g->adicionaVertice($gru);
$g->adicionaVertice($igu);


//FLN-IGU
$g->conecta($fln, $vcp, new Trecho(637.57,new DateTime('2014-05-14 07:45:00'),new DateTime('2014-05-14 08:59:00'),1,"AZUL"));
$g->conecta($vcp, $igu, new Trecho(637.57,new DateTime('2014-05-14 13:28:00'),new DateTime('2014-05-14 15:10:00'),1,"AZUL"));

$g->conecta($fln, $vcp, new Trecho(637.57,new DateTime('2014-05-14 11:18:00'),new DateTime('2014-05-14 12:37:00'),2,"AZUL"));
$g->conecta($vcp, $igu, new Trecho(637.57,new DateTime('2014-05-14 13:28:00'),new DateTime('2014-05-14 15:10:00'),2,"AZUL"));

$g->conecta($fln, $cgh, new Trecho(786.57,new DateTime('2014-05-14 00:05:00'),new DateTime('2014-05-14 07:15:00'),3,"TAM"));
$g->conecta($gru,$igu , new Trecho(786.57,new DateTime('2014-05-14 13:35:00'),new DateTime('2014-05-14 15:05:00'),3,"TAM"));

$g->conecta($fln,$gig , new Trecho(786.57,new DateTime('2014-05-14 06:43:00'),new DateTime('2014-05-14 08:13:00'),4,"TAM"));
$g->conecta($gig,$igu , new Trecho(786.57,new DateTime('2014-05-14 16:19:00'),new DateTime('2014-05-14 18:26:00'),4,"TAM"));

$g->conecta($fln,$gru , new Trecho(786.57,new DateTime('2014-05-14 09:45:00'),new DateTime('2014-05-14 10:55:00'),5,"TAM"));
$g->conecta($gru,$igu , new Trecho(786.57,new DateTime('2014-05-14 13:35:00'),new DateTime('2014-05-14 15:05:00'),5,"TAM"));

$g->conecta($fln,$cgh , new Trecho(786.57,new DateTime('2014-05-14 10:25:00'),new DateTime('2014-05-14 11:33:00'),6,"TAM"));
$g->conecta($cgh,$igu , new Trecho(786.57,new DateTime('2014-05-14 13:43:00'),new DateTime('2014-05-14 15:24:00'),6,"TAM"));

$g->conecta($fln,$gig , new Trecho(786.57,new DateTime('2014-05-14 10:28:00'),new DateTime('2014-05-14 10:28:00'),7,"TAM"));
$g->conecta($gig,$igu , new Trecho(786.57,new DateTime('2014-05-14 16:19:00'),new DateTime('2014-05-14 18:26:00'),7,"TAM"));

$g->conecta($fln,$cgh , new Trecho(786.57,new DateTime('2014-05-14 11:50:00'),new DateTime('2014-05-14 12:57:00'),8,"TAM"));
$g->conecta($cgh,$igu , new Trecho(786.57,new DateTime('2014-05-14 13:43:00'),new DateTime('2014-05-14 15:24:00'),8,"TAM"));

$g->conecta($fln,$gru , new Trecho(786.57,new DateTime('2014-05-14 13:47:00'),new DateTime('2014-05-14 15:05:00'),9,"TAM"));
$g->conecta($gru,$igu , new Trecho(786.57,new DateTime('2014-05-14 23:55:00'),new DateTime('2014-05-15 01:40:00'),9,"TAM"));

$g->conecta($fln,$cgh , new Trecho(786.57,new DateTime('2014-05-14 16:55:00'),new DateTime('2014-05-14 17:56:00'),10,"TAM"));
$g->conecta($gru,$igu , new Trecho(786.57,new DateTime('2014-05-14 23:55:00'),new DateTime('2014-05-15 01:40:00'),10,"TAM"));

$g->conecta($fln,$gru , new Trecho(786.57,new DateTime('2014-05-14 19:53:00'),new DateTime('2014-05-14 01:40:00'),11,"TAM"));
$g->conecta($gru,$igu , new Trecho(786.57,new DateTime('2014-05-14 23:55:00'),new DateTime('2014-05-15 01:40:00'),11,"TAM"));

$g->conecta($fln,$gru , new Trecho(786.57,new DateTime('2014-05-14 08:00:00'),new DateTime('2014-05-14 09:05:00'),12,"GOL"));
$g->conecta($gru,$igu , new Trecho(786.57,new DateTime('2014-05-14 11:15:00'),new DateTime('2014-05-14 12:37:00'),12,"GOL"));


//FLN-SAO
$g->conecta($fln,$gru , new Trecho(136.57,new DateTime('2014-05-14 11:23:00'),new DateTime('2014-05-14 12:25:00'),13,"AVIANCA"));
$g->conecta($fln,$gru , new Trecho(136.57,new DateTime('2014-05-14 15:42:00'),new DateTime('2014-05-14 16:55:00'),14,"AVIANCA"));
$g->conecta($fln,$cgh , new Trecho(141.57,new DateTime('2014-05-14 08:50:00'),new DateTime('2014-05-14 09:58:00'),15,"GOL"));
$g->conecta($fln,$cgh , new Trecho(141.57,new DateTime('2014-05-14 10:06:00'),new DateTime('2014-05-14 11:36:00'),16,"GOL"));
$g->conecta($fln,$cgh , new Trecho(141.57,new DateTime('2014-05-14 11:43:00'),new DateTime('2014-05-14 12:45:00'),17,"GOL"));
$g->conecta($fln,$cgh , new Trecho(141.57,new DateTime('2014-05-14 20:53:00'),new DateTime('2014-05-14 21:58:00'),18,"GOL"));
$g->conecta($fln,$gig , new Trecho(141.57,new DateTime('2014-05-14 06:33:00'),new DateTime('2014-05-14 08:11:00'),19,"GOL"));
$g->conecta($gig,$gru , new Trecho(141.57,new DateTime('2014-05-14 09:47:00'),new DateTime('2014-05-14 10:40:00'),19,"GOL"));
$g->conecta($fln,$gru , new Trecho(141.57,new DateTime('2014-05-14 11:26:00'),new DateTime('2014-05-14 12:50:00'),20,"GOL"));

//SAO-IGU
$g->conecta($vcp,$gig , new Trecho(279.55,new DateTime('2014-05-14 18:19:00'),new DateTime('2014-05-14 19:19:00'),21,"GOL"));
$g->conecta($gig,$igu , new Trecho(279.55,new DateTime('2014-05-14 22:00:00'),new DateTime('2014-05-14 23:59:00'),21,"GOL"));

$g->conecta($gru,$igu , new Trecho(417.55,new DateTime('2014-05-14 23:40:00'),new DateTime('2014-05-15 01:25:00'),22,"TAM"));
$g->conecta($gru,$igu , new Trecho(417.55,new DateTime('2014-05-14 23:55:00'),new DateTime('2014-05-15 01:40:00'),23,"AZUL"));
$g->conecta($vcp,$igu , new Trecho(434.55,new DateTime('2014-05-14 13:28:00'),new DateTime('2014-05-14 15:10:00'),24,"AZUL"));

$g->conecta($vcp,$cwb , new Trecho(434.55,new DateTime('2014-05-14 16:05:00'),new DateTime('2014-05-14 17:17:00'),25,"AZUL"));
$g->conecta($cwb,$igu , new Trecho(434.55,new DateTime('2014-05-14 23:07:00'),new DateTime('2014-05-15 00:23:00'),25,"AZUL"));

$g->conecta($vcp,$cwb , new Trecho(434.55,new DateTime('2014-05-14 18:10:00'),new DateTime('2014-05-14 19:09:00'),26,"AZUL"));
$g->conecta($cwb,$igu , new Trecho(454.55,new DateTime('2014-05-14 23:07:00'),new DateTime('2014-05-15 00:23:00'),26,"AZUL"));

$g->conecta($vcp,$cwb , new Trecho(483.55,new DateTime('2014-05-14 06:20:00'),new DateTime('2014-05-14 07:18:00'),27,"AZUL"));
$g->conecta($cwb,$igu , new Trecho(483.55,new DateTime('2014-05-14 10:52:00'),new DateTime('2014-05-14 12:16:00'),27,"AZUL"));

$g->conecta($vcp,$cwb , new Trecho(483.55,new DateTime('2014-05-14 07:00:00'),new DateTime('2014-05-14 07:58:00'),28,"AZUL"));
$g->conecta($cwb,$igu , new Trecho(483.55,new DateTime('2014-05-14 10:52:00'),new DateTime('2014-05-14 12:16:00'),28,"AZUL"));

$g->conecta($vcp,$cwb , new Trecho(483.55,new DateTime('2014-05-14 08:40:00'),new DateTime('2014-05-14 09:48:00'),29,"AZUL"));
$g->conecta($cwb,$igu , new Trecho(483.55,new DateTime('2014-05-14 10:52:00'),new DateTime('2014-05-14 12:16:00'),29,"AZUL"));



//CWB-IGU
$g->conecta($cwb,$gru , new Trecho(223.57,new DateTime('2014-05-14 21:13:00'),new DateTime('2014-05-14 22:30:00'),30,"GOL"));
$g->conecta($gru,$igu , new Trecho(223.57,new DateTime('2014-05-14 23:40:00'),new DateTime('2014-05-15 01:25:00'),30,"GOL"));
$g->conecta($cwb,$gru , new Trecho(291.57,new DateTime('2014-05-14 12:16:00'),new DateTime('2014-05-14 13:55:00'),31,"GOL"));
$g->conecta($gru,$igu , new Trecho(291.57,new DateTime('2014-05-14 15:45:00'),new DateTime('2014-05-14 17:40:00'),31,"GOL"));


//Conecta os aeroportos de SAO
$g->conecta($vcp,$gru , new Trecho(0,new DateTime('2014-05-14 00:00:00'),new DateTime('2014-05-14 00:00:00'),32,"ONIBUS"));
$g->conecta($vcp,$cgh , new Trecho(0,new DateTime('2014-05-14 00:00:00'),new DateTime('2014-05-14 00:00:00'),32,"ONIBUS"));

$g->conecta($gru,$vcp , new Trecho(0,new DateTime('2014-05-14 00:00:00'),new DateTime('2014-05-14 00:00:00'),32,"ONIBUS"));
$g->conecta($gru,$cgh , new Trecho(0,new DateTime('2014-05-14 00:00:00'),new DateTime('2014-05-14 00:00:00'),32,"ONIBUS"));

$g->conecta($cgh,$gru , new Trecho(0,new DateTime('2014-05-14 00:00:00'),new DateTime('2014-05-14 00:00:00'),32,"ONIBUS"));
$g->conecta($cgh,$vcp , new Trecho(0,new DateTime('2014-05-14 00:00:00'),new DateTime('2014-05-14 00:00:00'),32,"ONIBUS"));


////****
echo "<pre>";
//print_r($g);
echo "</pre><hr>";


$minimo = new GrafoMinimo($g,array($cwb,$gig,$poa));
echo "<pre>";
print_r($minimo);
echo "</pre><hr>";

echo "<pre>";
print_r($minimo->caminhoMinimo($fln, $igu, 2));
echo "</pre><hr>";