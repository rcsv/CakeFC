<?php

  // calendarlist.ctp
  // ----------------------------------
?>
<div id="mycal">
	<a data-toggle="collapse" data-parent="#mycal" href="#callist" id="my-calendar-list">My calendars</a>
	<div class="collapse in" id="callist">
		<?php foreach ( $calendars as $calendar ) { ?>
		<div><a href="#">
			<span class="glyphicon glyphicon-<?php
				if( $calendar['Calendar']['public'] ) {
					echo 'signal' ;
				} else {
					echo 'lock';
				}
			?>" style="color:<?php 
				echo $calendar['Calendar']['color'] ;
			?>"></span> - 
			<?php echo $calendar['Calendar']['title'] ; ?>
		</a></div>
		<?php } ?>
	</div>
</div>
