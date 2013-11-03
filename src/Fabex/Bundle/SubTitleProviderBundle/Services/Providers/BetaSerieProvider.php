<?php
/**
 * Created by PhpStorm.
 * User: fabex
 * Date: 11/3/13
 * Time: 6:12 AM
 */
namespace Fabex\Bundle\SubTitleProviderBundle\Services\Providers;

use Fabex\Bundle\BetaSerieBundle\Services\BetaSerie;

class BetaSerieProvider extends SubTitleProviderAbstract
{
    /**
     * @var \Fabex\Bundle\BetaSerieBundle\Services\BetaSerie
     */
    private $betaserie;

    public function __construct(BetaSerie $betaserie)
    {
        $this->betaserie = $betaserie;
    }

    public function getSubTitle($serie, $fullNameSerie, $season, $episode)
    {
        $srts = $this->betaserie->getSubtitle($serie, $season, $episode);

        foreach($srts as $srt) {
            if($srt->season == $season && $srt->episode == $episode) {
                $this->addSubtitle($srt->file, $srt->url);
            }
        }
        return $this->subtiles;
    }
}