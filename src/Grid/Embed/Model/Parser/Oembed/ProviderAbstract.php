<?php

namespace Grid\Embed\Model\Parser\Oembed;

use Zork\Factory\AdapterInterface as FactoryAdapterInterface;
use Zork\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

/**
 * Oembed provider adapter abstract
 *
 * @author Kristof Matos <kristof.matos@megaweb.hu>
 */
abstract class ProviderAbstract
    implements FactoryAdapterInterface,
               ServiceLocatorAwareInterface
{

    use ServiceLocatorAwareTrait;

    /**
     * Embed HTML code
     *
     * @var string
     */
    protected $_embedHtml;

    /**
     * Preview HTML code
     *
     * @var string
     */
    protected $_previewHtml;

    /**
     * Returns Oembed provider API endpoint URL with request URL,
     * or FALSE if given URL does not match provider URL schema
     *
     * @param string $contentUrl
     * @return string|false
     */
    abstract public function getFeedUrl($contentUrl);

    /**
     * Returns provider response data format
     *
     * @return string json|xml
     */
    abstract public function getFeedFormat();

    /**
     * Gets embed HTML code
     *
     * @return string
     */
    public function getEmbedHtml()
    {
        return $this->_embedHtml;
    }

    /**
     * Gets preview HTML code
     *
     * @return string
     */
    public function getPreviewHtml()
    {
        return $this->_previewHtml;
    }

    /**
     * Sets embedHtml and previewHtml from eombed response data
     *
     * @param object $response
     * @return void
     */
    public function parseResponse($response)
    {
        $contentFactory = $this->getServiceLocator()
                           ->get('Grid\Embed\Model\Parser\Oembed\ContentFactory');

        foreach( $contentFactory->getRegisteredAdapters() as $adapterName => $adapterClass )
        {
            $content = $contentFactory->factory($adapterName);
            if( $this->_embedHtml = $content->getEmbedHtml($response) )
            {
                break;
            }
        }

        if( isset($response->thumbnail_url) )
        {
            $title = isset($response->title)
                     ? htmlentities($response->title,ENT_COMPAT)
                     : '';
            $this->_previewHtml = '<img src="'.$response->thumbnail_url.'" '
                                  .' style="width: 100%; height: auto" '
                                  .' alt="'.htmlentities($response->title,ENT_COMPAT).'" />';
        }
        elseif( isset($response->title)  )
        {
            $translator = $this->getServiceLocator()->get('translator');
            $this->_previewHtml = '<p>'.$response->title.'</p>';
        }
        else
        {
            $translator = $this->getServiceLocator()->get('translator');
            $this->_previewHtml = $translator->translate(
                                        'embed.message.previewnotavailable',
                                        'embed');
        }
    }

    /**
     * @implements \Zork\Factory\AdapterInterface
     */
    public static function acceptsOptions( array $options )
    {
        return false;
    }

    /**
     * @implements \Zork\Factory\AdapterInterface
     */
    public static function factory( array $options = null )
    {
        return new static( $options );
    }

}
