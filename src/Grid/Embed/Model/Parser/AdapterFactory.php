<?php
namespace Grid\Embed\Model\Parser;

use 
    Zork\Factory\Builder,
    Zork\Factory\FactoryAbstract,
    Zend\ServiceManager\ServiceLocatorInterface,
    Zork\ServiceManager\ServiceLocatorAwareTrait,
    Zend\ServiceManager\ServiceLocatorAwareInterface;

/**
 * Embed parser adapter factory
 *
 * @author Kristof Matos <kristof.matos@megaweb.hu>
 */
class AdapterFactory extends FactoryAbstract
{

    use ServiceLocatorAwareTrait;

    /**
     * Constructor
     *
     * @param \Zork\Factory\Builder                         $factoryBuilder
     * @param \Zend\ServiceManager\ServiceLocatorInterface  $serviceLocator
     */
    public function __construct( Builder                    $factoryBuilder,
                                 ServiceLocatorInterface    $serviceLocator )
    {
        parent::__construct( $factoryBuilder );
        $this->setServiceLocator( $serviceLocator );
    }
    
    /**
     * Factory an object
     *
     * @param string|object|array $adapter
     * @param object|array|null $options
     * @return \Zork\Factory\AdapterInterface
     */
    public function factory( $adapter, $options = null )
    {
        $adapter = parent::factory( $adapter, $options );

        if ( $adapter instanceof ServiceLocatorAwareInterface )
        {
            $adapter->setServiceLocator( $this->getServiceLocator() );
        }

        return $adapter;
    }
}
