@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    @php
                        /**  @var \App\models\Issue $issue */
                    @endphp

                    @if($issue->exists)
                        <div class="card-header">Issue #{{$issue->id}}: {{$issue->title}}</div>
                        <form method="POST" action="{{ route('issue.update', $issue->id) }}">
                            @method('PATCH')
                    @else
                        <div class="card-header">Add new Issue</div>
                        <form method="POST" action="{{ route('issue.store') }}">
                    @endif

                    <div class="card-body">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Title</label>

                                <div class="col-md-6">
                                    @php
                                    $title = $issue->exists ? $issue->title : old('title');
                                    @endphp

                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $title }}" required autocomplete="title" autofocus/>

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Message</label>

                                <div class="col-md-6">
                                    @php
                                        $message = $issue->exists ? $issue->message : old('message');
                                    @endphp
                                    <input id="message" type="text" class="form-control @error('message') is-invalid @enderror" name="message" value="{{ $message }}" required autocomplete="current-message"/>

                                    @error('message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>



                <div class="form-group row">
                    <label for="file" class="col-md-4 col-form-label text-md-right">File</label>

                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="file">
                                <label class="custom-file-label" for="file">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>


                    @if($issue->exists)
                        <div class="form-group row">
                            <label for="file" class="col-md-4 col-form-label text-md-right">Author</label>

                            <div class="col-md-6">
                                {{$issue->author->name}}
                            </div>
                        </div>

                        @if(Auth::user()->role == 'manager')
                            <div class="form-group row">
                                <label for="file" class="col-md-4 col-form-label text-md-right">Answer</label>

                                <div class="col-md-6">
                                    <input id="answer" type="text" class="form-control @error('answer') is-invalid @enderror" name="answer" value="{{ $issue->answer }}" autocomplete="current-message"/>
                                </div>
                            </div>
                        @endif

                            <div class="form-group row">
                                <label for="file" class="col-md-4 col-form-label text-md-right">Closed</label>

                                <div class="col-md-6">
                                    <div class="custom-control-inline custom-control custom-checkbox">@php
                                            $checked = ($issue->closed) ? 'checked' : '';
                                        @endphp
                                        <input type="checkbox" name="closed" value="0" hidden checked/>
                                        <input type="checkbox" class="custom-control-input" id="closed" name="closed" value="1" {{ $checked }}/>
                                        <label class="custom-control-label" for="closed"></label>
                                    </div>
                                </div>
                            </div>
                    @endif

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                        @if($issue->exists)
                                        <button type="submit" class="btn btn-primary btn-success">
                                            Save
                                        @else
                                        <button type="submit" class="btn btn-primary">
                                            Add
                                        @endif
                                    </button>
                                </div>
                            </div>

                        </form>

                        @if($issue->exists)
                            <br/>
                            <form method="POST" action="{{ route('issue.destroy', $issue->id) }}">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-primary btn-danger">Delete Issue</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
