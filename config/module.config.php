<?php

return array(
    'router' => array(
        'routes' => array(
            'Grid\Embed\Paragraph' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/app/:locale/embed/load',
                    'defaults' => array(
                        'controller' => 'Grid\Embed\Controller\Paragraph',
                        'action'     => 'load',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Grid\Embed\Controller\Paragraph' => 'Grid\Embed\Controller\ParagraphController',
        ),
    ),
    'factory' => array(
        'Grid\Paragraph\Model\Paragraph\StructureFactory' => array(
            'adapter' => array(
                'embed' => 'Grid\Embed\Model\Paragraph\Structure\Embed',
            ),
        ),
        'Grid\Embed\Model\Parser\AdapterFactory' => array(
            'dependency' => array(
                'Grid\Embed\Model\Parser\AdapterInterface',
            ),
            'adapter'    => array(
                'oembed'      => 'Grid\Embed\Model\Parser\Oembed',
            ),
        ),
        'Grid\Embed\Model\Parser\Oembed\ProviderFactory' => array(
            'dependency' => array(
                'Grid\Embed\Model\Parser\Oembed\ProviderAbstract'
            ),
            'adapter'    => array(
                'youtube'       => 'Grid\Embed\Model\Parser\Oembed\Provider\Youtube',
                'flickr'        => 'Grid\Embed\Model\Parser\Oembed\Provider\Flickr',
                'vimeo'         => 'Grid\Embed\Model\Parser\Oembed\Provider\Vimeo',
                'soundcloud'    => 'Grid\Embed\Model\Parser\Oembed\Provider\Soundcloud',
                'viddler'       => 'Grid\Embed\Model\Parser\Oembed\Provider\Viddler',
                'hulu'          => 'Grid\Embed\Model\Parser\Oembed\Provider\Hulu',
                'myopera'       => 'Grid\Embed\Model\Parser\Oembed\Provider\MyOpera',
                'slideshare'    => 'Grid\Embed\Model\Parser\Oembed\Provider\SlideShare',
                'wordpress'     => 'Grid\Embed\Model\Parser\Oembed\Provider\WordPress',
                'chirbit'       => 'Grid\Embed\Model\Parser\Oembed\Provider\Chirbit',
                'circuitlab'    => 'Grid\Embed\Model\Parser\Oembed\Provider\CircuitLab',
                'qik'           => 'Grid\Embed\Model\Parser\Oembed\Provider\Qik',
                'revision3'     => 'Grid\Embed\Model\Parser\Oembed\Provider\Revision3',
                'smugmug'       => 'Grid\Embed\Model\Parser\Oembed\Provider\SmugMug',
                'photobucket'   => 'Grid\Embed\Model\Parser\Oembed\Provider\PhotoBucket',
             // 'discovery' is the fallback, must be the last
                'discovery'     => 'Grid\Embed\Model\Parser\Oembed\Provider\DefaultDiscovery',
            ),
        ),
        'Grid\Embed\Model\Parser\Oembed\ContentFactory' => array(
            'dependency' => array(
                'Grid\Embed\Model\Parser\Oembed\ContentAbstract'
            ),
            'adapter'       => array(
                'video'     => 'Grid\Embed\Model\Parser\Oembed\Content\Video',
                'photo'     => 'Grid\Embed\Model\Parser\Oembed\Content\Photo',
                'rich'      => 'Grid\Embed\Model\Parser\Oembed\Content\Rich',
             // 'default' is the fallback, must be the last
                'default'   => 'Grid\Embed\Model\Parser\Oembed\Content\DefaultLink',
            ),
        ),
    ),
    'form' => array(
        'Grid\Paragraph\CreateWizard\Start' => array(
            'elements'  => array(
                'type'  => array(
                    'spec'  => array(
                        'options'   => array(
                            'options'   => array(
                                'media' => array(
                                    'options'   => array(
                                        'embed' => 'paragraph.type.embed',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
        'Grid\Paragraph\Meta\Edit' => array(
            'fieldsets' => array(
                'embed' => array(
                    'spec' => array(
                        'name'      => 'embed',
                        'options'   => array(
                            'label'     => 'paragraph.type.embed',
                            'required'  => false,
                        ),
                        'elements'  => array(
                            'inputUrl' => array(
                                'spec' => array(
                                    'type'  => 'Zork\Form\Element\Text',
                                    'name'  => 'inputUrl',
                                    'options'   => array(
                                        'label'     => 'paragraph.form.embed.contenturl',
                                        'required'  => true,
                                    ),
                                    'attributes' => array(
                                        'data-js-type'  => 'js.embed.inputUrl',
                                    ),
                                ),
                            ),
                            'inputMaxwidth' => array(
                                'spec' => array(
                                    'type'  => 'Zork\Form\Element\Number',
                                    'name'  => 'inputMaxwidth',
                                    'options'   => array(
                                        'label'     => 'paragraph.form.embed.maxwidth',
                                        'required'  => false,
                                    ),
                                ),
                            ),
                            'inputMaxheight' => array(
                                'spec' => array(
                                    'type'  => 'Zork\Form\Element\Number',
                                    'name'  => 'inputMaxheight',
                                    'options'   => array(
                                        'label'     => 'paragraph.form.embed.maxheight',
                                        'required'  => false,
                                    ),
                                ),
                            ),
                            'embedHtml' => array(
                                'spec' => array(
                                    'type'  => 'Zork\Form\Element\Hidden',
                                    'name'  => 'embedHtml',
                                ),
                            ),
                            'error' => array(
                                'spec' => array(
                                    'type'  => 'Zork\Form\Element\Hidden',
                                    'name'  => 'error',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'grid/paragraph/render/embed' => __DIR__ . '/../view/grid/paragraph/render/paragraph.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'translator' => array(
        'translation_file_patterns' => array(
            'embed' => array(
                'type'          => 'phpArray',
                'base_dir'      => __DIR__ . '/../languages/embed',
                'pattern'       => '%s.php',
                'text_domain'   => 'embed',
            ),
        ),
    ),
    'modules'   => array(
        'Grid\Paragraph' => array(
            'customizeMapForms' => array(
                'embed' => array(
                    'element' => 'general',
                ),
            ),
        ),
    ),
);
