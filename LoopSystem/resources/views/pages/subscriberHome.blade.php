@extends('layouts.app')

@section('content')
<!-- Compiled and minified JavaScript -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"> --}}
<div class="home-page ">
    <!-- Home page header starts -->

    <nav >
        <div class="nav-wrapper teal lighten-2 col s12">
          <a href="" class="brand-logo left">Welcome {{auth()->user()->username}}</a>
          <ul class="right hide-on-med-and-down ">
            <li class="right">
                <!-- <span class="logout-user" ng-click="logout()"> -->
                <a class="logout-user " id="logout-user" href="{{ route('logout') }}"
                onclick="event.preventDefault();logout();
                document.getElementById('logout-form').submit();">
                <i class="material-icons" aria-hidden="true">power_settings_new</i>
                </a>
                {{-- <input type="submit"></button> --}}
                <br><br><br>
                @if(auth()->user()->user_type == "operator")
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none" >
                @else
                <form id="logout-form" action="{{ route('logoutSubs') }}" method="POST" style="display: none" >
                @endif
                @csrf

                <input type="submit" value="Logout">
                </form>

            </li>
          </ul>
        </div>
      </nav>

    <!-- Home page header ends -->

    <!-- Home page body start -->
    <div class="home-body">
        <div class="row" style="height: 100% !important; margin-bottom:0px;">
            <!-- Chat list Markup starts -->
            <div class="row" style="width:30%; margin-bottom:0px;">
                <div class="chat-list-container z-depth-2 col 12" style="height: 100% !important; ">
                    <p class="chat-list-heading"><h4 class="center-align"><b>Chat list</b></h4> </p>
                    {{-- <div class="input-field col 3">
                        <i class="material-icons prefix">search</i>
                        <input id="icon_prefix" type="text" class="validate">
                        <label for="icon_prefix">Search Conversation</label>
                    </div>

                    <div class="center-align col 3 ">
                        <ul class="tabs">
                            <li class="tab col s6"><a href="#test1" class="active blue-text text-darken-4">Conversations</a></li>
                            <li class="tab col s6"><a href="#test2" class="blue-text text-darken-4">Services</a></li>
                        </ul>
                    </div> --}}

                    <div class="chat-list col 3">

                        <ul class="collection with-header left-align" ng-if="data.chatlist.length > 0" id="users">
                            <!-- <li class="collection-item truncate active"
                            >User12345687</li> -->
                        </ul>
                        <!-- <div class="alert alert-info" ng-if="data.length !!= 0"> -->
                            <!-- <strong>No one is online to chat, ask someone to Login.</strong> -->
                            <!-- <strong>No conversations available.</strong> -->
                        <!-- </div> -->
                        <h1 id='m'></h1>
                        <div id="display"></div>
                        <div id="test">
                                
                                

                        </div>
                    </div>



                    {{-- <div class="center-align" style="margin-top: 500px;">
                        <button id="disconnect" class="waves-effect waves-light btn-small col 12" type="submit" name="submit" value="Disconnect" style="background-color: #546D74; height: 50px;">
                            Disconnect

                        <i class="material-icons">exit_to_app</i>
                    </button>
                    </div> --}}

                </div>
            </div>
            <!-- Chat List Markup ends -->

            <!-- Message Area Markup starts -->
            <div class="" style="width:70%; height:100%;">
                <div class="message-container2" ng-if="data.messages.length == 0" style="padding: 20px 0px 20px 20px;
                background-color: rgb(255, 255, 255);
                margin: 10px 0px 10px 10px;
                height: 104%;">
                <div id="chatName"></div>
                    <div class="message-list">
                        <ul class="message-thread center-align" style="overflow-y: auto;
                        list-style-type: none;
                        height: 95%;
                        width: 100%;
                        margin: 0px !important;
                        padding: 5px !important;
                        border-radius: 5px;
                        border: #ffffff;">


                <div class="chat" id="chat" style="height:30rem; overflow-y:auto;"><h3><b>Welcome, {{auth()->user()->username}}.</b></h3>
                    <h6>Please wait for a user.</h6>
                    <img class="center-align" src="https://media.giphy.com/media/bcKmIWkUMCjVm/giphy.gif" alt="" height="73%">

                </div>




                        </ul>
                    </div>

                </div>



                {{-- <div class="message-container" ng-if="data.messages.length > 0">
                    <span id="fixx">
                    <h5 class="collection-item truncate"
                    ng-class="{'active':friend.id == data.selectedFriendId}"
                    ></h5>
                    </span>
                    <div class="message-list">
                        <ul class="message-thread">

                            <li ng-repeat="messagePacket in data.messages"
                                ng-class="{ 'align-right' : alignMessage(messagePacket.fromUserId) } ">

                            </li>
                        </ul>
                    </div> --}}


                    <div class="message-text">
                        <form id="messageForm">
                        <div class="input-field col s11">
                            <i class="material-icons prefix">message</i>
                            <textarea id="message" name="message" type="text" class="materialize-textarea" ng-keydown="sendMessage($event)"></textarea>
                            <label for="message">Type a message</label>
                        </div>


                        <div class="col s1 align-left" >
                            <button id="submitmessage" class="waves-effect waves-light btn-small" type="submit" name="submit">

                            <i class="material-icons">send</i>
                        </div>
                        </form>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
            <!-- Message Area Markup ends -->


    </div>
