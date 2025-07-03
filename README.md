## Instruções de Instalação e Uso

### Usando Docker

1. Certifique-se de ter o Docker instalado.
2. Execute o build e o container:
   ```sh
   docker build -t desafio-db .
   docker run -d --rm -p 80:8080 --name desafio-db desafio-db
   ```
3. O sistema estará disponível em http://localhost.

### Ambiente Local

1. Instale as dependências PHP e Node.js:
   ```sh
   composer install
   npm install
   ```
2. Copie o arquivo `.env.example` para `.env` e gere a chave:
   ```sh
   cp .env.example .env
   php artisan key:generate
   ```
3. Execute as migrations:
   ```sh
   php artisan migrate
   ```
4. Inicie o servidor com um dos comandos abaixo:
   ```sh
   php artisan serve
   php -S localhost:80 -t public/
   ```

## Funcionalidades Implementadas

- Cadastro, listagem, edição e exclusão de tarefas (To-Do).
- Filtro de tarefas por título, data de criação e prazo de conclusão.
- Marcação de tarefas como concluídas e controle de data de conclusão.
- Autenticação de usuários.
- Políticas de autorização para garantir que apenas o dono pode visualizar, editar ou excluir suas tarefas.
- Testes automatizados (unitários e de feature) cobrindo modelos, políticas e controllers.

## Cobertura de Testes e Tipos

O projeto se encontra com **100% de cobertura de testes** (unitários e de feature) e **100% de cobertura de tipos**.
- Para verificar a cobertura de testes, execute:
  ```sh
  composer test:coverage
  ```
- Para verificar a cobertura de tipos, execute:
  ```sh
  composer type
  ```

## Decisões Técnicas e Considerações

- Utilização do Laravel 12.x e PHP 8.4 para aproveitar recursos modernos da linguagem e framework.
- Uso de Eloquent Scopes para facilitar filtros de tarefas pendentes e concluídas.
- Implementação de políticas via atributo #[UsePolicy] para maior clareza e segurança.
- Testes escritos com Pest para maior legibilidade e produtividade.
- Dockerfile multi-stage para builds otimizados e ambiente de produção enxuto.
- Banco de dados SQLite para facilitar testes e execução local, podendo ser facilmente trocado por outros drivers.
- Cobertura de 100% de tipos e testes, validada via CI.
- Uso de Alpine.js para interatividade leve e reativa no frontend, facilitando modais e interações sem dependências pesadas.

---
