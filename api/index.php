<!DOCTYPE html> <!-- essa linha eh para informar ao navegador que a versão que está sendo utilizada da HTML eh a 5 -->
<html lang="pt-br" class="overflow-hidden"> <!-- essa linha está sendo utilizada para indicar qual linguagem está o site e para esconder a barra lateral através de uma classe do Boostrap -->
<head> <!-- essa linha eh para abrir a tag head que é a 'cabeça' da HTML, onde fica as meta-informações ou meta-tags, como preferir -->
    <meta charset="UTF-8"> <!-- essa linha indica que a codificação dos caracteres está no código UTF-8 que suporta todos os tipos de acento e símbolos -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- essa linha eh para a escala da página caber certinho e se adapatar a tela do usuário e ao navegador -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> <!-- essas duas linhas são os links referentes ao framework BOOSTRAP que funcionam através da CDN -->
    <script src="https://kit.fontawesome.com/c1ea196d9b.js" crossorigin="anonymous"></script> <!-- esse eh o script do site de ícones que faz os ícones aparecerem  -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"> <!-- este eh o link do favicon (ícone), que fica na tab do navegador -->
    <title>Jogo da Velha</title> <!-- essa eh a tag que coloca o título na página que fica ao lado do favicon -->
    <?php // essa linha eh a abertura da tag PHP que faz o código em PHP funcionar dentro do HTMl
        require_once 'functions.php'; // esse eh o comeando que faz o requerimento de outro arquivo para esse arquivo para poder ser utilizado as funções e outras propriedades desse outro arquivo nesse arquivo aqui
        
        $ultimo_jogador = $_GET['jogador'] ?? 2; // declaração da variável que guarda quem foi o último jogador, caso não tenha nenhum então automaticamente ela recebe o valor 2
        $jogador_atual = $ultimo_jogador == 1 ? 2 : 1; //declaração da variável que informa o jogador atual de acordo com o último jogador, que caso for 1 muda para 2 e se já for 2 muda para 1
        $historico = ''; // declaração da variável onde ficará guardado o histórico da partida
        $coordenadas = []; // declaração da variável onde fica as coordenadas de onde o jogador clicou (qual botão foi pressionado)
        $get_coordenadas = $_GET['coordenadas'] ?? []; // declaração da variável que traz as coordenadas da URL e caso não venha nada então eh dado um array vazio
        $vencedor = $_GET['ganhador'] ?? 'ninguem'; //pega da URL o parâmetro que avisa se houve um ganhador
        $empate = 0; // declaração da variável usada para a situação de empate no jogo
        $ganhador = ''; // declaração da variável que armazena a ganhador 
        if ($vencedor == 'jogador2') // começa uma estrutura condicional onde eh checado se a variável $vencedor tem o valor sendo igual a jogador2
        {
            $ganhador = 'J2'; // bloco de comando que eh executado caso a condição do IF seja verdadeira,sendo ela true a variável $ganhador irá receber a string 
        }
        else if ($vencedor == 'jogador1') // caso a primeira condição seja falsa a estrutura passará para essa debaixo onde irá ser feita a checagem na variável $vencedor novamenta mas agora com o valor sendo igual a jogador1
        {
            $ganhador = 'J1'; // bloco de comando onde será atribuido o valor J1 a variável ganhador caso a condição acima seja verdadeira
            
        }
        else if ($vencedor == 'ninguem') // caso a de cima for falsa também, o programa irá executar essa checagem mas com o valor sendo igual a ninguem
        {
            $ganhador = ''; // bloco onde será atribuido o valor vazio a variável ganhador porque não houve ganhador
        }

        foreach ($get_coordenadas as $posicao => $jogador) // estrutura de repetição que varre o array com as coordenadas tratados os valores $posicao como as chaves e $jogador como os valores do array
        {
            $historico .= "$posicao=$jogador | "; // faz a incrementação na variável onde fica armazenada o histórico colocando a posição e o jogador no array a cada loop executado
            $coordenadas[$posicao] = $jogador; // atrbui ao parâmetro posicao o valor do jogador que jogou nessa posição
        }
    ?>
