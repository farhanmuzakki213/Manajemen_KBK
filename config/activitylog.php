<?php

return [

    /*
     * Jika diatur ke false, tidak ada aktivitas yang akan disimpan ke database.
     */
    'enabled' => env('ACTIVITY_LOGGER_ENABLED', true),

    /*
     * Ketika perintah clean dijalankan, semua aktivitas yang terekam lebih dari
     * jumlah hari yang ditentukan di sini akan dihapus.
     */
    'delete_records_older_than_days' => 365,

    /*
     * Jika tidak ada nama log yang diberikan ke helper activity()
     * kami menggunakan nama log default ini.
     */
    'default_log_name' => 'activity',

    /*
     * Anda dapat menentukan auth driver di sini yang mendapatkan model user.
     * Jika null, kami akan menggunakan auth driver Laravel saat ini.
     */
    'default_auth_driver' => null,

    /*
     * Jika diatur ke true, subjek mengembalikan model yang dihapus secara soft.
     */
    'subject_returns_soft_deleted_models' => false,

    /*
     * Model ini akan digunakan untuk mencatat aktivitas.
     * Ini harus mengimplementasikan interface Spatie\Activitylog\Contracts\Activity
     * dan memperluas Illuminate\Database\Eloquent\Model.
     */
    'activity_model' => \Spatie\Activitylog\Models\Activity::class,

    /*
     * Ini adalah nama tabel yang akan dibuat oleh migrasi dan
     * digunakan oleh model Activity yang dikirimkan dengan paket ini.
     */
    'table_name' => 'activity_log',

    /*
     * Ini adalah koneksi database yang akan digunakan oleh migrasi dan
     * model Activity yang dikirimkan dengan paket ini. Jika tidak disetel
     * koneksi database default Laravel akan digunakan.
     */
    'database_connection' => env('ACTIVITY_LOGGER_DB_CONNECTION'),

    /*
     * Log semua event secara otomatis.
     */
    'log_all_events' => true,

    /*
     * Gunakan log hanya untuk perubahan nilai yang berbeda.
     */
    'log_only_dirty' => true,

    /*
     * Log event secara otomatis.
     */
    'auto_log_events' => true,

    /*
     * Log event secara otomatis untuk semua model.
     */
    'log_events' => ['created', 'updated', 'deleted'],

    /*
     * Maksimal aktivitas yang disimpan untuk model.
     */
    'max_log_activities' => 0,

    /*
     * Buat log activity default.
     */
    'default_log' => [
        'log_name' => 'activity',
        'description' => 'Description',
        'properties' => [],
    ],
];
