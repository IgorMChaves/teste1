@extends('restrict.layout')

@section('content')
@if(count($errors) > 0)
<ul class="validator">
    @foreach($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
</ul>
@endif
<form method="POST" action="{{url('mensagem')}}" enctype="multipart/form-data">
    @csrf
    @method('POST')
    <div>
        <label for="numero">Numero</label>
        <input type="text" name="numero" id = "numero" value="{{old('numero') }}" required/>
    </div>
    <div>
        <label for="nome">Nome</label>
        <input type="text" name="nome" id = "nome" value="{{old('nome') }}" required/>
    </div>
    <div>
        <label for="url">Url</label>
        <input name="url" id="url" required>{{old('url')}} </input>
    </div>
    <div>
        <label for="assunto">Assunto</label>
        <textarea name="assunto" id="assunto" required>{{old('assunto')}} </textarea>
    </div>
    <button type="submit" class="button">Salvar</button>
</form>
@endsection