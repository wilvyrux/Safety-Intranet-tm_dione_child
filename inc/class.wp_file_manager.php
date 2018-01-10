<?php
require_once 'class.UploadHandler.php';

class JAF_WP_File_Manager
{

    private $upload_dir = 'jaf-files-upload';
    private $upload_path = '';
    private $folder_taxonomy = 'jaf_document_folder';
    public $post_type        = 'jaf_document_cpt';

    public function __construct()
    {
        $this->container_id = rand();
        $this->ajaxurl      = admin_url('admin-ajax.php');

        $upload = wp_upload_dir();
        $upload_dir = $upload['basedir'];
        $this->upload_path = $upload_dir . '/'.$this->upload_dir;

        add_shortcode('jaf-file-manager', [$this, 'render_sc']);
        add_shortcode('jaf-file-table', [$this, 'render_file_table_sc']);
        add_shortcode('jaf-file-table-tab', [$this, 'render_file_table_tab_sc']);
        $this->add_admin_ajax('jaf_load_files');
        $this->add_admin_ajax('share_file');
        $this->add_admin_ajax('delete_file');
        $this->add_admin_ajax('jaf_upload_file');
        $this->add_admin_ajax('add_new_folder');
        $this->add_admin_ajax('jaf_get_pdf_thumb');
        // $this->add_admin_ajax('jaf_download_file');
        add_action( 'template_redirect', [$this, 'jaf_download_file'] );
    }

    public function render_sc($atts = [])
    {
        extract(shortcode_atts([], $atts));

        add_action('wp_footer', [$this, 'echo_modal_markups']);
        wp_enqueue_script( 'jaf-file-manager-js', get_theme_file_uri().'/js/jaf-file-manager.js', ['jquery'], false, true );
        wp_localize_script( 'jaf-file-manager-js', 'jaf_file_manager', [ 'ajaxurl' => admin_url( 'admin-ajax.php' ) ] );

        $markup = '';

        $markup .= '<div  id="file-uploader-wrap-' . $this->container_id . '" class="file-uploader-wrap" >
                        <div class="row" > 
                            <div class="col-md-12" > 
                                <div id="progress" class="progress">
                                    <div class="progress-bar progress-bar-success"></div>
                                </div>
                                <div class="btn btn-success fileinput-button">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    <span>Select files...</span>
                                    <!-- The file input field used as target for the file upload widget -->
                                    <input id="fileupload" type="file" name="files[]" multiple>
                                </div>
                            </div>
                            <div class="col-md-12" > 
                                 <a class="btn btn-info" href="#" data-toggle="modal" data-target="#new-folder"><i class="fa fa-plus"></i>New Folder</a>
                            </div>
                        </div>

                       
                    </div>

                        <div id="file-manager-wrapper" >
                        <div class="page-bar">
                            <div class="loading-spinner pull-right" ><i class="fa fa-refresh fa-spin" aria-hidden="true"></i></div>
                            <ul class="page-breadcrumb folder-breadcrumb breadcrumb">
                                <li><a href="#"><i class="fa fa-folder-open"></i>Home</a></li>
                            </ul>
                        </div>
                        <div id="folder-file-container" class="folder-file-container" >

                        </div>
                    </div>
                    ';

        // $markup .= $this->modal_markups();
        $markup .= $this->inline_scripts();

        return $markup;
    }

    public function echo_modal_markups()
    {
        echo $this->modal_markups();
    }
    public function modal_markups()
    {
        $modals = '';
        $modals = '<!--modal for adding folder-->
                    <div id="new-folder" class="modal fade" role="dialog" >
                        <form id="form-new-folder">
                            <input type="hidden" name="action" value="add_new_folder" >
                            <input type="hidden" name="current_folder" value="" >
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">New Folder</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Folder Name  </label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="folder-name" value="" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success" data-id="" data-type="" >SAVE</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!--modal for deleting file-->
                    <div id="delete-file-folder" class="modal fade" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Are you sure you want to delete file?</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Deleting the item will remove it permanently on the system. Folder with items will be move to its parent or root.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger delete-file" data-id="" data-type="" >DELETE</button>
                                </div>
                            </div>
                        </div>
                    </div>

';

        return $modals;
    }

