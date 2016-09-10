<?php
/**
 *
 * VigLink extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2016 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace phpbb\viglink\cron;

/**
 * Viglink cron task.
 */
class viglink extends \phpbb\cron\task\base
{
	/** @var \phpbb\config\config $config Config object */
	protected $config;

	/** @var \phpbb\viglink\acp\viglink_helper $helper Viglink helper object */
	protected $helper;

	/** @var \phpbb\user $user User object */
	protected $user;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config              $config         Config object
	 * @param \phpbb\viglink\acp\viglink_helper $viglink_helper Viglink helper object
	 * @param \phpbb\user                       $user           User object
	 * @access public
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\viglink\acp\viglink_helper $viglink_helper, \phpbb\user $user)
	{
		$this->config = $config;
		$this->helper = $viglink_helper;
		$this->user = $user;
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		try
		{
			$this->helper->set_viglink_services(true);
		}
		catch (\RuntimeException $e)
		{
			$this->helper->log_viglink_error($e->getMessage());
		}
	}

	/**
	 * @inheritdoc
	 */
	public function is_runnable()
	{
		return (bool) $this->config['viglink_enabled'];
	}

	/**
	 * @inheritdoc
	 */
	public function should_run()
	{
		return $this->config['viglink_last_gc'] < strtotime('24 hours ago');
	}
}
