<?php

namespace PHPPM\Bootstraps;

use Drupal\Core\DrupalKernel;
use Drupal\Core\Site\Settings;
use Stack\Builder;
use Symfony\Component\HttpFoundation\Request;

/**
 * A default bootstrap for the Drupal framework
 */
class Drupal implements StackableBootstrapInterface
{
    /**
     * @var string|null The application environment
     */
    protected $appenv;

    /**
     * Instantiate the bootstrap, storing the $appenv
     */
    public function __construct($appenv)
    {
        $this->appenv = $appenv;
    }

    /**
     * Create a Drupal application
     */
    public function getApplication()
    {    	
        // Bootstrap Drupal.
        // Bootstrap code is modeled on a few examples in core/scripts, such as db-tools.php.
        
    	// Assume we're in DRUPAL_ROOT/vendor/php-pm/httpkernel-adapter/Bootstraps.  There
    	// may be a safer way to do this...
        $drupal_root = dirname(dirname(dirname(dirname(__DIR__))));
        
        // @todo: Is it necessary to call bootEnv()?  It's called automatically by createFromRequest().
        DrupalKernel::bootEnvironment();
        
        $request = Request::createFromGlobals();
        
        // @todo: Is it necessary to call initialize()? Is it called through createFromRequest()?
        $autoloader = include $drupal_root . '/autoload.php';
        Settings::initialize($drupal_root, DrupalKernel::findSitePath($request), $autoloader);
        
        $app = DrupalKernel::createFromRequest($request, $autoloader, $this->appenv);
        
        $app->boot();

        return $app;
    }

    /**
     * Return the StackPHP stack.
     */
    public function getStack(Builder $stack)
    {
        return $stack;
    }
}

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

final class BasicKernel extends Kernel
{
	public function registerBundles()
	{
		$bundles = [
		// we'll put stuff here later
		];
		return $bundles;
	}
	public function registerContainerConfiguration(LoaderInterface $loader)
	{

	}
	public function getLogDir()
	{
		return __DIR__.'/../var/log';
	}
	public function getCacheDir()
	{
		return __DIR__.'/../var/cache/'.$this->getEnvironment();
	}

	public function boot()
	{
		echo __FUNCTION__ . ': "booted". ';
	}

}