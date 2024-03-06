
<p align="center">
<a href="hhttps://www.adoorei.com.br/" target="_blank">
<img src="https://adoorei.s3.us-east-2.amazonaws.com/images/loje_teste_logoadoorei_1662476663.png" width="160"></a>
</p>

# Desafio Concluído com sucesso

Olá, prezados!! 😃🚀🚀🚀

É com muita alegria que elaboro esse documento exibindo todos os resultados da construção da nossa API. 
Adorei cada etapa do processo, muito obrigado pelo espaço!!

## Tecnologias utilizadas

1 - Laravel 10 
2 - PHP 8.3.3
3 - Sonarqube
4 - Sqlite
5 - Swagger
6 - Docker
7 - PHPUnit
8 - Ngnix
9 - Supervisor Linux
10 - Git e Composer


## Como usar a API

1 - Configure o seu arquivo hosts para acessar a api pelo endereço correto: 127.0.0.1 abc.app.br
2 - Faça o clone do fork e rode o comando para subir os containers do docker: docker-compose up -d 
3 - Aguarde até carregar os dois containers (Sonarqube e Backend)
4 - Acesse a api no browser: http://abc.app.br/api/products
5 - Acesse aos relatórios de cobertura de testes do Sonarqube em http://localhost:9000

## Rotas & Exemplos 

1 - Listar produtos disponíveis: 
  - Rota http://abc.app.br/api/products

  Exemplo de retorno: 
  ```json
  [
  {
    "name": "Celular 1",
    "price": "1.800",
    "description": "Aparelho dual chip na cor branca"
  },
  {
    "name": "Celular 2",
    "price": "3.200",
    "description": "Aparelho dual chip na cor preta"
  },
  {
    "name": "Celular 3",
    "price": "9.800",
    "description": "Aparelho dual chip na cor azul"
  },
  {
    "name": "Celular 4",
    "price": "3.000",
    "description": "Aparelho dual chip na cor vermelha"
  },
  {
    "name": "Celular 5",
    "price": "3.500",
    "description": "Aparelho dual chip na cor verde"
  },
  {
    "name": "Celular 6",
    "price": "4.000",
    "description": "Aparelho dual chip na cor amarelo"
  },
  {
    "name": "Celular 7",
    "price": "3.000",
    "description": "Aparelho dual chip na cor laranja"
  },
  {
    "name": "Celular 8",
    "price": "3.500",
    "description": "Aparelho dual chip na cor violeta"
  },
  {
    "name": "Celular 9",
    "price": "4.000",
    "description": "Aparelho dual chip na cor marrom"
  },
  {
    "name": "Celular 10",
    "price": "6.000",
    "description": "Aparelho dual chip na cor cinza"
  }
]
  ´´´
  


## Muito Obrigado!!!

Deus abençoe o nosso match!! 🙏🙏🙏
