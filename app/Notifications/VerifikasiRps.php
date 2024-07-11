<?php

namespace App\Notifications;

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
    protected $repRpsUas;
    protected $verRpsUas;
    public function __construct($repRpsUas, $verRpsUas)
    {
        $this->repRpsUas = $repRpsUas;
        $this->verRpsUas = $verRpsUas;
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
        $rekomendasi = $this->verRpsUas->rekomendasi;
        $message = 'Verifikasi RPS telah berhasil dilakukan.';

        if ($rekomendasi == 1) {
            $message .= ' dan RPS Tidak Layak Pakai.';
        } elseif ($rekomendasi == 2) {
            $message .= ' dan RPS Butuh beberapa revisi.';
        } elseif ($rekomendasi == 3) {
            $message .= ' dan layak dipakai.';
        }
        return [
            'pengurus_kbk' => $this->verRpsUas->r_pengurus->r_dosen->nama_dosen,
            'tanggal_ver' => $this->verRpsUas->tanggal_verifikasi,
            'dosen' => $this->repRpsUas->dosen_id,
            'matkul' => $this->repRpsUas->r_matkulKbk->r_matkul->kode_matkul,
            'rekomendasi' => $message,
            'saran' => $this->verRpsUas->saran,
            'id_ver_rps_uas' => $this->verRpsUas->id_ver_rps_uas,
            'url' => route('notifikasi.show', [
                'dosen_matkul_id' => $this->repRpsUas->dosen_matkul_id,
                'matkul_kbk_id' => $this->repRpsUas->matkul_kbk_id
            ]),
        ];
    }
}
