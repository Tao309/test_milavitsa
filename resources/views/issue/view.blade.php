@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="content">
            <h1>Issue: {{$issue->title}}</h1>

            <table>
                <tr>
                    <td>Title</td>
                    <td>
                        {{$issue->title}}
                    </td>
                </tr>
                <tr>
                    <td>Message</td>
                    <td>
                        {{$issue->message}}
                    </td>
                </tr>
                <tr>
                    <td>Author</td>
                    <td>
                        {{$issue->author->name}}
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection
