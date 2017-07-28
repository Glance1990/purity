<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/var/www/purityfashion/purity-fashion.com/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'new_purity');

/** Имя пользователя MySQL */
define('DB_USER', 'u_new_puri');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'ocQ8c81QKPG8');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'n}hHAT<^2$m%nAZ5sZiq],3i%J^s>52fM`D7*AxphA6bT77gScv9t|S&bUOh(Qtm');
define('SECURE_AUTH_KEY',  'f~so9y:y5V6*at.Zrb-:];UzeBo8wf-&?+<<Xgi+AL5@lt1.B<|88D~AGg6*v8/o');
define('LOGGED_IN_KEY',    ':==z3|iw16iI/RU-j4&n=L}EVbMrg+4]fz|>75myue?4qQJS9P1-oi}KbZOOJ;2|');
define('NONCE_KEY',        'f`WZrKIpH$S.(ubUHtdb^MENk=/1Q%Nb>,sC^+*24UG{8&v(ASt9Cv,Y}ewD>xgX');
define('AUTH_SALT',        '5Cz[/j6l|RRxk_gGc#8;UZZ)wSu-KL`/X*Nh-ny1K:.$8:ro+`j!.^<{_&<>Ft7O');
define('SECURE_AUTH_SALT', 'sZZ:),&s/#q84_Tgr9{!~`UV2mJ_e%_*His0F~AFN2m.EC[).aF~X!=zk@mj[0]}');
define('LOGGED_IN_SALT',   '&%:>W!IIfn}O9kX@v^l}D+)-<wYlk#l}i6LBP(w8;bd~rV+i{zt*k<},)n_rcO.v');
define('NONCE_SALT',       '6MDMH{q3GqXcLoAUd}*+xEz]bHdT,ZXVq:Pk2X$Qv+IWbQ301w7B=mmQH#%;?|r~');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'test_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 * 
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);





/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');