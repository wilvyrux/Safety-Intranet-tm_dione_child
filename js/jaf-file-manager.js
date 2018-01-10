jQuery(function($){
    var Jaf_WP_File_Manager = {};
    Jaf_WP_File_Manager.main_container = $('#file-manager-wrapper');
    Jaf_WP_File_Manager.folder_file_container = $('#folder-file-container');
    Jaf_WP_File_Manager.modal_delete = $('#delete-file-folder');
    Jaf_WP_File_Manager.modal_share = $('#share-file-modal');
    Jaf_WP_File_Manager.modal_new_folder = $('#new-folder');
    Jaf_WP_File_Manager.current_folder = 0;

    var ajaxurl = jaf_file_manager.ajaxurl;

    Jaf_WP_File_Manager.load_files = function(folder_term){
        var _this = this;

            //add a loading icon
            _this.main_container.find('.loading-spinner').fadeIn();

            $.post( ajaxurl, { action: 'jaf_load_files', folder_term : folder_term }, function(data){
                console.log('File lists is loading...');
            //console.log(data);

            if(data.status){
                _this.folder_file_container.html(data.html);
                _this.main_container.find('.folder-breadcrumb').html(data.ancestor);
                _this.current_folder = folder_term;
            }else{
                alert( data.message );
            }
            _this.main_container.find('.loading-spinner').fadeOut();

        }, 'json' );
        };

        Jaf_WP_File_Manager.init = function(){
            var _this = this;
            _this.load_files(0);


            /*Load file handler*/
            _this.main_container.on('click', '.file-element', function(e){
                console.log('file Clicked');

                var file_type = $(this).data('type');
                var file_id = $(this).data('id');
                var file_url = $(this).data('url');

                /*check if the file type is folder, then open it*/
                if(file_type == 'dir'){
                    _this.load_files(file_id);
                }else{
                    console.log(file_url);
                    window.open(file_url);
                }

            });

            /*Delete handler*/
            this.main_container.on('click', '.file-delete', function(){

                var file_type = $(this).attr('data-type');
                var file_id = $(this).attr('data-id');

                /*set modal values*/
                _this.modal_delete.find('.delete-file').attr('data-type', file_type).attr('data-id', file_id);

            });
            _this.modal_delete.on('click', '.delete-file', function(){
                var _this_button = $(this);
                $.post(ajaxurl, {action: 'delete_file', file_type: $(this).attr('data-type'), file_id: $(this).attr('data-id') }, function(data){
                    if(data.success){
                        _this.load_files(_this.current_folder);
                    }
                    _this_button.attr('data-type', '').attr('data-id', '');
                    _this.modal_delete.modal('hide');
                }, 'json' );

            });

            /*Form share handler*/
            this.main_container.on('click', '.file-share', function(){

                var file_type = $(this).data('type');
                var file_id = $(this).data('id');
                var file_user = $(this).data('shared_user');
                var file_department = $(this).data('shared_department');
                var file_manager = $(this).data('shared_manager');

                //set modal values
                _this.modal_share.find('input[name="file_type"]').val(file_type);
                _this.modal_share.find('input[name="file_id"]').val(file_id);
                //set selected
                _this.modal_share.find('select[name="share_to_user"]').val(file_user.split(","));
                _this.modal_share.find('select[name="share_to_department"]').val(file_department.split(","));
                _this.modal_share.find('input[name="share_to_manager"]').prop('checked', file_manager == '1' ? true : false);

            });
            _this.modal_share.on('submit', 'form', function(){
                var _this_form = $(this);

                $(_this_form).ajaxSubmit({
                    url: ajaxurl,
                    type: 'POST',
                    dataType: 'json',
                    success: function(data){
                        if(data.success){
                            _this.load_files(_this.current_folder);
                        }
                        _this.modal_share.modal('hide');
                        _this.modal_share.find('input[name="file_type"]').val('');
                        _this.modal_share.find('input[name="file_id"]').val('');
                        _this.modal_share.find('select[name="share_to_user"]').val('');
                        _this.modal_share.find('select[name="share_to_department"]').val('');
                        _this.modal_share.find('select[name="share_to_manager"]').val('');
                    },
                });

                return false;
            });

            _this.modal_new_folder.on('submit', 'form', function(){
                $(this).find('[name="current_folder"]').val(Jaf_WP_File_Manager.current_folder);
                $.post(ajaxurl, $(this).serializeArray(), function(data){
                    if(data.status){
                        _this.modal_new_folder.modal('hide');
                        _this.load_files(get_current_folder());
                    }else{
                        alert(data.message);
                    }
                }, 'json' );

                return false;
            });

            

        };

        Jaf_WP_File_Manager.init();

        /*File uploader handler*/
        function get_current_folder(){
            return (Jaf_WP_File_Manager != undefined && Jaf_WP_File_Manager.current_folder != undefined) ? Jaf_WP_File_Manager.current_folder : 0;
        }
        $('#fileupload').fileupload({
            url: ajaxurl,
            dataType: 'json',
            submit: function(e, data){
                $('#progress .progress-bar').css( 'width', '0%' );
                data.formData = {action: 'jaf_upload_file', current_folder: get_current_folder() };
            },
            done: function (e, data) {
                /*$.each(data.result.files, function (index, file) {
                    $('<p/>').text(file.name).appendTo('#files');
                });*/
            },
            always: function(){ Jaf_WP_File_Manager.load_files(get_current_folder()); },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                    );
            }
        }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');


    });