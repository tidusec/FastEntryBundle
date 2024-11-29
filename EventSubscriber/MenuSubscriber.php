<?php

/*
 * This file is part of the "FastEntryBundle" for Kimai.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\FastEntryBundle\EventSubscriber;

use App\Event\ConfigureMainMenuEvent;
use App\Utils\MenuItemModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class MenuSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly AuthorizationCheckerInterface $security)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ConfigureMainMenuEvent::class => ['onMenuConfigure', 100],
        ];
    }

    public function onMenuConfigure(ConfigureMainMenuEvent $event): void
    {
        $auth = $this->security;
        if (!$auth->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return;
        }

        $menu = $event->getMenu();
        $timeTracking = $menu->getChild('timesheet');

        if ($timeTracking !== null) {
            $timeTracking->addChild(
                new MenuItemModel(
                    'fast_entry',
                    'Fast Entry',
                    'fast_entry',
                    [],
                    'fas fa-bolt'
                )
            );
        }
    }
}
