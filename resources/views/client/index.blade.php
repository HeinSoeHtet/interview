@extends('layouts.master')

@section('content')

    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone</th>
            <th scope="col">Address</th>
            <th scope="col">Edit</th>
            <th scope="col">Bill</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
            <tr>
                <th scope="row">{{$client->id}}</th>
                <td>{{$client->name}}</td>
                <td>{{$client->email}}</td>
                <td>{{$client->phone}}</td>
                <td>{{$client->address}}</td>
                <td> 
                    <div style="display: flex; align-items:baseline">
                        <form action="{{route('client.edit', ['client' => $client->id])}}" method="get">
                            <button type="submit" class="btn btn-link">Edit</button>
                            </form>
                        <span>/</span>
                        <form action="{{route('client.destroy', ['client' => $client->id])}}" method="POST">
                          @csrf
                          @method('DELETE')
                            <button type="submit" class="btn btn-link">Delete</button>
                        </form>
                    </div>
                </td>
                <td>
                    <form action="{{route('client.billing.index', ['client' => $client])}}" method="GET">
                        <button type="submit" class="btn btn-link">Details</button>
                    </form>
                </td>
              </tr>
            @endforeach
        </tbody>
      </table>

      <nav>
        <ul class="pagination" style="justify-content:center">
          <li class="page-item {{ $clients->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{$clients->previousPageUrl()}}">Previous</a>
          </li>
          <li class="page-item  {{ $clients->hasMorePages() ? '' : 'disabled' }}">
            <a class="page-link" href="{{$clients->nextPageUrl()}}">Next</a>
          </li>
        </ul>
      </nav>

      <form action="{{route('client.create')}}" method="get">
        <div class="d-grid gap-1">
          <button class="btn btn-primary" type="submit">Create New Client</button>
        </div>
    </form>
@endsection