(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else if (typeof module === 'object' && module.exports) {
        module.exports = factory(require('jquery'));
    } else {
        factory(window.jQuery);
    }
}(function ($) {
    $.extend(true, $.summernote.lang, {
        'en-US': {
            imageupload: {
                image: 'Image',
                insert: 'Insert Image',
                selectFromFiles: 'Select from files',
                url: 'Image URL',
                upload: 'Upload',
                file: 'File'
            }
        }
    });

    $.extend($.summernote.options, {
        imageupload: {
            icon: '<i class="note-icon-picture" />',
        },
        callbacks: {
            onImageUploadFromUrl: null,
            onImageUploadFromFile: null
        }
    });

    $.extend($.summernote.options.callbacks, {
        onImageUpload: function(files) {
            var editor = $(this);
            var formData = new FormData();
            formData.append('image', files[0]);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            $.ajax({
                url: '/summernote/upload-image',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.url) {
                        $(editor).summernote('insertImage', response.url);
                    } else if (response.error) {
                        alert(response.error);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error(textStatus + " " + errorThrown);
                    alert('Image upload failed.');
                }
            });
        }
    });

    $.extend($.summernote.plugins, {
        'imageupload': function (context) {
            var self = this,
                ui = $.summernote.ui,
                $note = context.layoutInfo.note,
                $editor = context.layoutInfo.editor,
                $editable = context.layoutInfo.editable,
                options = context.options,
                lang = options.langInfo;

            context.memo('button.imageupload', function () {
                var button = ui.button({
                    contents: options.imageupload.icon,
                    tooltip: lang.imageupload.image,
                    click: function (e) {
                        context.invoke('imageupload.show');
                    }
                });
                return button.render();
            });

            this.initialize = function () {
                var $container = options.dialogsInBody ? $(document.body) : $editor;
                var body = `
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link active" href="#note-imageupload-url" data-bs-toggle="tab" data-toggle="tab">${lang.imageupload.url}</a></li>
                        <li class="nav-item"><a class="nav-link" href="#note-imageupload-file" data-bs-toggle="tab" data-toggle="tab">${lang.imageupload.file}</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="note-imageupload-url">
                            <div class="form-group note-group-image-url">
                                <label class="note-form-label">${lang.imageupload.url}</label>
                                <input class="note-image-url form-control note-form-control note-input" type="text" />
                            </div>
                        </div>
                        <div class="tab-pane" id="note-imageupload-file">
                            <div class="form-group">
                                <label class="note-form-label">${lang.imageupload.selectFromFiles}</label>
                                <input class="note-image-input form-control-file note-form-control note-input" type="file" name="file" accept="image/*" />
                            </div>
                        </div>
                    </div>
                `;

                var footer = `<button href="#" class="btn btn-primary note-image-btn">${lang.imageupload.insert}</button>`;

                this.$dialog = ui.dialog({
                    title: lang.imageupload.insert,
                    body: body,
                    footer: footer
                }).render().appendTo($container);
            };

            this.destroy = function () {
                ui.hideDialog(this.$dialog);
                this.$dialog.remove();
            };

            this.bindEnterKey = function ($input, $btn) {
                $input.on('keypress', function (event) {
                    if (event.keyCode === 13) {
                        $btn.trigger('click');
                    }
                });
            };

            this.show = function () {
                context.invoke('editor.saveRange');
                this.showImageUploadDialog().then(function (data) {
                    ui.hideDialog(self.$dialog);
                    context.invoke('editor.restoreRange');

                    if (data.url) {
                        if (options.callbacks.onImageUploadFromUrl) {
                            context.triggerEvent('image.upload.from.url', data.url);
                        } else {
                            context.invoke('editor.insertImage', data.url);
                        }
                    } else if (data.file) {
                        if (options.callbacks.onImageUploadFromFile) {
                            context.triggerEvent('image.upload.from.file', data.file);
                        } else {
                            self.uploadImage(data.file);
                        }
                    }
                }).fail(function () {
                    context.invoke('editor.restoreRange');
                });
            };

            this.showImageUploadDialog = function () {
                return $.Deferred(function (deferred) {
                    var $imageInput = self.$dialog.find('.note-image-input'),
                        $imageUrl = self.$dialog.find('.note-image-url'),
                        $imageBtn = self.$dialog.find('.note-image-btn');
                    
                    self.$dialog.find('.nav-link').on('click', function() {
                        setTimeout(() => {
                            if ($(this).attr('href') === '#note-imageupload-url') {
                                $imageUrl.focus();
                                $imageBtn.off('click').on('click', function (event) {
                                    event.preventDefault();
                                    deferred.resolve({ url: $imageUrl.val() });
                                });
                                self.bindEnterKey($imageUrl, $imageBtn);
                            } else {
                                $imageInput.focus();
                                $imageBtn.off('click').on('click', function (event) {
                                    event.preventDefault();
                                    deferred.resolve({ file: $imageInput[0].files[0] });
                                });
                            }
                        }, 100);
                    });

                    ui.onDialogShown(self.$dialog, function () {
                        context.triggerEvent('dialog.shown');
                        $imageUrl.val('');
                        $imageInput.val('');
                        $imageBtn.html(lang.imageupload.insert);

                        // Default to URL
                        $imageUrl.focus();
                        $imageBtn.off('click').on('click', function (event) {
                            event.preventDefault();
                            deferred.resolve({ url: $imageUrl.val() });
                        });
                        self.bindEnterKey($imageUrl, $imageBtn);
                    });
                    
                    ui.onDialogHidden(self.$dialog, function () {
                        $imageBtn.off('click');
                        if (deferred.state() === 'pending') {
                            deferred.reject();
                        }
                    });
                    ui.showDialog(self.$dialog);
                });
            };

            this.uploadImage = function(file) {
                var formData = new FormData();
                formData.append('image', file);
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                $.ajax({
                    url: '/summernote/upload-image',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.url) {
                            context.invoke('editor.insertImage', response.url);
                        } else if (response.error) {
                            alert(response.error);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error(textStatus + " " + errorThrown);
                        alert('Image upload failed.');
                    }
                });
            };
        }
    });
})); 