# Desafio Faberdata - full-stack
## PHP  |  Angular.js 


Link para acesso 

- https://f6e7-201-33-197-118.ngrok.io 

Sistema CRUD de tarefas

- CREATE
- VIEW
- UPDATE
- DELETE

## Features

- Login e cadastro de usuário.
- Tasks separadas por grupos.
- Atualização em tempo real, sem a necesidade de salvar.

## Steps

- Realizar cadastro e login.
- Criar Grupo de tarefas no icone "+"
- Selecionar grupo criado
- Criar tarefa inserindo as informaçoes da mesma
- Alerar a tarefa (não é necessário salvar - realizado em tempo real)
- Excluir a tarefa no botao "X" ao lado da mesma
- Excluir Grupo no icone "X" ao lado do nome
- Realizar Logout

## Tech

Tecnologias usadas

- [AngularJS] - front-end dinamico!
- [NGINX] - servir app.
- [PHP] - para o backend.

## Installation

Inserir configurações abaixo em nginx.conf para:

- configuraçao de rotas dinamicas do angular
- Remoção da extensão .php em URL
 
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
inserir tabelas descritas em database.sql no banco de dados

alterar configurações de banco em /api/db

## License

MIT
