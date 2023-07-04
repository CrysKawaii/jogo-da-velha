<?php // abertura da tag PHP
require_once 'functions.php'; // requerimento do arquivo onde se tem as funções 

$array_historico = explode(' | ', $_POST['historico']); // declaração da variável onde vai ter o array contendo o histórico de jogadas com as posiçãoes passdas através do métdo post do arquivo index, sendo feito o explode, ou seja, separando os valores das chaves para uma melhor compreensão e formatação
$array_historico_tratado = []; // inicialização do array onde se vai ter todos os valores tratados bonitinho
foreach ($array_historico as $valor_array) // começo de um laço de repetição onde serã tratado cada valor do array (posição que o jogador clicou e quem foi o jogador)
{
    $array = explode('=', $valor_array); // separação da posição e do jogador e armazenamento do dado que indica o jogador na variável $array
    $chave = $array[0]; // pega o valor do índice 0 do array $array (que nesse caso eh a posição que o jogador clicou) e colocana na variável chave
    @$valor = $array[1]; // pega o valor jo jogador que jogou (quem foi o jogador) e armazena dentro da variável $chave
    $array_historico_tratado[$chave] = $valor; // eh feita a atribuição dos valores para a variável que tem os dados tratados, recebendo como índice a chave do array que contém o histórico e o valor que eh o valor mesmo do $array_historico só que separadamente para um melhor entendimento
}

array_pop($array_historico_tratado); // eh feita a remoção do último intem do array porque ele sempre vem vazio (penso que eh o efeito de clicar no botão e ser feito o redirecionamento da página, por isso não conta como sendo clicado e passado as coordenadas)
unset($_POST['historico']); // eliminar o valor do campo histórico do formulário enviado (GPT), para poder usar a superglobal novamente sem se preocupar com os valores do histórico
$jogada_atual = array_keys($_POST)[0]; // pega o índice 0 (jogada, onde o jogador clicou) e coloca na variável $jogada_atual
$array_historico_tratado[$jogada_atual] = $_POST[$jogada_atual]; // adidiona o valor da jogada atual ao array tratado para ficar completo com todas as informações
$url = "https://jogo-da-velha-kappa-dusky.vercel.app/api/index.php?"; // declara a variável url que será utilizada para o redirecionamento da página principal com os parâmetros na URL que poderam ser passados e conseguidos para usar como dados para o tratamento dos mesmo no index.php

foreach ($array_historico_tratado as $posicao => $jogador) // começo de um laço que varre o array tratado tratando a posição e o jogador
{
    $url .= "coordenadas[$posicao]=$jogador&"; // faz a incrementação a cada loop no laço colocando as informações da posição e do jogador que acabou de jogar
}

$url .= "jogador=$jogador"; // implementa o parâmetro jogador para identificar o último jogador porque no laço acima apesar de incrementar o jogador não eh o suficiente para informar o programa quem será o príxmo por isso eh feita essa atribuição aqui
                                
$combinacoes_vencedoras = [ ['0-0', '0-1', '0-2'], //combinações vencedoras usadas para identificar o possível ganhador de acordo com as jogadas dele
                            ['1-0', '1-1', '1-2'], //<<<^^
                            ['2-0', '2-1', '2-2'], //<<<^^
                            ['0-0', '1-0', '2-0'], //<<<^^
                            ['0-1', '1-1', '2-1'], //<<<^^
                            ['0-2', '1-2', '2-2'], //<<<^^
                            ['0-0', '1-1', '2-2'], //<<<^^
                            ['0-2', '1-1', '2-0']  //<<<^^
                          ];

$jogador1 = []; // inicialização do array que contém as jogadas do jogador 1
$jogador2 = []; // inicialização do array que contém as jogadas do jogador 2
$vencedor = ''; // declaração da variável onde será armazenado o dado do vencendor (muito importante)
foreach ($combinacoes_vencedoras as $combinacao) // começo de um laço de repetiação que irá passar por cada combinção das combinações vencendoras
{
    $jogador1 = []; // aqui a variável eh reiniciada porque estava saindo réplicas desnecessárias dela por causa do laço de repetição, então eu reinicio para ficara somente os valores um vez só
    $jogador2 = []; // mesma coisa da variável $jogador1
    foreach ($combinacao as $par) // laço de repetilçao que passa por cada combinação pegado os pares delas
    {
        if (in_array($par, array_keys($array_historico_tratado))) // faz a checagem do array tratado para ver se bate com algum par das combições vencedoras 
        {
            if ($array_historico_tratado[$par] == 2) // faz a verificação do jogador que fez a jogada para ver se foi o 2
            {
                $jogador2[] = $par; // se tiver sido o jogador 2 então eh adicionado a jogada (posição da jogada) no array do jogador 2
            }
            else if ($array_historico_tratado[$par] == 1) // faz a checagem para ver se foi o jogador 1 que joogou
            {
                $jogador1[] = $par; // se foi o jogador 1 então eh colocado a jogada dele (posição da jogada) no array do jogador 1
            }
        }
        
    }

    if (count($jogador2) === count($combinacao)) // faz a verificação para confirmar se as jogadas acertadas pelo jogador 2 são as suficientes para definir uma combinação vencedora
    {
        $vencedor = 'jogador2'; // caos a condição seja true então a variável $vencendor eh implementada com a string jogador2
    }
    else if (count($jogador1) === count($combinacao)) // checa se o jogador 1 fez a combição vencedora
    {
        $vencedor = 'jogador1'; // caso tenha feito então a variável $vencedor receber a string jogador1 como valor
    }
}

$url .= "&ganhador=$vencedor"; // a variável eh incrementada com o parâmetro ganhador tendo como valor o valor da variável $vencedor, sendo jogador1 ou jogador2
header("Location: $url", true); // redireciona o usuário para a página principal do jogo modificando o cabeçalho HTTP do navegador para a URL especificada, nesse caso ela está na variável $url que contém TODOS os dados necessários para o jogo da velha funcionar corretamente, e esse TRUE indica se o cabeçalho enviado deve subtituir qualquer outro cabeçalho de mesmo nome. (GPT)
