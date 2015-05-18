<?php

namespace Gomeeki\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HistoryController extends Controller
{
    public function indexAction()
    {
        $this->get('session')->start();
        return $this->render('GomeekiCoreBundle:Front:history.html.twig');
    }

    public function partialHistoryListAction()
    {
        $historyList = $this->get('history_manager')->findBy(array('sessionId' => $this->get('session')->getId()));
        return $this->render('GomeekiCoreBundle:Front:_historyPartial.html.twig', array('historyList' => $historyList));
    }
}
