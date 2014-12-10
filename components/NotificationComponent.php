<?php
/**
 * Created by PhpStorm.
 * User: Rugalev
 * Date: 28.10.2014
 * Time: 11:31
 */

class NotificationComponent extends CApplicationComponent {

	private $_notifications;
	public $messagesCategory = 'notification';

	public function getAll($refresh = false, $userId = null) {
		if($userId === null)
			$userId = Yii::app()->user->id;
		if(!isset($this->_notifications[$userId]) || $refresh)
			$this->_notifications[$userId] = $this->fetchNotifications($userId);
		return $this->_notifications[$userId];
	}

	public function fetchNotifications($userId) {
		return $this->getScopedModel($userId)->findAll();
	}

	protected function getScopedModel($userId) {
		return Notification::model()->all($userId === null ? Yii::app()->user->id : $userId);
	}

	public function getDataProvider($config = array(), $userId = null) {
		return new CActiveDataProvider($this->getScopedModel($userId), $config);
	}

	public function set($type, $text, $params = array(), $userId = null) {
		Notification::add($type, Yii::t($this->messagesCategory, $text, $params), $userId === null ? Yii::app()->user->id : $userId);
	}

	public function replace($type, $text, $params = array(), $userId = null) {
		Notification::replace($type, Yii::t($this->messagesCategory, $text, $params), $userId === null ? Yii::app()->user->id : $userId);
	}
}