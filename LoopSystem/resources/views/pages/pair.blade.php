@extends('includes.admin_template')

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">

          <h1 class="m-0 text-dark"><i class="nav-icon fas fa-heartbeat"></i> Pairing</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Pairing</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->


  <div class="row">
    <div class="col s4 m4">
      <div class="card blue lighten-5">
        <div class="card-content black-text" >
            <div class="center-align"><h4>Subscribers</h4></div>
          <form action="#">




            <div class="contents" id="contents">


            <div id='subscribers_panel'>
           <!-- /show online subs not connected to any convo -->
            </div>

            </div>
          </form>

        </div>

      </div>
    </div>

    <div class="col s4 m4">
        <div class="card blue lighten-5">
            <div class="card-content black-text" >
                <div class="center-align"><h4>Operators</h4></div>
            <form action="#">
                <div class="contents" id="contents">
            <div id="operators_panel">
                <!-- show online operators -->
            </div>
                </div>
            </form>
          </div>
        </div>
      </div>

    <div>

    <p>
        <button class="btn waves-effect waves-light btn-large" type="button" name="action" id="pairBtn" style="margin-top: 150px;" onclick="pair()">
            <i class="material-icons right">keyboard_arrow_right</i>
        </button>

    </p>
    <p>
        <button class="btn waves-effect waves-light btn-large" type="button" name="action" id="unpairBtn" style="margin-top: 100px;" onclick="unpair()">

            <i class="material-icons right">keyboard_arrow_left</i>
        </button>
    </p>
    </div>


      <div class="col s4 m4">
        <div class="card blue lighten-5" >
            <div class="card-content black-text">
                <div class="center-align"><h4>Paired</h4></div>
            <form action="#">
                <div class="contents" id="contents">
                <div id="paired_panel">
                <!-- show paired -->
            </div>

            </div>
            </form>

          </div>

        </div>
      </div>
  </div>
  <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script type="text/javascript" src="http://localhost:8000/socket.io/socket.io.js"></script>
<script>
     var socket = io('http://localhost:8000');
 $(function(){

        var $subscribers = $('#subscribers_panel');
        var $operators = $('#operators_panel');
        var $paired = $('#paired_panel');

        $('#pairBtn').attr('disabled', true);
        $('#unpairBtn').attr('disabled', true);
        // show subs in subscribers_panel
        socket.on('showSubscribers', function(rows) {
            var html='';
            if(rows.length > 0){
                for (var i=0; i<rows.length; i++) {
                html += '<p><label> <input name="subscribers_rad" type="radio" onclick="showOperators('+rows[i].service_id+')" value="'+rows[i].id+'"/> <span>'+rows[i].subscriber_name+'</span></label></p>';

                }
            }else{
                html += "<h6><label>No Online / Available Subscribers</label></h6>";
            }
            $subscribers.html(html);
        });

        // show operators in operator_panel when subs name is clicked

        socket.on('showOperators', function(rows) {
            var html='';
            if(rows.length > 0){
                for (var i=0; i<rows.length; i++) {
                html += '<p><label> <input name="operators_rad" type="radio" onclick="enablePairBtn()" value="'+rows[i].id+'"/> <span>'+rows[i].username+'</span></label></p>';

                }
            }else{
                html += "<h6><label>No Online / Available Operators</label></h6>";
            }
            $operators.html(html);
        });

          // show operators in operator_panel

        socket.on('showOnOperators', function(rows) {
            var html='';
            if(rows.length > 0){
                for (var i=0; i<rows.length; i++) {
                html += '<p><label style="font-size:15px;">'+rows[i].username+'</label></p>';

                }
            }else{
                html += "<h6><label>No Online / Available Operators</label></h6>";
            }
            $operators.html(html);
        });

        socket.on('showPaired', function(rows) {
            var html='';
            if(rows.length > 0){
                for (var i=0; i<rows.length; i++) {
                html += '<p><label style="font-size:15px;"><input name="paired_rad" type="radio" onclick="enableUnpairBtn('+rows[i].con_id+')" value="'+rows[i].con_id+'"><span>'+rows[i].subscriber_name+' & '+rows[i].uname+' (as '+rows[i].persona_name+')</span></label></p>';

                }
            }else{
                html += "<h6><label>No paired yet</label></h6>";
            }
            $paired.html(html);
        });





 });

 function enableUnpairBtn(con_id){
     if(con_id){
         $('#unpairBtn').attr('disabled', false);
     }

 }

function enablePairBtn(){
    var ops = $("input[name='operators_rad']:checked").val();
    if(ops){
        $('#pairBtn').attr('disabled', false);
    }else if(empty(ops)){
        $('#pairBtn').attr('disabled', true);
    }

}

function showOperators(service_id){
    $('#pairBtn').attr('disabled', true);
    socket.emit('selectOperators', (service_id));

}

function pair(){

    var subs = $("input[name='subscribers_rad']:checked").val();
    var ops = $("input[name='operators_rad']:checked").val();
            if(subs || ops){
                // alert(subs + " "+ ops);
                socket.emit('pair', {subs: subs,
                    ops: ops,});
                    M.toast({html: 'Successfully Paired!'})
                    $('#pairBtn').attr('disabled', true);
            }else{
                alert();
            }
}

function unpair(){
    var pair = $("input[name='paired_rad']:checked").val();
    if(pair){
        // alert(pair);
        socket.emit('unpair', pair);
        M.toast({html: 'Successfully Unpaired!'})
        $('#unpairBtn').attr('disabled', true);
    }
}
</script>

<style>
#contents{
    overflow-y: auto;
    height: 400px;
}
</style>

 @endsection


