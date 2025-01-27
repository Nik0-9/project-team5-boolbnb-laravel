# Boolbnb - Laravel Project

Boolbnb è un progetto sviluppato con Laravel 10 che replica le funzionalità principali di una piattaforma simile a Airbnb. Questo progetto è stato realizzato in un team di quattro persone, con particolare attenzione alla gestione degli annunci di appartamenti, sponsorizzazioni e comunicazione tra utenti.

## Descrizione del Progetto

Boolbnb consente di:

- Gestire gli annunci di appartamenti, includendo dettagli come indirizzo, descrizione, immagine di copertina, numero di stanze, bagni e letti.
- Aggiungere servizi specifici agli appartamenti (es. Wi-Fi, parcheggio, piscina).
- Sponsorizzare gli annunci tramite il servizio di pagamento **Braintree**.
- Gestire i messaggi degli utenti interessati a un appartamento.
- Monitorare le visualizzazioni degli annunci.

## Requisiti

- **PHP**: >= 8.1
- **Composer**
- **Laravel**: 10.x
- Database relazionale (MySQL o equivalente)

## Installazione

1. Clonare la repository:

   ```bash
   git clone https://github.com/Nik0-9/project-team5-boolbnb-laravel.git
   ```

2. Entrare nella directory del progetto e installare le dipendenze:

   ```bash
   cd project-team5-boolbnb-laravel
   composer install
   ```

3. Copiare il file .env.example e rinominarlo in .env, quindi configurare le variabili d'ambiente, come le credenziali del database.

4. Generare la chiave dell'applicazione:

   ```bash
   php artisan key:generate
   ```

5. Configurare il database ed eseguire migrazioni con i seeder:

   ```bash
   php artisan migrate --seed
   ```

6. Avviare il server locale:

   ```bash
   php artisan serve
   ```

## Funzionalità principali

1. Gestione Appartamenti:
   - Creazione, visualizzazione, modifica e cancellazione di ppartamenti.
   - Aggiunta di servizi come Wi-Fi, Parcheggio, Cucina etc.

2. Sponsorizzazioni:
   - Garantita visualizzazione in prima pagina dell'appartamento.
   - Possibiltà di scelta tra 3 diversi piani di sponsorizzazione.
   - Integrazione di **Braintree** per i pagamenti sicuri.

3. Messaggistica:
   - Ricezione di messaggi inviati dagli utenti tramite un form dalla parte front-end del sito.
   - Salvataggio dei messaggi relativi ad un determinato appartamento.

4. Gestione Utenti:
   - Sistema di autenticazione fornito da **Laravel Breeze**   
