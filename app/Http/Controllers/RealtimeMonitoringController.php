<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RealtimeMonitoringController extends Controller
{
    public function stream(Request $request): StreamedResponse
    {
        session()->save();

        $fp    = $request->cookie('device_fp');
        $email = $request->query('user');

        $response = new StreamedResponse(function () use ($fp, $email) {
            set_time_limit(0);

            while (ob_get_level() > 0) {
                ob_end_flush();
            }

            // Kirim event connected
            echo "data: " . json_encode([
                'type'      => 'connected',
                'timestamp' => time(),
            ]) . "\n\n";
            flush();

            $start = time();

            while (time() - $start < 300) {

                if (connection_aborted()) break;

                $changed = $this->isFingerprintChanged($fp, $email);

                if ($changed !== null) {
                    echo "data: " . json_encode([
                        'type'      => 'fingerprint_changed',
                        'timestamp' => time(),
                        'changes'   => [
                            'updated_attendances' => [$changed],
                        ],
                    ]) . "\n\n";
                } else {
                    echo ": ping\n\n";
                }

                flush();
                sleep(2);
            }

            echo "event: close\ndata: reconnect\n\n";
            flush();
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');
        $response->headers->set('X-Accel-Buffering', 'no');

        return $response;
    }

    private function isFingerprintChanged(?string $fp, ?string $email): ?array
    {
        if (!$email || !$fp) return null;

        $user = User::where('email', $email)
            ->where('fingerprint_device', '!=', $fp)
            ->first(['email', 'fingerprint_device']);

        return $user ? $user->toArray() : null;
    }
}