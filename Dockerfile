# Imagem base para o serviço Laravel
FROM serversideup/php:8.4-fpm-nginx AS base

ENV PHP_OPCACHE_ENABLE=1
ENV AUTORUN_ENABLED=true

USER root

RUN curl -sL https://deb.nodesource.com/setup_22.x | bash -
RUN apt-get install -y nodejs

# Estágio de build
FROM base AS build

WORKDIR /var/www/html

# Copiando todos os arquivos do projeto primeiro
COPY --chown=www-data:www-data . .

USER www-data

# Instalando dependências do Composer com autoload otimizado
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Instalando dependências do frontend e compilando assets
RUN npm ci || npm install
RUN npm run build

# Removendo diretórios não necessários para produção
RUN rm -rf node_modules tests

# Estágio final
FROM base AS production

WORKDIR /var/www/html

# Copiando todos os arquivos compilados do estágio de build
COPY --chown=www-data:www-data --from=build /var/www/html /var/www/html

# Verificando se o diretório vendor existe
RUN ls -la /var/www/html && echo "Checking vendor directory:" && ls -la /var/www/html/vendor || echo "Vendor directory not found"

# Criando diretórios de storage necessários e definindo permissões
USER www-data
RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs
RUN touch database/database.sqlite
RUN chmod -R 775 storage bootstrap/cache

USER root

# Copia o .env.example para .env e genera a chave de aplicação
COPY .env.example .env
RUN php artisan key:generate

RUN sed -i 's/^;user =.*/user = www-data/' /usr/local/etc/php-fpm.d/docker-php-serversideup-pool.conf
RUN sed -i 's/^;group =.*/group = www-data/' /usr/local/etc/php-fpm.d/docker-php-serversideup-pool.conf
