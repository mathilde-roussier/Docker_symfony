# Docker_symfony

Test technique 

## Environnement de développement

### Pré-requis

* Symfony 4 ou 5
* Docker
* Docker-compose
* composer

### Lancer l'environnement de développement

```bash
docker-compose up -d

winpty docker exec -it docker_www bash 
cd projet
composer install
```

### Urls du projet 

http://localhost:8080 -> PhpMyAdmin
http://localhost:8082 -> Symfony