<?php
/**
 * Created by PhpStorm.
 * User: jguerin
 * Date: 24/01/17
 * Time: 16:46
 */

namespace App\Http\Controllers;


use App\School;
use App\Transformers\SchoolTransformer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\DataArraySerializer;

class SchoolController extends Controller
{
    
    private $defaultSchool = "Autre université à l'étranger";
    
    public function search(Request $request)
    {
        
        $query = School::query();
        
        $search = $request->input('search', null);
        
        if ($search !== null) {
            // tokenize
            $searchTokens = preg_split('~\s+~', $search);
            
            // apply filter for each token
            foreach ($searchTokens as $searchToken) {
                $likeToken = '%' . $searchToken . '%';
                $query->where('value', '!=', $this->defaultSchool);
                $query->where(function (Builder $query) use ($likeToken) {
                    $query->orWhere(
                      \DB::raw("unaccent(value)"),
                      'ilike',
                      \DB::raw("unaccent(" . \DB::getPdo()->quote($likeToken) . ")")
                    );
                });
            }
        }
        
        $schools = $query->take(10)->get();
        
        if ($schools->count() == 0) {
            //  default generic school => "Autre université à l'étranger"
            $defaultSchool = School::firstOrCreate(['value' => $this->defaultSchool]);
            $schools = new \Illuminate\Database\Eloquent\Collection();
            $schools->add($defaultSchool);
        }
        $schoolResource = new Collection($schools, new SchoolTransformer());
        
        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());
        
        return response()->json(
          $manager->createData($schoolResource)->toArray()
        );
    }
    
}