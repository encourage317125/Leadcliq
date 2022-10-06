@extends('layouts.main')

@section('main')

<h1>Edit Invitation</h1>
{{ Form::model($invitation, array('method' => 'PATCH', 'route' => array('invitations.update', $invitation->id))) }}
    <ul>
        <li>
            {{ Form::label('user_id', 'User_id:') }}
            {{ Form::input('number', 'user_id') }}
        </li>

        <li>
            {{ Form::label('team_id', 'Team_id:') }}
            {{ Form::input('number', 'team_id') }}
        </li>

        <li>
            {{ Form::label(' token', ' Token:') }}
            {{ Form::text(' token') }}
        </li>

        <li>
            {{ Form::label('status', 'Status:') }}
            {{ Form::input('number', 'status') }}
        </li>

        <li>
            {{ Form::label('name', 'Name:') }}
            {{ Form::text('name') }}
        </li>

        <li>
            {{ Form::label('email', 'Email:') }}
            {{ Form::text('email') }}
        </li>

        <li>
            {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
            {{ link_to_route('invitations.show', 'Cancel', $invitation->id, array('class' => 'btn')) }}
        </li>
    </ul>
{{ Form::close() }}

@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif

@stop