<?php
/**
 * Created by PhpStorm.
 * User: fabex
 * Date: 03/05/15
 * Time: 01:46
 */

namespace Fabex\Bundle\AppBundle\Provider\Torrent;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Class TorrentChainProvider
 * @package Fabex\Bundle\AppBundle\Provider\Torrent
 */
class TorrentChainProvider implements TorrentProviderInterface
{
    /**
     * @var ArrayCollection
     */
    protected $providers;

    public function __construct()
    {
        $this->providers = new ArrayCollection();
    }

    /**
     * @param TorrentProviderInterface $provider
     */
    public function addProvider(TorrentProviderInterface $provider)
    {
        if (!$this->providers->contains($provider)) {
            $this->providers->add($provider);
        }
    }

    /**
     * @param string $torrentName
     * @return array|mixed
     */
    public function getBestTorrent($torrentName)
    {
        $bestTorrents = array();
        foreach ($this->providers as $provider) {
            /** @var TorrentProviderInterface $provider */
            $bestTorrents[$provider->getName()] = $provider->getBestTorrent($torrentName);
        }

        return $bestTorrents;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'torrent_chain_provider';
    }
}