</div>


  <!-- Modal Structure -->
  {{-- <div id="modal1" class="modal modal-fixed-footer" style="height: 30%">
    <div class="modal-content">
      <h4>Disconnected</h4>
      <p>You are disconnected because you have exceed the maximum time limit. (60s)</p>
    </div>
    <div class="modal-footer">
      <a class="modal-close btn-flat">Ok</a>
    </div>
  </div> --}}


<style>
    /* #message {
    border-radius: 25px;
    background-color: eeeeee;
    padding: 20px;
     height: 20px;
    width: 1020px;
    resize: none;
    overflow:hidden;
    outline-width: 0;
    display: inline;

} */

#submitmessage {
    border-radius: 20%;
    height: 50px;

    margin-top: 10px;

    display: inline;
}
#fixx{
    margin-bottom: 1%;
}
#chat{
    overflow-y: auto;
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

<script>
     var instance = M.Tabs.init(el, options);
     var instance = M.Tabs.getInstance(elem);
     instance.select('tab_id');
     instance.updateTabIndicator();

// Or with jQuery

$(document).ready(function(){
  $('.tabs').tabs();
});
</script>
<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>

<script type="text/javascript" src="http://localhost:8000/socket.io/socket.io.js"></script>
    <script>
  //var socket = io('http://localhost:8000');




</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>

