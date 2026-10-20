## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and
creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in
many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache)
  storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

## Installation requirements

- PHP8.4
- Composer
- Node and npm

## Setup

- git clone
- cd into your installation directory
- composer install
- cp .env.example .env
- Edit APP_URL to match the URL being used
- php artisan key:generate
- npm install && npm run build
- php artisan serve (or use Herd)

## Configuration

Other than editing APP_URL, none is required - the five R&M-specific values in .env are :

- **RICKANDMORTY_URL** : the URL of the API;
- **RICKANDMORTY_TIMEOUT** : the timeout (in seconds) for each HTTP request to the API;
- **RICKANDMORTY_CACHELIFETIME** : the cache lifetime (in seconds) - deliberately set long;
- **RICKANDMORTY_COOLOFFTIME** : because of Cloudflare caching (see below), a 30 second (by default) cool-off period
  after a
  429 response is received that does not send a Retry-After header (if a Retry-After header is sent, the value in that
  is used instead);
- **RICKANDMORTY_DAILYLIMIT** : the API docs give a daily limit of 10,000 requests from one IP, so this is set 10% below
  to
  err on the side of caution.

## Architecture

- MVC without a database - the API serves as the data source, the models are plain value objects with fromApi();
- Request flow is route -> CharacterIndexRequest -> Controller -> Service -> Model -> View
- No SDK used for the API.
- Tailwind + DaisyUI for simple frontend.

## Notes

The data is effectively static, hence a long cache lifetime. Filters are sorted alphabetically by key and hashed with
their values and the current page.

Episodes are retrieved en-masse and then cached individually. Only bare bones information (name, ID, air date) is used
on the front of the site.

Search is in place for character name. Filters are in place for status and gender - species and type deliberately left
out because they're free text fields.

Rate limits - The API documents a limit of 10,000 requests a day, which the app guards with its own daily budget (
RICKANDMORTY_DAILYLIMIT). In practice, Cloudflare also enforces a short burst limit (error 1015, Retry-After: 6). The
cool-off honours Retry-After, so the app stops calling the API until the window has passed.

NB: on a fresh install the cache is empty, so changing filters rapidly will probably trip the burst limit briefly. The
app shows a "temporarily unavailable" message and recovers within seconds, and pages that are already cached are
unaffected. On the plus side, it makes the error handling easy to demonstrate.

Connection errors and 5xx errors are retried with deliberately short delays to cap request times at about 10s total.

429 errors aren't retried, a deliberate design choice.

Errors are handled gracefully - deliberately redirecting back to the landing page along with a flash message, to avoid a
loop being entered if the previous page's cached had expired (admittedly unlikely, but you never know...)

Middleware handles hammering of requests by an individual IP (max 60/minute).
