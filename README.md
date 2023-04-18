# Endpointy
* POST - /api/v1/create-user - wygenerowanie użytkownika i tokenów (admin i odczyt).
* GET - /api/v1/currencies - Pobranie wszystkich wpisów z bazy
* GET - /api/v1/currencies?date=YYY-MM-DD - Filtrowanie walut po dacie
* GET - /api/v1/currencies?currency=EUR - Filtrowanie walut po kodzie
* GET - /api/v1/currencies?date=YYY-MM-DD&currency=EUR - Filtrowanie walut po dacie i kodzie
* POST - /api/v1/currencies - Dodanie waluty

# Info
Podczas uruchamiania migracji można dodać flagę `--seed`, od razu wypełni tabelę 10 wpisami.

Przy pierwszym uruchomieniu należy wygenerować użytkownika i zapisać tokeny dla niego. Następnie używać ich w zalezności od potrzeb (token `admin` może odczytywać istniejące wpisy oraz dodawać nowe rekordy, `read` tylko odczytywać i filtrować).
