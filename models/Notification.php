<?php

/**
 * Created by PhpStorm.
 * User: Rugalev
 * Date: 27.10.2014
 * Time: 17:55
 */
class Notification extends RActiveRecord
{

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'notification';
	}

	public function all($userId) {
		$criteria = $this->dbCriteria;
		$t = $this->getTableAlias(false, false);
		$criteria->compare("{$t}.user_id", $userId);
		$criteria->compare("{$t}.valid", 1);
		$criteria->order = "{$t}.id ASC";
		return $this;
	}

	public static function add($type, $text, $userId) {
		Yii::app()->db->commandBuilder->createInsertCommand('notification', array('text' => $text, 'type' => $type, 'user_id' => $userId, 'valid' => 1))->execute();
	}

	public static function replace($type, $text, $userId) {
		$notification = Notification::model()->findByAttributes(array('user_id' => $userId, 'type' => $type, 'valid' => 1));
		if($notification !== null) {
			$notification->text = $text;
			$notification->created = time();
			$notification->save(false);
		} else
			self::add($type, $text, $userId);
	}

	public static function invalidate($flashId) {
		if(is_array($flashId)) {
			if(count($flashId)) {
				$ids = implode(',', $flashId);
				Notification::model()->updateAll(array('valid' => 0), "id IN ({$ids})");
			}
		}
		else
			Notification::model()->updateAll(array('valid' => 0), "id = :id", array(':id' => $flashId));
	}

	public static function invalidateAll($userId) {
		Notification::model()->updateAll(array('valid' => 0), "user_id = :userId", array(':id' => $userId));
	}

}