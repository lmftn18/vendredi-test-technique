<?php

namespace App\Http\Controllers;

use App\Association;
use App\Job;
use App\Transformers\AssociationTransformer;
use Illuminate\Http\Request;
use App\Transformers\JobTransformer;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;

class PageController extends Controller
{
    /**
     * Render the home page
     */
    protected function home()
    {
        return response()->responsiveView( 'pages/home' );
    }


    /**
     * Render the concept page
     */
    protected function concept()
    {
        return response()->responsiveView( 'pages/concept' );
    }

    /**
     * Render the partners page
     */
    protected function devenirPartenaire()
    {
        return response()->responsiveView( 'pages/partenaire' );
    }

    /**
     * Render the equipe page
     */
    protected function equipe()
    {
        return response()->responsiveView( 'pages/equipe' );
    }

    /**
     * Render the design page
     */
    protected function design()
    {
        return response()->responsiveView( 'design' );
    }
}
