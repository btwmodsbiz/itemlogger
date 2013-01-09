<?php

class Controller extends CController {
	public $layout='/layouts/default';

	public function renderJSON($data) {
		$this->renderPartial('/json', array('data' => $data));
	}
}
