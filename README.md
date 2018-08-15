<p align="center"><img src="public/images/logo.png" width="150" alt="Phue logo" /></p>

<h1 align="center">Phue</h1>
<h4 align="center">PHP microframework for creating powerful single page applications powered by Vue.js.</h4>

---

## Features:
 * PHP API on the backend, Vue.js on the frontend
 * Easy-to-use MVC platform
 * Powerful Express-like router
 * Uses Axios for requests

## Requirements

 * PHP (>5.4.0)
 * Node.js (for building the frontend) (>8.x)
 * A web server (nginx, Apache, lighttpd, etc.) :)

## Getting Started

Clone the repository:

```
git clone git@github.com:jozsefsallai/phue
cd phue
```

Install the dependencies:

```
npm i -g yarn
yarn
```

Build the frontend:

```
yarn build
# or yarn build:windows if you're on a Windows machine
```

Create a virtualhost that points to `/path/to/phue/public`. Example nginx config:

```
server {
  listen 80;
  root /path/to/phue/public/;
  index index.php index.html;

  server_name your_domain_name;

  location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/var/run/php/php7.2-fpm.sock;
  }
  
  location / {
    try_files $uri $uri/ /index.php?$args;
  }
}
```

While working on the frontend, it is recommended that you use `yarn watch` or `yarn watch:windows` so you don't have to rebuild the frontend from the ground up every time you make a change.

To test the API calls, a utility like Postman is recommended.

## Example

The microframework comes with a built-in example to get you started. The example is a basic to-do app that allows you to add, edit, delete tasks, as well as specify whether they are done or still need to be done. 

The tasks are stored in a JSON file, but the same thing can be accomplished using MySQL (in fact, I do recommend that you use MySQL and not JSON). The reason I went with JSON is that I wanted to make the process of getting started less of a hassle (setting up a database, creating a config with the database details, etc.).

## Building For Production

To build the frontend for production use, make sure to specify the appropriate NODE_ENV:

```
NODE_ENV=production yarn build
```

or if you're on Windows:

```
set NODE_ENV=production
yarn build
```

## Contribution

If you have found a bug or you think the code can be improved in any way, feel free to contribute to the development by either creating an issue or a pull request. Your contribution is more than welcome!

## License

MIT
