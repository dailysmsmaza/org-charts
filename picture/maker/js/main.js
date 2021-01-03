$(function () {

    'use strict';

    var console = window.console || {
        log: function () {
        }
    };
    var URL = window.URL || window.webkitURL;
    var $image = $('#image');
    var $download = $('#download');
    var $dataX = $('#dataX');
    var $dataY = $('#dataY');
    var $dataHeight = $('#dataHeight');
    var $dataWidth = $('#dataWidth');
    var $dataRotate = $('#dataRotate');
    var $dataScaleX = $('#dataScaleX');
    var $dataScaleY = $('#dataScaleY');
    var options = {
        aspectRatio: 16 / 9,
        preview: '.img-preview',
        crop: function (e) {
            $dataX.val(Math.round(e.detail.x));
            $dataY.val(Math.round(e.detail.y));
            $dataHeight.val(Math.round(e.detail.height));
            $dataWidth.val(Math.round(e.detail.width));
            $dataRotate.val(e.detail.rotate);
            $dataScaleX.val(e.detail.scaleX);
            $dataScaleY.val(e.detail.scaleY);
        }
    };
    var originalImageURL = $image.attr('src');
    var uploadedImageName = 'cropped.jpg';
    var uploadedImageType = 'image/jpeg';
    var uploadedImageURL;


    // Tooltip
    $('[data-toggle="tooltip"]').tooltip();


    // Cropper
    $image.on({
        ready: function (e) {
            console.log(e.type);
        },
        cropstart: function (e) {
            console.log(e.type, e.detail.action);
        },
        cropmove: function (e) {
            console.log(e.type, e.detail.action);
        },
        cropend: function (e) {
            console.log(e.type, e.detail.action);
        },
        crop: function (e) {
            console.log(e.type);
        },
        zoom: function (e) {
            console.log(e.type, e.detail.ratio);
        }
    }).cropper(options);


    // Buttons
    if (!$.isFunction(document.createElement('canvas').getContext)) {
        $('button[data-method="getCroppedCanvas"]').prop('disabled', true);
    }

    if (typeof document.createElement('cropper').style.transition === 'undefined') {
        $('button[data-method="rotate"]').prop('disabled', true);
        $('button[data-method="scale"]').prop('disabled', true);
    }


    // Download
    if (typeof $download[0].download === 'undefined') {
        $download.addClass('disabled');
    }


    // Options
    $('.docs-toggles').on('change', 'input', function () {
        var $this = $(this);
        var name = $this.attr('name');
        var type = $this.prop('type');
        var cropBoxData;
        var canvasData;

        if (!$image.data('cropper')) {
            return;
        }

        if (type === 'checkbox') {
            options[name] = $this.prop('checked');
            cropBoxData = $image.cropper('getCropBoxData');
            canvasData = $image.cropper('getCanvasData');

            options.ready = function () {
                $image.cropper('setCropBoxData', cropBoxData);
                $image.cropper('setCanvasData', canvasData);
            };
        } else if (type === 'radio') {
            options[name] = $this.val();
        }

        $image.cropper('destroy').cropper(options);
    });

    // Methods
    $('.docs-buttons').on('click', '[data-method]', function () {
        var $this = $(this);
        var data = $this.data();
        var cropper = $image.data('cropper');
        var cropped;
        var $target;
        var result;

        if ($this.prop('disabled') || $this.hasClass('disabled')) {
            return;
        }

        if (cropper && data.method) {
            data = $.extend({}, data); // Clone a new one

            if (typeof data.target !== 'undefined') {
                $target = $(data.target);

                if (typeof data.option === 'undefined') {
                    try {
                        data.option = JSON.parse($target.val());
                    } catch (e) {
                        console.log(e.message);
                    }
                }
            }

            cropped = cropper.cropped;

            switch (data.method) {
                case 'rotate':
                    if (cropped && options.viewMode > 0) {
                        $image.cropper('clear');
                    }

                    break;

                case 'getCroppedCanvas':
                    if (uploadedImageType === 'image/jpeg') {
                        if (!data.option) {
                            data.option = {};
                        }

                        data.option.fillColor = '#fff';
                    }

                    break;
            }

            result = $image.cropper(data.method, data.option, data.secondOption);

            switch (data.method) {
                case 'rotate':
                    if (cropped && options.viewMode > 0) {
                        $image.cropper('crop');
                    }

                    break;

                case 'scaleX':
                case 'scaleY':
                    $(this).data('option', -data.option);
                    break;

                case 'getCroppedCanvas':
                    if (result) {
                        // Bootstrap's Modal
                        // $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);
                        // $download.attr('href', result.toDataURL(uploadedImageType));
                        var old_data = canvas.getObjects();
                        if (!$download.hasClass('disabled')) {
                            download.download = uploadedImageName;
                            fabric.Image.fromURL(result.toDataURL(uploadedImageType), function (objects, options) {
                                ctx.clearRect(0, 0, canvas.width, canvas.height);
                                var background = objects;

                                if (height > 284) {
                                    background.scaleToHeight(height);
                                    background.set({
                                        selectable: false,
                                        lockRotation: false,
                                        hasControls: false
                                    });
                                } else {
                                    background.set({
                                        scaleX: canvas.width / background.width,
                                        scaleY: canvas.height / background.height,
                                        selectable: false
                                    });
                                }
                                canvas.clear(ctx)
                                canvas.calcOffset();
                                canvas.add(background);
                                canvas.centerObject(background);
                                canvas.renderAll();
                                refreshCanvas(old_data)
                            });
                            $('#cropModal').modal('hide')

                        }
                    }

                    break;

                case 'destroy':
                    if (uploadedImageURL) {
                        URL.revokeObjectURL(uploadedImageURL);
                        uploadedImageURL = '';
                        $image.attr('src', originalImageURL);
                    }

                    break;
            }

            if ($.isPlainObject(result) && $target) {
                try {
                    $target.val(JSON.stringify(result));
                } catch (e) {
                    console.log(e.message);
                }
            }

        }
    });


    // Keyboard
    $(document.body).on('keydown', function (e) {

        if (!$image.data('cropper') || this.scrollTop > 300) {
            return;
        }

        switch (e.which) {
            case 37:
                e.preventDefault();
                $image.cropper('move', -1, 0);
                break;

            case 38:
                e.preventDefault();
                $image.cropper('move', 0, -1);
                break;

            case 39:
                e.preventDefault();
                $image.cropper('move', 1, 0);
                break;

            case 40:
                e.preventDefault();
                $image.cropper('move', 0, 1);
                break;
        }

    });


    // Import image
    var $inputImage = $('#inputImage');

    if (URL) {
        $inputImage.change(function () {
            var files = this.files;
            var file;

            if (!$image.data('cropper')) {
                return;
            }

            if (files && files.length) {
                file = files[0];

                if (/^image\/\w+$/.test(file.type)) {
                    uploadedImageName = file.name;
                    uploadedImageType = file.type;

                    if (uploadedImageURL) {
                        URL.revokeObjectURL(uploadedImageURL);
                    }

                    uploadedImageURL = URL.createObjectURL(file);
                    $image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
                    $inputImage.val('');
                } else {
                    window.alert('Please choose an image file.');
                }
            }
        });
    } else {
        $inputImage.prop('disabled', true).parent().addClass('disabled');
    }


    //|=================================================================================|//
    //|=================================================================================|//
    //|                    Custom functions for Quote Generator Canvas                  |//
    //|=================================================================================|//
    //|=================================================================================|//


    //=================Canvas basic control settings===================//
    fabric.Object.prototype.set({
        transparentCorners: false,
        borderColor: '#dc0000',
        cornerColor: '#dc0000',
        borderSize: 10,
        cornerSize: 10
    });


    //============Initialisation of canvas on load===========//
    var host = window.location.protocol+'//'+window.location.hostname;
    var id = 1;
    var f = fabric.Image.filters;
    var canvas = new fabric.Canvas('canvas1');
    var canvas2 = new fabric.Canvas('canvas2');
    var ctx = canvas.getContext("2d");
    var ctx2 = canvas2.getContext("2d");
    var data = host+ '/images/default.jpg';
    var quote_image_bg = '';
    var quote_image_raw= '';
    var unsplashBG = false;
    if(quote != "" || quote){
        var return_image = function () {
            var tmp = null;
            $.ajax({
                'async': false,
                'type': "GET",
                'global': false,
                'dataType': 'html',
                'url': "parse-image",
                'data': {  'quote_image_data':  quote.image_url},
                'success': function (response) {
                    tmp = response;
                }
            });
            return tmp;
        }();

         quote_image_raw= return_image;
        unsplashBG = true;
        var blob = b64toBlob(quote_image_raw, 'image/png');
        quote_image_bg = URL.createObjectURL(blob);
        if($('#unsplash-image').attr('src') == ''){
            $('#unsplash-image').attr('src',quote_image_bg)
        }
        quote_image = quote_image_bg;



    }else if(quote_image){
       quote_image_raw= quote_image;
        unsplashBG = true;
        var blob = b64toBlob(quote_image_raw, 'image/png');
        quote_image_bg = URL.createObjectURL(blob);
        if($('#unsplash-image').attr('src') == ''){
            $('#unsplash-image').attr('src',quote_image_bg)
        }
        quote_image = quote_image_bg;


    }else{

        quote_image_bg =  host+ '/images/default.jpg';
    }

    data = quote_image_bg;

    $('#cropModal').find('.crop-image').attr('src', data);
    updateCropArea();


    //===========Initial canvas background image setting==============//
    fabric.Image.fromURL(data, function (objects, options) {
        var background = objects;
        background.set({
            scaleX: canvas.width / background.width,
            scaleY: canvas.height / background.height,
            selectable: false,
            lockRotation: true
        });
        applyFilter($('#filters').val());
        canvas.clear(ctx);
        canvas.add(background);
        canvas.centerObject(background);
        canvas.renderAll();
        if(quote != ""){
            $('.content').click();
            $('.footer').click();

        }else{
            $('.content').click();
        }
        canvas2.discardActiveObject();
        updateCropArea();

    });


    //===============Adding header,content,footer type of text to canvas=============//
    $(document).on('click', '.text-types span', function () {
        var content = '';
        var footer = '';
        var contentTop = '';
        var contentWidth = '';
        var contentFontSize = '';
        var footerWidth = '';
        var footerTop = '';
        var footerFontSize = '';

        if(quote != ""){
            content = quote.quote_text;
            footer = quote.author_name;
            contentTop = 10;
            contentFontSize = 20;
            footerFontSize = 18;
            footerTop = 230;
            contentWidth = 480;
            footerWidth = 300;


        }else{
            content = 'Click to edit';
            footer = 'Click to edit';
            contentTop=120;
            footerTop = 210;
            contentWidth=175;
            contentFontSize = 30;
            footerFontSize = 30;
            footerWidth = 175;
        }

        if ($(this).hasClass('active')) {
            var span = $(this)
            var type = span.data('type');

            var objs = canvas2.getObjects().map(function (o) {
                console.log(o.type+' '+type)
                if (o.type === type) {
                    canvas2.remove(o)
                    span.removeClass('active');
                }
            });
            canvas.renderAll();
            canvas2.renderAll();
        } else {
            $(this).addClass('active')
            if ($(this).hasClass('header')) {
                options = {
                    type: 'header',
                    top: 30,
                    text: 'Click to edit'
                }

            } else if ($(this).hasClass('content')) {
                options = {
                    type: 'content',
                    top: contentTop,
                    text: content,
                    textAlign:'center',
                    fontSize:contentFontSize,
                    width:contentWidth
                }
            } else {
                options = {
                    type: 'footer',
                    top: footerTop,
                    text: footer,
                    textAlign:'center',
                    fontSize:footerFontSize,
                    width:footerWidth
                }
            }
            addText(options)
        }
    });


    //================Dynamic Layout type setting==================//
    $(document).on('click', '#is_custom', function () {
        if ($(this).is(":checked")) {
            $('.custom-layout').toggleClass('d-none');
            $('.fixed-layout').addClass('d-none')
        } else {
            $('.custom-layout').addClass('d-none');
            $('.fixed-layout').toggleClass('d-none')
        }
    });




    //=============Size toggle buttons in crop model===========//
    $(document).on("click", ".docs-toggles label.btn.btn-primary", function (e) {
        var aspect_ratio = String($(this).find('input').val());
        if (aspect_ratio == "NaN" || ($(this).find('input').attr('id') == 'aspectRatio6')) {

            if (!$('#is_custom').is(":checked")) {

                $('#is_custom').click();


                // $('#width').val($('#dataWidth').val());
                // $('#height').val($('#dataHeight').val());
                var width = $('#width').val();
                var height = $('#height').val();
                height = height * 500 / width;
                width = 500;
                changeCanvasSize(width, height);
            }

        } else {
            if ($('#is_custom').is(":checked")) {
                $('#is_custom').click();

            }
            $("#layout_type").find("option").removeAttr('selected');
            $("#layout_type").find("option").each(function () {
                if (aspect_ratio == $(this).data('ar')) {
                    $(this).attr('selected', 'selected')
                    var sizes = $(this).val().split('x');
                    var width = sizes[0];
                    var height = sizes[1];
                    height = height * 500 / width;
                    width = 500;
                    changeCanvasSize(width, height);
                }
            })
        }
    });


    //===============Change background using file input=============//
    $(document).on('change', '#bg_image', function (e) {
        var _URL = window.URL || window.webkitURL;
        var file, img;
        if ((file = this.files[0])) {
            var file_size = file.size / 1000000;
            img = new Image();
            img.onload = function () {
                unsplashBG = false;
                if (file_size > 3) {
                    $('.error').removeClass('d-none').addClass('show').children('#error-message').empty().html('<strong>Sorry !</strong>  Please upload image containing size upto 3MB')
                    $('#bg_image').val('');
                } else if (this.width < 660 || this.width < 400) {
                    $('.error').removeClass('d-none').addClass('show').children('#error-message').empty().html('<strong>Sorry !</strong>  Please upload image with valid resolution. &nbsp;&nbsp;<small class="text-bold">(minimum : 660x400)</small>')
                    $('#bg_image').val('');
                } else {
                    $('.error').addClass('d-none').removeClass('show');
                    changeBG(file)
                }
            };
            img.src = _URL.createObjectURL(file);
        }
    });


    //============Stopping custom form from submitting===========//
    $("#custom_size_form").submit(function (e) {
        e.preventDefault(e);
    });


    //===============Giving customised size to image=============//
    $(document).on('click', '#custom_size_submit', function (e) {
        if (($('#width').val() == "" || $('#width').val() < 660 || $('#width') > 4000) || ($('#height').val() == "" || $('#height').val() < 400 || $('#height').val() > 4000)) {
            $('.error').removeClass('d-none').addClass('show').children('#error-message').empty().html('<strong>Sorry !</strong>  Please input valid size')
        } else {
            $('.error').addClass('d-none').removeClass('show')
            var width = $('#width').val();
            var height = $('#height').val();
            console.log(width +'and'+ height)
            height = height * 500 / width;
            width = 500;

            changeCanvasSize(width, height)
            // updateCropArea();
            if ($('#is_custom').is(':checked')) {
                $('#cropModal').find('.docs-toggles input:first').trigger('click');
                var aspect_ratio = $('#width').val() / $('#height').val();
                $('#cropModal').find('.docs-toggles').find('#aspectRatio6').val(aspect_ratio).parent('label.btn.btn-primary').trigger('click');
            }
        }
    });


    //================Update canvas size from select menu===============//
    $(document).on('change', '#layout_type', function () {
        var sizes = $(this).val().split('x');
        var width = sizes[0];
        var height = sizes[1];
        height = height * 500 / width;
        width = 500;
        updateCropArea();
        // changeCanvasSize(width, height);
    });


    //=============Change canvas background===============//
    function changeBG(file) {
        var old_data = canvas.getObjects();
        if(isValidURL(file)){
            $('#cropModal').find('.crop-image').attr('src', file);
            $('#cropModal').find('.cropper-view-box img').attr('src', file)
            $('#cropModal').find('.cropper-canvas img').attr('src', file)
            var data = file;

            fabric.Image.fromURL(data, function (objects, options) {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                var background = objects;
                if (height > 284) {
                    background.scaleToHeight(height);
                    background.set({
                        selectable: false,
                        lockRotation: false,
                        hasControls: false,
                    });
                } else {

                    background.set({
                        scaleX: canvas.width / background.width,
                        scaleY: canvas.height / background.height,
                        selectable: false,
                    });
                }
                canvas.clear(ctx)
                // canvas.getContext('2d').filter = 'brightness(0.7)';
                canvas.calcOffset();
                canvas.add(background);
                canvas.centerObject(background);
                canvas.renderAll();
                applyFilter($('#filters').val());
                refreshCanvas(old_data)
            });
        }else{
            var reader = new FileReader();
            reader.onload = function (f) {
                $('#cropModal').find('.crop-image').attr('src', f.target.result);
                $('#cropModal').find('.cropper-view-box img').attr('src', f.target.result)
                $('#cropModal').find('.cropper-canvas img').attr('src', f.target.result)
                var data = f.target.result;
                fabric.Image.fromURL(data, function (objects, options) {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    var background = objects;
                    if (height > 284) {
                        background.scaleToHeight(height);
                        background.set({
                            selectable: false,
                            lockRotation: false,
                            hasControls: false,
                        });
                    } else {

                        background.set({
                            scaleX: canvas.width / background.width,
                            scaleY: canvas.height / background.height,
                            selectable: false,
                        });
                    }
                    canvas.clear(ctx)
                    // canvas.getContext('2d').filter = 'brightness(0.7)';
                    canvas.calcOffset();
                    canvas.centerObject(background);
                    canvas.add(background);
                    canvas.renderAll();
                    applyFilter($('#filters').val());
                    refreshCanvas(old_data)

                });

            };
            reader.readAsDataURL(file);

        }

    }


    //=============Prevent object from moving outside the canvas==============//
    canvas2.on('object:moving', function (e) {
        var obj = e.target;
        // if object is too big ignore
        if (obj.currentHeight > obj.canvas.height || obj.currentWidth > obj.canvas.width) {
            return;
        }
        obj.setCoords();
        // top-left  corner
        if (obj.getBoundingRect().top < 0 || obj.getBoundingRect().left < 0) {
            obj.top = Math.max(obj.top, obj.top - obj.getBoundingRect().top);
            obj.left = Math.max(obj.left, obj.left - obj.getBoundingRect().left);
        }
        // bot-right corner
        if (obj.getBoundingRect().top + obj.getBoundingRect().height > obj.canvas.height || obj.getBoundingRect().left + obj.getBoundingRect().width > obj.canvas.width) {
            obj.top = Math.min(obj.top, obj.canvas.height - obj.getBoundingRect().height + obj.top - obj.getBoundingRect().top);
            obj.left = Math.min(obj.left, obj.canvas.width - obj.getBoundingRect().width + obj.left - obj.getBoundingRect().left);
        }
    });


    //=============Change canvas size==============//
    function changeCanvasSize(width, height) {//Change canvas size
        canvas2.setWidth(width);
        canvas2.setHeight(height);
        canvas.setHeight(height);
        canvas.setWidth(width);

        var old_data = canvas2.getObjects();
        var file = document.getElementById('bg_image').files[0];
        if(unsplashBG == true){
            var data = $('.bg-images.active').data('main');
            var img = document.querySelector( "#unsplash-image" );
            fabric.Image.fromURL(img.src, function (objects, options) {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                var background = objects;
                background.scaleToWidth(width);
                if (height > 284) {
                    background.scaleToHeight(height);
                }
                canvas.clear(ctx)
                background.set({
                    selectable: false,
                    lockRotation: false,
                    hasControls: false
                });
                canvas.calcOffset();
                canvas.add(background);
                canvas.centerObject(background);
                //====Rendering old canvas data to new resized canvas=====//
                refreshCanvas(old_data)
            });
        }else if(file){
            var reader = new FileReader();
            reader.onload = function (f) {
                var data = f.target.result;
                fabric.Image.fromURL(data, function (objects, options) {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    var background = objects;
                    background.scaleToWidth(width);
                    if (height > 284) {
                        background.scaleToHeight(height);
                    }
                    canvas.clear(ctx)
                    background.set({
                        selectable: false,
                        lockRotation: false,
                        hasControls: false
                    });
                    canvas.calcOffset();
                    canvas.add(background);
                    canvas.centerObject(background);
                    //====Rendering old canvas data to new resized canvas=====//
                    refreshCanvas(old_data)
                });
            };

            reader.readAsDataURL(file);
        } else if(quote != '' || quote_image != '') {
            fabric.Image.fromURL($('#unsplash-image').attr('src'), function (objects, options) {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                var background = objects;
                background.scaleToWidth(width);
                if (height > 284) {
                    background.scaleToHeight(height);
                }
                canvas.clear(ctx)
                background.set({
                    selectable: false,
                    lockRotation: false,
                    hasControls: false
                });
                canvas.calcOffset();
                canvas.add(background);
                canvas.centerObject(background);

                // ctx.clearRect(0, 0, canvas.width, canvas.height);
                // canvas.clear(ctx)

                //====Rendering old canvas data to new resized canvas=====//
                refreshCanvas(old_data)
                canvas2.renderAll();
            });

        }else{
            data = host+ '/images/default.jpg';
            fabric.Image.fromURL(data, function (objects, options) {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                var background = objects;
                background.scaleToWidth(width);
                if (height > 284) {
                    background.scaleToHeight(height);
                }
                canvas.clear(ctx)
                background.set({
                    selectable: false,
                    lockRotation: false,
                    hasControls: false
                });
                canvas.calcOffset();
                canvas.add(background);
                canvas.centerObject(background);

                // ctx.clearRect(0, 0, canvas.width, canvas.height);
                // canvas.clear(ctx)

                //====Rendering old canvas data to new resized canvas=====//
                refreshCanvas(old_data)
                canvas2.renderAll();
            });

        }
        applyFilter($('#filters').val());
        canvas.renderAll();
        canvas2.renderAll();
    }


    //==================Refresh Canvas==================//
    function refreshCanvas(old_data) {
        for (var key in old_data) {
            if (old_data[key].type && old_data[key].type != 'image') {
                if (old_data[key].top > 240) {
                    old_data[key].top = 230
                }
                canvas2.remove(old_data[key])
                canvas2.add(old_data[key])
            }
        }
    }


    //===============Update Crop Area===========//
    function updateCropArea() {
        var aspect_ratio = $('#layout_type').find('option:selected').data('ar');
        if ($('#is_custom').is(':checked')) {
            var aspect_ratio = $('#width').val() / $('#height').val()
            $('#cropModal').find('.docs-toggles').find('#aspectRatio6').val(aspect_ratio).parent('label.btn.btn-primary').trigger('click');
        } else {
            $('#cropModal').find('.docs-toggles input').each(function (t) {
                if (parseFloat($(this).val()) == aspect_ratio) {
                    $(this).parent('label.btn.btn-primary').trigger('click');
                }
            });
        }

    }


    //============Add Text on canvas============//
    function addText(options) {
        // var text = new fabric.IText(options.text, {
        var text = new fabric.Textbox(options.text, {
            fontFamily: 'Poppins',
            fill: (options.fill) ? options.fill : '#fff',
            top: options.top,
            fontSize: (options.fontSize) ? options.fontSize : 30,
            type: options.type,
            lockScalingFlip: true,
            lockScalingX: false,
            textAlign: (options.textAlign) ? options.textAlign : 'left',
            lockScalingY: true,
            id: (options.id) ? options.id : id + 1,
            zindex: 10,
            selectable: true,
            width: (options.width) ? options.width : 175
        });
        text.setControlsVisibility({
            mt: false, // middle top disable
            mb: false, // midle bottom
            ml: true, // middle left
            mr: true, // middle right
            br: false, // bottom right
            bl: false, // bottom left
            tl: false, // top left
            tr: false // top right
        });


        canvas2.on('text:changed', function (opt) {
            var t1 = opt.target;
            if (t1.width > t1.fixedWidth) {
                t1.fontSize *= t1.fixedWidth / (t1.width + 1);
                t1.width = t1.fixedWidth;
            }
        });
        canvas2.add(text).setActiveObject(text).bringToFront();
        if(quote != null && text.type == 'content'){
            text.center()
        }else{
            text.centerH();
        }


        var maxScaleX = 1.55;
        var maxScaleY = 1.55;

        text.on('scaling', function (e) {
            if (this.scaleX > maxScaleX) {
                this.scaleX = maxScaleX;
                this.left = this.lastGoodLeft;
                this.top = this.lastGoodTop;
            }
            if (this.scaleY > maxScaleY) {
                this.scaleY = maxScaleY;
                this.left = this.lastGoodLeft;
                this.top = this.lastGoodTop;
            }
            if (this.width > canvas.width - 10) {
                this.width = canvas.width - 10;
                this.left = 10;
                this.centerH();
            }
            this.lastGoodTop = this.top;
            this.lastGoodLeft = this.left;
        });

        text.on('selected',function () {
            $('.text-align').find('span').each(function () {
                if(text.textAlign == $(this).attr('data-align')){
                    $('.text-align').find('span').removeClass('active');
                    $(this).addClass('active');
                }
            })
        })
    }


    //=============Change font color=============//
    $(document).on('change', '#text-color', function () {
        var obj = canvas2.getActiveObject()
        obj.set({fill: this.value});
        canvas2.renderAll();
    });


    //===========Change font family==========//
    $(document).on('change', '#font-family', function () {
        var obj = canvas2.getActiveObject()
        obj.fontFamily = this.value;
        canvas2.renderAll();
    });


    //============Change font size==============//
    $(document).on('change', '#text-font-size', function () {
        var obj = canvas2.getActiveObject()
        if (this.value >= 15 && this.value <= 50) {
            obj.fontSize = this.value;
            canvas2.renderAll();
        }
    });


    //=============Setting text alignment==========//
    $(document).on('click', '.text-align span', function () {
        var align = $(this).data('align');
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            if ($('.text-align span.active').length == 0) {
                $('.text-align span[data-align="left"]').click();
            }
        } else {
            $('.text-align span').removeClass('active');
            $(this).addClass('active')
            var obj = canvas2.getActiveObject();
            obj.textAlign = align;
            canvas2.renderAll();
        }

    });


    //============Bold,italic and underline effects on text=========//
    $(document).on('click', '.text-controls-additional span.text-style', function () {
        var style = $(this).data('style');
        var obj = canvas2.getActiveObject();
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            if (style == 'bold') {
                obj.set("fontWeight", "");
            } else if (style == 'italic') {
                obj.set("fontStyle", "");
            } else {
                obj.set("underline", false)
            }
        } else {
            $('.text-controls-additional span.text-style').removeClass('active');
            $(this).addClass('active')
            if (style == 'bold') {
                obj.set("fontWeight", style);
            } else if (style == 'italic') {
                obj.set("fontStyle", style);
            } else {
                obj.set("underline", true)
            }
        }
        canvas2.renderAll();
    });


    //=========================Change filter from dropdown===============//
    $(document).on('change', '#filters', function () {
        var filter = $(this).val();
        applyFilter(filter);
        canvas.renderAll()
    });


    //===========================Apply filter ================================//
    var filters = {
        'light-contrast': 'brightness(0.6)',
        'heavy-contrast': 'brightness(0.3)',
        'light-blur': 'blur(2px)brightness(0.6)',
        'heavy-blur': 'blur(5px)brightness(0.6)',
        'grayscale': 'grayscale(1)brightness(0.6)',
        'sepia': 'sepia(1)brightness(0.6)',
        'invert': 'invert(1)brightness(0.6)',
        'hue': 'hue-rotate(80deg)brightness(0.6)',
        'saturate': 'saturate(30%)brightness(0.6)'
    }

    function applyFilter(name) {
        for (var key in filters) {
            if (key == name) {
                canvas.getContext('2d').filter = filters[key];
            }
        }
    }


    //=====================Download Edited Photo ==========================//
    $(document).on('click', '#download', function () {
        canvas2.discardActiveObject();
        canvas2.renderAll();
        var old_data = canvas2.getObjects();
        // refreshCanvas(old_data);
        // applyFilter($('#layout_type').val());
        var width;
        var height;
        var can3 = document.getElementById('canvas3');
        var can1 = document.getElementById('canvas1');
        var can2 = document.getElementById('canvas2');
        var ctx3 = can3.getContext('2d');


        if ($("#is_custom").is(":checked")) {
            width = $('#width').val();
            height = $('#height').val();
        } else {
            var sizes = $('#layout_type').val().split('x');
            width = sizes[0];
            height = sizes[1];
        }
        can3.height = height;
        can3.width = width;
        GetCanvasAtResoution(width, height);
        ctx3.drawImage(can1, 0, 0);
        ctx3.drawImage(can2, 0, 0);

        var img = can3.toDataURL("image/jpeg");
        $(this).attr('href', img);

        height = height * 500 / width;
        width = 500;
        GetCanvasAtResoution(width, height);
    });


    //================Scaling canvas and its objects before download================//
    function GetCanvasAtResoution(newWidth, newHeight) {
        if (canvas.width != newWidth) {
            var scaleMultiplier = newWidth / canvas.width;
            var objects = canvas.getObjects();
            for (var i in objects) {
                objects[i].scaleX = objects[i].scaleX * scaleMultiplier;
                objects[i].scaleY = objects[i].scaleY * scaleMultiplier;
                objects[i].left = objects[i].left * scaleMultiplier;
                objects[i].top = objects[i].top * scaleMultiplier;
                objects[i].setCoords();
            }
            var obj = canvas.backgroundImage;
            if (obj) {
                obj.scaleX = obj.scaleX * scaleMultiplier;
                obj.scaleY = obj.scaleY * scaleMultiplier;
            }

            canvas.discardActiveObject();
            canvas.setWidth(canvas.getWidth() * scaleMultiplier);
            canvas.setHeight(canvas.getHeight() * scaleMultiplier);
            applyFilter($('#filters').val())
            canvas.renderAll();
            canvas.calcOffset();
        }
        if (canvas2.width != newWidth) {
            var scaleMultiplier = newWidth / canvas2.width;
            var scaleMultiplierH = newHeight / canvas2.height;

            var objects = canvas2.getObjects();
            for (var i in objects) {
                objects[i].scaleX = objects[i].scaleX * scaleMultiplier;
                objects[i].scaleY = objects[i].scaleY * scaleMultiplier;
                objects[i].left = objects[i].left * scaleMultiplier;
                objects[i].top = objects[i].top * scaleMultiplier;
                objects[i].setCoords();
            }

            var obj = canvas2.backgroundImage;
            if (obj) {
                obj.scaleX = obj.scaleX * scaleMultiplier;
                obj.scaleY = obj.scaleY * scaleMultiplier;
            }

            canvas2.discardActiveObject();
            canvas2.setWidth(canvas2.getWidth() * scaleMultiplier);
            canvas2.setHeight(canvas2.getHeight() * scaleMultiplier);
            canvas2.renderAll();
            canvas2.calcOffset();
        }
    }


    //==============Selecting Background images from unsplash images=================//
    $(document).on('click', '.bg-images', function () {
        $('.bg-images').removeClass('active');
        $(this).addClass('active');
        var width = "";
        var height = "";
        var image_url = $(this).data('main');
        var xhr = new XMLHttpRequest();
        xhr.open( "GET", image_url, true );
        xhr.responseType = "arraybuffer";
        xhr.onload = function( e ) {
            // Obtain a blob: URL for the image data.
            var arrayBufferView = new Uint8Array( this.response );
            var blob = new Blob( [ arrayBufferView ], { type: "image/jpeg" } );
            var urlCreator = window.URL || window.webkitURL;
            var imageUrl = urlCreator.createObjectURL( blob );
            var img = document.querySelector( "#unsplash-image" );
            img.src = imageUrl;
            if ($('#is_custom').is(":checked")) {
                width = $('#dataWidth').val();
                height = $('#dataHeight').val();
            }else{
               var sizes =  $('#layout_type').val().split('x');
                width = sizes[0];
               height = sizes[1];
            }
            height = height * 500 / width;
            width = 500;
            unsplashBG = true;
            // changeBG(blob);
            $('#cropModal').find('.crop-image').attr('src', imageUrl);
            $('#cropModal').find('.cropper-view-box img').attr('src', imageUrl)
            $('#cropModal').find('.cropper-canvas img').attr('src', imageUrl)
            changeCanvasSize(width, height);
        };
        xhr.send();

    });


    //=================Check if string is valid url==============================//
    function isValidURL(string) {
        if( Object.prototype.toString.call(string) == '[object String]' ) {
            unsplashBG = true;
            var res = string.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
            if (res == null) {
                return false;
            }
            else {
                return true;
            }
        }else{
            return false;
        }
    }


    //=================Converting Base64 to Blob==============================//
    function b64toBlob(b64Data, contentType, sliceSize) {
        contentType = contentType || '';
        sliceSize = sliceSize || 512;

        var byteCharacters = atob(b64Data);
        var byteArrays = [];

        for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            var slice = byteCharacters.slice(offset, offset + sliceSize);

            var byteNumbers = new Array(slice.length);
            for (var i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }

            var byteArray = new Uint8Array(byteNumbers);

            byteArrays.push(byteArray);
        }

        var blob = new Blob(byteArrays, {type: contentType});
        return blob;
    }

});

