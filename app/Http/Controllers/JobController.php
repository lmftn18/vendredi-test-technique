<?php

namespace App\Http\Controllers;


use App\Application;
use App\Http\Middleware\CheckRole;
use App\Job;
use App\Transformers\JobTransformer;
use Helpers\AppHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;

class JobController extends Controller
{
    private $defaultPageSize = 6;
    
    /**
     * Search the job list with multiple criteria.
     *
     * @return Response
     */
    public function search( Request $request )
    {
        // create base query with all required joins
        $query = \DB::table( 'jobs' )
          ->leftJoin( 'worktypes', 'jobs.worktype_id', '=', 'worktypes.id' )
          ->leftJoin( 'contracts', 'jobs.contract_id', '=', 'contracts.id' )
          ->leftJoin( 'cities', 'jobs.city_id', '=', 'cities.id' )
          ->leftJoin( 'regions', 'cities.region_id', '=', 'regions.id' )
          ->leftJoin( 'departments', 'cities.department_id', '=', 'departments.id' )
          ->leftJoin( 'companies', 'jobs.company_id', '=', 'companies.id' )
          ->whereNotNull( 'jobs.published_at' );
        
        \AppHelper::addJoinFilterIdsToQuery( $query, 'worktypes', Input::get( 'worktypes', [] ) );
        \AppHelper::addJoinFilterIdsToQuery( $query, 'contracts', Input::get( 'contracts', [] ) );
        \AppHelper::addJoinFilterIdsToQuery( $query, 'regions', Input::get( 'regions', [] ) );
        
        $toSearchFields = [
          'jobs.title',
          'jobs.description',
          'cities.value',
          'departments.value',
          'regions.value',
          'contracts.value',
          'worktypes.value',
          'companies.name',
        ];
        \AppHelper::addSearchToQuery( $query, $toSearchFields, Input::get( 'search', null ) );
        
        $countQuery = clone $query;
        $count = $countQuery->select( \DB::raw( 'count(distinct jobs.*)' ) )
          ->first()
          ->count;
        
        $pageSize = (int)Input::get( 'page_size', $this->defaultPageSize );
        $pageIndex = (int)Input::get( 'page', 1 );
        $jobs = Job::hydrate(
          $query->select( 'jobs.*' )
            ->orderBy( 'jobs.order' )
            ->orderBy( 'jobs.updated_at', 'desc' )
            ->orderBy( 'jobs.title' )
            ->limit( $pageSize )
            ->offset( $pageSize * ($pageIndex - 1) )
            ->distinct()
            ->get()
            ->toArray()
        );
        
        $paginatedJobsArray = $this->getPaginatedJobsArray( $jobs, $count );
        
        return response()->json( $paginatedJobsArray );
    }
    
    /**
     * Get all results, paginates them and creates the structured array to return the user.
     *
     * @param Job[] $jobs
     * @param                                    $count
     *
     * @return array
     */
    private function getPaginatedJobsArray( $jobs, $count )
    {
        // for complex queries we need to create a custom paginator
        $paginator = new LengthAwarePaginator(
          $jobs,
          $count,
          Input::get( 'page_size', $this->defaultPageSize ),
          Input::get( 'page', '1' ),
          [
            'path' => \Request::url(),
            'query' => \Request::query(),
          ]
        );
        
        $resource = new Collection( $paginator->getCollection(), new JobTransformer() );
        $paginatorAdapter = new IlluminatePaginatorAdapter( $paginator );
        $resource->setPaginator( $paginatorAdapter );
        
        $manager = new Manager();
        
        return $manager->createData( $resource )->toArray();
    }
    
    /**
     * Register a candidate application and redirect him to the offer link.
     *
     * @return Response
     */
    public function apply( $id )
    {
        // sanity check: we have a candidate
        if (\Auth::check() === false || \Auth::user()->hasRole( 'candidate' ) === false) {
            abort( 403, CheckRole::BAD_ROLE_ERROR );
        }
        
        $candidate = \Auth::user()->candidate;
        $job = Job::findOrFail( $id );
        
        $application = Application::firstOrNew( [
          'candidate_id' => $candidate->id,
          'job_id' => $job->id,
        ] );
        $application->timestamp = new \DateTime();
        $application->save();
        
        $results = [];
        // If it's a PDF we display within Vendredi website
        
        if (!\AppHelper::isExternalLink($job->url)) {
            return response()->view( 'entreprises/visualize', [
              'job' => $job,
              'iframe_url' => \AppHelper::getPdfPreviewLink($job->url)
            ] );
        }else {
            return redirect()->to( $job->url );
        }
        
    }
    
}