    public function add_admin_ajax($action)
    {
        add_action("wp_ajax_$action", array($this, $action));
        add_action("wp_ajax_nopriv_$action", array($this, $action));
    }

    public function jaf_load_files()
    {
        $data = array(
            'status'  => false,
            'message' => '',
        );

        //get the current term to get the list of files and folders
        $term_folder = empty($_POST['folder_term']) ? 0 : $_POST['folder_term'];

        $current_user = wp_get_current_user();

        /*Get the term ancestor*/
        $ancestor = '<li><a class="file-element" data-type="dir" data-id="0" data-url="#" ><i class="fa fa-folder-open"></i>' . __('Home', 'wphrm') . ' ' . ($term_folder != 0 ? '<i class="fa fa-angle-right"></i>' : '') . '</a></li>';
        if ($term_folder != 0) {
            $ancestor_ids   = get_ancestors($term_folder, '', 'taxonomy');
            $ancestor_ids[] = $term_folder;
            $ctr            = 0;
            foreach ($ancestor_ids as $ancestor_id) {
                $ctr++;
                $term = get_term($ancestor_id);
                if (!is_wp_error($term) && !empty($term)) {
                    $url = get_term_link($term->term_id, $this->folder_taxonomy);
                    $ancestor .= '<li>
                    <a class="file-element" data-type="dir" data-id="' . $term->term_id . '" data-url="' . $url . '" >
                    <i class="fa fa-folder-open"></i>' . $term->name . ' ' . ($ctr < count($ancestor_ids) ? '<i class="fa fa-angle-right"></i>' : '') . '
                    </a>
                    </li>';
                }
            }
        }

        /*get the folder term under the current one*/
        $terms = get_terms(array(
            'taxonomy'   => $this->folder_taxonomy,
            'hide_empty' => 0,
            'parent'     => $term_folder,
        ));

        $has_folders = false;
        $html        = '<ul class="file-list-items" >';
        // $html        .= print_r($terms, 1);

        if (!is_wp_error($terms) && !empty($terms)) {
            $has_folders    = true;
            $data['status'] = !$data['status'] ? true : true;

            foreach ($terms as $term) {

                //check if the term has files for non admin users, if none dont display the folder
                $args = array(
                    'post_type'   => $this->post_type,
                    'post_status' => 'publish',
                );
                /*$args['meta_query'] = array(
                    'relation' => 'OR',
                    array(
                        'key'   => 'share_to_user',
                        'value' => get_current_user_id(),
                    ),
                    array(
                        'key'   => 'share_to_department',
                        'value' => $this->get_user_department(get_current_user_id()),
                    ),
                );*/
                $args['tax_query'] = array(array(
                    'taxonomy' => $this->folder_taxonomy,
                    'terms'    => $term->term_id,
                    'field'    => 'term_id',
                ));
                $folder_files = get_posts($args);
                /*if (count($folder_files) == 0 && !current_user_can('manage_options') ) {
                continue;
                }*/

                $url = get_term_link($term->term_id, $this->folder_taxonomy);

                $thumb = get_theme_file_uri( '/images/folder-thumb.png' );
                $thumb_img = '<img src="'.$thumb.'" alt="Folder" title="Folder Icon" >';

                $html .= '<li class=" file-container file-folder" >
                <a class="file-element" data-type="dir" data-id="' . $term->term_id . '" data-url="' . $url . '" >
                <div class="file-icon folder-icon-wrapper">
                    <i class="fa fa-folder" aria-hidden="true"></i>
                    <div class="file-thumb" >'.$thumb_img.'</div>
                </div>
                <div class="folder-name">' . $term->name . '</div>
                </a>
                <div class="status ' . (current_user_can('manage_options') ? '' : 'hidden') . '">
                <a class="file-delete text-danger" title="Delete" data-toggle="modal" data-target="#delete-file-folder" data-type="dir" data-id="' . $term->term_id . '" ><i class="fa fa-trash" aria-hidden="true"></i></a>
                </div>
                </li>';
            }
        } else {
            $data['message'] .= ' Cant load folders. ';
        }

        //now get the list of file under this term, if no category here
        $args = array(
            'post_type'      => $this->post_type,
            'post_status'    => ['publish', 'private'],
            'posts_per_page' => '-1',
        );

        if ($term_folder) {
            $args['tax_query'] = array(array(
                'taxonomy' => $this->folder_taxonomy,
                'terms'    => $term_folder,
                'field'    => 'term_id',
            ));
        } else {
            $args['tax_query'] = array(array(
                'taxonomy' => $this->folder_taxonomy,
                'terms'    => get_terms($this->folder_taxonomy, array('fields' => 'ids', 'hide_empty' => false)),
                'operator' => 'NOT IN',
            ));
        }

        /*if (!current_user_can('manage_options')) {
        $args['meta_query'] = array(
        'relation' => 'OR',
        array(
        'key'   => 'share_to_user',
        'value' => get_current_user_id(),
        ),
        array(
        'key'   => 'share_to_department',
        'value' => $this->get_user_department(get_current_user_id()),
        ),
        );
        }*/

        $posts = get_posts($args);

        if (!empty($posts)) {
            $data['status'] = !$data['status'] ? true : true;

            foreach ($posts as $post) {
                $file_upload_data = get_post_meta($post->ID, 'file_upload_data', true);
                //$file_upload_data = $file_upload_data ? unserialize($file_upload_data);
                $file_name = $file_upload_data->name;
                $url = $file_upload_data->url;
                $filesize = $file_upload_data->size / 1024;
                $filetype = $file_upload_data->type;
                $thumb = null;

                // $html .= print_r($file_upload_data, 1);
                $thumb = $this->get_file_thumb($file_name);
                if(!$thumb){
                  $thumb = $file_upload_data->url;
                }

                $shared_to_user       = get_post_meta($post->ID, 'share_to_user', true);
                $shared_to_department = get_post_meta($post->ID, 'share_to_department', true);
                $shared_to_manager    = get_post_meta($post->ID, 'share_to_manager', true);

                $thumb_img = $thumb ? '<img src="'.$thumb.'" title="'.$title.'" alt="'.$title.'" >' : '';
                $dl_link = add_query_arg(['jfm_action' => 'dl', 'pid' => $post->ID], site_url());

                $html .= '<li class="file-container '.($thumb ? 'with-thumbnail' : 'no-thumbnail').' " >
                <a class="file-element" data-type="file" data-id="' . $post->ID . '" data-url="' . $dl_link . '" >
                    <div class="file-icon file-icon-wrapper">
                        <i class="fa fa-file-text" aria-hidden="true"></i>
                        <div class="file-thumb" >'.$thumb_img.'</div>
                        <div class="file-meta-info" >
                            <span class="fsize" >Size: '.$filesize.' KB</span>
                            <span class="ftype" >Type: '.$filetype.'</span>
                        </div>
                    </div>
                    <div class="file-name">' . $post->post_title . '</div>
                </a>
                <div class="status ' . (current_user_can('manage_options') ? '' : 'hidden') . '">
                    <a class="file-share hide text-info" title="Share" data-toggle="modal" data-target="#share-file-modal" data-type="file" data-id="' . $post->ID . '" data-shared_user="' . $shared_to_user . '" data-shared_department="' . $shared_to_department . '" data-shared_manager="' . $shared_to_manager . '" ><i class="fa fa-share" aria-hidden="true"></i></a>
                    <a class="file-delete text-danger" title="Delete" data-toggle="modal" data-target="#delete-file-folder" data-type="file" data-id="' . $post->ID . '" ><i class="fa fa-trash" aria-hidden="true"></i></a>
                </div>
                <div class="action"></div>
                <div class="status"></div>
                </li>';
            }
        } elseif (!$has_folders) {
            $data['status'] = !$data['status'] ? true : true;
            $html .= '<div class="col-md-12" >
            <p class="description">No files to show.</p>
            </div>';
        } else {
            $data['message'] .= ' No Files under this folder. ';
        }

        $html .= '</ul>';

        $data['ancestor'] = $ancestor;
        //$data['count'] = count($posts);
        $data['args'] = $args;
        $data['html'] = $html;

        echo json_encode($data);
        exit;
    }

