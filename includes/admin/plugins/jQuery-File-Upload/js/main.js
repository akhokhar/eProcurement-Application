/*
 * jQuery File Upload Plugin JS Example
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/* global $, window */

$(function () {
    'use strict';

    // Initialize the jQuery File Upload widget:
    //$('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        //url: 'server/php/'
    //});

    // Enable iframe cross-domain access via redirect option:
    $('#fileupload_images').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    if (window.location.hostname === 'blueimp.github.io') {
        // Demo settings:
        $('#fileupload_images').fileupload('option', {
            url: '//jquery-file-upload.appspot.com/',
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            maxFileSize: 999000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
        });
        // Upload server status check for browsers with CORS support:
        if ($.support.cors) {
            $.ajax({
                url: '//jquery-file-upload.appspot.com/',
                type: 'HEAD'
            }).fail(function () {
                $('<div class="alert alert-danger"/>')
                    .text('Upload server currently unavailable - ' +
                            new Date())
                    .appendTo('#fileupload_images');
            });
        }
    } else {
        $('#fileupload_images').fileupload('option', {
            //url: '//jquery-file-upload.appspot.com/',
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            maxFileSize: 99900000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i, //ogg=>ogv
            change: function (e, data) {
                //return false;
                
                $.each(data.files, function (index, file) {
                    var fileType = file.name.split('.').pop(), allowdtypes = 'jpeg,jpg,png,gif';
                    if (allowdtypes.indexOf(fileType.toLowerCase()) > 0) {
                        
                        //alert('Type '+file.name.split('.').pop())
                        //console.log(file);
                        //alert('Invalid file type, aborted');
                        //return false;
                    }
                    
                    
                    //alert('Selected file: ' + file.type);
                });
            }
        });
        // Load existing files:
        $('#fileupload_images').addClass('fileupload-processing');
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#fileupload_images').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#fileupload_images')[0]
        }).always(function () {
            $(this).removeClass('fileupload-processing');
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, $.Event('done'), {result: result});
        });
    }

});



$(function () {
    'use strict';

    // Initialize the jQuery File Upload widget:
    //$('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        //url: 'server/php/'
    //});

    // Enable iframe cross-domain access via redirect option:
    $('#fileupload_thumbnail').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    if (window.location.hostname === 'blueimp.github.io') {
        // Demo settings:
        $('#fileupload_thumbnail').fileupload('option', {
            url: '//jquery-file-upload.appspot.com/',
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            maxFileSize: 999000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
        });
        // Upload server status check for browsers with CORS support:
        if ($.support.cors) {
            $.ajax({
                url: '//jquery-file-upload.appspot.com/',
                type: 'HEAD'
            }).fail(function () {
                $('<div class="alert alert-danger"/>')
                    .text('Upload server currently unavailable - ' +
                            new Date())
                    .appendTo('#fileupload_thumbnail');
            });
        }
    } else {
        $('#fileupload_thumbnail').fileupload('option', {
            //url: '//jquery-file-upload.appspot.com/',
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            maxFileSize: 99900000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i, //ogg=>ogv
            change: function (e, data) {
                //return false;
                
                $.each(data.files, function (index, file) {
                    var fileType = file.name.split('.').pop(), allowdtypes = 'jpeg,jpg,png,gif';
                    if (allowdtypes.indexOf(fileType.toLowerCase()) > 0) {
                        
                        //alert('Type '+file.name.split('.').pop())
                        //console.log(file);
                        //alert('Invalid file type, aborted');
                        //return false;
                    }
                    
                    
                    //alert('Selected file: ' + file.type);
                });
            }
        });
        // Load existing files:
        $('#fileupload_thumbnail').addClass('fileupload-processing');
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#fileupload_thumbnail').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#fileupload_thumbnail')[0]
        }).always(function () {
            $(this).removeClass('fileupload-processing');
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, $.Event('done'), {result: result});
        });
    }

});



$(function () {
    'use strict';

    // Initialize the jQuery File Upload widget:
    //$('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        //url: 'server/php/'
    //});

    // Enable iframe cross-domain access via redirect option:
    $('#fileupload_videos').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    if (window.location.hostname === 'blueimp.github.io') {
        // Demo settings:
        $('#fileupload_videos').fileupload('option', {
            url: '//jquery-file-upload.appspot.com/',
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            maxFileSize: 999000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
        });
        // Upload server status check for browsers with CORS support:
        if ($.support.cors) {
            $.ajax({
                url: '//jquery-file-upload.appspot.com/',
                type: 'HEAD'
            }).fail(function () {
                $('<div class="alert alert-danger"/>')
                    .text('Upload server currently unavailable - ' +
                            new Date())
                    .appendTo('#fileupload_videos');
            });
        }
    } else {
        $('#fileupload_videos').fileupload('option', {
            //url: '//jquery-file-upload.appspot.com/',
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            maxFileSize: 99900000,
            acceptFileTypes: /(\.|\/)(mp4|ogv|webm)$/i, //ogg=>ogv
            change: function (e, data) {
                //return false;
                
                $.each(data.files, function (index, file) {
                    var fileType = file.name.split('.').pop(), allowdtypes = 'jpeg,jpg,png,gif';
                    if (allowdtypes.indexOf(fileType.toLowerCase()) > 0) {
                        
                        //alert('Type '+file.name.split('.').pop())
                        //console.log(file);
                        //alert('Invalid file type, aborted');
                        //return false;
                    }
                    
                    
                    //alert('Selected file: ' + file.type);
                });
            }
        });
        // Load existing files:
        $('#fileupload_videos').addClass('fileupload-processing');
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#fileupload_videos').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#fileupload_videos')[0]
        }).always(function () {
            $(this).removeClass('fileupload-processing');
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, $.Event('done'), {result: result});
        });
    }

});
