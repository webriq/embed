<?php

namespace Grid\Embed\Model\Parser;

use Zork\ServiceManager\ServiceLocatorAwareTrait;
use Zend\Http\Client as HttpClient;

/**
 * Embed parser adapter trait
 *
 * @implements \Embed\Model\Parser\AdapterInterface
 * @implements \Zork\Factory\AdapterInterface
 *
 * @author Kristof Matos <kristof.matos@megaweb.hu>
 */
trait AdapterTrait
{
    use ServiceLocatorAwareTrait;

    /**
     * Stores error message
     *
     * @var string
     */
    protected $error = null;

    /**
     * Stores embed HTML code
     *
     * @var string
     */
    protected $embedHtml = null;

    /**
     * Stores preview HTML code
     *
     * @var string
     */
    protected $previewHtml = null;

    /**
     * HttpClient instance
     *
     * @var \Zend\Http\Client
     */
    protected $httpClient = null;


    /**
     * Gets httpClient, creates if not set
     *
     * @return \Zend\Http\Client
     */
    public function getHttpClient()
    {
        if( is_null($this->httpClient) )
        {
            $this->setHttpClient(
                $this->getServiceLocator()->get('Zend\Http\Client')
            );
        }
        return $this->httpClient;
    }

    /**
     *  Sets httpClient
     *
     * @param \Zend\Http\Client $httpClient
     * @return \Embed\Model\Parser\AdapterInterface
     */
    public function setHttpClient(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
        return $this;
    }


    /**
     * Gets error
     *
     * @implements \Embed\Model\Parser\AdapterInterface
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Sets error
     *
     * @param string $message
     * @return \Embed\Model\Parser\AdapterInterface
     */
    public function setError($message)
    {
        $this->error = $message;
        if( !empty($message) )
        {
            $this->setEmbedHtml(null);
            $this->setPreviewHtml(null);
        }
        return $this;
    }

    /**
     * Gets embed HTML
     *
     * @implements \Embed\Model\Parser\AdapterInterface
     * @return string
     */
    public function getEmbedHtml()
    {
        return $this->embedHtml;
    }

    /**
     * Sets embed HTML
     *
     * @param string $html
     * @return \Embed\Model\Parser\AdapterInterface
     */
    public function setEmbedHtml($html)
    {
        $this->embedHtml = $html;
        return $this;
    }

    /**
     * Gets preview HTML
     *
     * @implements \Embed\Model\Parser\AdapterInterface
     * @return string
     */
    public function getPreviewHtml()
    {
        return $this->previewHtml;
    }

    /**
     * Sets preview HTML
     *
     * @param string $html
     * @return \Embed\Model\Parser\AdapterInterface
     */
    public function setPreviewHtml($html)
    {
        $this->previewHtml = $html;
        return $this;
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
