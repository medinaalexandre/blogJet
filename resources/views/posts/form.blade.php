<div class="form-group">
    <label for="title" >Título</label>
    <input type="text" name="title" value="{{ old('title') ?? $post->title }}" class="form-control  {{ $errors->has('title') ? 'is-invalid' : '' }}">
    <div>{{ $errors->first('title') }}</div>
</div>

<div class="form-group">
    <label for="description">Descrição:</label>
    <input type="text" name="description" value="{{ old('description') ?? $post->description }}" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">
    <div><span class="required-red">{{ $errors->first('description') }}</span></div>
</div>

<div class="form-group">
    <label for="user_id">Autor:</label>
    <select name="user_id" class="form-control">
        @foreach($users as $user)
            <option value="{{ $user->id }}" {{ $user->id == $post->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="slug">Slug:</label>
    <input type="text" name="slug" value="{{ old('slug') ?? $post->slug }}" class="form-control">
    <div>{{ $errors->first('slug') }}</div>
</div>
<div class="panel-group">
    <label for="post_body">Post:</label>
    <textarea id="summernote" name="post_body" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('post_body') ?? $post->post_body }}</textarea>
    <div>{{ $errors->first('post_body') }}</div>
</div>

<div class="form-group d-flex flex-column">
    <label for="image">Imagem:</label>
    <img  class="img-fluid" @if(is_null($post->image)) src="{{asset('img/default_img_post.png')}}" @else src="/storage/images/{{$post->image}}" @endif></img>
    <input type="file" name="image" class="py-2">
    <div>{{ $errors->first('image') }}</div>
</div>

<div class="form-check col-sm-6">
    <label>Categorias:</label>
    @foreach($categories as $c)
        <div>
            <input type="checkbox" value="{{ $c->id }}" @if (old($c->id , $post->categories->contains($c->id))) checked='checked'
                                             @endif name="categories[]">
            <label class="form-check-label" for=" category_check{{ $c->id }}">
                {{ $c->name }}
            </label>
        </div>
    @endforeach
</div>
@csrf