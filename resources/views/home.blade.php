@extends('layouts.user')

@section('content')
<div id="app">
    {{-- <div class="container"> --}}
        <div class="row">
            <div class="container-fluid">
                <g-map></g-map>
                <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Chat Room
                        <span class="badge pull-right">
                            @{{ usersInRoom.length}}</span>
                        </span>
                        <chat-log :messages="messages"></chat-log>
                        <chat-composer v-on:messagesent="addMessage"></chat-composer>
                        
                    </div>
                </div>
                </div>
            </div>
        </div>
    {{-- </div> --}}
</div>

{{-- <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
