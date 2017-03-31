<!--
  DESIGN Page

  Show case the main design components
  
-->


@extends('layouts/main')

@section('title')
Design Elements
@endsection

@section('content')
<div class="row">

  <div class="col-md-6 col-sm-12">
  <h2> Buttons </h2>
  <p>
    <button class="btn btn-primary btn-lg">Large button</button>
    <button class="btn btn-primary ">Base button</button>
    <button class="btn btn-primary btn-sm">Small button</button>
  </p>
 
  <p>
    <button class="btn btn-info btn-lg">Large button</button>
    <button class="btn btn-info ">Base button</button>
    <button class="btn btn-info btn-sm">Small button</button>
  </p>
  
  <p>
    <button class="btn btn-success btn-lg">Large button</button>
    <button class="btn btn-success ">Base button</button>
    <button class="btn btn-success btn-sm">Small button</button>
  </p>
  <p>
    <button class="btn btn-warning btn-lg">Large button</button>
    <button class="btn btn-warning ">Base button</button>
    <button class="btn btn-warning btn-sm">Small button</button>
  </p>

  <p>
    <button class="btn btn-danger btn-lg">Large button</button>
    <button class="btn btn-danger ">Base button</button>
    <button class="btn btn-danger btn-sm">Small button</button>
  </p>
  </div>

  <div class="col-sm-12 col-md-6">
    <h2>Inputs</h2>

    <div class="form-group row">
      <div class="col-sm-6">
      <input class="form-control" placeholder="Base Input..." />
      </div>
    </div>
  
    <div class="form-group row">
      <div class="col-sm-6">
      <input class="form-control input-sm" placeholder=" Small Input..." />
      </div>
    </div>

    <div class="form-group row background-serenade">
      <div class="col-sm-4">
        <select class="form-control ">
          <option value="" disabled selected>Options</option>
          <option> Option 1</option>
          <option> Option 2</option>
        </select>
      </div>

      <div class="col-sm-4">
        <select class="form-control active">
          <option value="" disabled selected>Options</option>
          <option> Option 1</option>
          <option> Option 2</option>
        </select>
      </div>
    </div>

    <div class="form-group row background-serenade">
      <div class="col-sm-3">
        <select class="form-control input-sm">
          <option value="" disabled selected>Options</option>
          <option> Option 1</option>
          <option> Option 2</option>
        </select>
      </div>

      <div class="col-sm-3">
        <select class="form-control input-sm active">
          <option value="" disabled selected>Options</option>
          <option> Option 1</option>
          <option> Option 2</option>
        </select>
      </div>
    </div>
    </form>
  </div>
</div>
<div class="row">
  <div class="col-sm-12 col-md-6 background-serenade" style="min-height: 400px;">
    <h2>Dropdowns</h2>
    <div class="example-dropdown">
      <div class="dropdown">
        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
          Dropdown closed
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-vendredi" aria-labelledby="dropdownMenu1">
          <li><a href="#">Action</a></li>
          <li><a href="#">Another action</a></li>
          <li class="active"><a href="#">Something else here</a></li>
          <li role="separator" class="divider"></li>
          <li><a href="#">Separated link</a></li>
        </ul>
      </div>

      <div class="dropdown open">
        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
          Dropdown opened
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-vendredi" aria-labelledby="dropdownMenu1">
          <li><a href="#">Action</a></li>
          <li><a href="#">Another action</a></li>
          <li class="active"><a href="#">Something else here</a></li>
          <li role="separator" class="divider"></li>
          <li><a href="#">Separated link</a></li>
        </ul>
      </div>

      <div class="dropdown open">
        <button class="btn btn-sm btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
          Dropdown opened
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-vendredi" aria-labelledby="dropdownMenu1">
          <li><a href="#">Action</a></li>
          <li><a href="#">Another action</a></li>
          <li class="active"><a href="#">Something else here</a></li>
          <li role="separator" class="divider"></li>
          <li><a href="#">Separated link</a></li>
        </ul>
      </div>
    </div>

  </div>

  <div class="col-sm-12 col-md-6 " style="min-height: 400px;">
    <h2>Tabs</h2>
    <ul class="nav nav-pills">
      <li role="presentation" class="active"><a href="#">Home</a></li>
      <li role="presentation"><a href="#">Profile</a></li>
      <li role="presentation"><a href="#">Messages</a></li>
    </ul>
  </div>

  <div class="col-sm-12 col-md-6" style="min-height: 400px;">
    <h2>Pagination</h2>
    <nav aria-label="Page navigation" class="background-serenade">
      <ul class="pagination">
        
        <li class="active"><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">5</a></li>
        
      </ul>
    </nav>

    <nav aria-label="Page navigation" class="background-zircon">
      <ul class="pagination">
        <li class="active"><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">5</a></li>
        </ul>
    </nav>
  </div>

  <div class="col-sm-12 col-md-6 background-serenade" style="min-height: 400px;">
    <h2>Labels / Tags</h2>
    <p>
        <span class="label label-cause">Inclusion & Lien social</span>
        <span class="label label-job">Stage - 6 mois</span>
    </p>
  </div>
</div>



@endsection