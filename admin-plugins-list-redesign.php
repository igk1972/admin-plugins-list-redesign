<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;

/**
 * Class AdminPluginsListRedesignPlugin
 * @package Grav\Plugin
 */
class AdminPluginsListRedesignPlugin extends Plugin
{
    protected $version;

    /**
     * @return array
     *
     * The getSubscribedEvents() gives the core a list of events
     *     that the plugin wants to listen to. The key of each
     *     array section is the event that the plugin listens to
     *     and the value (in the form of an array) contains the
     *     callable (or function) as well as the priority. The
     *     higher the number the higher the priority.
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0],
            'onTwigSiteVariables'  => ['onTwigSiteVariables', 0],
            'onPageInitialized'    => ['onPageInitialized', 0],
        ];
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized()
    {
        if (!$this->isAdmin()) return;
        $this->enable([
            'onTwigTemplatePaths'    => ['onTwigAdminTemplatePaths', 0],
            'onAdminControllerInit'  => ['onAdminControllerInit', 0],
        ]);
    }

    public function onPageInitialized()
    {
    }

    public function onAdminControllerInit(Event $event)
    {
        $eventController = $event['controller'];
        $eventController->blacklist_views[] = $this->name;
    }

    /**
     * Add plugin templates path
     */
    public function onTwigAdminTemplatePaths()
    {
        array_unshift($this->grav['twig']->twig_paths, __DIR__ . '/admin/templates');
    }

    /**
     * Set needed variables to display direcotry.
     */
    public function onTwigSiteVariables()
    {
    }
}
