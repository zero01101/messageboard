@extends('default')
@section('content')
{!! Form::open() !!}
<a href="javascript:void(0);" class="btn btn-info" onclick="javascript:introJs().start();">?</a>
<p data-step="1" data-intro="this is the IP address you're posting from; this also determines which posts are bolded">posting from {{ $ip }}</p>
<div class="form-group">
    {!! Form::hidden('ip', $ip) !!}
    {!! Form::label('msg', 'message:') !!}
    <div data-step="2" data-intro="this is where you type your message">
        {!! Form::text('msg', null, ['class' => 'form-control']) !!}
    </div>
    <p/>
    <div data-step="3" data-intro="push this when you're done!">
        {!! Form::submit('add msg', ['class' => 'btn btn-primary form-control']) !!}
    </div>
</div>
@stop