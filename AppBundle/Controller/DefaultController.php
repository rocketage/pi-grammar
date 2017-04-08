<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @author Koen Vinken <vinkenkoen@gmail.com>
 */
class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Default:index.html.twig');
    }

    // https://pi.docker/app_dev.php/grammar/verb/the-present-simple/en
    // /app_mamp.php/grammar/verb/the-present-simple/es

    /**
     * @Route("/grammar/{section}/{topic}/{language}")
     */
    public function grammarAction($section, $topic, $language)
    {
        $path = sprintf('grammar/%s/%s', $section, $topic);

        $content = $this->get('grammar.content.topic.loader')->load($path, $language);

        return $this->render('AppBundle:Default:topic.html.twig', $content);
    }
}
