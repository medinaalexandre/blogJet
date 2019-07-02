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

Antes de seguir o tutorial, se você não tem conhecimento do laravel, recomendo olhar pelo menos os oito primeiros videos desse [tutorial.](https://www.youtube.com/watch?v=qiMYkrkXJ6k&list=PLpzy7FIRqpGD0kxI48v8QEVVZd744Phi4&index=1) Vai ser uma hora bem gasta entendendo os conceitos básicos do que vamos utilizar para criar o blog.

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
php artisan make:model Post -m
```
Com este comando vai ser criado o Modelo Post, a migration para criar a tabela Post e um controlador, vamos ver o que significa cada um destes itens ao longo do tutorial.
Para entender o comando você pode rodar "php artisan make:model -help", irá aparecer uma lista de opções que você pode utilizar junto com o comando, neste caso utilizamos -m para criar o migration do modelo Post.

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
Vamos linkar os nossos Models com as tabelas criadas, acesse o modelo **Post** e adicione a variavel $table
```php
    protected $table = 'posts';
```
Se você analisou o código do migrate de posts, viu que foi criado uma relação entre Posts e Usuários pela chave estrangeira "user_id". Vamos definir isso nos nossos modelos "Post" e "Usuário"

Adicione o seguinte trecho de código no modelo Post, ele está localizado em **blog/app/Post.php**

```php
    public function user(){
        return $this->belongsTo(User::class);
    }
```

E o seguinte trecho de código no modelo User, localizado em **blog/app/User.php**
```php 
    protected $table = 'users';
    
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
    protected $table = 'comments';        

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
        });
    }
```
Modifique o modelo **Post.php** e adicione o seguinte trecho de código
```php
    public function categories(){
        return $this->belongsToMany( Category::class);
    }
``` 
E no modelo **Category.php** adicione
```php
    protected $table = 'categories';
     
    public function posts(){
        return $this->belongsToMany(Post::class);
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

Crie um modelo Role, para definir que tipo de usuário vai ser.
```php
php artisan make:model Role -m
```

Modifique a migration **create_roles_table**
```php
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });
    }
```

Crie uma nova migration para armazenar as relações de users com roles
```php
php artisan make:migration create_role_user_table
```
Modifique a migration para
```php
    public function up()
    {
        Schema::create('role_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned();
            $table->integer('user_id')->unsigned();
        });
    }
```
Modifique o modelo **Role.php** e adicione a função
```php
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
```
E no modelo **User.php**
```php
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }
```

Ainda falta criar os likes e a tabela de autenticação com o Google, mas vamos deixar isso para depois.

Agora vamos atualizar o nosso banco
```php
php artisan migrate:fresh
```



## Views no laravel
Vamos modificar a página inicial do blog. As views no laravel ficam em **blog/resources/views/**


## Controllers no laravel
Os controllers ficam em **blog/app/Http/Controllers**, já temos alguns criados se você seguiu o tutorial.

Vamos criar um novo controller para os Posts
```php
php artisan make:controller PostsController -m Post
```
Modifique a função create para retornar a view que cria um post
```php
        public function create()
        {
            $users = User::all();
            $post = new Post();
            $categories = Category::all();
    
            return view('admin.posts.create',compact('users', 'post', 'categories'));
        }
```
Não esqueça de importar o Model de Category e User no controller, é necessário passar todos os usuários e todas as categorias para que o usuário possa escolher quem é o Autor do Post e quais Categorias o post pertence. O post vazio é um truque que usamos para poder reaproveitar o formulário de criar o post na hora de editar.

Nessa view, vamos ter um formulário que ira receber os dados do post, precisamos de uma função para receber, tratar e armazenar no banco os dados do post, essa função se chama **store**
```php
    public function store(Post $post, Request $request)
    {
        $request->validate(['title' => 'unique:posts'],['title.unique' => 'Já existe um post com esse título']);
        $post = Post::create($this->validateRequest());
        $post->categories()->sync(request()->request->get('categories'));

        return redirect('admin.post.list');
    }
```
Na primeira linha, validamos se o título é único, caso contrário o usuário receberá a mensagem _'Já existe um post com esse título'_. Caso o título não exista no banco de dados, vamos tentar criar o Post usando a função **Post::create()**
Como parametro, vamos passar os dados que recebemos da request do usuário **$this** e fazer uma validação, para o código ficar mais limpos, vamos criar uma função para isto

```php
    public function validateRequest(){
        $validatedData = request()->validate([
            'title' => 'required|min:5',
            'description' => 'required',
            'user_id' => 'required',
            'slug' => 'sometimes',
            'post_body' => 'required',
            'image' => 'sometimes|file|image|max:5000',
        ],[
            'title.required' => "O título é obrigatório!",
            'title.min' => "O título precisa ter mais que 5 caracteres!",
            'description.required' => "A descrição é obrigatória!",
            'post_body.required' => 'O post não pode ser vazio',
        ]);

        return $validatedData;
    }
```
Com essa função, além de definirmos todas as regras necessárias para publicar um post, garantimos que somente esses dados irão ser cadastrados no banco, caso o usuário edite o HTML e adicione um novo input com um novo campo, este dado será ignorado pela função.
Feito isto, o terceiro comando da nossa função **store** pega as categorias selecionadas pelo usuário na hora de criar o post e usa o método **sync** para atualizar as relações de post com categoria no banco de dados.

Agora vamos criar a função para retornar a view de editar o Post
```php
    public function edit(Post $post)
    {
        $users = User::all();
        $categories = Category::all();

        return view('posts.edit', compact('post', 'users', 'categories'));
    }
```
E a função de atualizar o post no banco
```php
    public function update(Request $request, Post $post)
    {
        $post->update($this->validateRequest($request));
        $post->categories()->sync($request->request->get('categories'));
        
        return redirect('admin.posts.list');
    }
```

Para deletar o post é simples, basta receber ele por parametro e usar o método **delete()**
```php
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect('admin.posts.list');
    }
```

## Acessando as views
Para ver suas views, você precisa dizer ao laravel como chegar nelas, isto é feito no arquivo **web.php** localizado em **blog/routes/web.php**

Vamos criar uma rota para entender como funciona. Adicione o seguinte trecho de código ao arquivo web.php
```php
Route::get('/novarota', function(){
    return 'Nova rota!';
});
```
E agora acesse localhost/novarota e veja o que aparece.

Para retornar uma view já existente, em vez de retornar uma String, vamos retornar uma view. Veja o exemplo
```php
Route::get('/admin', function (){
    return view('admin.index');
});
```
Quando retornar uma view, o laravel procura ela dentro da pasta **resources/views**, se a nossa view estiver dentro de uma pasta, dizemos primeiro o nome da pasta (admin) ponto o nome do arquivo, no caso do exemplo ele ira renderizar o arquivo **home.blade.php** que está em **resources/views/admin/home.blade.php**

Porém como estamos retornando nossas views no controller, a forma que iremos fazer isso no web.php será assim:
```php
Route::get(('/admin', 'AdminController@index');
```
Nesse caso, quando o usuário acessar http://localhost/admin, o laravel ira acessar o controller **AdminController** e usar a função **index**.
