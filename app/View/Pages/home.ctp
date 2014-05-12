<?php
if(!Configure::read('debug')) {
	throw new NotFoundException();
}

App::uses('Debugger', 'Utility');
