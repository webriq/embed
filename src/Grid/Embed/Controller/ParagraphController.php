<?php

namespace Grid\Embed\Controller;

use Grid\Embed\Model\Parser;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

/**
 * Embed paragraph controller
 *
 * @author Kristof Matos <kristof.matos@megaweb.hu>
 */
class ParagraphController extends AbstractActionController
{
    /**
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function loadAction()
    {
        $translator = $this->getServiceLocator()->get('translator');

        $url       = $this->params()->fromQuery('url');
        $maxwidth  = $this->params()->fromQuery('maxwidth');
        $maxheight = $this->params()->fromQuery('maxheight');

        $parser = new Parser($this->getServiceLocator());

        $parser->extractUrl($url,array('maxwidth'=>$maxwidth,
                                  'maxheight'=>$maxheight));

        $error = (string) $parser->getError();

        return new JsonModel( array(
            'embedHtml' => $parser->getEmbedHtml(),
            'previewHtml' => $parser->getPreviewHtml(),
            'error' => (empty($error)
                       ? ''
                       : $translator->translate($error,'embed'))
        ));


    }
}
