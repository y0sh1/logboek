@extends('layouts.application')

@section('content')

@if($entry->isNew())
{{ Form::open(['route' => ['logbooks.entries.store', $logbook->id]]) }}
@else
{{ Form::open(['route' => ['logbooks.entries.update', $logbook->id, $entry->id], 'method' => 'put']) }}
@endif

<div class="form-group">
	{{ Form::label('title', 'Titel') }}
	{{ Form::text('title', $entry->title, ['class' => 'form-control']) }}
</div>

<div class="form-group">
	{{ Form::label('body', 'Inhoud') }}
	{{ Form::textarea('body', $entry->body, ['class' => 'form-control markdown', 'rows' => 20]) }}
	<p><em>Je kunt bij het schrijven gebruik maken van <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Here-Cheatsheet">Markdown</a>.</em></p>
</div>

<div class="form-group">
	{{ Form::label('started_at', 'Begonnen om') }}
	{{ Form::text('started_at', $entry->started_at, ['class' => 'form-control']) }}
</div>

<div class="form-group">
	{{ Form::label('finished_at', 'Afgemaakt om') }}
	{{ Form::text('finished_at', $entry->finished_at, ['class' => 'form-control', 'placeholder' => 'Als je dit leeg laat wordt het de datum dat je op "Opslaan" drukt']) }}
</div>

<div class="form-group">
        {{ Form::label('who', 'Wie') }}
        {{ Form::text('who', $entry->who, ['class' => 'form-control']) }}
</div>

<div class="form-group">
        {{ Form::label('what', 'Wat') }}
        {{ Form::text('what', $entry->what, ['class' => 'form-control']) }}
</div>

<div class="form-group">
        {{ Form::label('where', 'Waar') }}
        {{ Form::text('where', $entry->where, ['class' => 'form-control']) }}
</div>

<div class="form-group">
        {{ Form::label('which', 'Welk') }}
        {{ Form::text('which', $entry->which, ['class' => 'form-control']) }}
</div>

<div class="form-group">
        {{ Form::label('way', 'Welke wijze') }}
        {{ Form::text('way', $entry->way, ['class' => 'form-control']) }}
</div>

<div class="form-group">
        {{ Form::label('when', 'Wanneer') }}
        {{ Form::text('when', $entry->when, ['class' => 'form-control']) }}
</div>

<div class="form-group">
        {{ Form::label('why', 'Waarom') }}
        {{ Form::text('why', $entry->why, ['class' => 'form-control']) }}
</div>

<button type="submit" class="btn btn-primary pull-left">Opslaan</button>

{{ Form::close() }}

@if(!$entry->isNew())

<div class="pull-right">
	@include('entries.delete_form', ['entry' => $entry])
</div>

@endif

@stop