<script type="text/javascript">
 var socket = io('http://localhost:8000');
 var $sendBtn = $('#submitmessage');
    $(function(){

        //var socket = io.connect();
        var $chatName= $('#chatName');
        var $chat = $('#chat');
        var $username = $('#username');
        var $users = $('#users');
        var $message = $('#message');
        var $messageForm = $('#messageForm');
        var $m = $('#m');
        var $display = $('#display');

        

        @foreach ($data as $value)
        var room = {{$value->con_id}}; 
        @endforeach

        socket.emit('room', room);


        $messageForm.submit(function(e){
            e.preventDefault();
            socket.emit('send message', {message:$message.val(), roomno: $m.val(),subs_id:'{{auth()->user()->id}}', con_id: $('#submitmessage').val()});
            // alert($('#submitmessage').val());
			$message.val("");
            $message.focus();
        });

        //message
        socket.on('new message', function(data){
            // $chat.append('<div class="card card-body bg-light"><b>'+data.user+': </b>' + data.msg + '</div>');
            if(data.id == '{{auth()->user()->id}}'){
                $chat.append('<li style="max-width: 300px;border-color: solid 0.5px rgba(0, 0, 0, 0.32);clear: both;text-decoration: none;list-style-type: none;margin: 20px 10px 0px 20px;float: right;margin-right: 20px;padding: 25px 34px;min-width: 160px;min-height: 10px;max-width: 350px;border:solid 1px #0000001f;background-color: eeeeee;line-height: 1.4;word-wrap: break-word;color: #444444;text-align: left;border-radius: 25px;"> <span class="align-right"><br/><small>'+moment().format('llll')+'</small></span>' + data.msg +'</li>');
            }else{
                $chat.append('<li style="max-width: 300px;border-color: solid 0.5px rgba(0, 0, 0, 0.32);clear: both;text-decoration: none;list-style-type: none;margin: 20px 10px 0px 20px;float: left;margin-right: 20px;padding: 25px 34px;min-width: 160px;min-height: 10px;max-width: 350px;border:solid 1px #0000001f;background-color: eeeeee;line-height: 1.4;word-wrap: break-word;color: #444444;text-align: left;border-radius: 25px;"> <span class="align-right"><br/><small>'+moment().format('llll')+'</small></span>' + data.msg +'</li>');
            }
            scrollToBottom();
        });


        socket.emit('login user', ['{{auth()->user()->id}}', '{{auth()->user()->username}}', '{{auth()->user()->user_type ?? 'subscriber'}}'], function(data){
            //Auto disconnect
            // setTimeout(function(){ $('.modal').modal(); }, 60000);
        });

        // socket.on('get users', function(data){
        //     var html = '';
        //     for(i =0 ; i <data.length;i++){
        //         html += '<li class="collection-item truncate active">'+data[i]+'</li>';
        //     }
        //     $users.html(html);
        // });

        socket.on('showrows', function(rows) {
        var html='';
        if(rows.length > 0){
            for (var i=0; i<rows.length; i++) {
            html += '<li class="collection-item truncate active" onclick="getMessages('+rows[i].con_id+')">'+rows[i].persona_name+'</li>';
            }
        }else{
            html += '<li class="collection-item active">No conversation available</li>';
        }
         $users.html(html);
        });

        socket.emit('getChatPersona', '{{auth()->user()->id}}', (data)=>{});

        socket.on('showName', (data)=>{
            var html = '<h4><b>'+data[0].persona_name+'</b></h4>';
           $chatName.html(html);
        });

        
        /*
        socket.on('get_room_credentials', (data)=>{
            var html += '<h4><b>'+data[0].con_id+'</b></h4>';
           $display.html(html);
        });
        */

        socket.emit('get_room_credentials', {subscriber_id:'{{auth()->user()->id}}'}, (data)=>{});
        

    socket.on('showMessages', (data)=>{
        var html = '';
        for(var i=0; i < data.length; i++ ){
            if(data[i].user_id == '{{auth()->user()->id}}'){
                html += '<li style="max-width: 300px;border-color: solid 0.5px rgba(0, 0, 0, 0.32);clear: both;text-decoration: none;list-style-type: none;margin: 20px 10px 0px 20px;float: right;margin-right: 20px;padding: 25px 34px;min-width: 160px;min-height: 10px;max-width: 350px;border:solid 1px #0000001f;background-color: eeeeee;line-height: 1.4;word-wrap: break-word;color: #444444;text-align: left;border-radius: 25px;"> <span class="align-right"><br/><small>'+moment(data[i].date_outbound).format('llll')+'</small></span>' + data[i].message +'</li>';
            }else{
                html += '<li style="max-width: 300px;border-color: solid 0.5px rgba(0, 0, 0, 0.32);clear: both;text-decoration: none;list-style-type: none;margin: 20px 10px 0px 20px;float: left;margin-right: 20px;padding: 25px 34px;min-width: 160px;min-height: 10px;max-width: 350px;border:solid 1px #0000001f;background-color: eeeeee;line-height: 1.4;word-wrap: break-word;color: #444444;text-align: left;border-radius: 25px;"> <span class="align-right"><br/><small>'+moment(data[i].date_outbound).format('llll')+'</small></span>' + data[i].message +'</li>';
            }
            // $chat.append('<li style="max-width: 300px;border-color: solid 0.5px rgba(0, 0, 0, 0.32);clear: both;text-decoration: none;list-style-type: none;margin: 20px 10px 0px 20px;float: left;margin-right: 20px;padding: 25px 34px;min-width: 160px;min-height: 10px;max-width: 350px;border:solid 1px #0000001f;background-color: eeeeee;line-height: 1.4;word-wrap: break-word;color: #444444;text-align: left;border-radius: 25px;"> <span class="align-right"><b>'+moment(data[i].date_outbound).format('llll')+'</b></span>' + data[i].message +'</li>');
            scrollToBottom();
            // console.log('msg :' + data[i].message + "date: " + data[i].date_outbound);
        }
        $chat.html(html);
    });
    });

function getMessages(id){
    //alert(id);
    $sendBtn.val(id);
    socket.emit('getMessages', id);
    socket.emit('getChatNamePersona', id);
}

function scrollToBottom(){
        const messageThread = document.querySelector('.chat');
        setTimeout(() => {
            messageThread.scrollTop = messageThread.scrollHeight + 500;
        }, 10);
    }

function logout(){
     socket.emit('logout user', ['{{auth()->user()->id}}', '{{auth()->user()->username}}', '{{auth()->user()->user_type ?? 'subscriber'}}'], function(data){
        //...
     });
}

</script>

@endsection

