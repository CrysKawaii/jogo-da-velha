<?php // abertura de uma tag PHP

if (!function_exists('pre')) // estrutura condicional que cria a função caso ela não exista
{
    function pre($data = '') // inicialização da função pre que tem um parâmetro opcional que se não for preenchido com nada recebe a string vazia (GPT)
    {
        echo '<pre style="margin:5px; opacity:0.95; border-radius:0; box-shadow: 1px 3px 5px 1px #888888; background-color:#282828; color:#EF4136; padding:10px; border-style:hidden hidden hidden inset; border-width:5px; border-color:#FF4B4B;">'; // impressão de uma tag HTML com um style para melhor entendimento do conteúdo
        print_r($data); // exibição do conteúdo do parâmetro com a função print_r do PHP
        echo '</pre>'; // fechamento da tag HTML através de um echo PHP
    };
}

function gera_icone($jogador_atual) // declaração da função que exibe o ícone no botão quando pressionado ou não com o parâmetro que recebe o jogador atual para ter a informação de quem estar jogado e a qual necessidade atender
{
    $icone = ''; // inicialização da variável que receberá o ícone que será implementado no botão através dessa mesma 
    switch ($jogador_atual) // criação de um switch para a troca de valores e adição de casos na variável $jogador_atual;
    {
        case 1: // caso seja o valor um
            $icone = "fa-xmark"; // a variável $icone receberá a string que diz referência ao ícone do site fontawasome
            break; // parada obrigatória que todo case tem que ter (sei apenas isso)
        case 2:
            $icone = "fa-circle"; // a variável $icone receberá a string que diz referência ao ícone do site fontawasome
            break; // mais uma parada obrigatória que todo case tem que ter (sei apenas isso)
        default:
            $icone = "fa-minus"; // a variável $icone receberá a string que diz referência ao ícone do site fontawasome
            break; // outra parada obrigatória que todo case tem que ter (sei apenas isso)
    }
    return $icone; // aqui eh retornado o valor da variável $icone onde será subtituído pela string
}
