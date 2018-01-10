<?php
class Company_Calendar {
	public $calendar_id = '';

	function __construct(){
		$this->ajaxurl = admin_url('admin-ajax.php');
		add_shortcode('company-calendar', [$this, 'render_sc']);
		add_action('wp_ajax_load_calendar_events', [$this, 'ajax_load_events']);
		add_action('wp_ajax_nopriv_load_calendar_events', [$this, 'ajax_load_events']);
		add_action('wp_ajax_load_event_popup_data', [$this, 'ajax_load_event_popup_data']);
		add_action('wp_ajax_nopriv_load_event_popup_data', [$this, 'ajax_load_event_popup_data']);
	}

	function render_sc($atts = []){
		extract(shortcode_atts([], $atts));

		$rid = rand();
		$this->calendar_id = 'company-calendar-'.$rid;

		$markup = '';

		$markup .= '<div id="'.$this->calendar_id.'" class="company-calendar" ></div>';
		$markup .= $this->inline_scripts();

		return $markup;
	}

	function inline_scripts(){
		$events = $this->get_events();
		$event_json = json_encode($events);
		$s = '<script type="text/javascript">
		jQuery(function($){
			$("#'.$this->calendar_id.'").fullCalendar({
				events: {
					url: "'.$this->ajaxurl.'",
					type: "POST",
					data: {
						action: "load_calendar_events",
					},
					error: function() {
						alert("there was an error while fetching events!");
					},
				},
				defaultView: "month",
				header: { 
					left:   "title",
					center: "",
					right:  "today month,agendaWeek,agendaDay prevYear,prev,next,nextYear",
				},
				buttonIcons :{
					prev: "left-single-arrow",
					next: "right-single-arrow",
					prevYear: "left-double-arrow",
					nextYear: "right-double-arrow"
				},
				eventClick: function(event, jsEvent, view){
					console.log(event);
					if(event.action_type == "lightbox" ){
						$.colorbox({
							href: "'.$this->ajaxurl.'",
							data: {action: "load_event_popup_data", id: event.id},
							maxWidth: "800px"
						});
					}
				},
			});

		});
		</script>';

		return $s;
	}

	function get_events(){
		$all_posts = [];

		$args = [
			'post_type' => 'calendar_events',
			'post_status' => 'publish',
			'posts_per_page' => -1,
		];

		$loop = new WP_Query($args);
		if($loop->have_posts()){
			while ($loop->have_posts()) {
				$loop->the_post();
				$is_all_day = get_field('is_all_day');

				if($is_all_day){
					$start = date( 'Y-m-d', strtotime(get_field('start_date')) );
					$end = date( 'Y-m-d', strtotime(get_field('end_date')) );
				}else{
					$start = date( 'Y-m-d\TH:i', strtotime(get_field('start_date')) );
					$end = date( 'Y-m-d\TH:i', strtotime(get_field('end_date')) );
				}

				$action_type =  get_field('calendar_action_type') ?  get_field('calendar_action_type') : 'none';

				$data['id'] = get_the_ID();
				$data['title'] = get_the_title();
				$data['allDay'] = $is_all_day;
				$data['start'] = $start;
				$data['end'] = $end;
				$data['url'] = sanitize_title($action_type) == 'single-page' ? get_the_permalink() : null;
				$data['action_type'] = sanitize_title($action_type);
				$data['className'] = 'company-event-entry';
				$data['borderColor'] = 'GREEN';
				$data['backgroundColor'] = 'GREEN';
				$data['textColor'] = '#FFF';

				$all_posts[] = $data;
			}
		}

		wp_reset_postdata();

		return $all_posts;
	}

	function ajax_load_events(){
		$events = $this->get_events();
		$event_json = json_encode($events);
		echo $event_json;
		exit;
	}

	function ajax_load_event_popup_data(){

		$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : false;

		if(!$id){
			echo 'Sorry, No Content Available.';
			exit;
		}

		$args = [
			'p' => $id,
			'post_type' => 'calendar_events',
			'post_status' => 'publish',
			'posts_per_page' => 1,
		];

		$loop = new WP_Query($args);
		if($loop->have_posts()){
			while ($loop->have_posts()) {
				$loop->the_post();
				echo '<h4>'.get_the_title().'<h4>';

				if(has_post_thumbnail()){
					echo '<div class="cal-modal-thumb" >';
					the_post_thumbnail();
					echo '</div>';
				}
				
				echo '<div class="cal-modal-excerpt" >';
				the_excerpt();
				echo '</div>';
			}
		}

		wp_reset_postdata();
		exit;
	}
}

new Company_Calendar;
