<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * Nilai dibaca dari environment variable TRUSTED_PROXIES.
     * - Kosong / tidak diset → null → tidak ada proxy yang dipercaya (aman untuk local & direct connection).
     * - Di production dengan reverse proxy/load balancer, set TRUSTED_PROXIES ke CIDR atau IP spesifik.
     *   Contoh: TRUSTED_PROXIES="10.0.0.0/8" atau TRUSTED_PROXIES="203.0.113.10,203.0.113.11"
     * - JANGAN gunakan '*' di production; itu memperbolehkan siapapun memalsukan X-Forwarded-For.
     *
     * @var array<int, string>|string|null
     */
    protected $proxies;

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;

    /**
     * Inisialisasi $proxies dari environment variable saat runtime.
     * Nilai kosong atau tidak diset menghasilkan null (tidak ada proxy dipercaya).
     * Nilai berisi koma diurai menjadi array IP/CIDR.
     */
    public function __construct()
    {
        $raw = env('TRUSTED_PROXIES', '');

        if (blank($raw)) {
            $this->proxies = null;
        } else {
            // Dukung nilai tunggal maupun daftar dipisah koma
            $parsed = array_values(array_filter(array_map('trim', explode(',', $raw))));
            $this->proxies = count($parsed) === 1 ? $parsed[0] : $parsed;
        }
    }
}
