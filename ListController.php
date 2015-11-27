<?php

namespace Workshop\StartBundle\Controller\ThemeBlock;

use LooopCore\FrameworkBundle\Controller\BaseAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Workshop\StartBundle\Entity\ThemeBlock;

use APY\DataGridBundle\Grid\Source\Entity;

class ListController extends BaseAction {

    public function runAction(Request $request) {

        $themeBlocks = ThemeBlock::getRepository()->findAll();

        return $this->renderDefaultView(
            ["themeBlocks"=>$themeBlocks]
        );
    }

    public function runGridAction(Request $request) 
    {        
        $grid = $this->get('grid');   
        $grid->setId('grid1');
        $source = new Entity('WorkshopStartBundle:ThemeBlock');
        $grid->setSource($source);
        $isReadyForRedirect = $grid->isReadyForRedirect();        
        if ($isReadyForRedirect) {            
            return new RedirectResponse($grid->getRouteUrl());
        } else {
            echo "new";
            var_dump($grid->getRouteUrl());
            $parameters['grid'] = $grid;        
            return $this->render('WorkshopStartBundle:ThemeBlock:indexGrid.html.twig',
                            $parameters);
        }          
        
        // A view with nested views must check before if there is a redirection needed
        // To these purpose the parent view should keep a list of child views
        // For Grid Child Views must be checked if a redirection is required and then the corresponding response object should be returned...
        // These checking should be invoked by a special method of initialization of a View (for example prepareView())
        // If a redirect response object is returned by these method, then such object should be returned
        
        // Create a new ComposedViewBuilder class to handle composed builders. The class should maintain 
        // the list of views to be mantained and notified when a response object is needed. However, every ViewBuilder should have a 
        // method to return its own response object instead of letting the controller to create a response.
        
        // Consider also for the new view type an option to group the subordinated views in tabs
        
        //return $grid->getGridResponse('WorkshopStartBundle:ThemeBlock:indexGrid.html.twig', 
        //                              $response);
    }
}
