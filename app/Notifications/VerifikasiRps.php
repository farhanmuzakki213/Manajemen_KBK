<?php

namespace App\Notifications;

use App\Models\Pengurus_kbk;
use App\Models\RepRpsUas;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifikasiRps extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $dosen_matkul;
    protected $pengurusKbk;
    public function __construct(RepRpsUas $dosen_matkul, Pengurus_kbk $pengurusKbk)
    {
        $this->dosen_matkul = $dosen_matkul;
        $this->pengurusKbk = $pengurusKbk;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Verifikasi RPS telah berhasil dilakukan.',
            'pengurus_kbk' => $this->pengurusKbk->r_dosen->id_dosen,
            'dosen' => $this->dosen_matkul->dosen_id,
            'matkul' => $this->dosen_matkul->matkul_kbk_id,
        ];
    }
}
