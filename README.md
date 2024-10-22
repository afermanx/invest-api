# Invest API

Esta é uma API desenvolvida em Laravel para gerenciar a carteira de investimentos de usuários, incluindo informações sobre ativos financeiros, movimentações e empresas.

## Tecnologias Utilizadas

-   Laravel
-   MySQL (ou outro banco de dados suportado)
-   Laravel Sail (para ambiente Docker)
-   Eloquent ORM

## Pré-requisitos

-   PHP >= 8.0
-   Composer
-   Docker (se usar Laravel Sail)
-   MySQL (ou outro banco de dados)

## Instalação

### Clone o Repositório

```bash
git clone https://github.com/afermanx/invest-api.git
cd invest-api
```
### Instalação com e sem o Laravel Sail

1. Instale as dependências com Composer:

    ##### Sail:

    ```bash
    ./vendor/bin/sail up -d
    ./vendor/bin/sail composer install
    ```

    ##### Normal:

    ```bash
    composer install
    ```

2. Configuração do Ambiente:

    ##### Copie o arquivo .env.example para .env:

    ##### Sail:

    ```bash
    ./vendor/bin/sail cp .env.example .env
    ```

    ##### Normal:

    ```bash
    cp .env.example .env
    ```

3. Execute as Migrações com as seeds:
    ##### Sail:
    ```bash
    ./vendor/bin/sail artisan migrate --seed
    ```
    ##### Normal:
    ```bash
    php artisan artisan migrate --seed
    ```
4. Inicie a Aplicação:

    ##### Sail:

    A aplicação estará disponível em http://localhost/api/v1. Você pode acessar a API através dos endpoints definidos.

    ##### Normal:

    ```bash
    php artisan serve
    ```

    A aplicação estará disponível em http://localhost:8000/api/v1. Você pode acessar a API através dos endpoints definidos.

    ##### Retorno:

    ```json
    {
        "message": "Welcome!",
        "name": "Invest-api",
        "version": "1.0.0",
        "documentation": "https://documenter.getpostman.com/view/5380407/2sAXxY4TyN"
    }
    ```
