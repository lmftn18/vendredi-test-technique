<!DOCTYPE html>
<html lang="en">
<head>
    <title>Vendredi - @yield('title')</title>
    @stack('meta')
    @include('layouts/head')
</head>
<body>

@if(!$disclaimerClosed)
    <div id="bandeauPrincipal" data-prevent
         class="alert alert-dismissible col-xs-12 bandeau-ssf-vendredi {{ !Route::currentRouteNamed('home') ? "navbar-fixed-top" : "" }}">

        <p class="text-center">Stagiaires Sans Frontières est devenu Vendredi ! <a target="_blank"
                                                                                   href="https://medium.com/p/2f72d3850d44">Nous
                t'expliquons tout ici.</a>
            <a id="closeBandeauPrincipal" href="javascript:void(0);" class="bandeau-close" aria-label="Close"><img
                        src="{{elixir('images/bandeau-close.png')}}" class="modal-close-icon" aria-hidden="true"></a>
        </p>
    </div>
    </div>
@endif


<nav id="mainNav"
     class="navbar {{ Route::currentRouteNamed('home') ?   "navbar-home navbar-inverse" : " navbar-default" }}
     {{ !$disclaimerClosed && ! Route::currentRouteNamed('home')?  'navbar-with-bandeau' : '' }}">
    <div class="container-fluid container-vendredi">
        <div class="navbar-header">
            <ul class="nav navbar-nav navbar-left">
                <li>
                    <a class="" href="{{ route('home') }}">
                        <img class="vendredi-logo hidden-sm hidden-xs"
                             alt="Logo vendredi"
                             src="{{ Route::currentRouteNamed('home') ?  elixir('images/vendredi-logo-white.png') : elixir('images/vendredi-logo-black.png') }}">

                        <img class="vendredi-logo hidden-md hidden-lg" alt="Logo vendredi"
                             src="{{ Route::currentRouteNamed('home') ?  elixir('images/v-logo-white.png') : elixir('images/v-logo-black.png') }}">
                    </a>
                </li>
            </ul>
        </div>

        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right ie11fix">

                <li class="header-main-links"><a href="#"></a></li>

                <li class="header-main-links hidden-lg-block"><a href="#"></a></li>

                <li class="header-main-links-help"><a href="{{ config('links.faq') }}" target="_blank">Aide</a></li>


                <li class="header-button-partenaire">

                    <p class="navbar-btn">
                        <a class="btn btn-sm {{  Route::currentRouteNamed('home') ? "btn-default" : "btn-warning"  }}"
                           href="{{ route('devenir-partenaire') }}">Devenir Partenaire</a>
                    </p>

                </li>

                <li>

                    <a id="accountLoggedIn" href="#userLogoutModal" data-toggle="modal"
                       class="{{ !$user ? 'hidden' : '' }}">
                        <img class="account-icon" alt="Login image" src="{{ elixir('images/account-icon-green.png')}}">
                    </a>

                    <a id="accountNotLoggedIn" href="#userConnectionModal" data-toggle="modal"
                       class="{{$user ? 'hidden' : '' }}">
                        <img class="account-icon" alt="Login image"
                             src="{{ Route::currentRouteNamed('home') ?  elixir('images/account-icon-white.png') : elixir('images/account-icon-black.png') }}">
                    </a>

                </li>

            </ul>
        </div><!-- /.navbar-collapse -->
    </div>
</nav>


@yield('hero')

<div class="container-fluid container-vendredi">
    <div class="row alert-container">
        <div class="col-md-6 col-md-offset-3 ">

            @if(Session::has('success'))
                @foreach(Session::get('success')->all() as $successMessage)
                    <div class="alert fade in alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        {{$successMessage}}
                    </div>
                @endforeach
            @endif

            @if(Session::has('errors'))
                @foreach(Session::get('errors')->all() as $errorMessage)
                    <div class="alert fade in alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        {{$errorMessage}}
                    </div>
                @endforeach
            @endif

        </div>
    </div>
    @yield('content')
</div>


