<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PenugasanDosen extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $proposal_ta;
    protected $pengurus_kbk;
    protected $id_penugasan;
    public function __construct($proposal_ta, $pengurus_kbk, $id_penugasan)
    {
        $this->proposal_ta = $proposal_ta;
        $this->pengurus_kbk = $pengurus_kbk;
        $this->id_penugasan = $id_penugasan;
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
            'pengurus_kbk' => $this->pengurus_kbk->r_dosen->nama_dosen,
            'nama_mahasiswa' => $this->proposal_ta->r_mahasiswa->nama,
            'nim_mahasiswa' => $this->proposal_ta->r_mahasiswa->nim,
            'id_penugasan' => $this->id_penugasan,
            'pesan' => "Anda Mendapatkan Penugasan Review",
            'url' => route('dosen_kbk_notifikasi.show', ['id_penugasan' => $this->id_penugasan]),
        ];
    }
}
