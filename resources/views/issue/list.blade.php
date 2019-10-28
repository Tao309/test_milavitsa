@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-left">

            <div class="page-header"><h1>Issues</h1></div>

            <table class="table">
                <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">InWork</th>
                    <th scope="col">Closed</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col">Author</th>
                </tr>
                </thead>
                @foreach ($issues as $issue)
                    @php
                        /**  @var \App\models\Issue $issue */

                        $inwork = (!empty($issue->manager->id)) ? 'Yes' : 'No';
                        $closed = ($issue->closed) ? 'Yes' : 'No';
                    @endphp

                    <tr>
                        <td>{{$issue->id}}</td>
                        <td>{{$issue->title}}</td>
                        <th scope="col">{{ $inwork }}</th>
                        <th scope="col">{{ $closed }}</th>
                        <td><a class="btn btn-light" href="{{ route('issue.show', $issue->id) }}">Open</a></td>
                        <td><a class="btn btn-primary" href="{{ route('issue.edit', $issue->id) }}">Edit</a></td>
                        <td>{{ $issue->author->name }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endsection
