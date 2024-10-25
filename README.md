# 📦 Catálogo de Produtos com API RESTful

## 🎯 Objetivo

Este projeto tem como objetivo criar um sistema de gerenciamento de produtos que oferece funcionalidades de CRUD (criar, ler, atualizar e excluir) e expõe uma API RESTful para integração com outros sistemas. O projeto é desenvolvido em PHP e tem como finalidade demonstrar habilidades em desenvolvimento backend, integração de sistemas e boas práticas de programação.

## ✨ Funcionalidades

- **🛠 CRUD de Produtos**: Criação, leitura, atualização e exclusão de produtos.
- **🌐 API RESTful**: Endpoints para permitir que outros sistemas consumam os dados dos produtos.
- **🤝 Integração Externa**: Integração com um sistema fictício de ERP para sincronizar dados dos produtos.
- **📄 Documentação da API**: Documentação detalhada dos endpoints usando Swagger ou Markdown.
- **🧪 Testes Automatizados**: Testes básicos para garantir a qualidade da API.

## ⚙️ Tecnologias Utilizadas

- **PHP** (Laravel opcionalmente)
- **MySQL** ou **SQLite** para o banco de dados
- **Slim Framework** ou **Laravel** para criação da API RESTful
- **PHPUnit** para testes
- **Docker** (opcional) para containerização
- **Git** para controle de versão

## 🚀 Como Rodar o Projeto

1. **Clone o repositório**:
   ```sh
   git clone git@github.com:IgorGuariroba/Catalogo-Produtos-API-RESTful.git
   ```

2. **Instale as dependências**:
   ```sh
   composer install
   ```

3. **Configure o banco de dados**:
   - Crie um banco de dados MySQL ou utilize SQLite.
   - Atualize o arquivo `.env` com as credenciais do banco de dados.

4. **Execute as migrações**:
   ```sh
   php artisan migrate
   ```

5. **Inicie o servidor**:
   ```sh
   php artisan serve
   ```

6. **Acesse a aplicação** em: `http://localhost:8000`

## 🐳 Utilizando Docker (Opcional)

1. **Build e execute o container**:
   ```sh
   docker-compose up --build
   ```
2. **Acesse a aplicação** em: `http://localhost:8000`

## 📄 Documentação da API

A documentação dos endpoints da API pode ser acessada em `/api/documentation`. Utilize ferramentas como Swagger para facilitar o consumo e entendimento da API.

## 🧪 Testes

Execute os testes para garantir a qualidade do código:
```sh
vendor/bin/phpunit
```

## 💡 Diferenciais

- **Deploy no Heroku**: Se possível, realizar o deploy no Heroku ou outra plataforma para que o avaliador possa testar diretamente.
- **Documentação Completa**: Incluir exemplos de requisições e respostas para facilitar o uso da API.

## 📬 Contribuições

Sinta-se à vontade para contribuir enviando Pull Requests ou abrindo Issues com sugestões e melhorias.

---

Este projeto visa demonstrar habilidades em desenvolvimento backend e integração de sistemas de forma prática e eficiente. Se precisar de mais informações, consulte a documentação ou entre em contato. 😊
