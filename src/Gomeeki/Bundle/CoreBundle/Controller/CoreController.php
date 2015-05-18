<?php

namespace Gomeeki\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{
    public function indexAction()
    {
        // init session
        $session = $this->get('session');
        $session->start();

        // By default we load the search page on Bangkok
        return $this->redirect($this->generateUrl('gomeeki_core_search_location', array('locationName' => 'Bangkok')));
    }
}
