<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Fideloper\Proxy\TrustProxies as Middleware; // pour Laravel 8
// Si tu es sur Laravel 9+ :
// use Illuminate\Http\Middleware\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    /**
     * Les proxies de confiance.
     *
     * Si ton app est derrière un load balancer, un proxy Nginx, ou Cloudflare,
     * tu peux mettre '*' pour faire confiance à tous les proxys intermédiaires.
     *
     * @var array|string|null
     */
    protected $proxies = '*';

    /**
     * Les en-têtes utilisés pour détecter l’adresse IP du client réel.
     *
     * Cette configuration permet de gérer la plupart des hébergeurs (Kamatera, Cloudflare, etc.)
     * et assure que $request->ip() retourne l’IP publique correcte.
     *
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;
}
