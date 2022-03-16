@extends('adminlte::page')

@section('title', 'Nico Business')

@section('content_header')
    <h1>Lista de Clients</h1>
@stop

@section('content')
   <a href="clients/create" class="btn btn-primary mb-3">Criar</a>

<table id="clients" class="table table-striped table-bordered shadow-lg mt-4" style="width:100%">
    <thead class="bg-primary text-white">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nome</th>
            <th scope="col">Telemovel</th>
            <th scope="col">Género</th>
            <th scope="col">Opções</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($clients as $client)
        <tr>
            <td>{{ $client->id}}</td>
            <td>{{$client->name}}</td>
            <td>{{$client->phone}}</td>
            @if ($client->gender)
            <td>Masculino</td>
            @else
            <td>Feminino</td>
            @endif
            <td>
                <form action="{{ route ('clients.destroy',$client->id)}}" method="POST">
                <a href="/clients/{{ $client->id}}/edit" class="btn btn-info">Editar</a>
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#clients').DataTable({
        "lengthMenu": [[5,10, 50,100,200,300,400,500, -1], [5, 10, 50,100,200,300,400,500, "All"]]
    });
} );
</script>

@stop
