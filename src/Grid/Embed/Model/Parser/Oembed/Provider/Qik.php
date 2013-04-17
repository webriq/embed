<?php

namespace Grid\Embed\Model\Parser\Oembed\Provider;

use Grid\Embed\Model\Parser\Oembed;
use Grid\Embed\Model\Parser\Oembed\ProviderAbstract;

/**
 * Qik Oembed provider adapter
 *
 * @author Kristof Matos <kristof.matos@megaweb.hu>
 */
class Qik extends ProviderAbstract
{

    /**
     * API endpoint
     */
    const API_ENDPOINT = 'http://qik.com/api/oembed';

    /**
     * @see \Embed\Model\Parser\Oembed\ProviderAbstract::getFeedUrl()
     *
     * @param string $contentUrl
     * @return string|false
     */
    public function getFeedUrl($contentUrl)
    {
        return
            preg_match('@http://([a-z\.-]*\.)?qik\.com/.+@i',$contentUrl)
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
