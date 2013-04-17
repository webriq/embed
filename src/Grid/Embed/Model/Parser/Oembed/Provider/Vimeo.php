<?php

namespace Grid\Embed\Model\Parser\Oembed\Provider;

use Grid\Embed\Model\Parser\Oembed;
use Grid\Embed\Model\Parser\Oembed\ProviderAbstract;

/**
 * Vimeo Oembed provider adapter
 *
 * @author Kristof Matos <kristof.matos@megaweb.hu>
 */
class Vimeo extends ProviderAbstract
{

    /**
     * API endpoint
     */
    const API_ENDPOINT = 'http://vimeo.com/api/oembed';

    /**
     * @see \Embed\Model\Parser\Oembed\ProviderAbstract::getFeedUrl()
     *
     * @param string $contentUrl
     * @return string|false
     */
    public function getFeedUrl($contentUrl)
    {
        $regex1 = '@^http://([a-z\.-]*\.)?vimeo\.com/.+@i';
        $regex2 = '@^http://([a-z\.-]*\.)?vimeo\.com/groups/[^/]+/videos/.+@i';
        return ( (boolean)preg_match($regex1, $contentUrl)
                 ||
                 (boolean)preg_match($regex2, $contentUrl)
               )
                ? self::API_ENDPOINT
                   .'.'.$this->getFeedFormat()
                   .'?url='.urlencode($contentUrl)
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
