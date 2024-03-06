
<p align="center">
<a href="hhttps://www.adoorei.com.br/" target="_blank">
<img src="https://adoorei.s3.us-east-2.amazonaws.com/images/loje_teste_logoadoorei_1662476663.png" width="160"></a>
</p>

# Desafio Concluído com sucesso

Olá, prezados!! 😃🚀🚀🚀

É com muita alegria que elaboro esse documento exibindo todos os resultados da construção da nossa API. 

Adorei cada etapa do processo, muito obrigado pelo espaço!!

## Tecnologias utilizadas

* Laravel 10
* PHP 8.3.3
* Sonarqube
* Sqlite
* Swagger
* Docker
* PHPUnit
* Ngnix
* Supervisor Linux
* Git e Composer


## Como usar a API

1 - Configure o seu arquivo hosts para acessar a api pelo endereço correto: 127.0.0.1 abc.app.br

2 - Faça o clone do fork e rode o comando para subir os containers do docker: docker-compose up -d 

3 - Aguarde até carregar os dois containers (Sonarqube e Backend)

4 - Acesse a api no browser: http://abc.app.br/api/products

5 - Acesse aos relatórios de cobertura de testes do Sonarqube em http://localhost:9000


## Rotas & Exemplos 

### Listar produtos disponíveis: 

  1 - Rota http://abc.app.br/api/products


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
  ```
  
  2 - Rota http://abc.app.br/api/sales

  ```json
  [
  {
    "sale_id": "202403041",
    "amount": 34400,
    "products": [
      {
        "product_id": 1,
        "name": "Celular 1",
        "price": "1.800",
        "amount": 1
      },
      {
        "product_id": 2,
        "name": "Celular 2",
        "price": "3.200",
        "amount": 1
      },
      {
        "product_id": 3,
        "name": "Celular 3",
        "price": "9.800",
        "amount": 3
      }
    ]
  },
  {
    "sale_id": "202403042",
    "amount": 54400,
    "products": [
      {
        "product_id": 1,
        "name": "Celular 1",
        "price": "1.800",
        "amount": 3
      },
      {
        "product_id": 5,
        "name": "Celular 5",
        "price": "3.500",
        "amount": 8
      },
      {
        "product_id": 7,
        "name": "Celular 7",
        "price": "3.000",
        "amount": 7
      }
    ]
  },
  {
    "sale_id": "202403043",
    "amount": 93000,
    "products": [
      {
        "product_id": 7,
        "name": "Celular 7",
        "price": "3.000",
        "amount": 7
      },
      {
        "product_id": 10,
        "name": "Celular 10",
        "price": "6.000",
        "amount": 10
      },
      {
        "product_id": 10,
        "name": "Celular 10",
        "price": "6.000",
        "amount": 2
      }
    ]
  },
  {
    "sale_id": "202403044",
    "amount": 74600,
    "products": [
      {
        "product_id": 2,
        "name": "Celular 2",
        "price": "3.200",
        "amount": 8
      },
      {
        "product_id": 5,
        "name": "Celular 5",
        "price": "3.500",
        "amount": 6
      },
      {
        "product_id": 6,
        "name": "Celular 6",
        "price": "4.000",
        "amount": 7
      }
    ]
  },
  {
    "sale_id": "202403045",
    "amount": 93500,
    "products": [
      {
        "product_id": 5,
        "name": "Celular 5",
        "price": "3.500",
        "amount": 5
      },
      {
        "product_id": 9,
        "name": "Celular 9",
        "price": "4.000",
        "amount": 4
      },
      {
        "product_id": 10,
        "name": "Celular 10",
        "price": "6.000",
        "amount": 10
      }
    ]
  }
]
  ```
  3 - Rota http://abc.app.br/api/sale/1 
    * GET: traz os dados de uma venda específica
    * PUT: Atualiza uma venda
    * DELETE: Cancela uma venda (Estou usando Softdeletes)

  4 - Rota http://abc.app.br/api/sale
    * POST: Registra uma nova venda 

  5 - Rota http://abc.app.br/api/sale/1/products
    * POST: Adiciona produto a uma venda de id 1

## Consultas de Vendas e Produtos

![Consulta da Lista de Vendas](image_1.png)
![Consulta da Lista de Produtos](image_2.png)

## Resultados do Sonarqube (Cobertura de Testes Automatizados)

![Status PASSED no projeto supervisonado pelo sonarqube](image_3.png)
![Mais de 80% de cobertura geral da API](image_4.png)

## Documentação do Swagger


## Muito Obrigado!!!

Deus abençoe o nosso match!! 🙏🙏🙏
