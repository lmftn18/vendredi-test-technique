<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({'gtm.start': new Date().getTime(), event: 'gtm.js'});
        var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
      })(window, document, 'script', 'dataLayer', 'GTM-PFXD8N9');</script> <!-- End Google Tag Manager -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Vendredi - @yield('title')</title>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png" />
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900"/>
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
    <link rel="stylesheet" href="{{ elixir('css/font-awesome.min.css') }}">
    @stack('meta')

    <script>(function () {
        var w = window;
        var ic = w.Intercom;
        if (typeof ic === "function") {
          ic('reattach_activator');
          ic('update', intercomSettings);
        } else {
          var d = document;
          var i = function () {
            i.c(arguments)
          };
          i.q = [];
          i.c = function (args) {
            i.q.push(args)
          };
          w.Intercom = i;
          function l() {
            var s = d.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = 'https://widget.intercom.io/widget/ue12udqa';
            var x = d.getElementsByTagName('script')[0];
            x.parentNode.insertBefore(s, x);
          }

          if (w.attachEvent) {
            w.attachEvent('onload', l);
          } else {
            w.addEventListener('load', l, false);
          }
        }
      })()</script>
</head>
<body>

<?php
$lightNavbar = false;
?>
<nav class="navbar navbar-mobile {{  Route::currentRouteNamed('home')  ?   "" : "navbar-fixed-top" }} {{  Route::currentRouteNamed('home')  ?   "navbar-home" : ( $lightNavbar ?   "navbar-mobile-light" : "navbar-mobile-dark"  ) }}">
    <div class="container-fluid container-vendredi">
        <div class="navbar-header">
            <a class="navbar-toggle collapsed" data-toggle="collapse" href="#collapseMenu" aria-expanded="false">
            </a>
            <ul class="nav navbar-nav navbar-left navbar-nav-logo">
                <li>
                    <a class="" href="{{ route('home') }}">
                        <img class="vendredi-logo" alt="Logo vendredi"
                             src="{{ (Route::currentRouteNamed('home') || $lightNavbar) ?  elixir('images/vendredi-logo-black-small.png') : elixir('images/vendredi-logo-white-small.png') }}">
                    </a>
                </li>
            </ul>
        </div>

        <div class="collapse navbar-collapse" id="collapseMenu">
            <ul class="nav navbar-nav">
                <li><a href="{{ config('links.faq') }}" target="_blank">Aide</a></li>
                <li><a href="{{ route('concept') }}">Concept</a></li>
                <li><a href="{{ route('equipe') }}">Équipe</a></li>
                <li><a href="{{ route('devenir-partenaire') }}">Devenir partenaire</a></li>
                <li><a href="{{ config('links.medium') }}" target="_blank">Témoignages</a></li>


            </ul>
        </div><!-- /.navbar-collapse -->
    </div>
</nav>

@yield('hero')

<div class="container-fluid container-vendredi container-vendredi-mobile">
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
                    <div class="alert fade in alert-danger alert-dismissible" role="alert">
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
        <div class="col-xs-12 footer-social-media">
            <h6 class="footer-title text-center">Nous suivre sur les réseaux</h6>
            <ul class="footer-list text-center footer-social-media">
                @include('/layouts/socialmedia-list-black')
            </ul>
        </div>
        <div class="col-xs-12">
            <p class="footer-brand footer-brand-mobile text-center">
                <img class="vendredi-logo" alt="Logo vendredi" src="{{ elixir('images/vendredi-logo-black.png') }}">
                <br/>
                © Vendredi tous droits réservés 2016
            </p>

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
  };

  $(document).ready(function () {
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
