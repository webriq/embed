<?php

namespace Grid\Embed\Model\Parser\Oembed\Provider;

use Grid\Embed\Model\Parser\Oembed;
use Grid\Embed\Model\Parser\Oembed\ProviderAbstract;

/**
 * Revision3 Oembed provider adapter
 *
 * @author Kristof Matos <kristof.matos@megaweb.hu>
 */
class Revision3 extends ProviderAbstract
{

    /**
     * API endpoint
     */
    const API_ENDPOINT = 'http://revision3.com/api/oembed/';

    /**
     * @see \Embed\Model\Parser\Oembed\ProviderAbstract::getFeedUrl()
     *
     * @param string $contentUrl
     * @return string|false
     */
    public function getFeedUrl($contentUrl)
    {
        return
            preg_match('@http://([a-z\.-]*\.)?revision3\.com/.+@i',$contentUrl)
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
