console.log('ARQUIVO flash-mensagem.js CARREGADO');

function esconderMensagem() {

    // Veja sempre o console para saber o que está acontecendo

    // document.getElementsByClassName retorna um array com todos os elementos HTML que possuem a classe passada como parametro
    let divFlashMensagem = document.getElementsByClassName('flash-mensagem');
    console.log('DIVS COM A CLASSE flash-mensagem:', divFlashMensagem);

    // Como no javascript não temos um foreach, vamos utilizar um for para percorrer o array
    // a estrutura é a mesma do foreach do php
    // so lembrando que para criar uma variavel no js é "let i" e não "$i" como no php
    for (let i = 0; i < divFlashMensagem.length; i++) {
        // vamos pegar cada elemento do array e adicionar a classe esconder
        // classList é uma propriedade do javascript que permite adicionar, remover ou verificar se um elemento possui uma classe css
        // se você der console.log(divFlashMensagem[i].classList) vai ver que é um array com todas as classes do elemento
        console.log('CLASSES DO ELEMENTO:', divFlashMensagem[i].classList);
        // Vamos criar a classe "esconder" no css
        divFlashMensagem[i].classList.add('esconder');
    }
}

// setTimeout é uma função do javascript que executa uma função depois de um determinado tempo
// Sempre que a página web é carregada, o javascript executa o código de cima para baixo
// porem o setTimeout é uma exceção, ele executa a função depois do tempo determinado
// no caso 5000 milisegundos ou 5 segundos
// a função que estamos passando para ser executada após 5 segundos é a esconderMensagem
// perceba que estamos passando o nome SEM os parenteses,
// isso é porque estamos passando a referência da função e não o retorno dela
// se passarmos com parenteses a função será executada imediatamente
// e não é isso que queremos
setTimeout(esconderMensagem, 5000);