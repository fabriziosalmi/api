# api, a part of RI

This is a self (but-not-restricted-to-myself) learning project. 

## technologies

- simple charts rendering
- html, css, php
- nginx, node, npm, php-fpm, mysql
- docker
- bash, crontab
- scaling, performance, security
- data sources analisys, gathering, indexing
- 3rd party tools use

## let's play

- a cheap Linux VPS is enough to start otherwise follow the white rabbit

_apt based whiterabbit_

- install nginx, php-fpm, a mysql compatible server, docker, python, curl
- create a mysql database 

```
CREATE TABLE `checks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url_id` int(11) NOT NULL,
  `monitor_id` int(11) NOT NULL,
  `score` float NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47186 DEFAULT CHARSET=utf8mb4;
```
- you need a php-fpm powered vhost on nginx
- download the code and have fun :D


## monitoring

[![SonarCloud](https://sonarcloud.io/images/project_badges/sonarcloud-white.svg)](https://sonarcloud.io/summary/new_code?id=fabriziosalmi_api)

- [sonarcloud](https://sonarcloud.io/project/overview?id=fabriziosalmi_api) (public free access)
- sentry.io
- Cloudflare 
- GitHub


## source code
Don't blame me for weak coding, I'm not a coder. I'll try to make it at my best and I'm open to PR of course.
If You want to know more about "RI", [You're welcome](mailto:fabrizio.salmi@gmail.com).

Please be patient, everything is done as is, free time, no rush, no rules atm.

