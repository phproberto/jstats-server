<?php

namespace Stats;

use Joomla\Controller\ControllerInterface;
use Joomla\DI\ContainerAwareInterface;
use Joomla\DI\ContainerAwareTrait;
use Joomla\Router\RestRouter;

/**
 * Stats application router
 *
 * @since  1.0
 */
class Router extends RestRouter implements ContainerAwareInterface
{
	use ContainerAwareTrait;

	/**
	 * Get a controller object for a given name.
	 *
	 * @param   string  $name  The controller name (excluding prefix) for which to fetch and instance.
	 *
	 * @return  ControllerInterface
	 *
	 * @since   1.0
	 * @throws  \RuntimeException
	 */
	protected function fetchController($name)
	{
		// Derive the controller class name.
		$class = $this->controllerPrefix . ucfirst($name);

		// If the controller class does not exist panic.
		if (!class_exists($class))
		{
			throw new \RuntimeException(sprintf('Unable to locate controller `%s`.', $class), 404);
		}

		// If the controller does not follows the implementation.
		if (!is_subclass_of($class, 'Joomla\\Controller\\ControllerInterface'))
		{
			throw new \RuntimeException(
				sprintf('Invalid Controller. Controllers must implement Joomla\Controller\ControllerInterface. `%s`.', $class), 500
			);
		}

		// Instantiate the controller.
		return $this->getContainer()->get($class);
	}
}
