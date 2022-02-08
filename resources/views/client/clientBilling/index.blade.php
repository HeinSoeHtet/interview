@extends('layouts.master')

@section('content')

<div class="card mb-3">
    <div class="row g-0">
      <div class="col-md-4">
        <img src="{{Storage::url($client->photo)}}"  class="img-fluid rounded-start"  style="padding: 8%"  alt="">
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h5 class="card-title">{{$client->name}}</h5>
          <p class="card-text">Email -{{$client->email}} </p>
          <p class="card-text">Phone - {{$client->phone}}</p>
          <p class="card-text">Address - {{$client->address}}</p>
        </div>
      </div>
    </div>
  </div>

  @if (count($billings))
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Amount</th>
        <th scope="col">Due Date</th>
        <th scope="col">Description</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($billings as $billing)
        <tr>
            <th scope="row">{{$billing->id}}</th>
            <td>{{$billing->amount}}</td>
            <td>{{$billing->due_date}}</td>
            <td  style="max-width:300px;">{{$billing->description}}</td>
            <td> 
                <div style="display: flex; align-items:baseline">
                    <form action="{{route('client.billing.edit', ['client' => $client ,'billing' => $billing])}}" method="get">
                        <button type="submit" class="btn btn-link">Edit</button>
                        </form>
                    <span>/</span>
                    <form action="{{route('client.billing.destroy', ['client' => $client, 'billing' => $billing->id])}}" method="POST">
                      @csrf
                      @method('DELETE')
                        <button type="submit" class="btn btn-link">Delete</button>
                    </form>
                </div>
            </td>
          </tr>
        @endforeach
    </tbody>
  </table>


  <nav>
    <ul class="pagination" style="justify-content:center">
      <li class="page-item {{ $billings->onFirstPage() ? 'disabled' : '' }}">
        <a class="page-link" href="{{$billings->previousPageUrl()}}">Previous</a>
      </li>
      <li class="page-item  {{ $billings->hasMorePages() ? '' : 'disabled' }}">
        <a class="page-link" href="{{$billings->nextPageUrl()}}">Next</a>
      </li>
    </ul>
  </nav>
  @else
  <div style="display: block; text-align:center; margin-top: 10%; color:grey;">
    <h5>
      No Billing Information
    </h5>
  </div>
  @endif

  <form action="{{route('client.billing.create', ['client' => $client])}}" method="get">
    <div class="d-grid gap-1">
      <button class="btn btn-primary" type="submit">Add Billing</button>
    </div>
</form>
    

@endsection