</head> <!-- fechamento da tag head da HTML -->
<body> <!-- abertura da tag do corpo da página -->
    <h1 class="text-center pt-4"># Jogo da Velha #</h1> <!-- Colocação do título ao conteúdo dentro da página -->
    <form action="logica.php" method="post"> <!-- inicialização de um formulário com a ação do arquivo logica.php usando o método post -->
        <input type="hidden" name="historico" value="<?= $historico ?>"> <!-- input sendo usado com o tipo escondido apenas para enviar (submeter) os dados da variável $historico para o arquivo logica.php onde serão tratados os dados (GPT) -->
        <?php for ($i = 0; $i < 3; $i++): ?> <!-- abertura e fechamento da tag PHP junto com a inicializaçõ de um laço de repetiçao que vai ser repetido 3 vezes -->
            <div class="row text-center"> <!-- criação de uma div com a classe row (linha) que vem do BS para o estilo de linhas e tabelas, também a classe que centraliza os textos dessa div -->
                <div class="col-3"></div> <!-- criação de outra div com a classe col-3 (tamanho 3 de coluna) do BS que indica que essa div irá ocupar o espaço equivalente a 3 colunas de uma linha (de acordo com o BS) -->
                <?php for ($k = 0; $k < 3; $k++): ?> <!-- abertura e fechamento de uma tag PHP junto com outra inicizalizaçõ de um laço que também irá se repetir 3 vezes  -->
                    <div class="col-2"> <!-- criação de uma div com a classe col-2 que eh indica que essa div irá ocupar o espaço de 2 colunas na linha -->
                        <button name="<?= $i . '-' .  $k ?>" class="btn bg-secondary my-4 w-100 h-75 text-white <?= @$coordenadas["$i-$k"] !== null || $ganhador == 'J1' || $ganhador == 'J2' ? "disabled" : ''?> <?php @$coordenadas["$i-$k"] !== null ? $empate += 1 : '' ?>"
                        value="<?= $jogador_atual ?>"> <!-- abertura de uma tag button que cria um botão, sendo eles os botões do jogo que o usuário pode clicar, ele tem o name sendo a numeração dos laços de repetição de uma forma tratada que são usados como uma forma de passar as coordenadas para serem usadas a fim de complementar a classe que tem os estilos, cores, margem, largura, altura e cor do texto sendo implementados pelo BOOSTRAP. A última implementação eh a que deine se o botão irá ser desabilitado ou não, sendo feita uma checagem usando o operador ternário do PHP onde verifica se a variável coordenadas tendo como chave as posições clicadas pelo usuário de uma forma tratada, ($i-$k) para uma melhor legibilidade e entedimento, caso seja diferente de null, ou seja, caso há valores ali (o usuário tendo clicado e a variável tenha sido atribuida) ou caso a variábel $ganhador tenha o valor sendo igual a J1 ou essa mesma tenha o valor sendo igual a J2 o botão irá receber a implementação de uma classe BS onde ficará desabilitado não podendo ser mais cliacao para evitar mudanças após o jogo e nessa mesma linha ainda há a incrementação da variável $empate que se as coordenadas forem diferentes de null ela terá o valor dela mais um-->
                            <i class="fa-solid
                            <?= gera_icone(@$coordenadas["$i-$k"]) ?>">
                            </i> <!-- aqui eh onde o ícone do botão eh gerado, de acordo com a clicada do jogador (KKKK) -->
                        </button> <!-- fechamento da tag button -->
                    </div> <!-- fechamento da div -->
                <?php endfor ?> <!-- encerramento da estrutura de repetição que gera as linhas -->
                <div class="col-3"></div> <!-- criação de uma div para a complementação do espaço na página para ficar tudo alinhado e bonito e centralizado -->
            </div> <!-- fechamento de uma div -->
        <?php endfor ?> <!-- encerramento do laço que faz as colunas -->
    </form> <!-- fechamento do formulário -->
    <div class="d-flex justify-content-center mt-5"> <!-- criação de uma div com as classes para o alinhamento dela e uma margem encima para não ficar muito colado no jogo -->
        <a class="btn btn-success text-center" href="index.php"><i class="fa-solid fa-arrows-rotate"></i> Reiniciar</a> <!-- aqui eh criado um link em forma de botão que sempre que cliado a página eh recarregada e o jogo eh reiniciado -->
    </div> <!-- fechamento da div -->
    <?php if ($empate == 9 && $vencedor == 'ninguem') : ?> <!-- criação e inicializaçõa de uma estrutura condicional onde eh feita a checagem da variável $empate para ver se o valor dela chegou a nove que caso tenha chegado, isso quer dizer que os botões todos foram clicados e nõa houve ganhador nenum -->
        <script> // abertura da tag script onde eh executado os códigos em JavaScript (tive que usar para exibir os alertas)
            window.onload = function() // função anônima que será chamada automaticamente quando a página for recarregada que mostrará o alerta
            {
                Swal.fire({
                    imageUrl: 'https://www.criarmeme.com.br/i/sapo-triste.jpg',
                    imageWidth: 300,
                    imageHeight: 100,
                    title: 'EMPATE',
                    width: 500,                                                   // estilização do alerta para deixar com a cara de um BR mesmo (HEHEH)
                    padding: '3em',
                    confirmButtonText:'<i class="fa fa-thumbs-up"></i> GG!',
                    color: '#ffffff',
                    background: '#ffa500',
                });
            };
        </script> <!-- fechamento da tag script  -->
    <?php elseif ($vencedor == 'jogador1' || $vencedor == 'jogador2'): ?> <!-- caso a condição de cima não for atendida então o programa irá fazer essa checagem que verifica se a variável $vencedor tem o valor sendo igual a jogador1 ou jogador2 -->
        <script> // abertura de mais uma tag script usada para mostrar o alerta
            window.onload = function() // mais uma vez a função sendo carregada ao recarregar
            {
                Swal.fire({
                    // icon: 'warning',
                    imageUrl: 'https://www.insoonia.com/wp-content/uploads/2013/12/meme-safado.jpg',
                    imageWidth: 300,
                    imageHeight: 100,
                    title: 'JOGADOR ><?= $ultimo_jogador ?>< VENCEU!', // detalhe para essa linha eh que será mostrado um texto com o conteúdo tendo a variável $ultimo_jogdor para não precisar fazer outra condição para outro jogador (HEHE)
                    width: 500,                                                         // outra personalização do melhor estilo BR
                    padding: '3em',
                    confirmButtonText:'<i class="fa fa-thumbs-up"></i> GG!',
                    color: '#ffffff',
                    background: '#ffa500',
                });
            };
        </script> <!-- fechamento da tag script -->
    <?php endif ?> <!-- encerramento da estrutura condicional -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- tag script que carrega via CDN o conteúdo do site sweet alert de modo online para que eu não precise baixar para usar -->
</body> <!-- fechamento da tag do corpot da página -->
</html> <!-- fehcamento da tag HTML inidicando o fim da página -->
    <!-- linha em branco porque acostumei a fazer isso em PYTHON -->