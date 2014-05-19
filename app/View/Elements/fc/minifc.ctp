<?php

	// MINI FC
	// 
?>
<div style="padding-top: 8px;">
<div class="btn-group">
	<button type="button" class="btn btn-default btn-sm btn-success" onclick="location.href='<?php echo $this->webroot; ?>events/add';">Create</button>
	<button type="button" class="btn btn-default btn-sm btn-success" id="quickadd"
			data-container="body" data-toggle="popover" data-placement="bottom"><span class="caret"></span><span class="sr-only">Quick Add</span></button>
</div>
</div>
<hr>
<div id="minical">
	<a data-toggle="collapse" data-parent="#minical" href="#minifc" id="current-view-mini"></a>
	<div class="fc collapse in" id="minifc"></div>
	<?php
	
		// display calendar list
		// -------------------------------
		echo $this->element('fc/calendars');
	?>
</div>
