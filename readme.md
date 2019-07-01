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
DB_HOST=127.0.0.1         <- Coloque o IP do seu banco de dados
DB_PORT=3306  	          <- A porta que o BD está utilizando
DB_DATABASE=homestead     <- O nome do seu banco de dados
DB_USERNAME=homestead     <- O usuário com acesso ao BD
DB_PASSWORD=secret        <- A senha do usuário
```

## Usuários
O laravel tem um sistema de autenticação de usuários pronto já, para utilizar basta rodar o comando
```php
php artisan make:auth
```
Após isso, uma série de arquivos foi modificado ou criado pelo laravel, para entender melhor o que aconteceu, veja na [documentação](https://laravel.com/docs/5.8/authentication#authentication-quickstart) as alterações feitas pelo comando.

## Criando as tabelas no banco de dados
O laravel usa o sistema de [migrations](https://laravel.com/docs/5.8/migrations) para criar um controle de versão do banco de dados. Acesse os migrations criados pelo "comando artisan make:auth" para ver a estrutura de um migration. Os migrations ficam em: **blog/database/migrations**

*O laravel contém uma grande quantidade de arquivos e pastas, para não perder tempo procurando cada vez que for modificar algum arquivo diferente, procure qual o atalho para navegar entre arquivos na IDE que estiver utilizando.
Caso esteja usando o [PHPStorm](https://www.jetbrains.com/phpstorm/), o atalho para navegar entre os arquivos é **CTRL+SHIFT+N**.*

Agora vamos criar a primeira tabela do banco de dados, a tabela Post. Rode o seguinte comando:
```php
php artisan make:model Post -rm
```
Com este comando vai ser criado o Modelo Post, a migration para criar a tabela Post e um controlador, vamos ver o que significa cada um destes itens ao longo do tutorial.
Para entender o comando você pode rodar "php artisan make:model -help", irá aparecer uma lista de opções que você pode utilizar junto com o comando, neste caso utilizamos -r para criar o controlador com a estrutura de Resource, e -m para criar o migration do modelo Post.

Acesse o arquivo da migration post, ele está em **blog/database/migrations/ 0000_00_00_0000_create_posts_table.php**
Agora vamos adicionar os elementos que um post tem, seu código deverá ficar parecido com isto:
``` php
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('title');
            $table->text('description');

            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('slug')->unique()->nullable();
            $table->mediumText('post_body');

            $table->string('image')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
```
Se você analisou o código, viu que foi criado uma relação entre Posts e Usuários pela chave estrangeira "user_id". Vamos definir isso nos nossos modelos "Post" e "Usuário"

Adicione o seguinte trecho de código no modelo Post, ele está localizado em **blog/app/Post.php**

```php
    public function user(){
        return $this->belongsTo(User::class);
    }
```

E o seguinte trecho de código no modelo User, localizado em **blog/app/User.php**
```php 
    public function posts(){
        return $this->hasMany(Post::class);
    }
```
Para entender melhor o que significa "belongsTo, hasMany, belongsToMany", leia sobre [Eloquent Relationships](https://laravel.com/docs/5.8/eloquent-relationships)

Agora vamos criar o migration dos comentários, rode o comando
```php
php artisan make:model Comment -m
```
Adicione os atributos do comentário no migration **create_comments_table**
```php
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade");
            $table->foreign('post_id')->references('id')->on('posts')->onDelete("cascade");
            $table->text("comment");
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
```
Modifique o modelo **Post.php** e adicione o seguinte trecho de código
```php
    public function comments(){
        return $this->hasMany(Comment::class);
    }
```
No modelo **Comment.php** adicione
```php
    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
```


Criando a migration para categorias
```php
php artisan make:model Category -m
```
Adicione o seguinte trecho de código a função **create** da migration **create_categories_table** 
```php
    $table->string('name');
```



### Relações N para N no laravel
Para criar uma relação N para N, é necessário uma nova tabela para guardar os relacionamentos entre Post e Categorias, pois um post pode conter várias categorias, e uma categoria pode ter vários posts.
Rode o comando
```php
php artisan make:migration create_category_post_table
```
Atualize a função up da migration **create_category_post_table** para
```php
public function up()
    {
        Schema::create('category_post', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->unsignedBigInteger('post_id')->index();
            $table->foreign('post_id')->references('id')->on('posts')->onDelete("cascade");
            $table->unsignedBigInteger('category_id')->index();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete("cascade");
            $table->timestamps();
        });
    }
```

Vamos rodar um migrate para ver se tudo está dando certo até aqui
```php
php artisan migrate:fresh
```

Talvez você receba a seguinte mensagem de erro:
```php
 Illuminate\Database\QueryException  : SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long; max key length is 767 bytes (SQL: alter table `users` add unique `users_email_unique`(`email`))
```

Para resolver isso siga os passos abaixo:

• Edite o arquivo app\Providers\AppServiceProvider.php

• Adicione o namespace use Illuminate\Support\Facades\Schema;

• Dentro do método boot adicione Schema::defaultStringLength(191);

• Resultado final do arquivo:
```php
use Illuminate\Support\Facades\Schema;

public function boot()
{
    Schema::defaultStringLength(191);
} 

```
Aqui está a solução no [stackoverflow](https://pt.stackoverflow.com/questions/245432/sqlstate-42000-syntax-error-or-access-violation-1071-specified-key-was-too-lon)

Agora vamos continuar criando nosso banco

Modifique o modelo **Post.php** e adicione o seguinte trecho de código
```php
    public function categories(){
        return $this->belongsToMany( Category::class);
    }
``` 
E no modelo **Category.php** adicione
```php
    public function posts(){
        return $this->belongsToMany(Post::class);
    }
```
