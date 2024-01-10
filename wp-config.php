<?php
/**
 * The base configuration for WordPress.
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @see https://wordpress.org/documentation/article/editing-wp-config-php/
 */

// ** Database settings - You can get this info from your web host ** //
/* The name of the database for WordPress */
define('DB_NAME', 'pastoraleconlefamigliemeet');

/* Database username */
define('DB_USER', 'root');

/* Database password */
define('DB_PASSWORD', 'matteo');

/* Database hostname */
define('DB_HOST', 'localhost');

/* Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/* The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '[]NRn,&Tq@SBln9fb[Qv_Y!@fRke1Q@]o3+XI$!A`PD2IU/iGr1Z+$w5v;:[`/_e');
define('SECURE_AUTH_KEY', '<[N$`t@:cIu.P@lBNsN7*)p%HZ|Z`b><;) UQc>[W6T^tR,BFxkDZWKbl6N;jy$F');
define('LOGGED_IN_KEY', 'RybX1kg$RY!xJoqL6I^u>NAS-K*u,*$I:BSDC2G0uO).Y#clP/a$QilX$%fZSEC`');
define('NONCE_KEY', 'tpat;OddtKTHXeS8d#-n$NSsEXp_3@C!wRp@k{C<zgI0}O)1(n|M1xQ,(}zS!I:B');
define('AUTH_SALT', 'EzYOaVe^/2f>~u6tZ2s=$<Y5LM=v/__X:</*x:l!}WF;5(AfC#?|l9fZua.ugbfl');
define('SECURE_AUTH_SALT', 'feo!Ak/;0_ti,WA9KvPlmw b].ywG}N(@kXJ3E<;z(P4:QbX@+,jEJ87f_er}Kz4');
define('LOGGED_IN_SALT', 'I%]{qh z_cvLv@abA9F#Tvzqhw%Pfp}x}q4X,If{!zXx1_9JvMcAVd9gA{A0M1P3');
define('NONCE_SALT', ':mh{S6XH:{}4~knf_gc*^jXDrWHV.)N}@yUKPg;HgwobY%~zEmZe.$(Xvo]r[~)r');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/*
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define('WP_DEBUG', false);
define('ENVIRONMENT', 'development');
define('LOG_PATH', __DIR__.'/wp-content/log');
/* Add any custom values between this line and the "stop editing" line. */

/* That's all, stop editing! Happy publishing. */

/* Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__.'/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH.'wp-settings.php';
