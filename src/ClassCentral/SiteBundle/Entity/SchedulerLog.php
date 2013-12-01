<?php

namespace ClassCentral\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SchedulerLog
 */
class SchedulerLog
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var boolean
     */
    private $emailSent;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var string
     */
    private $jobId;

    /**
     * @var \ClassCentral\SiteBundle\Entity\User
     */
    private $user;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return SchedulerLog
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return SchedulerLog
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set emailSent
     *
     * @param boolean $emailSent
     * @return SchedulerLog
     */
    public function setEmailSent($emailSent)
    {
        $this->emailSent = $emailSent;
    
        return $this;
    }

    /**
     * Get emailSent
     *
     * @return boolean 
     */
    public function getEmailSent()
    {
        return $this->emailSent;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return SchedulerLog
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set jobId
     *
     * @param string $jobId
     * @return SchedulerLog
     */
    public function setJobId($jobId)
    {
        $this->jobId = $jobId;
    
        return $this;
    }

    /**
     * Get jobId
     *
     * @return string 
     */
    public function getJobId()
    {
        return $this->jobId;
    }

    /**
     * Set user
     *
     * @param \ClassCentral\SiteBundle\Entity\User $user
     * @return SchedulerLog
     */
    public function setUser(\ClassCentral\SiteBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \ClassCentral\SiteBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}

abstract class SchedulerJobType {
    const JOB_TYPE_SEARCH = 1;
    const JOB_TYPE_COURSES = 2;
}

abstract class SchedulerStatus {
    const STATUS_NEW = 1;    // The first time when the user is created. No need to run the job then
    const STATUS_CREATED = 2; // Job is created
    const STATUS_FINISHED = 3; // Job is finished

}
