<?php

class Controller extends CController {
	public $layout='/layouts/blank';

	public function renderJSON($data) {
		$this->renderPartial('/json', array('data' => $data));
	}
}
