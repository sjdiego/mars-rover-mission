![](https://i.imgur.com/Uf2bXDx.jpg)

# Mars Rover Mission

### Your Task
You’re part of the team that explores Mars by sending remotely controlled vehicles to the surface of the planet. Develop a software that translates the commands sent from earth to instructions that are understood by the rover.

### Requirements
* You are given the initial starting point (x,y) of a rover and the direction (N,S,E,W) it is facing.
* The rover receives a collection of commands. (E.g.) FFRRFFFRL
* The rover can move forward (f).
* The rover can move left/right (l,r).
* Suppose we are on a really weird planet that is square. 200x200 for example :)
* Implement obstacle detection before each move to a new square. If a given
sequence of commands encounters an obstacle, the rover moves up to the last possible point, aborts the sequence and reports the obstacle.

### Take into account
* Rovers are expensive, make sure the software works as expected.

### How to use
Just copy or rename the __docker-compose.example.yml__ file to __docker-compose.yml__ and run the following commands:
* `docker-compose up -d`
* `docker-compose exec php composer install`
* `docker-compose exec php php artisan rover`

After the third command it will generate a terrain with obstacles and the vehicle will
be placed somewhere randomly. Then it will ask you to type some movements. If all
commands can be executed successfully, it will display a table with performed movements
over the terrain.

In case that some obstacle is in the path of the movements, the execution will stop and
it will display an alert with the location of last safe position.

### Tests
You can make sure that the software runs as expected typing some of the following commands
to run the tests:
* `docker-compose exec php php vendor/bin/phpunit`
* `docker-compose exec php php artisan test`


