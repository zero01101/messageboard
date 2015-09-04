@extends('default')
@section('content')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <a href="post" class="btn btn-primary" data-step="1" data-intro="so, you click this button, it takes you to a form where you write a post...">
        add new msg
    </a>
    <a href="javascript:void(0);" class="btn btn-info" onclick="javascript:introJs().start();">?</a>
    <br />
    <br />
    <div class="control-group" data-step="2" data-intro="...and they all show up here afterward! messages in bold are from posted from your current IP address.">
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
    <a href="view?cf" class="btn btn-default pull-right bottom" data-step="3" data-intro="...?????">&pi;</a>
@stop