<?php
  // fc/header.ctp
  // -------------------------------------------
?>
<div class="row" style="border-bottom: 1px solid #f0f0f0; margin-bottom: 8px;">
<div class="fixedleft-185">
    <h4 style="padding: 3px 0 0 0;font-family:Segoe UI,Meiryo UI,sans-serif" id="current-view"></h4>
</div>
<div class="fixedleft-185-remain">
	<div style="padding:8px 0;">
		<button type="button" id="wfc-btn-today" class="btn btn-default btn-sm">today</button>
		<div class="btn-group">
			<button type="button" id="wfc-btn-prev" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-chevron-left"></i></button>
			<button type="button" id="wfc-btn-next" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-chevron-right"></i></button>
		</div>
		<span id="current-view" style="padding-left: 13px;"></span>
		<div style="float:right;">
			<div class="btn-group">
				<button type="button" id="wfc-btn-day" class="btn btn-default btn-sm">Day</button>
				<button type="button" id="wfc-btn-week" class="btn btn-default btn-sm">Week</button>
				<button type="button" id="wfc-btn-month" class="btn btn-default btn-sm">Month</button>
			</div>
			<button type="button" id="wfc-btn-more" class="btn btn-default btn-sm"> more </button>
			<button type="button" id="wfc-btn-config" class="btn btn-default btn-sm"> <i class="glyphicon glyphicon-cog"></i> </button>
		</div>
	</div>
</div>
</div><!-- end row, end fc/header element -->
