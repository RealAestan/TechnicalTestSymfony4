# Mini application symfony 4

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/63b703c9cb99471fb35bb42486013c8c)](https://app.codacy.com/app/RealAestan/TechnicalTestSymfony4?utm_source=github.com&utm_medium=referral&utm_content=RealAestan/TechnicalTestSymfony4&utm_campaign=Badge_Grade_Dashboard)

## Installation

### Cloner le repository

Via SSH :

```bash
$ git clone git@github.com:RealAestan/TechnicalTestSymfony4.git
```
Via HTTPS :

```bash
$ git clone https://github.com/RealAestan/TechnicalTestSymfony4.git
```

## Installer les dépendances

### Installer Docker

#### Ubuntu

`https://docs.docker.com/v17.09/engine/installation/linux/docker-ce/ubuntu/`

#### Debian

`https://docs.docker.com/v17.09/engine/installation/linux/docker-ce/debian/`

#### CentOS

`https://docs.docker.com/v17.09/engine/installation/linux/docker-ce/centos`

### Installer Docker Compose

`https://docs.docker.com/compose/install/`

### Debian/Ubuntu utilitaires

```bash
$ sudo apt-get update
```

```bash
$ sudo apt-get install make xdg-utils
```

### CentOS utilitaires

```bash
$ sudo yum install -y make xdg-utils
```

## Lancer le script d'installation

Il est situé à la racine du projet `deploy.sh`

```bash
$ sudo chmod +x deploy.sh
```

```bash
$ sudo ./deploy.sh
```

## Troubleshooting

L'application doit s'ouvrir automatiquement dans votre navigateur par défaut,
si ce n'est pas le cas rendez-vous sur `http://symfony.localhost:8080/`

Si cela ne fonctionne pas vérifier le contenu de votre fichier /etc/hosts

## Divers

### Nginx vhost config

Les fichiers de configuration pour nginx sont disponibles dans le dossier `nginx`

### PHP-FPM config

Les fichiers de configuration pour PHP-FPM sont disponibles dans le dossier `php-fpm`

### Projet symfony

Le code source du projet symfony est disponible dans le dossier `symfony`

### Versions utilisées

*   PHP 7.2.13
*   Symfony 4.2.3
*   Nginx 1.14.2
*   MySQL 5.7.21
