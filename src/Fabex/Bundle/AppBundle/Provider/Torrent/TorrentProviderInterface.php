<?php
/**
 * Created by PhpStorm.
 * User: fabex
 * Date: 03/05/15
 * Time: 01:23
 */

namespace Fabex\Bundle\AppBundle\Provider\Torrent;

/**
 * Interface TorrentProviderInterface
 * @package Fabex\Bundle\AppBundle\Provider\Torrent
 */
interface TorrentProviderInterface
{
    /**
     * @param string $torrentName
     * @return mixed
     */
    public function getBestTorrent($torrentName);

    /**
     * @return string
     */
    public function getName();
}
