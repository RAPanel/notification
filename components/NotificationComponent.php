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

	public function getAll($refresh = false) {
		if(!isset($this->_notifications) || $refresh)
			$this->_notifications = $this->fetchNotifications();
		return $this->_notifications;
	}

	protected function fetchNotifications() {
		return $this->getScopedModel()->findAll();
	}

	protected function getScopedModel() {
		return Notification::model()->all($this->getUserId());
	}

	protected function getUserId() {
		return Yii::app()->user->getId();
	}

	public function getDataProvider($config = array()) {
		return new CActiveDataProvider($this->getScopedModel(), $config);
	}

	public function set($type, $text, $params = array(), $userId = null) {
		Notification::add($type, Yii::t($this->messagesCategory, $text, $params), $userId === null ? $this->getUserId() : $userId);
	}

	public function replace($type, $text, $params = array(), $userId = null) {
		Notification::replace($type, Yii::t($this->messagesCategory, $text, $params), $userId === null ? $this->getUserId() : $userId);
	}
}