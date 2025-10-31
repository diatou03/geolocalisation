<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\Facades\MQTT;

class LoRaStream extends Command
{
    protected $signature = 'lorastream:listen';
    protected $description = 'Écoute en continu les messages MQTT provenant de LoRa32';

    public function handle()
    {
        $this->info('Connexion au broker MQTT…');

        $mqtt = MQTT::connection(); // Utilise la config 'default_connection'
        
        $mqtt->subscribe('lorastream/#', function ($topic, $message) {
            $this->info("Reçu [$topic]: $message");
            // Traitement : sauvegarde, dispatch d’événement, etc.
        }, 0);

        $this->info('Abonné au topic lorastream/#, en écoute…');

        // Démarrer la boucle MQTT - bloquante
        $mqtt->loop(true);
    }
}
