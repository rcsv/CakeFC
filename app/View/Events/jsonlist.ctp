<?php

	// jsonlist.ctp
	// return JSON style data
	// --------------------------------------------
	
	if(empty($events)) {
		return;
	}
	
	$rows = array() ;
	
	foreach ($events as $d) {
		$rows[] = array(
			'id' 			=> $d['Event']['id'],
			'title' 		=> $d['Event']['title'],
			'calendar_id'	=> $d['Event']['calendar_id'],
			'start'			=> !empty($d['Event']['start']) ? date('Y-m-d H:i', strtotime($d['Event']['start'])) : '',
			'end'			=> !empty($d['Event']['end']  ) ? date('Y-m-d H:i', strtotime($d['Event']['end']  )) : '',
			'allDay'		=> $d['Event']['allday'],
			'place'			=> $d['Event']['place'],
			'description'	=> $d['Event']['description'],
			'editable'		=> 'true',
			'startEditable'	=> 'true',
			'durationEditable'	=> 'true',
			'calendar'		=> $d['Calendar']['title'],
			'color'			=> $d['Calendar']['color']);
	}
	
	header('Content-Type: Application/json');
	echo json_encode($rows);
	
