<?php

use App\Helpers\AppStatic;
use App\Http\Controllers\Admin\EducationCrudController;
use App\Http\Controllers\Admin\CompanyCrudController;
use App\Http\Controllers\Admin\JobCrudController;
use App\Http\Controllers\Admin\ContractCrudController;
use App\Http\Controllers\Admin\RythmCrudController;
use App\Http\Controllers\Admin\WorktypeCrudController;
use App\Http\Controllers\Admin\SchoolCrudController;
use App\Http\Controllers\Admin\UserCrudController;
use App\Http\Controllers\Admin\CandidateCrudController;
use App\Http\Controllers\Admin\RegionCrudController;
use App\Http\Controllers\Admin\CityCrudController;
use App\Http\Controllers\Admin\ApplicationCrudController;
use App\Http\Controllers\Admin\AssociationCrudController;
use App\Http\Controllers\Admin\CauseCrudController;
use App\Http\Controllers\Admin\MissionCrudController;

?>


@if (Auth::check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="http://placehold.it/160x160/00a65a/ffffff/&text={{ Auth::user()->lastname[0] ? Auth::user()->lastname[0] : 'user' }}" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>{{ Auth::user()->name }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="header">ACCUEIL</li>
          <!-- ================================================ -->
          <!-- ==== Recommended place for admin menu items ==== -->
          <!-- ================================================ -->
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>

            </li>

          <li class="header">UTILISATEURS</li>
            <li>
              <a href="{{ url(config('backpack.base.route_prefix', 'admin')).'/education' }}">
                <i class="fa fa-book"></i> <span>{{ AppStatic::mb_ucfirst(EducationCrudController::PLURAL_NAME) }}</span>
              </a>
            </li>
            <li>
              <a href="{{ url(config('backpack.base.route_prefix', 'admin')).'/school' }}">
                <i class="fa fa-home"></i> <span>{{ AppStatic::mb_ucfirst(SchoolCrudController::PLURAL_NAME) }}</span>
              </a>
            </li>
            <li>
              <a href="{{ url(config('backpack.base.route_prefix', 'admin')).'/user' }}">
                <i class="fa fa-user"></i> <span>{{ AppStatic::mb_ucfirst(UserCrudController::PLURAL_NAME) }}</span>
              </a>
            </li>
            <li>
              <a href="{{ url(config('backpack.base.route_prefix', 'admin')).'/candidate' }}">
                <i class="fa fa-graduation-cap"></i> <span>{{ AppStatic::mb_ucfirst(CandidateCrudController::PLURAL_NAME) }}</span>
              </a>
            </li>

          <!-- ======================================= -->
          <li class="header">NAVIGATION</li>
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/logout') }}"><i class="fa fa-sign-out"></i> <span>{{ trans('backpack::base.logout') }}</span></a></li>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
@endif
