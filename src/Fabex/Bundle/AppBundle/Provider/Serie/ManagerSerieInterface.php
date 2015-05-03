<?php
/**
 * Created by PhpStorm.
 * User: fabex
 * Date: 02/05/15
 * Time: 14:48
 */

namespace Fabex\Bundle\AppBundle\Provider\Serie;

/**
 * Interface ManagerSerieInterface
 * @package Fabex\Bundle\AppBundle\Provider\Serie
 */
interface ManagerSerieInterface
{
    public function memberAuthentication($login, $password);
    public function memberLastEpisode();
}