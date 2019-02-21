# Mini application symfony 4

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

### Debian/Ubuntu

```bash
$ sudo apt install docker docker-compose make xdg-utils
```

```bash
$ sudo systemctl enable docker.service
```

```bash
$ sudo systemctl start docker.service
```


### CentOS/RHEL

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
