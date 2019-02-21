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

### Ubuntu

```bash
$ sudo apt-get update
```

```bash
$ sudo apt-get install apt-transport-https ca-certificates curl software-properties-common make xdg-utils
```

```bash
$ curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
```
```bash
$ sudo apt-get update
```

```bash
$ sudo apt install docker-ce python-pip
```

```bash
$ sudo usermod -aG docker $(whoami)
```

```bash
$ sudo pip install docker-compose
```

### Debian

```bash
$ sudo apt-get update
```

```bash
$ sudo apt-get install apt-transport-https ca-certificates curl gnupg2 software-properties-common make xdg-utils
```

```bash
$ curl -fsSL https://download.docker.com/linux/$(. /etc/os-release; echo "$ID")/gpg | sudo apt-key add -
```

```bash
$ sudo apt-get update
```

```bash
$ sudo apt install docker-ce python-pip
```

```bash
$ sudo usermod -aG docker $(whoami)
```

```bash
$ sudo pip install docker-compose
```

### CentOS

```bash
$ sudo yum install -y yum-utils device-mapper-persistent-data lvm2 make epel-release xdg-utils
```

```bash
$ sudo yum-config-manager --add-repo https://download.docker.com/linux/centos/docker-ce.repo
```

```bash
$ sudo yum install docker-ce python-pip
```

```bash
$ sudo usermod -aG docker $(whoami)
```

```bash
$ sudo systemctl enable docker.service
```

```bash
$ sudo systemctl start docker.service
```

```bash
$ sudo pip install docker-compose
```

```bash
$ sudo yum upgrade python*
```

## Lancer le script d'installation

Il est situé à la racine du projet `deploy.sh`

```bash
$ sudo ./deploy.sh
```

## Divers

### Nginx vhost config

Les fichiers de configuration pour nginx sont disponibles dans le dossier `nginx`

### PHP-FPM config

Les fichiers de configuration pour PHP-FPM sont disponibles dans le dossier `php-fpm`
