<?php
/**
 * Mail Sender Main Class
 *
 * @package MailSender
 */

namespace mailsender\includes;

use mailsender\includes\admin\Setting;

defined( 'ABSPATH' ) || exit;

/***
 * MailSender Class
 */
class MailSender {

	/**
	 * Instance
	 *
	 * @var $intance
	 */
	protected static $instance = null;

	/***
	 * Constructor
	 */
	public function __construct() {
		$this->includes();
		$this->init();
	}

	/**
	 * Initialization
	 */
	public function init() {
		new Setting();
	}

	/**
	 * Including classes
	 */
	public function includes() {
		include_once MAILSENDER_PLUGIN_PATH . '/includes/admin/class-setting.php';
	}

	/**
	 * Creating Instance
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

}
