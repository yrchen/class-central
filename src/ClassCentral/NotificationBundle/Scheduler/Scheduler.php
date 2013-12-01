<?php

namespace ClassCentral\NotificationBundle\Scheduler;

use ClassCentral\SiteBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Handles the creation and tracking of jobs
 * Class Scheduler
 * @package ClassCentral\NotificationBundle\Scheduler
 */
class Scheduler {

    private $container;

    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }



    public function createJob(User $user, $type)
    {

    }

} 