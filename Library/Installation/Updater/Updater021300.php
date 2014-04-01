<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Claroline\CoreBundle\Library\Installation\Updater;

use Claroline\CoreBundle\Entity\UserPublicProfilePreferences;

class Updater021300
{
    private $container;
    private $logger;
    private $objectManager;

    public function __construct($container)
    {
        $this->container     = $container;
        $this->objectManager = $container->get('claroline.persistence.object_manager');
    }

    public function postUpdate()
    {
        $this->setPublicUrlOnUsers();
        $this->createUserPublicProfilePreferences();
    }

    protected function setPublicUrlOnUsers()
    {
        $this->log('Updating public url for users...');

        /** @var \Claroline\CoreBundle\Repository\UserRepository $userRepository */
        $userRepository = $this->objectManager->getRepository('ClarolineCoreBundle:User');
        /** @var \CLaroline\CoreBundle\Entity\User[] $users */
        $users = $userRepository->findByPublicUrl(null);

        /** @var \Claroline\CoreBundle\Manager\UserManager $userManager */
        $userManager = $this->container->get('claroline.manager.user_manager');

        foreach ($users as $user) {
            $publicUrl = $userManager->generatePublicUrl($user);
            $user->setPublicUrl($publicUrl);
            $this->objectManager->persist($user);
            $this->objectManager->flush();
        }

        $this->log('Public url for users updated.');
    }

    protected function createUserPublicProfilePreferences()
    {
        $this->log('Creating public profile preferences for users...');

        /** @var \Claroline\CoreBundle\Repository\UserRepository $userRepository */
        $userRepository = $this->objectManager->getRepository('ClarolineCoreBundle:User');
        /** @var \CLaroline\CoreBundle\Entity\User[] $users */
        $users = $userRepository->findWithPublicProfilePreferences();

        foreach ($users as $user) {
            if (null === $user->getPublicProfilePreferences()) {
                $newUserPublicProfilePreferences = new UserPublicProfilePreferences();
                $newUserPublicProfilePreferences->setUser($user);
                $this->objectManager->persist($newUserPublicProfilePreferences);
            }
        }

        $this->objectManager->flush();

        $this->log('Public profile preferences for users created.');
    }

    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    private function log($message)
    {
        if ($log = $this->logger) {
            $log('    ' . $message);
        }
    }
}