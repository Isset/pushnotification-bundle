# IssetBVPushNotificationBundle
Bundle for sending push notifications to apple/android/windows

## Install:
### Composer:
````bash
composer require issetbv/pushnotificationbundle
````
### config
To send messages add connections to the isset_bv_push_notification config
````yaml
isset_bv_push_notification:
    #connection_handler: //overwrite the connection handler for all notifiers which don't have there own connection handler set
    apple:
        #connection_handler: connection handler for this notifier
        connections:
            live:
                key_location: <path_to_key>
                key_password_phrase: <password_phrase>
                default: true
    android:
        connections:
            live:
                api_key: <api-key>
                default: true
    windows:
        connections:
            live:
                default: true
            live_other:
                default: true
````
### parameters
Default logger is the @logger to change the logger set the isset_bv_push_notification.center.logger.service to a different logger service
````yaml
isset_bv_push_notification.center.logger.service: logger
````
## Code samples
### Example apple message
````php
<?php
$deviceToken = ''; //devicetoken
$center = $this->get('isset_bv_push_notification.center');
$message = new AppleMessageAps($deviceToken);
$message->getAps()->setAlert('Test apple');
$envelope = $center->queue($message);
$center->flushQueue();
echo $envelope->getState();
````
### Example android message
````php
<?php
$deviceToken = ''; //devicetoken
$center = $this->get('isset_bv_push_notification.center');
$message = new AndroidMessage($deviceToken);
$message->addToPayload('notification', ['title' => 'Test android']);
$envelope = $center->queue($message);
$center->flushQueue();
echo $envelope->getState();
````
### Example windows message
````php
<?php
$center = $this->get('isset_bv_push_notification.center');
$message = new WindowsMessage('https://cloud.notify.windows.com/?token=AQE%bU%2fSjZOCvRjjpILow%3d%3d');
$message->addToPayload('wp:Text1', 'Test windows');
$envelope = $center->queue($message);
$center->flushQueue();
echo $envelope->getState();
````
### Example sending message over other connection then the default one
````php
<?php
$center = $this->get('isset_bv_push_notification.center');
$message = new WindowsMessage('https://cloud.notify.windows.com/?token=AQE%bU%2fSjZOCvRjjpILow%3d%3d');
$message->addToPayload('wp:Text1', 'Test windows');
$envelope = $center->queue($message, 'live_other');
$center->flushQueue(); 
// if you only want to flush the live_other queue
// $center->flushQueue('live_other'); 
echo $envelope->getState();
````