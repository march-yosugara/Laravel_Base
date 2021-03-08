<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword;

class PasswordResetMultiLang extends ResetPassword
{
  use Queueable;

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return ['mail'];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($notifiable)
  {
    if (static::$toMailCallback) {
      return call_user_func(static::$toMailCallback, $notifiable, $this->token);
    }
    if (static::$createUrlCallback) {
      $url = call_user_func(static::$createUrlCallback, $notifiable, $this->token);
    } else {
      $url = url(route('password.reset', [
        'token' => $this->token,
        'email' => $notifiable->getEmailForPasswordReset(),
      ], false));
    }

    $mailMessage = new MailMessage;
    $mailMessage->greeting = __('mail.password_reset.greeting');
    return $mailMessage
      ->subject(__('mail.password_reset.subject'))
      ->line(__('mail.password_reset.line1'))
      ->action(__('mail.password_reset.action'), $url)
      ->line(__('mail.password_reset.line2', ['count' => config('auth.passwords.users.expire')]))
      ->line(__('mail.password_reset.line3'));
  }

  /**
   * Get the array representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function toArray($notifiable)
  {
    return [
      //
    ];
  }
}
