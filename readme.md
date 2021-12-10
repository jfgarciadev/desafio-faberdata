# Desafio Faberdata - full-stack
## PHP  |  Angular.js 


Link para acesso 

- https://e871-2804-c30-c288-e501-d5de-b7c4-c559-28c1.ngrok.io

Sistema CRUD de tarefas


- CREATE
- VIEW
- UPDATE
- DELETE

## Features

- Login e cadastro de usuário.
- Tasks separadas por grupos.
- Atualização em tempo real, sem a necesidade de salvar.

## Tech

Tecnologias usadas

- [AngularJS] - front-end dinamico!
- [NGINX] - servir app.
- [PHP] - para o backend.

## Installation

Inserir configurações abaixo em nginx.conf

```sh
location / {
	index       index index.html index.php;
	try_files   $uri $uri/ /index.html =404;
}
location /api/ {
	try_files $uri $uri.html $uri/ @extensionless-php;
	index index.html index.htm index.php;
}
location @extensionless-php {
	rewrite ^(.*)$ $1.php last;
}
```


## License

MIT
