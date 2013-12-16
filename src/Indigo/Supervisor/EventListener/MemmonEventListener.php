<?php

namespace Indigo\Supervisor\EventListener;

use Indigo\Supervisor\Supervisor;
use Symfony\Component\Process\Process as SymfonyProcess;

class MemmonEventListener extends AbstractEventListener
{
	protected $supervisor;
	protected $program = array();
	protected $group = array();
	protected $any;
	protected $name = null;

	public function __construct(Supervisor $supervisor, array $program = array(), array $group = array(), $any, $name = null)
	{
		$this->supervisor = $supervisor;
		$this->program = $program;
		$this->group = $group;
		$this->any = $any;
		$this->name = $name;
	}

	protected function doListen(array $payload)
	{
		if (strpos($payload[0]['eventname'], 'TICK') == false) {
			return 0;
		}

		$processes = $this->supervisor->getAllProcess();

		foreach ($processes as $process) {
			if (empty($process['pid'])) {
				continue;
			}

			$pname = $process['group'] . ':' . $process['name'];

			$process = new SymfonyProcess('ps -orss= -p ' . $process['pid']);
			$process->run();

			if ( ! $process->isSuccessful() or ($mem = intval($process->getOutput())) < 1) {
				continue;
			}

			$mem = $mem * 1024;

			if (array_key_exists($process['name'], $this->programs) and $this->programs[$process['name']] >= $mem) {
				$this->restart()
			}
		}
	}

	protected function restartProcess($process, $mem)
	{
		$pname = $process['name'] . ':' . $process['group'];

		$this->supervisor->stopProcess($pname);
		$this->supervisor->startProcess($pname);
	}
}