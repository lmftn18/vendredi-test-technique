<?php
/**
 * Created by PhpStorm.
 * User: jguerin
 * Date: 24/01/17
 * Time: 16:48
 */

namespace App\Transformers;


use App\School;
use League\Fractal\TransformerAbstract;

class SchoolTransformer extends TransformerAbstract
{
  public function transform(School $school){
    return [
      'id' => $school->id,
      'value' => $school->value
    ];
  }
}