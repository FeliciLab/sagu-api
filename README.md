# Instrução para instalação
- clonar projeto com git clone https://github.com/EscolaDeSaudePublica/sagu-api.git
- `cd sagu-api`.
- rodar o comando `docker-compose exec php-fpm composer install `para instalar as **dependências do composer**
- Abrir navegador em _http://localhost:8085/_

# Configuração
-  `docker-compose exec php-fpm php artisan key:generate`. Se não ouver o pacote lumem-generate instalar seguindo as instruções do [link](https://github.com/flipboxstudio/lumen-generator/tree/6.0)
-  Depois da permissão nas pasta storage com os seguintes comandos
    - `docker exec -it saguapi bash`
    - `chown -R $USER:www-data storage`
    - `chown -R $USER:www-data bootstrap`
    - `chmod -R 775 storage`
    - `chmod -R 775 bootstrap`




# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/lumen-framework/v/unstable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](http://lumen.laravel.com/docs).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
