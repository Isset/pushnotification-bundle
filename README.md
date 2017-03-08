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
                key_location: path_to_key
                key_password_phrase: password_phrase
                default: true
    android:
        connections:
            live:
                api_key: 'AIzaSyCb2huVrZ-pwGBZrSdMNitA6r6fHOMTOrs'
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
$center = $this->get('isset_bv_push_notification.center');
$message = new AppleMessageAps('d2ef514a2f7e45b0aff20897fae011bda0b52ca8c6e0dd5b0f1e78705331155c');
$message->getAps()->setAlert('Test apple');
$envelope = $center->queue($message);
$center->flushQueue();
echo $envelope->getState();
````
### Example android message
````php
<?php
$center = $this->get('isset_bv_push_notification.center');
$message = new AndroidMessage('d9b55sAPIb0:APA91bFVl03GMhOKXCLyJ3i1PR3BMW7QGOC579DV6W-89fBHj5-w3k_RoTmxCeDtIBIeV7aOKt3xwHH8zbGvSnLEEd6ymb-fupy-ZFVJ89804aBxEyvoMee0BSVGom9pIgfUVMeVeBVh');
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