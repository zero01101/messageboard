@extends('default')
@section('content')
{!! Form::open() !!}
<input type="hidden" name="_current_board" value="{{ $board_id }}">
<a href="javascript:(goback);" class="btn btn-default" data-step="1" data-intro="click this to go back to the messageboard without posting"><b><<</b></a>
<a href="javascript:void(0);" class="btn btn-info" onclick="javascript:introJs().start();">?</a>
<p data-step="2" data-intro="this is the IP address you're posting from; this also determines which posts are bolded">posting from {{ $ip }}</p>
<div class="form-group">
    {!! Form::hidden('ip', $ip) !!}
    {!! Form::label('msg', 'message:') !!}
    <div data-step="3" data-intro="this is where you type your message">
        {!! Form::text('msg', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
    </div>
    <p/>
    <div data-step="4" data-intro="push this when you're done!">
        {!! Form::submit('add msg', ['class' => 'btn btn-primary form-control']) !!}
    </div>
</div>
<div class="form-group">
    <div class="control-group" data-step="5" data-intro="here are the 5 most recent messages, for your posting convenience :)">
        @foreach($messages as $message)
            <?php
            $testvar = $message->message;
            if (filter_var($testvar, FILTER_VALIDATE_URL)) {
                $msg = '<a href="' . $testvar . '">'. $testvar . '</a>';
            } else {
                $msg = $testvar;
            }
            ?>
            <message>
                <p>
                    <?php $detected_ip = $_SERVER['REMOTE_ADDR'] ?>
                    @if($message->author_ip == $detected_ip)
                        <b>you</b> said (at {{ $message->created_at }}): <b>{!! $msg !!}</b>
                    @else
                        {{ $message->author_ip }} said (at {{ $message->created_at }}): {!! $msg !!}
                    @endif
                </p>
            </message>
        @endforeach
    </div>
</div>
@stop
@section('footer')
    <script>
        function goback() {
            document.location = "//<?php echo getenv('APP_HOST') . '/' . getenv('APP_PATH') . '/view/' . $board_id ?>";
        }
    </script>
@stop