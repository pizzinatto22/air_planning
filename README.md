# DESCRIÇÃO DO PROBLEMA

O problema a ser resolvido pretende descobrir a rota aérea mais barata para chegar de um aeroporto à outro, dada algumas características.

Abaixo será descrito o problema e depois proposto um modelo de grafos que o represente.

A dinâmica das passagens aéreas no Brasil e no mundo é muito diversa e os preços não são regidos por tabela. A origem/destino, horário de busca, existência de promoções, feriados próximos, dia da semana (do voo) e outros itens podem interferir na composição do preço. Cidades turísticas tendem a apresentar um preço mais elevado em suas tarifas. Quando a origem e destino são turísticos, o preço fica ainda maior. Um dos casos que se enquadra nessa situação é Florianópolis → Foz do Iguaçu.

Em pesquisa feita no site decolar.com no dia 09/05/2014, os preços com origem no Aeroporto Internacional Hercílio Luz (FLN) e destino no Aeroporto Internacional de Foz do Iguaçu/Cataratas (IGU) para voos no dia 14/05/2014 eram:

| # | Empresa | Ori1 | Dest1 | Voo1 | Hora Saída1 | Hora Chegada1 | Ori2 | Dest2 | Voo2 | Hora Saída2 | Hora Chegada2 | Duração Total | Valor(R$) | Taxa Emb. (R$) | ValorFinal (R$) |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | Azul | FLN | VCP | 4120 | 07:45 | 08:59 | VCP | IGU | 4491 | 13:28 | 15:10 | 7:25 | 616 | 21.57 | 637.57 |
| 2 | Azul | FLN | VCP | 4064 | 11:18 | 12:37 | VCP | IGU | 4491 | 13:28 | 15:10 | 7:25 | 616 | 21.57 | 637.57 |
| 3 | TAM | FLN | CGH | 3100 | 06:05 | 07:!5 | GRU | IGU | 3559 | 13:35 | 15:05 | 9:00 | 765 | 21.57 | 786.57 |
| 4 | TAM | FLN | GIG | 3418 | 06:43 | 08:13 | GIG | IGU | 3187 | 16:19 | 18:26 | 11:43 | 765 | 21.57 | 786.57 |
| 5 | TAM | FLN | GRU | 3112 | 09:45 | 10:55 | GRU | IGU | 3559 | 13:35 | 15:05 | 5:20 | 765 | 21.57 | 786.57 |
| 6 | TAM | FLN | CGH | 3102 | 10:25 | 11:33 | CGH | IGU | 3340 | 13:43 | 15:24 | 4:59 | 765 | 21.57 | 786.57 |
| 7 | TAM | FLN | GIG | 3410 | 10:28 | 12:23 | GIG | IGU | 3187 | 16:19 | 18:26 | 7:58 | 765 | 21.57 | 786.57 |
| 8 | TAM | FLN | CGH | 3347 | 11:50 | 12:57 | CGH | IGU | 3340 | 13:43 | 15:24 | 3:34 | 765 | 21.57 | 786.57 |
| 9 | TAM | FLN | GRU | 3184 | 13:47 | 15:05 | GRU | IGU | 3557 | 23:55 | 01:40 | 11:53 | 765 | 21.57 | 786.57 |
| 10 | TAM | FLN | CGH | 3104 | 16:55 | 17:56 | GRU | IGU | 3557 | 23:55 | 01:40 | 8:45 | 765 | 21.57 | 786.57 |
| 11 | TAM | FLN | GRU | 3414 | 19:53 | 21:05 | GRU | IGU | 3557 | 23:55 | 01:40 | 5:47 | 765 | 21.57 | 786.57 |
| 12 | GOL | FLN | GRU | 2161 | 08:00 | 09:05 | GRU | IGU | 1380 | 11:15 | 12:37 | 4:37 | 765 | 21.57 | 786.57 |

(como não existem voos diretos, foram considerados apenas voos com 1 escala)

Lembrando apenas que essas passagens são emitidas com os dois trechos no mesmo bilhete. Nos casos da TAM, onde um dos trechos chega em Congonhas, a companhia oferece ônibus grátis para transferência para Guarulhos.

Agora, fazendo a pesquisa de passagens apenas de Florianópolis →São Paulo

