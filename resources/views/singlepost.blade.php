@extends('layouts.app')

@section('content')
    <div class="container single-post">
        <div class="row">
            <div class="col-md-8">
                <h1>
                    {{$post->title}}
                </h1>
                <span>Criado por <a href="/user/{{$post->user->id}}">{{$post->user->name}}</a> em {{ $post->created_at }}</span><br><br>
                <img @if(is_null($post->image)) src="{{asset('img/default_img_post.png')}}" @else src="/storage/images/{{$post->image}}" @endif class="img-fluid">
                <p class="text-muted">{{ $post->description }}</p>
                <hr>
                <p>{!! $post->post_body !!}</p>

                <hr><br><br>

                <h4>Categorias: @foreach($post->categories as $category)
                    <a href="/categories/{{$category->name}}"><span class="badge badge-info">{{$category->name}}</span></a>
                                      @endforeach </h4>

                @guest
                    <h4>Curtidas deste post:</h4><button type="submit" class="likeButton"> <i class="far fa-thumbs-up"></i></button> {{ $post->likes()->count() }}
                @else
                    <form action="/likePost" method="POST" class="likePost">
                        @csrf
                        <input type="hidden" name="post_id" value="{{$post->id}}">
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
                        <h4>Curtidas deste post:</h4><button type="submit" class="likeButton"><div class="justify-content-start">{!! $post->isAuthUserLikedPost() ? '<i class="likesIconPost fas fa-thumbs-up"></i>' : '<i class="likesIconPost far fa-thumbs-up"></i>' !!}
                                                                                                                                <div class="likesCountPost"> {{ $post->likes()->count() }} </div> </div></button>

                    </form>
                @endguest


                <h3>Comentários</h3>
                    <div class="selectorAll">
                    @foreach($post->comments as $c)
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Comentário de {{ $c->user->name }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Postado em {{$c->created_at}}</h6>
                                    <p class="card-text">{{$c->comment}}</p>
                                    @guest
                                       <button type="submit" id="likeCommentButton"> <i class="far fa-thumbs-up"></i></button> {{ $c->likes()->count() }}
                                    @else
                                        <form action="/likeComment" method="POST" class="likeComment">
                                            @csrf
                                            <input type="hidden" name="comment_id" value="{{$c->id}}">
                                            <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
                                                <button type="submit" class="likeButton"><div class="justify-content-start">{!! $c->isAuthUserLikedComment() ? '<i class="likesIcon fas fa-thumbs-up"></i>' : '<i class="likesIcon far fa-thumbs-up"></i>' !!}
                                                                                                                            <div class="likesCount"> {{ $c->likes()->count() }} </div> </div></button>
                                        </form>
                                    @endguest
                                </div>
                            </div>
                    @endforeach
                    </div>
                @guest
                    <br>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <a href="/login">Logue-se</a> para <strong>comentar</strong> e dar <strong>like</strong> no post!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <span></span>
                @else
                    <div class="row">
                        <div class="col-md-12">
                            <form  id="sendComment" action="{{ route('sendComment') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>

                                <div class="form-group">
                                    <label for="comment">Comentário</label>
                                    <textarea class="form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}" name='comment' placeholder="Escreva seu comentário aqui" rows="7">{{old("comment")}}</textarea>
                                    <div><span class="required-red">{{ $errors->first('comment') }}</span></div>
                                </div>

                                <input type="hidden" name="post_id" value="{{$post->id}}">

                                <button type="submit" class="btn btn-outline-primary" >Comentar</button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

            <div class="col-md-4">
                <h3 class="category-sidebar">Últimos posts</h3>
                <div class="list-group">
                    @foreach($ultimosposts as $p)
                        <a href="/post/{{ $p->slug }}" class="list-group-item list-group-item-action flex-column align-items-start my-2">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $p->title }}</h6>
                            </div>
                            <div class="d-flex flex-row justify-content-between">
                                <small>{{ $p->created_at->diffForHumans() }}</small> <small><i class="far fa-thumbs-up"></i> {{ $p->likes()->count() }}</small>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        // like post
        $(function(){
            $('.likePost').submit(function(e){
                e.preventDefault();
                var route = '/likePost';
                var form_data = $(this);

                $.ajax({
                    type: 'POST',
                    url: route,
                    data: form_data.serialize(),
                    success: function(){
                        troca();
                    },
                });
                function troca(){
                    let icon = e.target.getElementsByClassName('likesIconPost');
                    let nr = e.target.getElementsByClassName('likesCountPost');
                    if(icon[0].classList.contains('far')){
                        nr[0].innerHTML++;
                        icon[0].classList.remove('far');
                        icon[0].classList.add('fas');
                    }else{
                        nr[0].innerHTML--;
                        icon[0].classList.add('far');
                        icon[0].classList.remove('fas');
                    }
                }

            });
        });

        $(function(){
            $('.likeComment').submit(function(e){
                e.preventDefault();
                var route = '/likeComment';
                var form_data = $(this);

                $.ajax({
                    type: 'POST',
                    url: route,
                    data: form_data.serialize(),
                    success: function(){
                        troca();
                    },
                });
                function troca(){
                    let icon = e.target.getElementsByClassName('likesIcon');
                    let nr = e.target.getElementsByClassName('likesCount');
                    if(icon[0].classList.contains('far')){
                        nr[0].innerHTML++;
                        icon[0].classList.remove('far');
                        icon[0].classList.add('fas');
                    }else{
                        nr[0].innerHTML--;
                        icon[0].classList.add('far');
                        icon[0].classList.remove('fas');
                    }
                }
            });
        });
    </script>
@endsection