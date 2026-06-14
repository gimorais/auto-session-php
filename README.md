# Auto Session

Mini sistema acadêmico para cadastro e manutenção de marcas e modelos de veículos. O projeto foi desenvolvido com PHP, JavaScript, Bootstrap e SCSS, utilizando `$_SESSION` como armazenamento temporário e sem banco de dados.

## Funcionalidades

- Cadastro, listagem, edição e exclusão de marcas;
- Cadastro, listagem, edição e exclusão de modelos;
- Relacionamento entre modelos e marcas;
- Regra de integridade que impede excluir marcas com modelos vinculados;
- Validação dos formulários no JavaScript e no PHP;
- Busca de marcas e filtro de modelos;
- Tema claro e escuro;
- Contador de acessos durante a sessão;
- Opção para limpar todos os dados da sessão.

## Tecnologias

- PHP 8+
- HTML5
- JavaScript
- Bootstrap 5
- Bootstrap Icons
- SCSS / Sass
- Docker

## Executar localmente

É necessário ter o PHP 8 ou superior instalado.

```bash
php -S localhost:8000
```

Depois, acesse `http://localhost:8000` no navegador.

## Trabalhar com o SCSS

Instale as dependências:

```bash
npm install
```

Para recompilar o CSS automaticamente durante o desenvolvimento:

```bash
npm run sass
```

Para gerar o CSS final:

```bash
npm run build:css
```

## Executar com Docker

```bash
docker build -t auto-session-php .
docker run --rm -p 10000:10000 auto-session-php
```

Depois, acesse `http://localhost:10000`.

## Deploy no Render

O repositório contém `Dockerfile` e `render.yaml`. No Render, conecte o repositório do GitHub e crie um Blueprint ou um Web Service com runtime Docker.

O serviço está configurado para realizar um novo deploy automaticamente a cada atualização da branch principal.

> Os cadastros existem somente durante a sessão do usuário. Eles podem ser apagados quando a sessão termina ou quando o serviço gratuito de hospedagem reinicia.

## Estrutura principal

```text
assets/
├── css/
├── img/
├── js/
└── scss/
includes/
├── footer.php
├── header.php
├── scroll-top.php
└── viewcount.php
index.php
menu.php
manterMarca.php
manterModelo.php
limparSessao.php
Dockerfile
render.yaml
```

## Autoria

Desenvolvido por [Giovana Silva Morais](https://github.com/gimorais) para fins acadêmicos.
