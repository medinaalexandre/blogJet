# Crie um blog com o Laravel 5.8!

Para criar o blog iremos utilizar o Laravel 5.8, para utilizar ele é necessário ter o composer instalado no computador.
[Download composer](https://getcomposer.org/)


## Instalando o laravel
Primeiro instale o laravel.
```php
composer global require laravel/installer
```
Quando o composer terminar de baixar as dependências do laravel, rode o seguinte comando para criar um novo projeto laravel
```php
composer create-project --prefer-dist laravel/laravel blog
```
Agora, acesse a pasta do seu projeto e coloque seu projeto online.
```php
cd blog
php artisan serve
```
Acesse o link que apareceu no seu terminal [http://127.0.0.1:8000](http://127.0.0.1:8000/)

Se tudo deu certo, ao acessar o link aparecera uma tela de boas vindas do Laravel
![Resultado de imagem para tela inicial do laravel](https://cdn-images-1.medium.com/max/1200/1*G8cSIjXdmX1kP5oTsks1tw.png)
Caso não tenha aparecido esta tela, provavelmente você está sem algum dos requisitos para rodar o laravel, verifique os requisitos na [documentação do Laravel](https://laravel.com/docs/5.8#server-requirements).


## Configurações inicias do laravel

Se você instalou o laravel utilizando o composer como demonstrado neste tutorial, você já tem um arquivo chamado .env dentro da pasta do seu projeto laravel.  Abra o arquivo .env e verifique se a chave de aplicação foi criada, a chave será algo deste tipo

    APP_KEY=base64:wGMZl4gRjMzoboMCMbxyYOHUTg2rqrdTKU666hrpMJg=

Caso você não tenha o arquivo .env, crie uma cópia do arquivo .env.example e renomeie para .env
Agora para gerar a chave de aplicação, rode o seguinte comando
`php artisan key:generate`
## Configurando o banco de dados do blog

Neste tutorial iremos usar o [MySQL](https://www.mysql.com/) como SGBD, para dizer ao laravel qual é o nosso banco de dados, acesse o arquivo .env e procure pelas seguintes linhas
```
DB_CONNECTION=mysql       <- Defina a conexao como "mysql"
DB_HOST=127.0.0.1  		  <- Coloque o IP do seu banco de dados
DB_PORT=3306  			  <- A porta que o BD está utilizando
DB_DATABASE=homestead     <- O nome do seu banco de dados
DB_USERNAME=homestead     <- O usuário com acesso ao BD
DB_PASSWORD=secret		  <- A senha do usuário
```