<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/pt-br:Editando_wp-config.php
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'crud_wordpress');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'root');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', '');

/** Nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Charset do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8mb4');

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '}Z%.uG:=mCz}hLVg1DJRdFty&WQ>Zo1Jo?`+w`KZMT?oww@Pa&&: 6zCYH3nb`{s');
define('SECURE_AUTH_KEY',  '~vFI]4l[mG.}I{2z_F#xOXw++~#P~{aog`Y<fe.&z> sa84Za}kl3ftv=) Etjx]');
define('LOGGED_IN_KEY',    'yx/P_9Aq8%i:UU-tRwv{:|#}o.W_^<&4< T;SlY?>F=n|xpgKoS&5}q^Jle5D}rU');
define('NONCE_KEY',        ']sIlgc!A]yNbXV~Gvlj1c]~p*nFutu)EGxyle@Un.+?nND$6Obu%#,$*_OY893^z');
define('AUTH_SALT',        'Lc}G~v>@>EO?i_toc?WnM~ ${ha;DyLgo:r24,$ag%i&M]+vd;#t]yX^0XMbyyXX');
define('SECURE_AUTH_SALT', '.M9yp5!W!yXle4BI?-vA?jH6[Tet,d5B(Yw>+AcSh)yAnIQ0{2%^IAW1.4J+E8{f');
define('LOGGED_IN_SALT',   'BK$Q-P~]|?:^e=HoMOV{f&TR%d{FlY$/m~3g3l%`k:^jq?7{Xq2-G6PBLmt^/q-|');
define('NONCE_SALT',       '|MMhZn?1b0Md|5IIza:1is,o[9N+47[UeB,=Mb mEU11C`:!uw dc:E1s$}/{311');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://codex.wordpress.org/pt-br:Depura%C3%A7%C3%A3o_no_WordPress
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Configura as variáveis e arquivos do WordPress. */
require_once(ABSPATH . 'wp-settings.php');
