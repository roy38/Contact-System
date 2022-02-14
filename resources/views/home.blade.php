@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- {{ __('You are logged in!') }} -->
                    <p>Contacts Table <a href="/create"><button class="btn btn-primary" id="createContact">Create</button></a></p>
                    <br>
                    <br>
                    <!-- {{ Auth::user()->name }}
                    {{ Auth::user()->id }} -->

                <div class="container mb-30">
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            @if ( count($contacts) > 0 )
                            Search: <input type="text" name="search" id="search" class="form-control">
                            @else
                            Search: <input type="text" name="search" id="search" class="form-control" disabled="disabled">
                            @endif
                        </div>
                    </div>
                </div>

                @if ( count($contacts) > 0 )

                <table class="table">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Company</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody id="results">

                        @foreach ($contacts as $contact)
                  
                        <tr>
                            <td><!--{{ $contact->id }}--> {{ $contact->name }}</td>
                            <td>{{ $contact->company }}</td>
                            <td>{{ $contact->phone }}</td>
                            <td>{{ $contact->email }}</td>
                            <td><a class="action-text" href="/edit/{{ $contact->id }}"><button class="btn btn-success">EDIT</button></a>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal{{$contact->id}}">DELETE</button>
                            </td>
                        </tr>  

                        <!-- Modal -->
                        <div id="myModal{{$contact->id}}" class="modal fade" role="dialog">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-body">
                                <p style="font-size: 20px;">Are you sure you want to DELETE?</p>
                                <form method="POST" action = "{{ route('delete', $contact->id) }}"> @csrf @method('DELETE') <button class="btn btn-danger delete-ni">YES{{$contact->id}}</button></form>
                                <button class="btn btn-success" data-dismiss="modal">NO</button>
                              </div>
                            </div>
                          </div>
                        </div>

                        @endforeach

                    </tbody>
                  </table>
                  <div class="pagi-list">
                    {{ $contacts->links() }}
                  </div>

                  @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="results">
                            <tr>
                                <td class="no-results">No Results</td>
                            </tr>
                        </tbody>
                    </table>
                  @endif

                </div>
            </div>
        </div>
    </div>
</div>

@endsection