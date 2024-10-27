# 🏛️ Sistema de Gestão de Solicitações de Serviços Públicos

## 📋 Descrição do Projeto

Este projeto foi desenvolvido como um desafio técnico para uma vaga, o projeto consiste basicamente em um **Sistema de Gestão de Solicitações de Serviços Públicos** que permite aos cidadãos registrar solicitações de serviços, como reparo de iluminação pública, coleta de lixo, e limpeza de praças, de maneira simples e eficiente. O sistema conta com uma interface intuitiva e permite acompanhar o status das solicitações. Ele foi desenvolvido utilizando a arquitetura **MVC (Model-View-Controller)**, garantindo uma separação clara entre a lógica de negócios, a interface do usuário e a manipulação de dados.

Além das funcionalidades principais, algumas funcionalidades opcionais foram implementadas, como a integração com o **Google Maps** para localizar e exibir o endereço das solicitações, o envio de **e-mails via SMTP do Gmail** para confirmação de solicitação, e a geração de **relatórios simples** para administração.

## ✨ Funcionalidades Principais

- **Cadastro de Solicitações de Serviços**: Os usuários podem registrar diferentes tipos de solicitações, como reparos de iluminação pública, coleta de lixo, limpeza de praças, entre outros.
- **Autenticação de usuários:** O sistema tem dois tipos de usuários, cidadãos (user) e administradores (admin). Os cidadãos podem criar solicitações e acompanharem o status, enquanto administradores gerenciam todas as solicitações.
- **Geolocalização com Google Maps**: Ao registrar uma solicitação, os usuários podem inserir o endereço manualmente ou selecionar diretamente no mapa a localização exata. Isso facilita a precisão das solicitações.
- **Gerenciamento de Solicitações**: Os administradores podem visualizar todas as solicitações, atualizá-las (mudança de status) e até excluí-las.
- **Status das Solicitações**: Cada solicitação pode estar em um dos três status: `Pendente`, `Em Andamento`, ou `Concluído`, e os usuários podem acompanhar o progresso.
- **Envio de E-mails (SMTP via Gmail)**: O sistema envia e-mails de confirmação aos usuários utilizando o servidor SMTP do Gmail, informando sobre o status das suas solicitações.
- **Modal para Criação de Solicitações**: Um modal foi implementado para facilitar o registro de novas solicitações sem sair da página principal.
- **Relatórios Simples**: Administradores podem gerar relatórios com dados como o número de solicitações por tipo de serviço e o tempo médio de resposta para cada tipo de serviço.

## 🚀 Funcionalidades Opcionais Implementadas

- **Geocodificação com Google Maps**: O sistema faz uso da API de Geocodificação do Google Maps para converter endereços em coordenadas geográficas (lat/long) e vice-versa.
- **Relatórios de Solicitações**: O sistema permite que administradores gerem relatórios sobre o número de solicitações por tipo de serviço e relatórios relacionados  ao tempo médio de resposta para cada tipo de serviço.
- **Envio de E-mails**: O sistema utiliza o SMTP do Gmail para enviar e-mails de confirmação e notificação aos usuários sempre que uma solicitação é registrada ou seu status é atualizado.

## 🛠️ Tecnologias Utilizadas

- **PHP**
- **Bootstrap 5**
- **JavaScript/ES6**
- **MySQL**
- **Google Maps API**
- **SMTP (Simple Mail Transfer Protocol) via Gmail**
- **Arquitetura MVC (Model-View-Controller)**

## 📂 Estrutura do Projeto

O projeto segue a arquitetura **MVC**, que facilita a manutenção e evolução do sistema. Abaixo está uma breve descrição de como o código está organizado:

- **Model**: Responsável pela interação com o banco de dados, realizando operações de CRUD (Create, Read, Update, Delete) relacionadas às solicitações.
- **View**: Contém os arquivos responsáveis pela interface com o usuário. Utiliza Bootstrap para garantir que as telas sejam visualmente consistentes.
- **Controller**: Contém a lógica de negócios do sistema, processando as requisições dos usuários, interagindo com os modelos e retornando as respostas apropriadas para as views.

## 🔌 APIs Utilizadas

### Google Maps API
A API do Google Maps foi utilizada para fornecer funcionalidades de geolocalização, incluindo a exibição de mapas interativos e a conversão de endereços em coordenadas geográficas. Os usuários podem clicar no mapa para definir a localização de uma solicitação ou inserir manualmente um endereço, que será convertido em coordenadas automaticamente.

### SMTP (Envio de E-mails via Gmail)
Foi utilizado o **SMTP do Gmail** para o envio de e-mails de confirmação e notificação. Toda vez que uma solicitação é registrada ou seu status é atualizado, o sistema envia um e-mail ao usuário através do servidor do Gmail.
