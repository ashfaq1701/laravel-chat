var socket;
var channelId = 0;
var loadedMessageCount = 0;

jQuery(document).ready(function()
{
	socket = window.appSocket;
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    socket.on('textMessage', function (newMessage) {
        receiveTextMessage(newMessage);
    });
    
    socket.on('fileMessage', function(newMessage) {
    	receiveFileMessage(newMessage);
    });
    
    socket.on('onlineStatus', function(statusJson) {
    	console.log(statusJson);
    	updateChannelOnlineStatus(statusJson);
    });

    socket.connect(function () {
    	
    });
    
    $('#chat-panel').click(function()
    {
    	if(channelId != 0)
    	{	
    		readMessages(channelId);
    	}
    });
    
    $('#chat-file-input').change(function()
    {
    	if(channelId != 0)
    	{
    		uploadAttachment();
    	}
    });
});

function updateChannelOnlineStatus(statusJson)
{
	var statusObj = JSON.parse(statusJson);
	var channelId = statusObj.channel_id;
	var online = statusObj.online;
	if(online == 0)
	{
		$('#'+channelId+'-online-status').removeClass();
		$('#'+channelId+'-online-status').addClass("hasnotification hasnotification-default mr5");
	}
	else
	{
		$('#'+channelId+'-online-status').removeClass();
		$('#'+channelId+'-online-status').addClass("hasnotification hasnotification-success mr5");
	}
}

function receiveTextMessage(messageJson)
{
	var message = JSON.parse(messageJson);
	if(message.channel_id == channelId)
	{
		displayTextMessage(message);
	}
	else
	{
		var unread = parseInt($('#unread-'+message.channel_id).text());
		if(isNaN(unread))
		{
			$('#unread-'+message.channel_id).text('1');
		}
		else
		{
			$('#unread-'+message.channel_id).text(unread+1);
		}
	}
}

function receiveFileMessage(messageJson)
{
	var message = JSON.parse(messageJson);
	if(message.channel_id == channelId)
	{
		displayFileMessage(message);
	}
	else
	{
		var unread = parseInt($('#unread-'+message.channel_id).text());
		if(isNaN(unread))
		{
			$('#unread-'+message.channel_id).text('1');
		}
		else
		{
			$('#unread-'+message.channel_id).text(unread+1);
		}
	}
}

function channelSelected(id)
{
	channelId = id;
	loadedMessageCount = 0;
	jQuery('#chat-body').empty();
	jQuery.ajax(
	{
		url: '/channel/chat-top/'+id,
		type: 'GET',
		success: function(response)
		{
			reinitializeChannel();
			$('#chat-heading').append(response);
		}
	});
	
	loadMessages();
	
	readMessages(id);
}

function sendTextMessage()
{
	var message = jQuery('#message-text').val();
	if((message != '') && (channelId != 0))
	{
		socket.send('textMessage', createTextMessageObject(message));
		jQuery('#message-text').val('');
	}
}

function sendFileMessage(filename)
{
	socket.send('fileMessage', createFileMessageObject(filename));
}

function readMessages(channelId)
{
	jQuery.ajax(
	{
		url: '/channel/markread/'+channelId,
		type: 'GET',
		success: function(response)
		{
			$('#unread-'+channelId).text('');
		}
	})
}

function loadMessages()
{
	jQuery.ajax(
		{
			url: '/channel/messages/'+channelId+'/'+loadedMessageCount,
			type: 'GET',
			success: function(response)
			{
				loadedMessageCount++;
				var messages = response.messages;
				var more = response.more;
				for(var i in messages)
				{
					message = messages[i];
					if(message.type == 'text')
					{
						displayTextMessage(message);
					}
					else
					{
						displayFileMessage(message);
					}
				}
				if(more == true)
				{
					jQuery('#chat-body').prepend('<a id="load-more-link" href="#" onclick="loadOldMessages()">Load More</a><br/>');
				}
				else
				{
					jQuery('#load-more-link').remove();
				}
			}
		}
	);
}

function loadOldMessages()
{
	jQuery.ajax(
		{
			url: '/channel/messages/'+channelId+'/'+loadedMessageCount,
			type: 'GET',
			success: function(response)
			{
				loadedMessageCount++;
				var messages = response.messages;
				var more = response.more;
				for(var i in messages)
				{
					message = messages[i];
					displayOldTextMessage(message);
				}
				if(more == true)
				{
					jQuery('#chat-body').prepend('<a id="load-more-link" href="#" onclick="loadOldMessages()">Load More</a><br/>');
				}
				else
				{
					jQuery('#load-more-link').remove();
				}
			}
		}
	);
}

function createTextMessageObject(message)
{
	var messageObject = {
		'channel_id': channelId,
		'text': message
	};
	return JSON.stringify(messageObject);
}

function createFileMessageObject(filename)
{
	var messageObject = {
		'channel_id': channelId,
		'file': filename
	};
	return JSON.stringify(messageObject);
}

function reinitializeChannel()
{
	jQuery('#chat-heading').empty();
	jQuery('#chat-body').empty();
}

function displayOldTextMessage(message)
{
	jQuery('#chat-body').prepend('<span class="sender-name">' + message.user.name + '</span> : ' + message.text + '<br/>');
}

function displayTextMessage(message)
{
	jQuery('#chat-body').append('<span class="sender-name">' + message.user.name + '</span> : ' + message.text + '<br/>');
}

function displayFileMessage(message)
{
	if((message.type == 'image'))
	{
		jQuery('#chat-body').append('<span class="sender-name">' + message.user.name + '</span> : <img src="' + message.file_path + '" class="file-message-image"/><br/>');
	}
	else
	{
		jQuery('#chat-body').append('<span class="sender-name">' + message.user.name + '</span> : <a href="' + message.file_path + '">'+message.file_path+'</a><br/>');
	}
}

function uploadAttachment()
{
	jQuery('#chat-file-input').fileupload(
	{
		url: '/uploads/file',
		success: function(files)
		{
			sendFileMessage(files[0]);
		},
		error: function(msg)
		{
			console.log(msg);
		}
	});
}