| # | Empresa | Ori1 | Dest1 | Voo1 | Hora Saída1 | Hora Chegada1 | Ori2 | Dest2 | Voo2 | Hora Saída2 | Hora Chegada2 | Duração Total | Valor(R$) | Taxa Emb. (R$) | ValorFinal (R$) |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | Avianca | FLN | GRU | 6261 | 11:23 | 12:25 |   |   |   |   |   | 1:02 | 115 | 21.57 | 136.57 |
| 2 | Avianca | FLN | GRU | 6175 | 15:42 | 16:55 |   |   |   |   |   | 1:13 | 115 | 21.57 | 136.57 |
| 3 | Gol | FLN | CGH | 1503 | 08:50 | 09:58 |   |   |   |   |   | 1:08 | 120 | 21.57 | 141.57 |
| 4 | Gol | FLN | CGH | 1679 | 10:06 | 11:36 |   |   |   |   |   | 1:30 | 120 | 21.57 | 141.57 |
| 5 | Gol | FLN | CGH | 1507 | 11:43 | 12:45 |   |   |   |   |   | 1:02 | 120 | 21.57 | 141.57 |
| 6 | Gol | FLN | CGH | 1513 | 20:53 | 21:58 |   |   |   |   |   | 1:05 | 120 | 21.57 | 141.57 |
| 7 | Gol | FLN | GIG | 1915 | 06:33 | 08:11 | GIG | GRU | 1743 | 09:47 | 10:40 | 4:07 | 120 | 21.57 | 141.57 |
| 8 | Gol | FLN | GRU | 1265 | 11:26 | 12:50 |   |   |   |   |   | 1:24 | 120 | 21.57 | 141.57 |



E São Paulo → Foz do Iguaçu

| # | Empresa | Ori1 | Dest1 | Voo1 | Hora Saída1 | Hora Chegada1 | Ori2 | Dest2 | Voo2 | Hora Saída2 | Hora Chegada2 | Duração Total | Valor(R$) | Taxa Emb. (R$) | ValorFinal (R$) |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | Gol | VCP | GIG | 1761 | 18:19 | 19:19 | GIG | IGU | 1462 | 22:00 | 23:59 | 5:40 | 257 | 22.55 | 279.55 |
| 2 | Gol | GRU | IGU | 1384 | 23:40 | 01:25 |   |   |   |   |   | 1:45 | 395 | 22.55 | 417.55 |
| 3 | Tam | GRU | IGU | 3557 | 23:55 | 01:40 |   |   |   |   |   | 1:45 | 395 | 22.55 | 417.55 |
| 4 | Azul | VCP | IGU | 4491 | 13:28 | 15:10 |   |   |   |   |   | 1:42 | 412 | 22.55 | 434.55 |
| 5 | Azul | VCP | CWB | 4017 | 16:05 | 17:17 | CWB | IGU | 4460 | 23:07 | 00:23 | 8:18 | 412 | 22.55 | 434.55 |
| 6 | Azul | VCP | CWB | 4137 | 18:10 | 19:09 | CWB | IGU | 4460 | 23:07 | 00:23 | 6:13 | 432 | 22.55 | 454.55 |
| 7 | Azul | VCP | CWB | 4081 | 06:20 | 07:18 | CWB | IGU | 4156 | 10:52 | 12:16 | 5:56 | 461 | 22.55 | 483.55 |
| 8 | Azul | VCP | CWB | 2500 | 07:00 | 07:58 | CWB | IGU | 4156 | 10:52 | 12:16 | 5:16 | 461 | 22.55 | 483.55 |
| 9 | Azul | VCP | CWB | 4284 | 08:40 | 09:48 | CWB | IGU | 4156 | 10:52 | 12:16 | 3:36 | 461 | 22.55 | 483.55 |



Aparentemente, um local que despacha vários voos para Foz do Iguaçu é Curitiba. Assim, considera-se válido voos que saiam de Curitiba e façam escala em São Paulo.

| # | Empresa | Ori1 | Dest1 | Voo1 | Hora Saída1 | Hora Chegada1 | Ori2 | Dest2 | Voo2 | Hora Saída2 | Hora Chegada2 | Duração Total | Valor(R$) | Taxa Emb. (R$) | ValorFinal (R$) |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | Gol | CWB | GRU | 1933 | 21:13 | 22:30 | GRU | IGU | 1384 | 23:40 | 01:25 | 04:12 | 202 | 21.57 | 223.57 |
| 2 | Gol | CWB | GRU | 1925 | 12:16 | 13:35 | GRU | IGU | 1382 | 15:45 | 17:40 | 05:25 | 270 | 21.57 | 291.57 |



