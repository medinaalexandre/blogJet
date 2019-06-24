<div class="form-group">
    <label for="name" >Nome:</label>
    <input type="text" name="name" placeholder="Nome" value="{{ old('name') ?? $user->name }}" class="form-control">
    <div>{{ $errors->first('name') }}</div>
</div>

<div class="form-group">
    <label for="email">Email:</label>
    <input type="text" name="email" placeholder="Email" value="{{ old('email') ?? $user->email }}" class="form-control">
    <div>{{ $errors->first('email') }}</div>
</div>

<div class="form-group">
    <label for="roles">Funções:</label>
    @foreach($roles as $r)
        <div>
            <input type="checkbox" value="{{$r->id}}"  @if(old($r->id, $user->roles->contains($r->id))) checked='checked'
                                                       @endif name="roles[]"/>
            <label for="role_check{{$r->id}}" class="form-check-label">{{$r->name}}</label>
        </div>
    @endforeach
</div>

<div class="form-group">
    <label for="password">Senha:</label>
    <input type="password" name="password" placeholder="Senha" value="{{ old('password') ?? $user->password }}" class="form-control">
    <div>{{ $errors->first('password') }}</div>
</div>
@csrf