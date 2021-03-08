<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail;

class VerifyEmailMultiLang extends VerifyEmail
{
  use Queueable;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

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
    $verificationUrl = $this->verificationUrl($notifiable);
    if (static::$toMailCallback) {
      return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
    }
    $mailMessage = new MailMessage;
    $mailMessage->greeting = __('mail.verify_email.greeting');
    return $mailMessage
      ->subject(__('mail.verify_email.subject'))
      ->line(__('mail.verify_email.line1'))
      ->action(__('mail.verify_email.action'), $verificationUrl)
      ->line(__('mail.verify_email.line2'));
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
