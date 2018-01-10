<?php
class Company_Calendar {
	public $calendar_id = '';

	function __construct(){
		$this->ajaxurl = admin_url('admin-ajax.php');
		add_shortcode('company-calendar', [$this, 'render_sc']);
		add_shortcode('calendar-upcoming-events', [$this, 'render_upcoming_events_sc']);
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
						/*$.colorbox({
							href: "'.$this->ajaxurl.'",
							data: {action: "load_event_popup_data", id: event.id},
							maxWidth: "800px"
						});*/


						/*$.fancybox({
					        width: 400,
					        height: 400,
					        autoSize: false,
					        href: "'.$this->ajaxurl.'?action=load_event_popup_data&id=" + event.id,
					        type: "ajax"
					    });*/

						$.fancybox.open({
						    src: "'.$this->ajaxurl.'?action=load_event_popup_data&id=" + event.id,
						    type: "ajax",
						    opts: {},
						    width: 400,
						    ajax : {
						        settings : {
						            data : {
						                action : "load_event_popup_data",
						                id: event.id
						            }
						        }
					    	},
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

				$action_type =  get_field('calendar_action_type') ?  get_field('calendar_action_type') : 'single-page';

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
				echo '<div class="modal-container container calendar-event-modal-container">
					  <div class="modal-title"><h4>'.get_the_title().'<h4></div>
					  <div class="modal-body">';

				if(has_post_thumbnail()){
					echo '<div class="cal-modal-thumb" >';
					the_post_thumbnail();
					echo '</div>';
				}
				
				echo '<div class="cal-modal-excerpt" >';
				the_excerpt();
				echo '</div>';

				echo '</div>
					  <div class="modal-footer"><a href="javascript:;" class="btn btn-primary" data-fancybox-close="">Close</a></div>
					<button data-fancybox-close="" class="fancybox-close-small" title="Close"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35 35"><path d="M12,12 L23,23 M23,12 L12,23"></path></svg></button></div>';
			}
		}

		wp_reset_postdata();
		exit;
	}

	function render_upcoming_events_sc($atts = []){
		extract(shortcode_atts( [
			'count' => 6
		], $atts ));


		$args = [
			'post_type' => 'calendar_events',
			'post_status' => 'publish',
			'posts_per_page' => $count,
			'orderby' => 'meta_value',
			'meta_key' => 'start_date',
			'meta_type' => 'DATETIME',
			/*'meta_query' => [
				[
					'key' => 'start_date',
					'value' => date('Y-m-d'),
					'compare' => '>',
					'type' => 'DATETIME'
				]
			],*/
		];

		$html = '';
		$posts = get_posts($args);
		if($posts){
			$html .= '<div class="calendar-upcoming-events" >';
			$html .= '<table class="table" >';
			foreach ($posts as $k => $v) {

				$is_all_day = get_field('is_all_day', $v->ID);
				$venue = get_field('venue', $v->ID);

				if($is_all_day){
					$start = date( 'Y-m-d', strtotime(get_field('start_date', $v->ID)) );
					$sMonth = date( 'M', strtotime(get_field('start_date', $v->ID)) );
					$sDay = date( 'd', strtotime(get_field('start_date', $v->ID)) );
					$end = date( 'Y-m-d', strtotime(get_field('end_date', $v->ID)) );
					$sTime = '';
					$eTime = '';
				}else{
					$start = date( 'Y-m-d H:i', strtotime(get_field('start_date', $v->ID)) );

					$sMonth = date( 'M', strtotime(get_field('start_date', $v->ID)) );
					$sDay = date( 'd', strtotime(get_field('start_date', $v->ID)) );
					$end = date( 'Y-m-d H:i', strtotime(get_field('end_date', $v->ID)) );
				}

				$complete_date_text = ($start == $end) ? $start : $start.' - '.$end;

				$venue_text = $venue ? '<span class="event-venue">'.$venue.'</span>' : '';

				$html .= '<tr>
					<td class="event-title-col" >
						<div class="event-title" >
							<a href="'.get_permalink( $v->ID ).'" ><span class="title">'.$v->post_title.'</span></a>
							<span class="complete-date">'.$complete_date_text.'</span>
							'.$venue_text.'
						</div>
					</td>
					<td class="date-start-col" >
						<div class="date-start" >
							<span class="month">'.$sMonth.'</span>
							<span class="day">'.$sDay.'</span>
						</div>
					</td>
					</tr>';
				}

				$html .= '</table>';
				$html .= '</div>';
		}
		return $html;

	}
}

new Company_Calendar;
