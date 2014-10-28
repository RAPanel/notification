<?php
/**
 * Created by PhpStorm.
 * User: Rugalev
 * Date: 27.10.2014
 * Time: 19:11
 */

class InvalidateNotification extends CAction {

	public $return;

	public function run($id = null) {
		$userId = Yii::app()->user->id;
		if($id === null)
			Notification::invalidateAll($userId);
		else {
			$notification = Notification::model()->findByAttributes(array('user_id' => $userId, 'id' => $id));
			if ($notification !== null)
				Notification::invalidate($id);
		}
		if(!isset($this->return))
			$this->return = array('/site/index');
		$this->controller->redirect($this->return);
	}

}