    public function get_user_department($user_id)
    {
        //get_user_department
        $wphrmEmployeeBasicInfo = $this->WPHRMGetUserDatas($user_id, 'wphrmEmployeeInfo');
        return intval($wphrmEmployeeBasicInfo['wphrm_employee_department']);
    }

    public function WPHRMGetUserDatas($ID, $key)
    {
        $wphrmUserInfo  = get_user_meta($ID, $key, true);
        $wphrmUserDatas = array();
        if ($wphrmUserInfo != ''):
            $wphrmUserDatas = unserialize(base64_decode($wphrmUserInfo));
        endif;
        return $wphrmUserDatas;
    }

    public function share_file()
    {
        $type = empty($_REQUEST['file_type']) ? false : $_REQUEST['file_type'];
        $id   = empty($_REQUEST['file_id']) ? false : $_REQUEST['file_id'];
        //$share_to_user = isset($_REQUEST['share_to_user']) ? $_REQUEST['share_to_user'] : '';
        $share_to_user = array();
        foreach ($_REQUEST['share_to_user'] as $selected) {
            $share_to_user[] = $selected;
        }
        //$share_to_department = isset($_REQUEST['share_to_department']) ? $_REQUEST['share_to_department'] : '';
        $share_to_department = array();
        foreach ($_REQUEST['share_to_department'] as $selected) {
            $share_to_department[] = $selected;
        }
        $share_to_manager = isset($_REQUEST['share_to_manager']) ? $_REQUEST['share_to_manager'] : 0;
        /*$share_to_manager = array();
        foreach($_REQUEST['share_to_manager'] as $selected){
        $share_to_manager[] = $selected;
        }*/

        if (!$type || !$id) {
            wp_send_json_error();
        }

        update_post_meta($id, 'share_to_user', implode(',', $share_to_user));
        update_post_meta($id, 'share_to_department', implode(',', $share_to_department));
        update_post_meta($id, 'share_to_manager', $share_to_manager);

        wp_send_json_success($_REQUEST);
        exit;

    }

