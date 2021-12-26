# Snake website ![alt text](https://github.com/macieeek/laravel-snake-website/blob/main/public/assets/icons/32x32.png?raw=true) 

> ### Project of the website where you can interact via API with Snake game which is available to download on it.
> ###
> ### Online: https://snake-gra.pl/

- Project uses a login system from the [Breeze starter kit](https://laravel.com/docs/8.x/starter-kits#laravel-breeze) which has been modified.
- Application is responsive, made with the [Bootstrap 5](https://getbootstrap.com/docs/5.1/getting-started/introduction/).
- To display tables is used the [DataTables](https://datatables.net/) plugin.
- [jQuery](https://jquery.com/) is used to write JavaScript things.
- Every user has his own profile which everyone can visit.
- Logged user can set an avatar, change an email, change a password etc. in a user panel.
- Users can compare each other in a ranking page what means players can compete which is very fun!
- User with special permission is able to use admin panel which contains all users list, unique visitors and application logs.
- Admin is able to ban user's account, ban IP, look at application logs etc.
- Snake mini-game which is available to play on welcome page is made in clear JavaScript.
- In application has been implemented PWA system, what means website can run in a offline mode (without an internet connection - caches things while first visit).

# Installation

To successfully install and test application you need to have installed [composer](https://getcomposer.org/download/), [npm](https://docs.npmjs.com/cli/v7/commands/npm-install), [Git](https://git-scm.com/) and database environment (for example [XAMPP](https://www.apachefriends.org/pl/index.html) - localhost).

Open folder where you want to have project files, open console and then clone the repository

    git clone https://github.com/macieeek/laravel-snake-website.git
	
Change folder in console to created folder with project files

	cd laravel-snake-website

Install all the dependencies using composer

    composer install
	
Run npm install command

	npm install
	
Run npm run dev command to compile js files

	npm run dev

Copy the example env file and make the required configuration changes in the .env file

    copy .env.example .env

Generate a new application key

    php artisan key:generate
	
Create the symbolic link between storage and public folders

	php artisan storage:link

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000 or http://127.0.0.1:8000

To fill database with data use db:seed command which will create users accounts with randomly generated game data etc.

	php artisan db:seed
    