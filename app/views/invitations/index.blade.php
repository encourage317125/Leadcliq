@extends('layouts.main')

@section('main')

<h1>All Invitations</h1>

<p>{{ link_to_route('invitations.create', 'Add new invitation') }}</p>

@if ($invitations->count())
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>User_id</th>
				<th>Team_id</th>
				<th> Token</th>
				<th>Status</th>
				<th>Name</th>
				<th>Email</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($invitations as $invitation)
                <tr>
                    <td>{{{ $invitation->user_id }}}</td>
					<td>{{{ $invitation->team_id }}}</td>
					<td>{{{ $invitation-> token }}}</td>
					<td>{{{ $invitation->status }}}</td>
					<td>{{{ $invitation->name }}}</td>
					<td>{{{ $invitation->email }}}</td>
                    <td>{{ link_to_route('invitations.edit', 'Edit', array($invitation->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('invitations.destroy', $invitation->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-default')) }}
                        {{ Form::close() }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    There are no invitations
@endif

@stop