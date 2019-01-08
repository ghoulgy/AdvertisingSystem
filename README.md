## Bulletin System

This a real-time web application which is allow users to post their needs and demands online so that the people nearby can discover it.

It is focused more on the usage of google maps and integration of the Vue.js google maps library by using Laravel as the PHP Backend Framework.

:heavy_exclamation_mark: **Remarks For Windows**  
Can use Windows Subsystem Linux to install a Ubunutu machine that create the Redis server connect with the app.  

## Pre-requisite

* [Laravel 5.x](https://laravel.com/docs/master)  
* [Laravel Echo Server](https://github.com/tlaverdure/laravel-echo-server)  
* [Redis](https://redis.io/)  
* [NodeJs](https://nodejs.org/en/)  

## Deployment

**Laravel**
```
php artisan serve  
php artisan queue:listen  
laravel-echo-server start
```
**Laravel Echo Server**
```
laravel-echo-server start
```
**Redis (Server - Ubuntu)**
```
sudo apt-get install redis-server
bind 127.0.0.1 or bind 0.0.0.0
sudo service redis-server restart
redis-cli
```
or
```
sudo apt-get install redis-server -y  
sudo sed -i -e 's/127.0.0.1/0.0.0.0/g' /etc/redis/redis.conf  
sudo service redis-server restart  
```
**npm**
```
npm run dev
```
or
```
npm run watch
```