# API de Gerenciamento de Fórmulas de Manipulação

## Descrição do Projeto

Este projeto consiste em uma API desenvolvida para uma farmácia de manipulação, com o objetivo de gerenciar clientes, fórmulas de manipulação e os ativos utilizados nessas fórmulas. A API foi construída utilizando o framework Laravel, seguindo os princípios RESTful para garantir fácil integração e escalabilidade.

### Objetivos Principais

- **Gerenciamento de Dados:** A API permite o armazenamento e a manipulação de informações de clientes, fórmulas de manipulação e ativos.
- **Processamento de Solicitações:** Implementa a lógica necessária para processar as solicitações de fórmulas feitas pelos clientes, incluindo a associação de ativos a essas fórmulas.
- **Segurança e Eficiência:** Tratamento adequado de dados sensíveis como CPF, telefone, e nome, garantindo a segurança e a conformidade com as normas de privacidade.

## Tecnologias Utilizadas

- Laravel 11
- MySQL
- Swagger para documentação da API

## Requisitos

- PHP 8.x
- Composer
- MySQL

## Instalação

1. Clone o repositório:
   
   ```git clone https://github.com/rrodrigofranco/FormulaManager ```<br />
   ```cd FormulaManager ```

2. Instale as dependências do projeto:

    ```composer install```

3. Configure o arquivo .env:

    ```cp .env.example .env```<br />
    ```php artisan key:generate```

4. Configure o banco de dados no arquivo .env:

    ```DB_CONNECTION=mysql```<br />
    ```DB_HOST=127.0.0.1```<br />
    ```DB_PORT=3306```<br />
    ```DB_DATABASE=nome_do_banco```<br />
    ```DB_USERNAME=usuario```<br />
    ```DB_PASSWORD=senha```<br />

5. Execute as migrações:

    ```php artisan migrate```

## Endpoints da API

### Endpoints para Clientes

- **GET /api/clientes**
  - Lista todos os clientes.

- **POST /api/clientes**
  - Cria um novo cliente.
  - **Parâmetros:**
    - `nome`: string, obrigatório.
    - `cpf`: string, obrigatório.
    - `telefone`: string, opcional.

- **GET /api/clientes/{id}**
  - Obtém detalhes de um cliente específico.

- **PUT /api/clientes/{id}**
  - Atualiza as informações de um cliente específico.
  - **Parâmetros:**
    - `nome`: string, opcional.
    - `cpf`: string, opcional.
    - `telefone`: string, opcional.

- **DELETE /api/clientes/{id}**
  - Exclui um cliente específico.

### Endpoints para Fórmulas de Manipulação

- **GET /api/formulas**
  - Lista todas as fórmulas de manipulação.

- **POST /api/formulas**
  - Cria uma nova fórmula de manipulação.
  - **Parâmetros:**
    - `nome`: string, obrigatório.
    - `descricao`: string, opcional.
    - `cliente_id`: integer, obrigatório.

- **GET /api/formulas/{id}**
  - Obtém detalhes de uma fórmula de manipulação específica.

- **PUT /api/formulas/{id}**
  - Atualiza as informações de uma fórmula de manipulação específica.
  - **Parâmetros:**
    - `nome`: string, opcional.
    - `descricao`: string, opcional.
    - `cliente_id`: integer, opcional.

- **DELETE /api/formulas/{id}**
  - Exclui uma fórmula de manipulação específica.

### Endpoints para Ativos

- **GET /api/ativos**
  - Lista todos os ativos.

- **POST /api/ativos**
  - Adiciona um novo ativo.
  - **Parâmetros:**
    - `nome`: string, obrigatório.
    - `descricao`: string, opcional.

- **GET /api/ativos/{id}**
  - Obtém detalhes de um ativo específico.

- **PUT /api/ativos/{id}**
  - Atualiza as informações de um ativo específico.
  - **Parâmetros:**
    - `nome`: string, opcional.
    - `descricao`: string, opcional.

- **DELETE /api/ativos/{id}**
  - Exclui um ativo específico.

## Documentação da API

A documentação da API foi gerada utilizando o Swagger. Para acessá-la, inicie o servidor localmente e acesse `/api/documentation` no seu navegador.

