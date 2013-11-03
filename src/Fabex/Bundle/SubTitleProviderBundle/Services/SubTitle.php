<?php
/**
 * Created by PhpStorm.
 * User: fabex
 * Date: 11/3/13
 * Time: 6:54 AM
 */
namespace Fabex\Bundle\SubTitleProviderBundle\Services;

use Fabex\Bundle\SubTitleProviderBundle\Services\Providers\SubTitleProviderInterface;

class SubTitle
{
    protected $providers = array();
    protected $subtitles = array();


    public function addProvider(SubTitleProviderInterface $provider)
    {
        $this->providers[] = $provider;
    }

    public function getSubTitle($serie, $fullNameSerie, $season, $episode)
    {
        foreach ($this->providers as $provider) {
            $srts = $provider->getSubTitle($serie, $fullNameSerie, $season, $episode);
            if (is_array($srts)) {
                $this->subtitles = array_merge($this->subtitles, $srts);
            }
        }
        return $this->subtitles;
    }
}