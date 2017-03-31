<?php

namespace App\Http\Controllers;


use App\Application;
use App\Association;
use App\Http\Middleware\CheckRole;
use App\Job;
use App\Transformers\AssociationTransformer;
use App\Transformers\JobTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Input;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;

class AssociationController extends Controller
{
    private $defaultPageSize = 4;

    /**
     * Search the job list with multiple criteria.
     *
     * @return Response
     */
    public function search( Request $request )
    {
        // create base query with all required joins
        $query = \DB::table( 'associations' )
                    ->leftJoin( 'missions', 'associations.id', '=', 'missions.association_id' )
                    ->leftJoin( 'regions', 'associations.region_id', '=', 'regions.id' )
                    ->leftJoin( 'association_cause', 'association_cause.association_id', '=', 'associations.id' )
                    ->leftJoin( 'causes', 'association_cause.cause_id', '=', 'causes.id' )
                    ->leftJoin( 'worktypes', 'missions.worktype_id', '=', 'worktypes.id' )
                    ->whereNotNull( 'associations.published_at' );

        \AppHelper::addJoinFilterIdsToQuery( $query, 'causes', Input::get( 'causes', [] ) );
        \AppHelper::addJoinFilterIdsToQuery( $query, 'worktypes', Input::get( 'worktypes', [] ) );
        \AppHelper::addJoinFilterIdsToQuery( $query, 'regions', Input::get( 'regions', [] ) );

        $toSearchFields = [
            'missions.title',
            'associations.name',
            'associations.tagline',
            'associations.description',
            'regions.value',
            'causes.value',
            'worktypes.value',
        ];
        \AppHelper::addSearchToQuery( $query, $toSearchFields, Input::get( 'search', null ) );

        $countQuery = clone $query;
        $count = $countQuery->select( \DB::raw( 'count(distinct associations.*)' ) )
                            ->first()
            ->count;

        $pageSize = (int) Input::get( 'page_size', $this->defaultPageSize );
        $pageIndex = (int) Input::get( 'page', 1 );
        $associations = Association::hydrate(
            $query->select( 'associations.*' )
                  ->orderBy( 'associations.order' )
                  ->orderBy( 'associations.updated_at', 'desc' )
                  ->orderBy( 'associations.name' )
                  ->limit( $pageSize )
                  ->offset( $pageSize * ( $pageIndex - 1 ) )
                  ->distinct()
                  ->get()
                  ->toArray()
        );

        $paginatedJobsArray = $this->getPaginatedAssociationsArray( $associations, $count );

        return response()->json( $paginatedJobsArray );
    }

    /**
     * Get all results, paginates them and creates the structured array to return the user.
     *
     * @param Association[] $associations
     * @param int           $count
     *
     * @return array
     */
    private function getPaginatedAssociationsArray( $associations, $count )
    {
        // for complex queries we need to create a custom paginator
        $paginator = new LengthAwarePaginator(
            $associations,
            $count,
            Input::get( 'page_size', $this->defaultPageSize ),
            Input::get( 'page', '1' ),
            [
                'path'  => \Request::url(),
                'query' => \Request::query(),
            ]
        );

        $resource = new Collection( $paginator->getCollection(), new AssociationTransformer() );
        $paginatorAdapter = new IlluminatePaginatorAdapter( $paginator );
        $resource->setPaginator( $paginatorAdapter );

        $manager = new Manager();

        return $manager->createData( $resource )->toArray();
    }
}