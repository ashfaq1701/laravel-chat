<?php

Route::get('/chat', 'Chat\ChatController@index');

Route::get('/channel/chat-top/{channelId}', 'Chat\ChatController@chatTop');

Route::get('/channel/messages/{channelId}/{pageNumber?}', 'Chat\ChannelController@messages');

Route::get('/channel/markread/{channelId}', 'Chat\ChannelController@markMessagesRead');

Route::post('/uploads/file', 'Chat\UploadController@fileUpload')->name('file.upload');

Route::get('images/{filename}', 'Chat\FileController@imageDownload');

Route::get('files/{filename}', 'Chat\FileController@fileDownload');