@extends('layouts.admin_layout')

@section('title', 'Parents Chat')

@section('extra_css')
    <style>
        .fa-2x {
            font-size: 1.5em;
        }

        .app {
            position: relative;
            overflow: hidden;
            top: 19px;
            height: calc(100% - 38px);
            margin: auto;
            padding: 0;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .06), 0 2px 5px 0 rgba(0, 0, 0, .2);
        }

        .app-one {
            background-color: #f7f7f7;
            height: 100%;
            overflow: hidden;
            margin: 0;
            padding: 0;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .06), 0 2px 5px 0 rgba(0, 0, 0, .2);
        }

        .side {
            padding: 0;
            margin: 0;
            height: 100%;
        }
        .side-one {
            padding: 0;
            margin: 0;
            height: 100%;
            width: 100%;
            z-index: 1;
            position: relative;
            display: block;
            top: 0;
        }

        .side-two {
            padding: 0;
            margin: 0;
            height: 100%;
            width: 100%;
            z-index: 2;
            position: relative;
            top: -100%;
            left: -100%;
            -webkit-transition: left 0.3s ease;
            transition: left 0.3s ease;

        }


        .heading {
            padding: 10px 16px 10px 15px;
            margin: 0;
            height: 60px;
            width: 100%;
            background-color: #eee;
            z-index: 1000;
        }

        .heading-avatar {
            padding: 0;
            cursor: pointer;

        }

        .heading-avatar-icon img {
            border-radius: 50%;
            height: 40px;
            width: 40px;
        }

        .heading-name {
            padding: 0 !important;
            cursor: pointer;
        }

        .heading-name-meta {
            font-weight: 700;
            font-size: 100%;
            padding: 5px;
            padding-bottom: 0;
            text-align: left;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: #000;
            display: block;
        }
        .heading-online {
            display: none;
            padding: 0 5px;
            font-size: 12px;
            color: #93918f;
        }
        .heading-compose {
            padding: 0;
        }

        .heading-compose i {
            text-align: center;
            padding: 5px;
            color: #93918f;
            cursor: pointer;
        }

        .heading-dot {
            padding: 0;
            margin-left: 10px;
        }

        .heading-dot i {
            text-align: right;
            padding: 5px;
            color: #93918f;
            cursor: pointer;
        }

        .searchBox {
            padding: 0 !important;
            margin: 0 !important;
            height: 60px;
            width: 100%;
        }

        .searchBox-inner {
            height: 100%;
            width: 100%;
            padding: 10px !important;
            background-color: #fbfbfb;
        }


        /*#searchBox-inner input {
          box-shadow: none;
        }*/

        .searchBox-inner input:focus {
            outline: none;
            border: none;
            box-shadow: none;
        }

        .sideBar {
            padding: 0 !important;
            margin: 0 !important;
            background-color: #fff;
            overflow-y: auto;
            border: 1px solid #f7f7f7;
            height: calc(100% - 120px);
        }

        .sideBar-body {
            position: relative;
            padding: 10px !important;
            border-bottom: 1px solid #f7f7f7;
            height: 72px;
            margin: 0 !important;
            cursor: pointer;
        }

        .sideBar-body:hover {
            background-color: #f2f2f2;
        }

        .sideBar-avatar {
            text-align: center;
            padding: 0 !important;
        }

        .avatar-icon img {
            border-radius: 50%;
            height: 49px;
            width: 49px;
        }

        .sideBar-main {
            padding: 0 !important;
        }

        .sideBar-main .row {
            padding: 0 !important;
            margin: 0 !important;
        }

        .sideBar-name {
            padding: 10px !important;
        }

        .name-meta {
            font-size: 100%;
            padding: 1% !important;
            text-align: left;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: #000;
        }

        .sideBar-time {
            padding: 10px !important;
        }

        .time-meta {
            text-align: right;
            font-size: 12px;
            padding: 1% !important;
            color: rgba(0, 0, 0, .4);
            vertical-align: baseline;
        }

        /*New Message*/

        .newMessage {
            padding: 0 !important;
            margin: 0 !important;
            height: 100%;
            position: relative;
            left: -100%;
        }
        .newMessage-heading {
            padding: 10px 16px 10px 15px !important;
            margin: 0 !important;
            height: 100px;
            width: 100%;
            background-color: #00bfa5;
            z-index: 1001;
        }

        .newMessage-main {
            padding: 10px 16px 0 15px !important;
            margin: 0 !important;
            height: 60px;
            margin-top: 30px !important;
            width: 100%;
            z-index: 1001;
            color: #fff;
        }

        .newMessage-title {
            font-size: 18px;
            font-weight: 700;
            padding: 10px 5px !important;
        }
        .newMessage-back {
            text-align: center;
            vertical-align: baseline;
            padding: 12px 5px !important;
            display: block;
            cursor: pointer;
        }
        .newMessage-back i {
            margin: auto !important;
        }

        .composeBox {
            padding: 0 !important;
            margin: 0 !important;
            height: 60px;
            width: 100%;
        }

        .composeBox-inner {
            height: 100%;
            width: 100%;
            padding: 10px !important;
            background-color: #fbfbfb;
        }

        .composeBox-inner input:focus {
            outline: none;
            border: none;
            box-shadow: none;
        }

        .compose-sideBar {
            padding: 0 !important;
            margin: 0 !important;
            background-color: #fff;
            overflow-y: auto;
            border: 1px solid #f7f7f7;
            height: calc(100% - 160px);
        }

        /*Conversation*/

        .conversation {
            padding: 0 !important;
            margin: 0 !important;
            height: 100%;
            /*width: 100%;*/
            border-left: 1px solid rgba(0, 0, 0, .08);
            /*overflow-y: auto;*/
        }

        .message {
            padding: 0 !important;
            margin: 0 !important;
            background-size: cover;
            overflow-y: auto;
            border: 1px solid #f7f7f7;
            height: calc(100% - 120px);
        }
        .message-previous {
            margin : 0 !important;
            padding: 0 !important;
            height: auto;
            width: 100%;
        }
        .previous {
            font-size: 15px;
            text-align: center;
            padding: 10px !important;
            cursor: pointer;
        }

        .previous a {
            text-decoration: none;
            font-weight: 700;
        }

        .message-body {
            margin: 0 !important;
            padding: 0 !important;
            width: auto;
            height: auto;
        }

        .message-main-receiver {
            /*padding: 10px 20px;*/
            max-width: 60%;
        }

        .message-main-sender {
            padding: 3px 20px !important;
            margin-left: 40% !important;
            max-width: 60%;
        }

        .message-text {
            margin: 0 !important;
            padding: 5px !important;
            word-wrap:break-word;
            font-weight: 200;
            font-size: 14px;
            padding-bottom: 0 !important;
        }

        .message-time {
            margin: 0 !important;
            margin-left: 50px !important;
            font-size: 12px;
            text-align: right;
            color: #9a9a9a;

        }

        .receiver {
            width: auto !important;
            padding: 4px 10px 7px !important;
            border-radius: 10px 10px 10px 0;
            background: #ffffff;
            font-size: 12px;
            text-shadow: 0 1px 1px rgba(0, 0, 0, .2);
            word-wrap: break-word;
            display: inline-block;
        }

        .sender {
            float: right;
            width: auto !important;
            background: #dcf8c6;
            border-radius: 10px 10px 0 10px;
            padding: 4px 10px 7px !important;
            font-size: 12px;
            text-shadow: 0 1px 1px rgba(0, 0, 0, .2);
            display: inline-block;
            word-wrap: break-word;
        }


        /*Reply*/

        .reply {
            height: 60px;
            width: 100%;
            background-color: #f5f1ee;
            padding: 10px 5px 10px 5px !important;
            margin: 0 !important;
            z-index: 1000;
        }

        .reply-emojis {
            padding: 5px !important;
        }

        .reply-emojis i {
            text-align: center;
            padding: 5px 5px 5px 5px !important;
            color: #93918f;
            cursor: pointer;
        }

        .reply-recording {
            padding: 5px !important;
        }

        .reply-recording i {
            text-align: center;
            padding: 5px !important;
            color: #93918f;
            cursor: pointer;
        }

        .reply-send {
            padding: 5px !important;
        }

        .reply-send i {
            text-align: center;
            padding: 5px !important;
            color: #93918f;
            cursor: pointer;
        }

        .reply-main {
            padding: 2px 5px !important;
        }

        .reply-main textarea {
            width: 100%;
            resize: none;
            overflow: hidden;
            padding: 5px !important;
            outline: none;
            border: none;
            text-indent: 5px;
            box-shadow: none;
            height: 100%;
            font-size: 16px;
        }

        .reply-main textarea:focus {
            outline: none;
            border: none;
            text-indent: 5px;
            box-shadow: none;
        }

        @media screen and (max-width: 700px) {
            .app {
                top: 0;
                height: 100%;
            }
            .heading {
                height: 70px;
                background-color: #009688;
            }
            .fa-2x {
                font-size: 2.3em !important;
            }
            .heading-avatar {
                padding: 0 !important;
            }
            .heading-avatar-icon img {
                height: 50px;
                width: 50px;
            }
            .heading-compose {
                padding: 5px !important;
            }
            .heading-compose i {
                color: #fff;
                cursor: pointer;
            }
            .heading-dot {
                padding: 5px !important;
                margin-left: 10px !important;
            }
            .heading-dot i {
                color: #fff;
                cursor: pointer;
            }
            .sideBar {
                height: calc(100% - 130px);
            }
            .sideBar-body {
                height: 80px;
            }
            .sideBar-avatar {
                text-align: left;
                padding: 0 8px !important;
            }
            .avatar-icon img {
                height: 55px;
                width: 55px;
            }
            .sideBar-main {
                padding: 0 !important;
            }
            .sideBar-main .row {
                padding: 0 !important;
                margin: 0 !important;
            }
            .sideBar-name {
                padding: 10px 5px !important;
            }
            .name-meta {
                font-size: 16px;
                padding: 5% !important;
            }
            .sideBar-time {
                padding: 10px !important;
            }
            .time-meta {
                text-align: right;
                font-size: 14px;
                padding: 4% !important;
                color: rgba(0, 0, 0, .4);
                vertical-align: baseline;
            }
            /*Conversation*/
            .conversation {
                padding: 0 !important;
                margin: 0 !important;
                height: 100%;
                /*width: 100%;*/
                border-left: 1px solid rgba(0, 0, 0, .08);
                /*overflow-y: auto;*/
            }
            .message {
                height: calc(100% - 140px);
            }
            .reply {
                height: 70px;
            }
            .reply-emojis {
                padding: 5px 0 !important;
            }
            .reply-emojis i {
                padding: 5px 2px !important;
                font-size: 1.8em !important;
            }
            .reply-main {
                padding: 2px 8px !important;
            }
            .reply-main textarea {
                padding: 8px !important;
                font-size: 18px;
            }
            .reply-recording {
                padding: 5px 0 !important;
            }
            .reply-recording i {
                padding: 5px 0 !important;
                font-size: 1.8em !important;
            }
            .reply-send {
                padding: 5px 0 !important;
            }
            .reply-send i {
                padding: 5px 2px 5px 0 !important;
                font-size: 1.8em !important;
            }
        }
    </style>
