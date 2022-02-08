@extends('layouts.master')

@section('content')


@if (count($billings))
  
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Amount</th>
            <th scope="col">Due Date</th>
            <th scope="col">Description</th>
            <th scope="col">Client ID</th>
            <th scope="col">Client Name</th>
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
                <td>{{$billing->client_id}}</td>
                <td>{{$billing->client->name}}</td>
                <td> 
                    <div style="display: flex; align-items:baseline">
                        <form action="{{route('billing.destroy', ['billing' => $billing->id])}}" method="POST">
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

@endsection