# Sistema de Login e Cadastro PHP/POO
Este é um sistema simples de login e cadastro em PHP que inclui recursos de login e registro de usuários. Abaixo estão os principais componentes do código.

# Estrutura de Pastas
<strong>lib:</strong> Contém a lógica de backend do sistema.<br>
<strong>class-user.php:</strong> Classe que gerencia operações relacionadas aos usuários, como login, registro e logout.<br>
<strong>index.php:</strong> Arquivo principal que direciona o fluxo da aplicação e inclui as páginas apropriadas com base na autenticação do usuário.<br>
<strong>lib/pages: </strong>Este diretório conteria arquivos de página específicos, mas não estão incluídos no código fornecido.<br>

# Configuração do Banco de Dados
O sistema utiliza um banco de dados MySQL. As configurações de conexão com o banco de dados podem ser encontradas em lib/class-user.php:


<code>define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'seu_banco');</code>


# Fluxo Principal (index.php)
1. <strong>Inicialização: </strong>O sistema define configurações iniciais, incluindo o fuso horário e o tratamento de erros.

2. <strong>Instanciação do Usuário: </strong>Uma instância da classe User é criada para gerenciar o estado e as operações do usuário.

3. <strong>Verificação de Login: </strong>Se o usuário estiver logado, a página do painel é incluída. Caso contrário, o sistema verifica se uma URL específica foi fornecida.

# URLs Específicas:

<strong>register: </strong>Se a URL contiver "register", a página de registro é incluída.<br>
<strong>logout: </strong>Se a URL contiver "logout", o usuário é desconectado.<br>

<strong>Função includePage(): </strong>Essa função inclui dinamicamente as páginas com base no nome fornecido.

# Classe User (lib/class-user.php)
Esta classe gerencia as operações do usuário, incluindo login, registro e logout. Além disso, fornece métodos para obter informações do usuário, como nome e moedas.

# Métodos Principais
<strong>__construct(): </strong>Verifica se o usuário está logado ao instanciar a classe.<br>
<strong>sign_up(): </strong>Registra um novo usuário no banco de dados.<br>
<strong>sign_in(): </strong>Autentica um usuário e define cookies de sessão.<br>
<strong>sign_out(): </strong>Desconecta o usuário e destrói a sessão.<br>
<strong>_set_cookies(): </strong>Define cookies de usuário para autenticação persistente.<br>
<strong>_getMyName(): </strong>Obtém o nome do usuário.<br>

# Considerações Finais
Este sistema de login é um ponto de partida básico e pode ser expandido com mais recursos, como páginas de perfil, gerenciamento de usuarios, etc. Certifique-se de configurar o banco de dados antes de usar o sistema.