    public function delete_file()
    {
        $response = [];
        $type = empty($_POST['file_type']) ? false : $_POST['file_type'];
        $id   = empty($_POST['file_id']) ? false : $_POST['file_id'];

        if (!$type || !$id || !current_user_can( 'manage_options' )) {
            wp_send_json_error();
        }

        if ($type == 'dir') {
            //delete term
            $result = wp_delete_term($id, $this->folder_taxonomy);
            if ($result) {
                wp_send_json_success();
            }

        } elseif ($type == 'file') {
            //delete post
            $terms = wp_get_post_terms( $id, $this->folder_taxonomy , ['fields' => 'ids']);
            $file_data = get_post_meta( $id, 'file_upload_data', true);
            $result = wp_delete_post($id, true);

            //also delete the file on the server
                $upload     = wp_upload_dir();
                $upload_dir = $upload['basedir'];
            if(!is_wp_error( $terms ) && !empty($terms) && $result && $file_data){
                foreach ($terms as $folder_id) {
                    $file_path =  $upload_dir . '/'.$this->upload_dir.'/' . $folder_id . '/'.$file_data->name;
                   $deleted = wp_delete_file( $file_path );
                   $response['path'] = [ $file_path, $deleted];
                }
            }else{
                $file_path =  $upload_dir . '/'.$this->upload_dir.'/0/'.$file_data->name;
                   $deleted = wp_delete_file( $file_path );
                   $response['path'] = [ $file_path, $deleted];
            }

            if ($result) {
                wp_send_json_success($response);
            }

        } else {
            wp_send_json_error();
        }
        wp_send_json_error();

    }

