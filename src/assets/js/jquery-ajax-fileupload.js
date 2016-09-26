(function ( $ )
{
    $.fn.fileupload = function(options)
    {
        var uploaded = false;
        var msg = '';
        var files;
        if($(this.val()) != '')
        {
            var formData = new FormData();
            formData.append('file', $(this)[0].files[0]);
            if((options.url != null) && (typeof options.url != 'undefined')) {
                $.ajax({
                    url: options.url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        files = data.files;
                        if (files.length == 0) {
                            uploaded = false;
                            msg = 'File not supported';
                        }
                        else {
                            uploaded = true;
                        }
                    },
                    error: function () {
                        uploaded = false;
                        msg = 'Error in upload';
                    },
                    complete: function () {
                        if (uploaded)
                        {
                            if($.isFunction(options.success))
                            {
                                options.success.call(this, files);
                            }
                        }
                        else
                        {
                            if($.isFunction(options.error))
                            {
                                options.error.call(this, msg);
                            }
                        }
                    }
                });
            }
            else
            {
                if($.isFunction(options.error))
                {
                    options.error.call(this, 'URL parameter must be provided');
                }
            }
        }
    };
}( jQuery ));