@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="content">
            <div class="page-header"><h1>Issue: {{$issue->title}}</h1></div>

            @php
                /**  @var \App\models\Issue $issue */

                $inwork = (!empty($issue->manager->id)) ? 'Yes' : 'No';
                $closed = ($issue->closed) ? 'Yes' : 'No';
            @endphp

            <table class="table">
                <tr>
                    <td class="table-active">Title</td>
                    <td>
                        {{$issue->title}}
                    </td>
                </tr>
                <tr>
                    <td class="table-active">Message</td>
                    <td>
                        {{$issue->message}}
                    </td>
                </tr>
                <tr>
                    <td class="table-active">Author</td>
                    <td>
                        {{$issue->author->name}}
                    </td>
                </tr>
                <tr>
                    @php
                        $class = (!empty($issue->manager->id)) ? 'table-success' : 'table-active';
                    @endphp
                    <td class="{{ $class }}">InWork</td>
                    <td>
                        {{ $inwork }}
                    </td>
                </tr>
                <tr>
                    <td class="table-active">Closed</td>
                    <td>
                        {{ $closed }}
                    </td>
                </tr>
                <tr>
                    @php
                        $class = (!empty(trim($issue->answer))) ? 'table-success' : 'table-active';
                    @endphp

                    <td class="{{ $class }}">Answer</td>
                    <td>
                        {{ $issue->answer }}
                    </td>
                </tr>
            </table>
        </div>

        <form method="POST" action="{{ route('issue.takeInWork', $issue->id) }}">
            @method('PUT')
            @csrf
            <button type="submit" class="btn btn-primary btn-success">Take In Work</button>
        </form>
    </div>
@endsection
