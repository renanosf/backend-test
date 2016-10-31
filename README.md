<p align="center">
  <a href="http://www.catho.com.br">
      <img src="http://static.catho.com.br/svg/site/logoCathoB2c.svg" alt="Catho"/>
  </a>
</p>
# backend-test

## Projeto

Foi utilizado o framework [codeigniter](https://www.codeigniter.com) e a biblioteca [codeigniter-restserver](https://github.com/chriskacerguis/codeigniter-restserver) para a realização desse projeto 

## Utilização
Para utilizar este projeto basta clonar o repositorio dentro da pasta www do seu apache ou semelhante. Para realizar a busca da vaga faça uma requisição GET para webservice/vagas enviando os parâmetros de busca, cidade e ordem. Todos os parâmetros são opicinais, a ordenação é feita de forma ascendente se nada for enviado, para invertes envie "desc".

1. http://localhost/webservice/vagas?busca=coordenador&cidade=Jose&ordem=desc
2. http://localhost/webservice/vagas?busca=Desenvolvedor%20Java

## Código
A parte principal do código se encontra em catho_application/controllers/Webservice.php
