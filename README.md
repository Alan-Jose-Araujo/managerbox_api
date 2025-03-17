<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://github.com/Alan-Jose-Araujo/managerbox_api/blob/master/public/standard_images/logo.png" width="400" alt="Laravel Logo">
    </a>
</p>

# Manager Box

<p>
    O <b>Manager Box</b> é uma plataforma de gerenciamento de estoque para empresas de diferentes ramos de atividade.
    O sistema busca tornar o processo de organização e auditoria de estoque mais simples e eficaz. Oferecendo um histórico
    de todas as movimentações e gestão dos itens do inventário.
</p>

## <i>"O que o sistema possui?"</i>
<ul>
    <li>Gestão de itens</li>
    <li>Movimentação de estoque</li>
    <li>Exportação do relatório de itens/movimentações</li>
</ul>

## <i>"Como executá-lo?"</i>
<ol>
    <li>Instale o <a href="https://www.php.net/"><b>PHP 8.4.x</b></a></li>
    <li>Instale o <a href="https://getcomposer.org/"><b>Composer 2.x.x</b></a></li>
    <li>Clone o repositório com o comando <code>git clone https://github.com/Alan-Jose-Araujo/managerbox_api.git</code></li>
    <li>Instale as dependências do composer com o comando <code>composer install</code>. Caso tenha problemas com as extensões, adicione a opção <code>--ignore-platform-reqs</code></li>
    <li>Instale as dependências do node com o comando <code>npm install</code></li>
    <li>Certifique-se de que o arquivo <code>cnae_codes.json</code> está no diretório <code>storage/app/private</code>. Caso não esteja, <a href="https://drive.google.com/file/d/1_nA8ImLswDXE92TRId658f3AiMuQBoT4/view?usp=sharing">baixe-o aqui</a>.</li>
    <li>Configure as credenciais do seu banco de dados Mysql</li>
    <li>Execute o comando <code>php artisan key:generate</code></li>
    <li>Execute o comando <code>php artisan migrate</code>, caso queira, pode adicionar a opção <code>--seed</code> para agilizar</li>
    <li>Caso não tenha adicionado a flag <code>--seed</code> no passo anterior, execute o comando <code>php artisan db:seed</code></li>
    <li>Execute agora o comando <code>php artisan serve</code></li>
    <li>Acesse a URL disponibilizada pelo servidor</li>
</ol>
