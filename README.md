# FCM

This package allows laravel projects use Firebase cloud messaging service. You can use it as a notification channel. For example
in your notification:

```
class CommentRepliedNotification extends Notification
{
  public function via()
  {
      return [\Plus\Fcm\FcmChannel::class];
  }

  public function toFcm($notifiable)
  {
      return [
          'priority' => 'normal',

          'notification' => [
              'content_available' => true,
              'title' => 'Your comment was replied.',
              'subtitle' => 'Thank you',
              'body' => 'Thank you for your comment.',
              'badge' => 1,
              'sound' => 'default',
          ]
      ];
  }
}
```

Notify it to the user.

```
$parentComment->user->notify(new CommentRepliedNotification);
```

Define fcm notification route to your user or notifiable model.

```
class User extends Model
{
    public function routeNotificationForFcm()
    {
        return [
          'DEVICE_FCM_ID_OF_USER_1',
          'DEVICE_FCM_ID_OF_USER_2',
        ];
    }
}
```
