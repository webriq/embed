<?php

namespace Grid\Embed\Model\Parser;

use \Embed\Model\Parser;

/**
 * Oembed - Embed parser adapter
 *
 * @implements \Embed\Model\Parser\AdapterInterface
 *
 * @author Kristof Matos <kristof.matos@megaweb.hu>
 */
class Oembed implements AdapterInterface
{
    use AdapterTrait;

    const FEED_FORMAT_XML  = 'xml';
    const FEED_FORMAT_JSON = 'json';

    protected $selectedProviderName = null;

    protected $oembedApiCallUrl = null;

    /**
     *
     * @param type $contentUrl
     * @param type $params
     * @return boolean
     */
    public function parse($contentUrl,$params=array())
    {
        $parsed = false;

        $serviceLocator = $this->getServiceLocator();

        $providerFactory = $serviceLocator
                           ->get('Grid\Embed\Model\Parser\Oembed\ProviderFactory');

        foreach( $providerFactory->getRegisteredAdapters() as $adapterName => $adapterClass )
        {
            $this->selectedProviderName = $adapterName;

            $provider = $providerFactory->factory($adapterName);

            if( $this->oembedApiCallUrl = $provider->getFeedUrl($contentUrl) )
            {
                if( isset($params['maxwidth']) && (int)$params['maxwidth']>0 )
                {
                    $this->oembedApiCallUrl .= "&maxwidth=".(int)$params['maxwidth'];
                }
                if( isset($params['maxheight']) && (int)$params['maxheight']>0 )
                {
                    $this->oembedApiCallUrl .= "&maxheight=".(int)$params['maxheight'];
                }

                try
                {
//                    \FB::log($adapterName,'Oembed adapter');
//                    \FB::log($this->oembedApiCallUrl,'Oembed request URL');

                    $httpClient = $this->getHttpClient();
                    $httpClient->setURI($this->oembedApiCallUrl);
                    $httpResponse = $httpClient->send();

                    if( $httpResponse && $httpResponse->isSuccess())
                    {
                        $response = $this->responseToObject(
                                            $httpResponse->getBody(),
                                            $provider->getFeedFormat()
                                    );

                        $response->adapter    = $adapterName;
                        $response->requestUrl = $contentUrl;

                        //\FB::log($response,'Oembed response');

                        $provider->parseResponse($response);

                        if( preg_match("/^<script/i",$provider->getEmbedHtml()) )
                        {
                            $this->setError(Parser::ERROR_CONTENT_NOT_SUPPORTED);
                        }
                        else
                        {
                            $this->setEmbedHtml($provider->getEmbedHtml());
                            $this->setPreviewHtml($provider->getPreviewHtml());
                        }
                    }
                    elseif( $httpResponse->isNotFound() )
                    {
                        $this->setError(Parser::ERROR_CONTENT_NOT_FOUND);
                    }
                    else
                    {
                        $this->setError(Parser::ERROR_SERVICE_NOT_AVAILABLE);
                    }
                }
                catch( \Exception $ex)
                {
                    $this->setError(Parser::ERROR_SERVICE_NOT_AVAILABLE);
                }

                $parsed = true;
                break;
            }
        }
        return $parsed;
    }

    /**
     * Gets selected provider name
     *
     * @return string
     */
    public function getSelectedProviderName()
    {
        return $this->selectedProviderName;
    }

    /**
     * Gets oembed API call URL
     *
     * @return string
     */
    public function getOembedApiCallUrl()
    {
        return $this->oembedApiCallUrl;
    }

    /**
     * Converts oembed call response strings to object
     *
     * @param string $responseString
     * @param string $format
     * @return object
     */
    protected function responseToObject($responseString,$format)
    {
        if( $format == self::FEED_FORMAT_JSON )
        {
            $formatted = json_decode($responseString);
        }
        elseif( $format == self::FEED_FORMAT_XML )
        {
            $f = function($iterator)
            {
                $node = new \stdClass();
                foreach($iterator as $key=>$val)
                {
                    $node->$key = ( $iterator->hasChildren() )
                        ? call_user_func (__FUNCTION__, $val)
                        : strval($val);
                }
                return $node;
            };
            $formatted = $f(new \SimpleXmlIterator($responseString, null));
        }
        return $formatted;
    }

}
