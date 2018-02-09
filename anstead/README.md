> Why pay for hosting when you can use this…

# Anstead

Ansible playbooks for setting up a LEMP stack for Laravel.

- Local development environment with Vagrant
- High-performance production servers
- One-command provisioning
- One-command deployments

## What's included

This playbook configures the following and more:

* Ubuntu 16.04 Xenial LTS
* Nginx
* PHP 7.1
* MariaDB
* Redis
* SSL support (scores an A+ on the [Qualys SSL Labs Test](https://www.ssllabs.com/ssltest/))
* Let's Encrypt integration for free SSL certificates
* HTTP/2 support (requires SSL)
* Composer
* sSMTP (mail delivery)
* Supervisor
* MailHog
* Fail2ban
* ferm

## Requirements

Ensure all dependencies have been installed before moving on:

* [Ansible](http://docs.ansible.com/ansible/intro_installation.html#latest-releases-via-pip) 2.0.2
* [Virtualbox](https://www.virtualbox.org/wiki/Downloads) >= 4.3.10
* [Vagrant](http://www.vagrantup.com/downloads.html) >= 1.5.4
* [vagrant-bindfs](https://github.com/gael-ian/vagrant-bindfs#installation) >= 0.3.1
* [vagrant-hostmanager](https://github.com/smdahlen/vagrant-hostmanager#installation)

## Installation

```shell
# → Root folder
├── ansible/      # → Ansible / Vagrant folder
└── laravel/      # → Laravel app
```

All Ansible commands should be ran from the `/ansible` directory

```shell
cd ansible
```

## Servers

This playbook has been designed to have three servers in production:

- a web server consisting of application code, PHP & Nginx
- a database server with MariaDB installed
- a separate server for Redis

however it is possible to use only one server, which is how the staging and development environments are setup.

## Development environment

Vagrant calls the Ansible script to provision a virtual machine for local
development.

```shell
vagrant up # start Vagrant
cd /srv/www/example.com/current # all Artisan & Composer commands to be ran here
```

## Remote server setup (staging/production)

A base `Ubuntu 16.04` server is required for setting up remote servers.

Ensure `hosts/{staging,production}` contains the IP address(es) of the server(s) you wish to provision, that
`group_vars/{staging,production}/{laravel_apps, vault}.yml` has been configured and then use the provision command to call Ansible:

```shell
bin/provision.sh <environment>
```

## Deployments

Could not be easier:

```shell
bin/deploy.sh <environment> <app name>
```

### Rollbacks (untested)

Rollback to the previous **working** release using:

```shell
./rollback.sh {staging,production}
```
