<?php

namespace Grid\Embed\Model\Parser\Oembed\Provider;

use Grid\Embed\Model\Parser\Oembed;
use Grid\Embed\Model\Parser\Oembed\ProviderAbstract;

/**
 * Soundcloud Oembed provider adapter
 *
 * @author Kristof Matos <kristof.matos@megaweb.hu>
 * @author David Pozsar <david.pozsar@megaweb.hu>
 */
class Soundcloud extends ProviderAbstract
{

    /**
     * API endpoint
     */
    const API_ENDPOINT = 'http://soundcloud.com/oembed';

    /**
     * @see \Embed\Model\Parser\Oembed\ProviderAbstract::getFeedUrl()
     *
     * @param string $contentUrl
     * @return string|false
     */
    public function getFeedUrl($contentUrl)
    {
        return preg_match('@^http://([a-z\.-]*\.)?soundcloud\.com/.+@i', $contentUrl)
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
