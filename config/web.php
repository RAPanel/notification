<?php
return array(
	'import' => array(
		'notification.models.Notification',
		'notification.components.NotificationComponent',
		'notification.actions.InvalidateNotification',
	),
	'components' => array(
		'notification' => array(
			'class' => 'NotificationComponent',
		),
	),
);