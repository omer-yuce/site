<?php
/**
 * WordPress için taban ayar dosyası.
 *
 * Bu dosya şu ayarları içerir: MySQL ayarları, tablo öneki,
 * gizli anahtaralr ve ABSPATH. Daha fazla bilgi için
 * {@link https://codex.wordpress.org/Editing_wp-config.php wp-config.php düzenleme}
 * yardım sayfasına göz atabilirsiniz. MySQL ayarlarınızı servis sağlayıcınızdan edinebilirsiniz.
 *
 * Bu dosya kurulum sırasında wp-config.php dosyasının oluşturulabilmesi için
 * kullanılır. İsterseniz bu dosyayı kopyalayıp, ismini "wp-config.php" olarak değiştirip,
 * değerleri girerek de kullanabilirsiniz.
 *
 * @package WordPress
 */

// ** MySQL ayarları - Bu bilgileri sunucunuzdan alabilirsiniz ** //
/** WordPress için kullanılacak veritabanının adı */
define( 'DB_NAME', 'site_db' );

/** MySQL veritabanı kullanıcısı */
define( 'DB_USER', 'root' );

/** MySQL veritabanı parolası */
define( 'DB_PASSWORD', '' );

/** MySQL sunucusu */
define( 'DB_HOST', 'localhost' );

/** Yaratılacak tablolar için veritabanı karakter seti. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Veritabanı karşılaştırma tipi. Herhangi bir şüpheniz varsa bu değeri değiştirmeyin. */
define('DB_COLLATE', '');

/**#@+
 * Eşsiz doğrulama anahtarları.
 *
 * Her anahtar farklı bir karakter kümesi olmalı!
 * {@link http://api.wordpress.org/secret-key/1.1/salt WordPress.org secret-key service} servisini kullanarak yaratabilirsiniz.
 * Çerezleri geçersiz kılmak için istediğiniz zaman bu değerleri değiştirebilirsiniz. Bu tüm kullanıcıların tekrar giriş yapmasını gerektirecektir.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '?2P2hf(57il<WTEy<0`Wbt;c7;2N`Vv0}3K@}Afnuh*(#~5.{wMGU<<~0$dMv>TS' );
define( 'SECURE_AUTH_KEY',  'j^9IecY3S23?y+&b,ce**PB%WX,?]E;`.z}yziT~Z4iZtT`z|,cS}al?w4JtVW8n' );
define( 'LOGGED_IN_KEY',    'iD+7zqsO}UCrN0Q)SDi8$y}.LO<nxq[M0-8rXFT0Uw[33lgo]B bi&,DrE.0#WF3' );
define( 'NONCE_KEY',        '3yeFt64M}Et:Q)H:JA66):vCB/ajo3( zOdB-o9L%+Z)t0tCc!Wg~S_N#7A**UJm' );
define( 'AUTH_SALT',        'WjF C6SasgS9I%;l}]#}a-|!lO]F{TqE/Ci{TH{-t)@v0kA|+4_1V*kz>9~Vun.J' );
define( 'SECURE_AUTH_SALT', '[UnS1L!6^m1fM*lR%wke/{^ZzS`QcT0_Up56!H@jCe,+%t=s(GP<8SMVQAaJaf*d' );
define( 'LOGGED_IN_SALT',   'SY)lQbR}%&JjzTY~jkTPOZP+<o#3ZuI4WP#gdQ~d$Pu>jTw=xDm4y$c:[USCSU}>' );
define( 'NONCE_SALT',       '-+XJ}| }CS7#DSZfjw9F!zA@P8SLHo}^4E%LA`=XD*2vVNK?M_e76sxvH*P^w]%8' );
/**#@-*/

/**
 * WordPress veritabanı tablo ön eki.
 *
 * Tüm kurulumlara ayrı bir önek vererek bir veritabanına birden fazla kurulum yapabilirsiniz.
 * Sadece rakamlar, harfler ve alt çizgi lütfen.
 */
$table_prefix = 'wp_';

/**
 * Geliştiriciler için: WordPress hata ayıklama modu.
 *
 * Bu değeri "true" yaparak geliştirme sırasında hataların ekrana basılmasını sağlayabilirsiniz.
 * Tema ve eklenti geliştiricilerinin geliştirme aşamasında WP_DEBUG
 * kullanmalarını önemle tavsiye ederiz.
 */
define('WP_DEBUG', false);

/* Hepsi bu kadar. Mutlu bloglamalar! */

/** WordPress dizini için mutlak yol. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** WordPress değişkenlerini ve yollarını kurar. */
require_once(ABSPATH . 'wp-settings.php');
