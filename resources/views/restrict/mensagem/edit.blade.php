@extends('restrict.layout')

@section('content')
@if(count($errors) > 0)
<ul class="validator">
    @foreach($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
</ul>
@endif
<form method="POST" action="{{url('mensagem', $mensagem->id)}}">
    @csrf
    @method('PUT')
    <div>
        <label for="nome">Nome</label>
        <input type="text" name="nome" id = "titulo" value="{{ $mensagem->nome }}" required/>
    </div>
    <div>
        <label for="codigo">Url</label>
        <textarea name="url" id="url" required>{{ $mensagem->url}} </textarea>
    </div>
    <div>
        <label for="assunto">Assunto</label>
        <textarea name="assunto" id="assunto" required>{{ $mensagem->assunto}} </textarea>
    </div>
    <button type="submit" class="button">Salvar</button>
</form>
@endsection