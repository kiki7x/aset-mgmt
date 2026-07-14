<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ConfigController extends Controller
{
    public function index(): View
    {
        // Fonnte
        $fonnteToken = DB::table('config')->where('name', 'fonnte_token')->value('value') ?? config('fonnte.token');
        $fonnteSender = DB::table('config')->where('name', 'fonnte_sender')->value('value') ?? config('fonnte.sender');
        $fonnteGroupId = DB::table('config')->where('name', 'fonnte_group_id')->value('value') ?? config('fonnte.group_id');

        // SMTP Email
        $mailHost = DB::table('config')->where('name', 'mail_host')->value('value') ?? config('mail.mailers.smtp.host');
        $mailPort = DB::table('config')->where('name', 'mail_port')->value('value') ?? config('mail.mailers.smtp.port');
        $mailUsername = DB::table('config')->where('name', 'mail_username')->value('value') ?? config('mail.mailers.smtp.username');
        $mailPassword = DB::table('config')->where('name', 'mail_password')->value('value') ?? config('mail.mailers.smtp.password');
        $mailEncryption = DB::table('config')->where('name', 'mail_encryption')->value('value') ?? config('mail.mailers.smtp.encryption');
        $mailFromAddress = DB::table('config')->where('name', 'mail_from_address')->value('value') ?? config('mail.from.address');
        $mailFromName = DB::table('config')->where('name', 'mail_from_name')->value('value') ?? config('mail.from.name');

        // Monitoring
        $monitorRetentionDays = DB::table('config')->where('name', 'monitor_retention_days')->value('value') ?? config('monitoring.retention_days');
        $monitorDefaultInterval = DB::table('config')->where('name', 'monitor_default_interval')->value('value') ?? config('monitoring.default_interval');

        return view('admin.settings.config.index', compact(
            'fonnteToken',
            'fonnteSender',
            'fonnteGroupId',
            'mailHost',
            'mailPort',
            'mailUsername',
            'mailPassword',
            'mailEncryption',
            'mailFromAddress',
            'mailFromName',
            'monitorRetentionDays',
            'monitorDefaultInterval'
        ));
    }

    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'fonnte_token' => 'nullable|string',
            'fonnte_sender' => 'nullable|string',
            'fonnte_group_id' => 'nullable|string',
            'mail_host' => 'nullable|string',
            'mail_port' => 'nullable|string',
            'mail_username' => 'nullable|string',
            'mail_password' => 'nullable|string',
            'mail_encryption' => 'nullable|in:tls,ssl,null',
            'mail_from_address' => 'nullable|email',
            'mail_from_name' => 'nullable|string',
            'monitor_retention_days' => 'nullable|integer|min:1',
            'monitor_default_interval' => 'nullable|integer|min:1',
        ]);

        $fields = [
            'fonnte_token',
            'fonnte_sender',
            'fonnte_group_id',
            'mail_host',
            'mail_port',
            'mail_username',
            'mail_password',
            'mail_encryption',
            'mail_from_address',
            'mail_from_name',
            'monitor_retention_days',
            'monitor_default_interval',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                DB::table('config')->updateOrInsert(
                    ['name' => $field],
                    ['value' => (string) $request->input($field), 'updated_at' => now()]
                );
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Konfigurasi berhasil disimpan.',
        ]);
    }
}
