# Projeto Kanasta - Documentação

O projeto foi desenvolvido para processar arquivos grandes contendo uma lista de dívidas, gerar os respectivos boletos, e enviar e-mails de forma eficiente, utilizando filas de processamento com foco em eficiência, escalabilidade e boas práticas de programação.

---

## Arquitetura do Sistema

Este projeto foi desenvolvido utilizando, como base arquitetural, a `Clean Architecture` com algumas práticas de `Domain-Driven Design`, de forma adaptada para o framework Laravel.

A seguir, uma breve explicação sobre as camadas dessa arquitetura adaptada:

* **Domain:**

    - Contém as entidades centrais com as regras de negócio puras (`Entities`).
    - Classes e interfaces abstraídas.
    - Não há dependências de framework, banco de dados, nem packages externos.

* **Application:**

    - Contém os casos de uso que são os executores das funções da aplicação, exemplo: `ProcessDebtUseCase`.
    - Faz a orquestração entre os componentes da aplicação através dos Services.

* **Infrastructure:**

    - Utiliza dependências do framework, banco de dados e packages externos.
    - Implementa os repositórios concretos com as interfaces de domínio, exemplo: `DebtRepository - DebtRepositoryInterface`.
    - Contém serviços específicos de infraestrutura, como o envio de email, jobs em fila e Database Transactions.

* **Componentes originais do Laravel:**
    - `App/Http/Controllers` - Contém os controllers originais do Laravel, somente como uma porta de entrada da aplicação, direcionando para o serviço correto.
    - `App/Http/Controllers/Requests` - Utiliza os Requests gerados pelo Laravel para a validação dos dados especificamente da requisição.
    - `App/Models` - Models Eloquent mantidas como adaptadores do banco de dados, sendo mapeados para as entidades de domínio.

---

## Configuração do Ambiente

### Requisitos

-   Docker e Docker Compose instalados
-   Composer instalado
-   Git instalado

### Passos para configuração

Clone o repositório:

```bash
git clone https://github.com/LucasOlmedo/kanastra-file-processor.git
cd kanastra-file-processor/
```

Configure as variáveis de ambiente:

Crie um arquivo `.env` baseado no exemplo:

```bash
cp .env.example .env
```

Atualize as informações no arquivo `.env` conforme sua configuração local, especialmente as seções de banco de dados e URLs da aplicação.

Sugestão abaixo:

```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=api
DB_USERNAME=root
DB_ROOT_PASSWORD=root
```

Construa os contêineres Docker:

```bash
docker-compose up -d
```

Entre no contêiner da aplicação:

```bash
docker-compose exec api bash
```

Dentro do `contêiner`, altere as permissões para escrita nos arquivos:

```
chown 1000:1000 -Rf storage/ bootstrap/cache
chmod 777 -Rf storage/ bootstrap/cache
```

Dentro do `contêiner`, instale as dependências:

```bash
composer install
```

Dentro do `contêiner`, gere a chave da aplicação:

```bash
php artisan key:generate
```

Dentro do `contêiner`, execute as migrações para configurar o banco de dados:

```bash
php artisan migrate:fresh --seed
```

Para a execução das filas, dentro do `contêiner`, rode o comando:

```bash
php artisan queue:work
```

**Atenção!**

> [!WARNING]
> A variável de ambiente `CHUNK_SIZE` foi configurada para limitar, ou aumentar, o tamanho do bloco (`chunk`) a ser processado pelo job. O valor padrão é um chunk de 2000.

Nesta aplicação o processamento em filas foi mantido em `database` por se tratar de uma execução simples, porém para casos reais, mais complexos e com alto volume de filas, optar pelo `Redis` é mais performático.

---

## Endpoint

-   **POST - /api/upload-debts** - Importação do arquivo `.csv`:
    -   (form-data) _debt_file_ `required` - Campo necessário para upload do arquivo.

---

## Fluxo da Aplicação

### 1. Importação de Dados

1. O usuário envia um arquivo CSV contendo as dívidas.
2. O arquivo é processado em `chunks` para evitar sobrecarga na memória.
3. Imediatamente após o upload do arquivo, o usuário recebe a informação de que os registros serão processados.
4. Cada `chunk` cria um job na fila para processamento (`App\Infrastructure\Jobs\ProcessChunkDebtDataJob`).

### 2. Processamento

1. Para configurar o tamanho dos `chunks` (padrão 2000), altere a variável de ambiente `CHUNK_SIZE`.
    - Um valor `menor` garante uma requisição um pouco mais rápida e maior rastreabilidade no caso de erro, mas pode sobrecarregar a fila pelo número de jobs excessivos lançados.
    - Um valor `maior` deixa a requisição um pouco mais lenta e pode sobrecarregar o `bulk insert` (dependendo do banco de dados que estiver usando), mas lança menos jobs e é mais performático com a fila.
    - No meu ambiente, utilizei `CHUNK_SIZE=5000` e performou razoavelmente bem. A requisição para um arquivo .csv com 1.100.00 linhas foi, em média, de 30 segundos enquanto o processamento da fila (Bulk Inserts) foi entre 10 e 12 minutos no total.
2. Cada job verifica duplicidade de registros no banco, removendo do `chunk` os duplicados.
3. O bloco de registros é salvo no banco (`Debt`) com um _bulk insert_.
4. Baseado nesse bloco de registros, os boletos (`Invoice`) são gerados e também inseridos no banco com um _bulk insert_.

### 3. Envio de Boletos

1. Cada boleto (`Invoice`) gerado é enviado ao e-mail correspondente (simulação com logs).
2. Falhas nos jobs são logadas e reprocessadas automaticamente.

---

## Testes

Execute os testes unitários e de integração para garantir que o sistema está funcionando corretamente:

Entre no contêiner da aplicação:

```bash
docker-compose exec api bash
```

Dentro do `contêiner`, execute os testes:

```bash
php artisan test
```
