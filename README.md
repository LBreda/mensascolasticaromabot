# MensaScolasticaRomaBot

Questo software è un bot Telegram per conoscere i menu delle mense scolastiche comunali a Roma.

Non è affiliato in nessun modo con il Comune di Roma, e potete utilizzarlo su [@MensaScolasticaRomaBot](https://t.me/MensaScolasticaRomaBot).

Se invece volete installarlo:

```bash
git clone https://github.com/LBreda/mensascolasticaromabot.git
cd mensascolasticaromabot
cp .env.example .env
composer install
php artisan key:generate
```

Modificate il file .env con i necessari parametri, e registrate il WebHook con:

```bash
php artisan msr:initialize
```

Enjoy!
