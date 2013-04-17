<?php

namespace Grid\Embed\Model\Paragraph\Structure;

use Grid\Paragraph\Model\Paragraph\Structure\AbstractLeaf;

/**
 * Embed paragraph structure
 *
 * @author Kristof Matos <kristof.matos@megaweb.hu>
 */
class Embed extends AbstractLeaf
{
    /**
     * Paragraph type
     *
     * @var string
     */
    protected static $type = 'embed';

    /**
     * Paragraph-render view-open
     *
     * @var string
     */
    protected static $viewOpen = 'grid/paragraph/render/embed';

    /**
     * Input URL
     *
     * @var string
     */
    public $inputUrl       = null;

    /**
     * Input maxwidth (optional)
     *
     * @var integer
     */
    public $inputMaxwidth  = null;

    /**
     * Input maxheight (optional)
     *
     * @var integer
     */
    public $inputMaxheight = null;

    /**
     * Stores oembed reading error
     *
     * @var string
     */
    public $parserError  = null;

    /**
     * Stores embed HTML code
     *
     * @var string
     */
    public $embedHtml   = null;

    /**
     * Stores preview HTML code
     *
     * @var string
     */
    public $previewHtml = null;

}
