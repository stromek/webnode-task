**Pokračování na https://github.com/stromek/strom-php-app**

# Obecné požadavky
- Vytvořit soubor /.env (z .env.example)
- Do .evn není nutné zadávát údaje (jen musí existovat). Aplikace vrací falešná data a připojení k MySQL/Elasticu je jenom nachystané.


# Apache
- Spuštění v Apache s VirtualHostem.
- DocumentRoot musí mířit do /htdocs
- Povolit .htaccess

# PHP Dev
- php -S localhost:8000 -t ./htdocs

# AWS
- serverless deploy

# Vývoj
- docker 
- Aplikace poběží na *localhost:8000*
