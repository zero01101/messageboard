@extends('default')
@section('content')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="_current_board" value="{{ $board_id }}">
    <br />
    <div class="control-group">
        <a href="javascript:post();" class="btn btn-primary" data-step="1" data-intro="so, you click this button, it takes you to a form where you write a post...">
            add new msg
        </a>
        <a href="javascript:void(0);" class="btn btn-info" onclick="javascript:introJs().start();">?</a>
        <br />
        <br />
        <div class="dropdown">
            <a class="dropdown-toggle btn btn-default" type="button" id="dropdown_messageboards" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  data-step="3" data-intro="you can choose to view a specific messageboard with this list">
                messageboards
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdown_messageboards">
                @foreach($boards as $board)
                    <li><option class="dropdownValue" value="<?php echo $board['id']?>"><?php echo $board['title']?></option></li>
                @endforeach
            </ul>
            <b>viewing: {{ $title }}</b>
        </div>
    </div>
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
    <a href="view?cf=yesplz" class="btn btn-default pull-right bottom" data-step="4" data-intro="...?????">&pi;</a>
@stop
@section('footer')
    <script>
        $('option').click(function(e) {
            document.location = "//<?php echo getenv('APP_HOST') . '/' . getenv('APP_PATH') . '/'?>view/" + this.value;
        });

        function post() {
            document.location = "//<?php echo getenv('APP_HOST') . '/' . getenv('APP_PATH') . '/'?>post/" + <?php echo $board_id ?>;
        }

    </script>
@stop