<div class="container-fluid footer block-vendredi">
    <div class="row">
        <div class="col-md-3">
            <p class="footer-brand">
                <img class="vendredi-logo" alt="Logo vendredi" src="{{ elixir('images/vendredi-logo-black.png') }}">
                <br/>
                © Vendredi tous droits réservés 2017
            </p>

        </div>
        <div class="col-sm-2">
            <h6 class="footer-title">Candidats</h6>
            <ul class="footer-list">

                <li><a href="#userConnectionModal" data-toggle="modal">Se connecter</a></li>

            </ul>
        </div>

        <div class="col-sm-2">
            <h6 class="footer-title">A Propos</h6>
            <ul class="footer-list">
                <li><a href="{{ config('links.faq') }}" target="_blank">Aide</a></li>
                <li><a href="{{ route('concept') }}">Concept</a></li>
                <li><a target="_blank" href="{{ config('links.medium') }}">Témoignages</a></li>
            </ul>
        </div>

        <div class="col-sm-2">
            <h6 class="footer-title">Nous connaitre</h6>
            <ul class="footer-list">
                <li><a href="{{ route('devenir-partenaire') }}">Devenir Partenaire</a></li>
                <li><a href="{{ route('equipe') }}">Équipe <em>(Nous recrutons!)</em></a></li>
                <li><a href="http://documents.vendredi.cc/9en9a6B" target="_blank">Presse</a></li>
            </ul>
        </div>

        <div class="col-sm-3 footer-social-media">
            <h6 class="footer-title">Nous suivre sur les réseaux</h6>
            <ul class="footer-list footer-social-media">
                @include('/layouts/socialmedia-list-black')
            </ul>
        </div>
    </div>
</div>
@include('/users/_modal-inscription')
@include('/users/_modal-connection')
@include('/users/_modal-forgotten-password')
@include('/users/_modal-mon-compte')


@push('scripts')
<script type="text/javascript">
  // Helper for the Linkedin buttons
  window.updateLinkedinButtonsWithAppropriateLink = function (redirect_url) {

    var linkedinLink = new Url("{!!$linkedinUrl!!}");
    linkedinLink.query.current_page = encodeURIComponent(redirect_url);
    $(".btn-linkedin").prop('href', linkedinLink.toString());

    var loginLink = new Url("{!! URL::route('candidate_login') !!}");
    loginLink.query.current_page = redirect_url;
    $("#candidateLoginForm").prop('action', loginLink.toString());

    var registerLink = new Url("{!! URL::route('candidate_register') !!}");
    registerLink.query.current_page = redirect_url;
    $("#userInscriptionForm").prop('action', registerLink.toString());

    if(redirect_url == "") {
      $(".btn-linkedin").attr('target', '_self');
    } else {
      $(".btn-linkedin").attr('target', '_blank');
    }

  }

  $(document).ready(function () {
    $("#accountNotLoggedIn").click(function () {
      updateLinkedinButtonsWithAppropriateLink("");
    });

    $("#forgottenPasswordLink").click(function () {
      $("#userConnectionModal").modal('hide');

      $("#userConnectionModal").on('hidden.bs.modal', function () {
        $("#userForgottenPasswordModal").modal('show');
        $("#userConnectionModal").off('hidden.bs.modal');
      });
    });

    $("#userInscriptionLink").click(function () {

      $("#userConnectionModal").modal('hide');

      $("#userConnectionModal").on('hidden.bs.modal', function () {
        $("#userInscriptionModal").modal('show');
        $("#userConnectionModal").off('hidden.bs.modal');
      });
    });

    $("#userConnectionLink").click(function () {
      $("#userInscriptionModal").modal('hide');

      $("#userInscriptionModal").on('hidden.bs.modal', function () {
        $("#userConnectionModal").modal('show');
        $("#userInscriptionModal").off('hidden.bs.modal');
      });
    });
  });
</script>
@endpush

<script type="text/javascript" src="{{ elixir('js/app.js') }}"></script>
<script>
  window.Laravel = <?php echo json_encode([
      'csrfToken' => csrf_token(),
    ]); ?>
</script>
<!-- Dump blade "inline"-javascripts -->
@stack('scripts')
@include('users/intercom')
</body>
</html>
