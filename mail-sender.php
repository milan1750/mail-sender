<?php
/**
 * Plugin Name:       Mail Sender
 * Plugin URI:        https://example.com/firstplugin
 * Description:       Plugin for sending custom mails to registered users;
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Milan Malla
 * Author URI:        https://example.com
 * Text Domain:       mail-sender
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package MailSender
 */

namespace mailsender;

use mailsender\includes\MailSender;

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'MAILSENDER_PLUGIN_FILE' ) ) {
	define( 'MAILSENDER_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'MAILSENDER_PLUGIN_PATH' ) ) {
	define( 'MAILSENDER_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'MAILSENDER_PLUGIN_URL' ) ) {
	define( 'MAILSENDER_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

require MAILSENDER_PLUGIN_PATH . 'includes/class-mailsender.php';

$GLOBALS['mail_sender'] = MailSender::instance();