    public function jaf_upload_file()
    {
        $response = array(
            'status'  => false,
            'message' => '',
        );
        if (class_exists('UploadHandler')) {

            $folder_id = empty($_REQUEST['current_folder']) ? 0 : $_REQUEST['current_folder'];

            $upload     = wp_upload_dir();
            $upload_dir = $upload['basedir'];
            $upload_url = $upload['baseurl'];
            $upload_dir = $upload_dir . '/'.$this->upload_dir.'/' . $folder_id . '/';
            $upload_url = $upload_url . '/'.$this->upload_dir.'/' . $folder_id . '/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755);
            }
            $options = array(
                'max_file_size'    => (1048576 * 10),
                'image_file_types' => '/\.(gif|jpe?g|png|doc|docx|pdf|ppt|pptx|xls|xlsx)$/i',
                'upload_dir'       => $upload_dir,
                'upload_url'       => $upload_url,
                //'thumbnail' => array('max_width' => 80,'max_height' => 80),
                'print_response'   => false,
            );
            $upload_obj               = new UploadHandler($options);
            $files                    = $upload_obj->response['files'];
            $response['upload_obj']   = $upload_obj;
            $response['upload_data']  = $upload_obj->response['files'];
            $response['upload_count'] = count($upload_obj->response['files']);

            foreach ($upload_obj->response['files'] as $file) {
                //$response['filename'] = $file->name;
                $new_file = array(
                    'post_title'   => sanitize_text_field($file->name),
                    'post_content' => '',
                    'post_type'    => $this->post_type,
                    'post_status'  => 'publish',
                    'post_author'  => is_user_logged_in() ? get_current_user_id() : 1,
                    //'tax_input'     => array( 'wphrm_document_folder' => array($folder_id) ),
                );
                $post_id              = wp_insert_post($new_file);
                $response['new_post'] = $post_id;
                if (!is_wp_error($post_id)) {
                    $tag = array((int) $folder_id);
                    wp_set_post_terms($post_id, $tag, $this->folder_taxonomy);
                    update_post_meta($post_id, 'file_upload_data', $file);
                    update_post_meta($post_id, 'file_url', $file->url);
                    update_post_meta($post_id, 'file_name', $file->name);
                    update_post_meta($post_id, 'file_type', $file->type);
                    update_post_meta($post_id, 'file_size', $file->size);
                    update_post_meta($post_id, 'file_thumbnail', $file->thumbanilUrl);
                    update_post_meta($post_id, 'download_token', rand());
                    $response['status']     = true;
                    $response['post_ids'][] = $post_id;
                } else {
                    $response['message'] = 'cant add new post';
                }
                $response['result'][] = $post_id;
            }
        } else {
            $response['message'] = 'Class UploadHandler not exists, its required.';
        }
        echo json_encode($response);exit;
    }

    public function add_new_folder()
    {
        $response = array(
            'status'  => false,
            'message' => '',
        );

        $current_term = empty($_REQUEST['current_folder']) ? 0 : (int) $_REQUEST['current_folder'];
        $folder_name  = empty($_REQUEST['folder-name']) ? false : trim($_REQUEST['folder-name']);

        if ($folder_name) {
            $args = array( 'parent' => $current_term );
            //if ($current_term != 0) { $args['parent'] = $current_term; }

            if (!term_exists($folder_name, $this->folder_taxonomy)) {

                if (wp_insert_term($folder_name, $this->folder_taxonomy, $args)) {
                    $response['status']  = true;
                    $response['message'] = 'Folder added';
                } else {
                    $response['message'] = 'No folder name set';
                }
                    $response['args'] = $args;
            } else {
                $response['message'] = 'Folder name already exists!';
            }

            echo json_encode($response);exit;
        } else {
            $response['message'] = 'No folder name set';
        }

    }

    function jaf_get_pdf_thumb(){
        var_dump(class_exists('Imagick'));
        $im = new imagick( $this->upload_path.'/0/dummy.pdf[0]' );
        $im->setImageFormat('jpg');
        //header('Content-Type: image/jpeg');
        echo $im;
        exit;
    }

    public function inline_scripts()
    {
        return '';
    }

    function get_file_thumb($file_name){
        $thumb = null;
        if(pathinfo($file_name, PATHINFO_EXTENSION) == 'pdf'){
            $thumb = get_theme_file_uri('/images/pdf-thumb.png');
        }elseif(in_array(pathinfo($file_name, PATHINFO_EXTENSION), ['xls', 'xlsx'])){
            $thumb = get_theme_file_uri('/images/excel-thumb.png');
        }elseif(in_array(pathinfo($file_name, PATHINFO_EXTENSION), ['ppt', 'pptx'])){
            $thumb = get_theme_file_uri('/images/ppt-thumb.png');
        }elseif(in_array(pathinfo($file_name, PATHINFO_EXTENSION), ['doc', 'docx'])){
            $thumb = get_theme_file_uri('/images/word-thumb.png');
        }elseif(in_array(pathinfo($file_name, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg', 'gif', 'bmp'])){
            $thumb = null;
        }
        return $thumb;
    }

    function jaf_download_file(){

        if(isset($_GET['jfm_action']) && $_GET['jfm_action'] == 'dl' && isset($_REQUEST['pid'])){
            $pid = esc_html( $_REQUEST['pid'] );
            $file_data = $this->get_file_data($pid);

            $terms = wp_get_post_terms( $pid, $this->folder_taxonomy , ['fields' => 'ids']);

            if(!is_wp_error( $terms ) && !empty($terms)){
                $file_path =  $this->upload_path.'/' . $terms[0] . '/'.$file_data->name;
            }else{
                $file_path =  $this->upload_path.'/0/'.$file_data->name;
            }
            $downloads = get_post_meta( $pid, 'downloads', true );
            update_post_meta( $pid, 'downloads', ++$downloads );
            header('Content-Type: '.$file_data->type );
            header("Content-Transfer-Encoding: Binary" ); 
            header("Content-disposition: attachment; filename=\"" . sanitize_file_name( $file_data->title ) . "\"" ); 
            // readfile($file_url);
            readfile($file_path);

            exit;
        }

    }

    function get_file_data($pid){
        $file_data = [];

        $p = get_post($pid);

        if($p){
            $meta_1 = get_post_meta( $p->ID, 'file_upload_data', true );
            $meta_2 = get_post_meta( $p->ID, 'download_counter', true );
            $data = [];
            $data['url'] = $meta_1->url;
            $data['name'] = $meta_1->name;
            $data['thumbnail'] = $meta_1->thumbnailUrl;
            $data['type'] = $meta_1->type;
            $data['title'] = $p->post_title;
            $data['downloads'] = $meta_2 ? $meta_2 : 0;
            $file_data = (object) $data;
        }
        return $file_data;
    }

    function render_file_table_sc($atts = []){
        extract(shortcode_atts( [
            'type' => 'latest',
            'count' => '6',
        ], $atts ));

        $args = [
            'post_type' => $this->post_type,
            'posts_per_page' => $count,
            'post_status' => ['publish', 'private'],
        ];

        $css_class = [];

        $meta_query = [];
        if($type == 'top-download'){ 
            $args['orderby'] = 'meta_value';
            $args['meta_key'] = 'downloads';
            $args['meta_type'] = 'NUMERIC';
            $args['order'] = 'DESC';
            $css_class[] = 'most-downloaded';
        }else{
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
            $css_class[] = 'type-latest';
        }
        $args['meta_query'] = $meta_query;


        $output = '<div class="jaf-file-table-container '.implode(' ', $css_class).'" >';

        $loop = new WP_Query($args);
        if($loop->have_posts()){
            $output .= '<table class="table jaf-file-table">';
            $output .= '<tr><th>&nbsp;</th><th>File Name</th><th>Action</th></tr>';
            while ($loop->have_posts()) {
                $loop->the_post();
                $post_id = get_the_ID();
                $title = get_the_title();

                $file_upload_data = get_post_meta( $post_id, 'file_upload_data', true );
                $download_count = get_post_meta( $post_id, 'downloads', true );
                $thumb = $this->get_file_thumb($file_upload_data->name);
                if(!$thumb){
                  $thumb = $file_upload_data->thumbnailUrl;
                }
                $thumb_img = $thumb ? '<img src="'.$thumb.'" title="'.$title.'" alt="'.$title.'" >' : '';

                $preview_url = 'https://drive.google.com/viewerng/viewer?url='.$file_upload_data->url.'?pid=explorer&efh=false&a=v&chrome=false&embedded=true';

                if(in_array(pathinfo($file_upload_data->name, PATHINFO_EXTENSION), ['pdf', 'xlsx', 'xls', 'docx', 'doc', 'pptx', 'ppt'])){
                    $preview_link = '<a href="javascript:;" target="_blank" class="file-tool-link is-frame jaf-file-preview" data-fancybox data-type="iframe" data-src="'.$preview_url.'" >view</a>';
                }else{
                    $preview_link = '<a target="_blank" class="file-tool-link is-image jaf-file-preview" href="'.$file_upload_data->url.'" data-fancybox="images" >view</a>';
                }

                $download_markup = ($type == 'top-download') ? '<span class="download-count" title="Download Count" ><span class="download-count-label">'._n('download', 'downloads', $download_count).'</span>: '.$download_count.'</span>' : '';

                $dl_link = add_query_arg(['jfm_action' => 'dl', 'pid' => $post_id], site_url());
                $output .= '<tr>
                <td><span class="file-thumb" >'.$thumb_img.'</span></td>
                <td>'.$title.' '.$download_markup.'</td>
                <td>
                    '.$preview_link .'
                    <a href="'.$dl_link.'" target="_blank" class="file-tool-link" >download</a>
                </td>
                </tr>';
            }
            $output .= '</table>';
        }
        wp_reset_postdata();


        $output .= '</div>';
        $output .= '<script type="text/javascript">
            jQuery(function($){
                /*$(".jaf-file-preview").fancybox.open({
                    type : "iframe",
                    opts : {
                        afterShow : function( instance, current ) {
                            console.info( "Done");
                        }
                    }
                });*/
            });
        </script>';
        //$output .= '<iframe src="https://drive.google.com/viewerng/viewer?url=https://library.osu.edu/assets/Documents/SEL/QuickConvertWordPDF.pdf?pid=explorer&efh=false&a=v&chrome=false&embedded=true" width="400px" height="300px"  />';

        return $output;

    }

    function render_file_table_tab_sc($atts = []){
		extract(shortcode_atts( [
		    'count' => '6',
		], $atts ));

		$tabs = [
			'latest-files' => [
				'title' => 'Latest Files',
				'content' => '[jaf-file-table type="latest" count="'.$count.'" ]'
			],
			'top-download' => [
				'title' => 'Most Downloaded',
				'content' => '[jaf-file-table type="top-download" count="'.$count.'" ]'
			]
		];

		$out = '<div class="jaf-file-table-tabs-wrapper">';
		$out .= '<div role="tabpanel">';

		/*Tabs*/
		$tabs_list = '<ul class="nav nav-tabs" role="tablist">';
		foreach ($tabs as $k => $v) {
			$tab_id = 'jaf-file-tab-'.$k;
			$is_active = $k == 'latest-files' ? 'active' : '';
				$tabs_list .= '<li role="presentation" class="'.$is_active.'"><a href="#'.$tab_id.'" aria-controls="'.$tab_id.'" role="tab" data-toggle="tab">'.$v['title'].'</a></li>';
		}
		$tabs_list .= '</ul>';
		$out .= $tabs_list;

		$tabs_content = '<div class="tab-content">';
		foreach ($tabs as $k => $v) {
			$tab_id = 'jaf-file-tab-'.$k;
			$is_active = $k == 'latest-files' ? 'active' : '';
			$tabs_content .= '<div role="tabpanel" class="tab-pane '.$is_active.'" id="'.$tab_id.'">'.do_shortcode( $v['content'] ).'</div>';
		}
		$tabs_content .= '</div>';
		$out .= $tabs_content;

		$out .= '</div>';
		$out .= '</div>';

		return $out;

    }	
}

new JAF_WP_File_Manager();
