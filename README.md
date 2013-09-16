# Welcome to Exceptional Emails

## Exceptional Emails is a PHP/Python/Mongodb based service that tells you about emails that didn't turn up

At the moment this might be a bit of a challenge to set up, you will need:

* Apache
* PHP
* MongoDB
* SlickGrid https://github.com/mleibman/SlickGrid
* Python

The python scripts run from cron jobs, they are responsible for receiving emails (on port 1025, it is assumed you map port 25 to 1025 using iptables so the python process can run unpriviledged)
The PHP bits are responsible for the web user interface

This also includes Socialite.js and SlickGrid in the repository at the moment, you should get them from their respective homes instead.