@endsection

@section('content')


    <div class="container app">
        <div class="app-one" style="width:95%;height:81vh;">
            <div class="col-sm-3 side">
                <div class="side-one">
                    <div class="row heading">
                        <div class="col-sm-3 col-xs-3 heading-avatar">
                            <div class="heading-avatar-icon">
                                <img style="visibility: hidden;" src="https://bootdey.com/img/Content/avatar/avatar1.png">
                            </div>
                        </div>

                    </div>


                    <div class="row sideBar">
                        @if(sizeof($chats))
                            @foreach($chats as $chat)
                                <div class="row sideBar-body" data-chat="{{ json_encode($chat) }}">
                                    <div class="col-sm-3 col-xs-3 sideBar-avatar">
                                        <div class="avatar-icon">
                                            <img src="https://bootdey.com/img/Content/avatar/avatar1.png">
                                        </div>
                                    </div>
                                    <div class="col-sm-9 col-xs-9 sideBar-main">
                                        <div class="row">
                                            <div class="col-sm-8 col-xs-8 sideBar-name">
                                                <span class="name-meta">{!! $chat['parent_name'] !!}</span>
                                            </div>
                                            <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                                                <span class="time-meta pull-right">{!! $chat['date'] !!}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row sideBar-body">
                                <div class="col-sm-9 col-xs-9 sideBar-main">
                                    <p class="text-center">No conversations</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="side-two">
                    <div class="row newMessage-heading">
                        <div class="row newMessage-main">
                            <div class="col-sm-2 col-xs-2 newMessage-back">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                            </div>
                            <div class="col-sm-10 col-xs-10 newMessage-title">
                                New Chat
                            </div>
                        </div>
                    </div>

                    <div class="row composeBox">
                        <div class="col-sm-12 composeBox-inner">
                            <div class="form-group has-feedback">
                                <input id="composeText" type="text" class="form-control" name="searchText" placeholder="Search People">
                                <span class="glyphicon glyphicon-search form-control-feedback"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-9 conversation active-chat hidden">
                <div class="row heading">
                    <div class="col-sm-2 col-md-1 col-xs-3 heading-avatar">
                        <div class="heading-avatar-icon">
                            <img src="https://bootdey.com/img/Content/avatar/avatar6.png">
                        </div>
                    </div>
                    <div class="col-sm-8 col-xs-7 heading-name">
                        <a class="heading-name-meta" href="javascript:void(0)" id="chat-header"></a>
                        <span class="heading-online">Online</span>
                    </div>
                    <div class="col-sm-1 col-xs-1  heading-dot pull-right">
                        <i class="fa fa-ellipsis-v fa-2x  pull-right" aria-hidden="true"></i>
                    </div>
                </div>

                <div class="row message" id="conversation" style="max-height:100%;overflow-y: scroll;">

                </div>

                <form action="{{ route('admin_send_chat_msg') }}" method="POST" id="sendMsg">
                    @csrf
                    <input type="hidden" name="chat_id" id="chat-id">
                    <input type="hidden" name="recipient_id" id="recipient-id">
                    <div class="row reply">
                        <div class="col-sm-1 col-xs-1 reply-emojis">
                            <i class="fa fa-smile-o fa-2x"></i>
                        </div>
                        <div class="col-sm-9 col-xs-9 reply-main">
                            <textarea name="message" class="form-control" rows="1"></textarea>
                        </div>
                        <div class="col-sm-1 col-xs-1 reply-recording">
                            <i class="fa fa-microphone fa-2x" aria-hidden="true"></i>
                        </div>
                        <div class="col-sm-1 col-xs-1 reply-send">
                            <i class="send-btn fa fa-send fa-2x" aria-hidden="true"></i>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-sm-9 new-chat conversation">
                <div class="col-sm-12" style="height: 100%;display: flex;justify-content: center; align-items: center;">
                    <h4><a href="javascript:void(0)" data-toggle="modal" data-target="#newChatModal"><i class="fa fa-envelope-open"></i>&nbsp;   New Chat</a></h4>
                </div>
            </div>
        </div>
    </div>

    <!-- New chat Modal -->
    <div id="newChatModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">New Chat</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin_send_msg') }}" method="POST" class="form-horizontal form-bordered" enctype="multipart/form-data"
                    >

                        @csrf
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Select Parent</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="parent_id">
                                    <option disabled selected>~select parent~</option>
                                    @foreach($parents as $parent)
                                        <option value="{!! $parent->id !!}">{!! ucwords($parent->name) !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Message</label>
                            <div class="col-sm-8">
                                <textarea name="message" placeholder="Message" id="" rows="5" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-success" type="submit">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection
@section('extra_js')

    <script>
        $(document).ready(function () {

            $(".sideBar-body").on('click', function(){
                $(".new-chat").addClass('hidden');
                $(".active-chat").removeClass('hidden');

                var chat = $(this).data('chat');
                $("#chat-id").val(chat.chat_id);
                $("#recipient-id").val(chat.parent_id);
                $("#chat-header").html(chat.parent_name);

                var msgsHtml = ``;
                chat.messages.forEach(message => {
                    msgsHtml += `

                    <div class="row message-body">
                        <div class="col-sm-12 ${message.msg_class}">
                            <div class="${message.container_class}">
                                <div class="message-text">
                                    ${message.message}
                                </div>
                                <span class="message-time pull-right">${message.time}</span>
                            </div>
                        </div>
                    </div>

                    `;
                });

                $("#conversation").empty().html(msgsHtml);

            });

            $(".send-btn").on('click', function(){
                $("#sendMsg").trigger('submit');
            });

        });
    </script>

@endsection