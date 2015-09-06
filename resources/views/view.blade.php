@extends('default')
@section('content')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="_current_board" value="{{ $board_id }}">

    <!-- Post Message Modal -->
    <div class="modal fade" id="post_modal" tabindex="-1" role="dialog" aria-labelledby="post_modal_label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="post_modal_label">post new message</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::open(['url' => 'post', 'method' => 'post']) !!}
                        {!! Form::hidden('ip', $ip) !!}
                        {!! Form::hidden('_current_board', $board_id) !!}
                        <div>
                            posting to: <select id="combobox" name="board_id" class="btn btn-default">
                                @foreach($boards as $board)
                                    <?php $selected = ' '?>
                                    @if($board['id'] == $board_id)
                                        <?php $selected = ' selected'?>
                                    @endif
                                    <option value="<?php echo $board['id']?>"{{ $selected }}><?php echo $board['title']?></option>
                                @endforeach
                            </select>

                        </div>
                        <p/>

                        <div>
                            {!! Form::text('msg', null, ['class' => 'form-control', 'autofocus' => 'autofocus', 'id' => 'msgtxt']) !!}
                        </div>
                        <p/>

                        <div>
                            {!! Form::submit('add msg', ['class' => 'btn btn-primary form-control']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- New Board Modal -->
    <div class="modal fade" id="board_modal" tabindex="-1" role="dialog" aria-labelledby="board_modal_label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="board_modal_label">create new board</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::open(['url' => 'create', 'method' => 'post']) !!}
                        {!! Form::hidden('ip', $ip) !!}
                        <div class="form-group">
                            <div>
                                {!! Form::text('title', null, ['class' => 'form-control', 'autofocus' => 'autofocus', 'id' => 'title']) !!}
                            </div>
                            <br/>

                            <div>
                                {!! Form::submit('create board', ['class' => 'btn btn-primary form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
                </div>
            </div>
        </div>
    </div>

    <br/>
    <div class="control-group">
        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#post_modal" board_id="{{ $board_id }}"
           data-step="1" data-intro="so, you click this button, it takes you to a form where you write a post...">add
            new msg</a>
        <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#board_modal" data-step="4"
           data-intro="...and you can create a brand new messageboard with this button!">create new board</a>
        <a href="javascript:void(0);" class="btn btn-info" onclick="javascript:introJs().start();">?</a>
        <br/>
        <br/>

        <div class="dropdown">
            <a class="dropdown-toggle btn btn-default" type="button" id="dropdown_messageboards" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false" data-step="3"
               data-intro="you can choose to view a specific messageboard with this list...">
                messageboards
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdown_messageboards">
                @foreach($boards as $board)
                    <li>
                        <option class="dropdownValue" value="{{ $board['id'] }}">{{ $board['title'] }}</option>
                    </li>
                @endforeach
            </ul>
            <b>viewing: {{ $title }}</b>
        </div>
    </div>
    <br/>
    <div class="control-group well" data-step="2"
         data-intro="...and they all show up here afterward! messages in bold are from posted from your current IP address.">
        @foreach($messages as $message)
            <?php
            $testvar = $message->message;
            if (filter_var($testvar, FILTER_VALIDATE_URL)) {
                $msg = '<a href="' . $testvar . '">' . $testvar . '</a>';
            } else {
                $msg = $testvar;
            }
            ?>
            <message>
                <p>
                    @if($message->author_ip == $ip)
                        <b>you</b> said (at {{ $message->created_at }}): <b>{!! $msg !!}</b>
                    @else
                        {{ $message->author_ip }} said (at {{ $message->created_at }}): {!! $msg !!}
                    @endif
                </p>
            </message>
        @endforeach
    </div>
@stop
@section('footer')
    <script>
        $('.dropdownValue').click(function (e) {
            document.location = "//<?php echo getenv('APP_HOST') . '/' . getenv('APP_PATH') . '/'?>view/" + this.value;
        });
        $('#post_modal').on('shown.bs.modal', function () {
            $('#msgtxt').focus()
        })
        $('#board_modal').on('shown.bs.modal', function () {
            $('#title').focus()
        })
    </script>
@stop