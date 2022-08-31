@extends('restrict.layout')

@section('content')
<div>
    <a href="{{url('mensagem/create')}}" class="button">Adicionar</a>
</div>
<table>
    <thead>
        <tr>
            <th>Numero</th>
            <th>Nome</th>
            <th>Url</th>
            <th>Assunto</th>
            <th>Editar</th>
            <th>Remover</th>
        </tr>
    <thead>
    <tbdody>
        @foreach($mensagens as $mensagem)
        <tr>
            <td>{{$mensagem->user->name}}</td>
            <td>{{$mensagem->nome}}</td>
            <td>{{$mensagem->url}}</td>
            <td>{{$mensagem->assunto}}</td>
            <td>
                <a href="{{route('mensagem.edit',$mensagem->id)}}" class="button">
                    Editar
                </a>
            </td>
            <td>
                <form method="POST" action="{{route('mensagem.destroy',$mensagem->id)}}" onsubmit="return confirm('Tem certeza?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="button">
                        Remover
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection