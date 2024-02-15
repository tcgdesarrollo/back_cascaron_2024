# Container usage
1. Xdebug comes disabled by default, you can install and enable xdebug in your container by uncommenting the xdebug package installation/enabling lines in the Dockerfile.
2. It is recommended to install Microsoft's dev containers extension in order to run vscode inside a container environment. Once inside, all your code will be executed and interpreted by the installed interpreter.
3. Install your prefered extensions inside the container, independent from your host machine.

# Container setup
1. $cp Dockerfile.example Dockerfile.
2. $cp docker-compose.yml.example docker-compose.yml.
3. in docker-compose, change user and uid to your current user and uid. To get this info, run $id in your terminal.
4. $docker-compose up --build -d. You can optionally do $docker-compose up --build -d --remove-orphans to remove unused containers.
# App Setup
1. $composer install.
2. $cp .env.example .env.
3. configure the .env file to point to your database.
4. php artisan key:generate.
5. php artisan cache:clear.
6. php artisan config:clear.

# Setup database
1. WARNING: this commands empties current .env database and fills it with seeding data. $php artisan migrate:fresh --seed
2. $php artisan cache:clear.