Veja que a mesmo comprando separadamente o trecho mais caro de FLN-SAO e o mais caro de SAO-IGU, (R$ 141.57+ R$ 483.55), eles saem por R$ 625.12, o que é inferior que o trecho mais barato quando  a passagem é comprada de uma única vez (em um único bilhete), que sai por R$ 637.57 (claro que para fazer essa combinação, devem ser considerados os horários e aeroportos de chegada e saída).

Melhorando ainda esse preço, veja que seguintes combinações podem ser feitas:

| # | Bilhete 1 adquirido | Trechos utilizados | Valor | Bilhete 2 adquirido | Trechos Utilizados | Valor | Valor Final |
| --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | FLN-GIG-GRU06:33-08:11 e 09:47-10:40 | FLN-GIG06:33-08:11 | 141.57 | VCP-GIG-IGU18:19-19:19 e 22:00-23:59 | GIG-IGU22:00-23:59 | 279.55 | 421.12 |
| 2 | FLN-GRU15:42-16:55 | FLN-GRU11:23-12:25 | 136.57 | CWB-GRU-IGU21:13-22:30 e 23:40-01:25 | GRU-IGU23:40-01:25 | 223.57 | 360.14 |

Esta tabela indica que é possível comprar um bilhete com vários trechos, mas usar apenas alguns. Na primeira linha, foi sugerido utilizar apenas o trecho FLN-GIG do primeiro bilhete e o GIG-IGU do segundo bilhete. Perceba que esta indicação não entra em méritos burocráticos como despacho de bagagem (ela só pode ser despachada no primeiro aeroporto e retirada no ultimo) ou efeito de atraso (se o primeiro trecho atrasar a ponto de perder o segundo trecho, a outra companhia não tem obrigação de reacomodá-lo em outro voo). O único objetivo aqui é mostrar que existem outras opções de compra que podem fazer consumidor economizar.



# MODELO SUGERIDO

O modelo para representar a situação real é:

Um grafo `G=(V,A)`, onde
```
	V = {x|x representa um aeroporto}
	A = {t= (x1, x2, preço, data e hora de partida, data e hora de chegada, companhia, número do bilhete) |
			t representa uma ligação feita por uma empresa utilizando um meio de transporte
			entre o aeroporto x1 e x 2 (sem escalas, conexões ou baldeações entre eles) e
				- Preço é o valor pago pelo bilhete da passagem
				- Data e hora da partida é o horário que o meio de transporte parte de x1
				- Data e hora de chegada é o horário que o meio de transporte chega em x2
				- Companhia é o nome da companhia que realizará o trecho
				- Número do bilhete  é um identificador do bilhete de passagem
		}
```

# SOLUÇÃO

A solução do problema consiste em popular o grafo sugerido com os trechos disponíveis ligando dois aeroportos. Os bilhetes com conexão devem ser inseridos com com o mesmo _número de bilhete_.

No caso dos aeroportos de São Paulo, deve ser inserido um bilhete entre cada um um com preço zero, indicando que o passageiro pode se deslocar, por exemplo, de Guarulhos a Congonhas gratuitamente.

No caso de aeroportos próximos, como de Navegantes e Florianópolis, ou Foz do Iguaçu e Cascavel pode ser utilizado o mesmo recurso. Isso indica que trechos que chagam e partem entre esses aeroportos são equivalentes.

Depois disso, um grafo reduzido deve ser calculado, onde cada vértice é uma componente fortemente conexa do grafo anterior, e as arestas são as arestas do grafo anterior que ligam vértices que estão CFCs diferentes.

A partir do grafo reduzido, calcular todos os trechos partindo do aeroporto de origem até o aeroporto de destino.

Neste caso, o algoritmo de custo mínimo não pode ser utilizado, pois como o modelo representa um multi-grafo, a escolha do trecho mais barato entre 2 aeroportos intermediários não garante o menor preço global, pois o horário pode ser limitante (a escolha de um trecho mais barato pode forçar a escolher um trecho caro no próximo aeroporto).

Depois de calculados todos os trechos (com uma estratégia de busca em profundidade, por exemplo), deve ser selecionado o mais barato e apresentado para o usuário.

Durante a busca dos caminhos, deve ser levado em consideração um intervalo de tempo mínimo entre os voos, para que seja possível efetuar a troca de aeronave com segurança.
