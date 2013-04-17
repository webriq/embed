<?php

namespace Grid\Embed\Model\Parser\Oembed\Provider;

use Grid\Embed\Model\Parser\Oembed;
use Grid\Embed\Model\Parser\Oembed\ProviderAbstract;

/**
 * CircuitLab Oembed provider adapter
 *
 * @author Kristof Matos <kristof.matos@megaweb.hu>
 */
class CircuitLab extends ProviderAbstract
{

    /**
     * API endpoint
     */
    const API_ENDPOINT = 'https://www.circuitlab.com/circuit/oembed/';

    /**
     * @see \Embed\Model\Parser\Oembed\ProviderAbstract::getFeedUrl()
     *
     * @param string $contentUrl
     * @return string|false
     */
    public function getFeedUrl($contentUrl)
    {
        return
            preg_match('@https://([a-z\.-]*\.)?circuitlab\.com/circuit/.+@i',$contentUrl)
            ? self::API_ENDPOINT
               .'?format='.$this->getFeedFormat()
               .'&url='.urlencode($contentUrl)
            : false;
    }

    /**
     * @see \Embed\Model\Parser\Oembed\ProviderAbstract::getFeedFormat()
     *
     * @return string json|xml
     */
    public function getFeedFormat()
    {
        return Oembed::FEED_FORMAT_JSON;
    }

}
