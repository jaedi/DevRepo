var app = require('express')();
var http = require('http').createServer(app);
var io = require('socket.io')(http);
const mysql = require('mysql');
const util = require('util');

let rm = 0;
connected_users = [];
users = [];


const port = 8000;
http.listen(8000, function(){
  console.log('listening on *: ' + port);
});

const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'loopsystem'
});

connection.connect((err) => {
  if(err){
    console.log('Error connecting to Db');
    return;
  }
  console.log('Connection established');
});


//Connection
io.on('connection', function(socket){
  if(connected_users){
  	connected_users.push(socket);
    console.log('Connected %s sockets connected', connected_users.length);
  }

//User Login
socket.on('login user', function(data, callback){
	callback(true);
	socket.id = data[0];
    socket.username = data[1];
    socket.usertype = data[2];
	if(users.includes(socket.username)){
		console.log('exists');
	}else{
		users.push(socket.username);
    }


    if(socket.usertype=="operator" || socket.usertype=="admin"){
        connection.query("UPDATE users SET user_status='active' WHERE id="+socket.id+"", function(err){
            if(err){
                console.log('Error: ' + err.message);
            }else{
                console.log(socket.username+' is Online.\n');
                updateUsernames();
                loadData();
            }
        });
    }else{
        connection.query("UPDATE subscribers SET subscriber_status='active' WHERE id="+socket.id+"", function(err){
            if(err){
                console.log('Error: ' + err.message);
            }else{
                console.log(socket.username+' is Online.\n');
                updateUsernames();
                loadData();
            }
        });
    }

});


showChatPersona();

//User Logout
socket.on('logout user', function(data, callback){
	callback(true);
	socket.id = data[0];
	socket.username = data[1];
    socket.usertype = data[2];
    if(socket.usertype=="operator" || socket.usertype=="admin"){
        connection.query("UPDATE users SET user_status='inactive' WHERE id="+socket.id+"", function(err){
    		if(err){
    			console.log('Error: ' + err.message);
    		}else{
                console.log(socket.username+' is now Offline.\n');
                loadData();
    		}
    	});
    }else{
        connection.query("UPDATE subscribers SET subscriber_status='inactive' WHERE id="+socket.id+"", function(err){
            if(err){
                console.log('Error: ' + err.message);
            }else{
                console.log(socket.username+' is now Offline.\n');
                loadData();
            }
        });
    }

});


function updateUsernames(){
	io.sockets.emit('get users', users);
}

//Disconnect
  	socket.on('disconnect', function(data){
  		users.splice(users.indexOf(socket.username), 1);
		connected_users.splice(connected_users.indexOf(socket), 1);
		updateUsernames();
		console.log('Disconnected: %s sockets connected', connected_users.length);

		updateUsernames();
	});

    function showChatPersona(){
        socket.on('getChatPersona', (data)=>{
            connection.query('SELECT persona_name, con_id FROM personas INNER JOIN conversations ON personas.persona_id = conversations.persona_id WHERE conversations.subscriber_id = "'+data+'" AND status="active"', (err, rows, fields)=>{
                if(err){
                    console.log('ERROR: ' + err.message);
                }else{
                    socket.emit('showrows', rows);
                }
            });
        });

        socket.on('getChatSubscriber', (data)=>{
            connection.query('SELECT subscriber_name, con_id, subscriber_id FROM subscribers INNER JOIN conversations ON subscribers.id = conversations.subscriber_id WHERE conversations.user_id = "'+data+'" AND status="active"', (err, rows, fields)=>{
                if(err){
                    console.log('ERROR: ' + err.message);
                }else{
                    socket.emit('showrowsSubs', rows);
                    console.log(data[0].subscriber_name)
                }
            });
        });

    }

getMessagesSubs();

    function getMessagesSubs(){
        socket.on('getMessages', (id)=>{
            connection.query('SELECT message, date_outbound, user_id FROM (SELECT message, date_outbound, user_id FROM outbound WHERE con_id="'+id+'" UNION SELECT message, date_inbound, user_id FROM inbound WHERE con_id="'+id+'") conversations ORDER BY date_outbound', (err, msg, fields)=>{
                if(err){
                    console.log('Error: ' + err.message);
                }else{
                    socket.emit('showMessages', msg);
                    // console.log(id);
                    // console.log('msg: ' + msg[0].message + " date: " + msg[0].date_outbound);
                }
            });
        });

        socket.on('getChatNameSub', (id)=>{
            connection.query('SELECT subscriber_name, subscriber_id FROM subscribers INNER JOIN conversations ON subscribers.id = conversations.subscriber_id WHERE conversations.con_id="'+id+'"', (err, rows, fields)=>{
                if(err){
                    console.log('Error: ' + err.message);
                }else{
                    socket.emit('showName', rows);
                }
            });
        });

        socket.on('getChatNamePersona', (id)=>{
            connection.query('SELECT persona_name FROM personas INNER JOIN conversations ON personas.persona_id = conversations.persona_id WHERE conversations.con_id="'+id+'"', (err, rows, fields)=>{
                if(err){
                    console.log('Error: ' + err.message);
                }else{
                    socket.emit('showName', rows);
                }
            });
        });
    }

    function showpaired(){
          //show paired
          connection.query('SELECT users.username AS uname, subscriber_name, persona_name, con_id FROM conversations INNER JOIN users ON conversations.user_id = users.id INNER JOIN subscribers ON conversations.subscriber_id = subscribers.id INNER JOIN personas ON conversations.persona_id = personas.persona_id WHERE status="active"', (err, rows, fields)=>{
            if(err){
                console.log('Error: '+ err.message);
            }else{
                io.sockets.emit('showPaired', rows);
            }
        });

         //admin pairing show online subs
         connection.query("SELECT username,id, service_id,subscriber_name FROM subscribers WHERE subscriber_status='active' AND id NOT IN (SELECT subscriber_id FROM conversations WHERE status='active')", function(err, rows, fields){
            if(err){
                console.log('Error: ' + err.message);
            }else{
                io.sockets.emit('showSubscribers', rows);
            }
        });

        //admin pairing show online ops
        connection.query("SELECT username,id, service_id,username FROM users WHERE user_status='active' AND user_type!='admin' AND id NOT IN (SELECT user_id FROM conversations WHERE status='active')", function(err, rows, fields){
            if(err){
                console.log('Error: ' + err.message);
            }else{
                io.sockets.emit('showOnOperators', rows);
            }
        });

        //admin pairing show online operators w/ same service
        socket.on('selectOperators', (service_id)=>{
            connection.query('SELECT username, id, username FROM users WHERE service_id="'+service_id+'" AND user_status="active" AND user_type != "admin"', (err, rows, fields)=>{
                if(err){
                    console.log('Error: ' + err.message);
                }else{
                    io.sockets.emit('showOperators', rows);
                }
            });
        });
    }
   
let r = 0;
let rr = 0;

    socket.on('room', function(room){
        rr = room;
        socket.join(rr);
        console.log("SUBSCRIBER is currently in room: " + rr);
        console.log(io.sockets.adapter.rooms);
       // console.log(io.sockets.adapter.room[rr].sockets);
        //io.sockets.in(rr).emit('connectToRoom', rr);
    });

    // socket.on('roomOp', function(roomOp){
    //     socket.join(roomOp);
    //     console.log("OPERATOR is currently in room: " + roomOp);
    //    // io.sockets.in(roomOp).emit('connectToRoomOp', roomOp);
    //     r = roomOp;
    // });

    //Send Message
    socket.on('send message', function(data){
        connection.query('INSERT INTO inbound (message, user_id, con_id) VALUES ("'+data.message+'", "'+data.subs_id+'", "'+data.con_id+'")', (err)=>{
            if(err){
                console.log('Error: ' + err.message);
            }else{
                getMessagesSubs(data.con_id);
            }
        });
		console.log('SUBSCRIBER send message', data.message, 'sending to ', data.con_id);
        // io.sockets.in("room"+data.roomno).emit('new message', {msg: data.message, user:socket.username});
        io.sockets.in(data.con_id).emit('new message', {msg: data.message, user:socket.username, id: data.subs_id});

        
    });
    //Send MessageOps
    socket.on('send messageOps', function(data){
        console.log('OPERATOR send message', data.message, 'sending to ', data.con_id);
        // io.sockets.in("room"+data.roomno).emit('new message', {msg: data.message, user:socket.username, id: data.subs_id});
        //io.sockets.in(data.con_id).emit('new message', {msg: data.message, user:socket.username, id: data.subs_id});
        io.emit('new message', {msg: data.message, user:socket.username, id: data.subs_id});
        connection.query('INSERT INTO outbound (message, user_id, con_id) VALUES ("'+data.message+'", "'+data.subs_id+'", "'+data.con_id+'")', (err)=>{
            if(err){
                console.log('Error: ' + err.message);
            }else{
                getMessagesSubs(data.con_id);
            }
        
        });
    });
    
   

    function loadData(){
        showChatPersona();
        showpaired();
        socket.on('unpair', (data)=>{
            connection.query('UPDATE conversations SET status = "inactive" WHERE con_id="'+data+'"', (err)=>{
                if(err){
                    console.log('Error: ' + err.message);
                }else{
                    console.log('Unpaired Successfully');
                    showpaired();
                    showChatPersona();
                }
            });
        });

        socket.on('pair', (data)=>{
            connection.query('SELECT service_id, persona_id FROM users WHERE id="'+data.ops+'"', (err, rows, fields)=>{
                if(err){
                    console.log('Error: ' + err.message);
                }else{
                    connection.query('SELECT con_id from conversations WHERE subscriber_id="'+data.subs+'" AND persona_id = "'+rows[0].persona_id+'"', (err1, row, fields)=>{
                        if(err1){
                            console.log('Error: ' + err1.message);
                        }else{
                            if(row.length > 0){
                                connection.query('UPDATE conversations SET user_id="'+data.ops+'", status="active" WHERE con_id = "'+row[0].con_id+'"', (err3)=>{
                                    if(err3){
                                        console.log('Error: ' + err3.message);
                                    }else{
                                        console.log('Successfully paired!');
                                        showpaired();
                                        showChatPersona();
                                    }
                                });

                            }else{
                                connection.query('INSERT INTO conversations (subscriber_id, user_id, service_id, persona_id, status) VALUES ("'+data.subs+'", "'+data.ops+'", "'+rows[0].service_id+'", "'+rows[0].persona_id+'", "active")', (err2)=>{
                                    if(err2){
                                        console.log('Error: ' + err2.message);
                                    }else{
                                        console.log('Successfully paired!');
                                        showpaired();
                                        showChatPersona();
                                    }
                                });
                            }
                        }

                    });

                }

            });


        });


    }

    loadData();
	
});


