@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-left">

            <h1>Issues</h1>

            <table>
                @foreach ($issues as $issue)
                    <tr>
                        <td>{{$issue->id}}</td>
                        <td>{{$issue->title}}</td>
                        <td><a href="{{ route('issue.show', $issue->id) }}">Open</a></td>
                        <td><a href="{{ route('issue.edit', $issue->id) }}">Edit</a></td>
                    </tr>
                @endforeach
            </table>

        </div>
    </div>

@endsection
