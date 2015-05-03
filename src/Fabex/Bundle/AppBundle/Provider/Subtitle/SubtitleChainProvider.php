<?php
/**
 * Created by PhpStorm.
 * User: fabex
 * Date: 03/05/15
 * Time: 01:46
 */

namespace Fabex\Bundle\AppBundle\Provider\Subtitle;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class SubtitleChainProvider
 * @package Fabex\Bundle\AppBundle\Provider\Subtitle
 */
class SubtitleChainProvider implements SubtitleProviderInterface
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
     * @param SubtitleProviderInterface $provider
     */
    public function addProvider(SubtitleProviderInterface $provider)
    {
        if (!$this->providers->contains($provider)) {
            $this->providers->add($provider);
        }
    }

    /**
     * @param string $serie
     * @param string $season
     * @param string $episode
     * @param string $fullNameSerie
     * @return array|mixed
     */
    public function getSubtitle($serie, $season, $episode, $fullNameSerie)
    {
        $bestTorrents = array();
        foreach ($this->providers as $provider) {
            /** @var SubtitleProviderInterface $provider */
            $bestTorrents[$provider->getName()] = $provider->getSubtitle($serie, $season, $episode, $fullNameSerie);
        }

        return $bestTorrents;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'subtitle_chain_provider';
    }
}
