@extends('layouts/main')

@push('meta')
<meta name="description"
      content="Vendredi propose des stages partagés entre entreprise et association. Faire un Vendredi, c'est travailler 4 jours par semaine en entreprise, 1 jour par semaine en association."/>
@endpush

@section('title')
    Chaque jour compte
@endsection

@section('hero')
    <div id="hero">
        <img id="hero-lundi" src="/images/hero-lundi.jpg" class="hero-bg in">
        <img id="hero-mardi" src="/images/hero-mardi.jpg" class="hero-bg hidden">
        <img id="hero-mercredi" src="/images/hero-mercredi.jpg" class="hero-bg hidden">
        <img id="hero-jeudi" src="/images/hero-jeudi.jpg" class="hero-bg hidden">
        <img id="hero-vendredi" src="/images/hero-vendredi.jpg" class="hero-bg hidden">
        <div class="container container-vendredi hero-text">
            <div class="row">
                <div class="col-sm-offset-1 col-sm-10">
                    <h1 class="hero-title">
                        Un stage unique <br/>
                        pour ton avenir

                    </h1>
                    <p class="hero-subtitle">
                        Découvre toutes nos offres de stages <br/>
                        partagés entre entreprise et association</p>
                    <p class="hero-buttons">
                        <a href="#offres-anchor" class="btn btn-sm btn-default voir-les-offres">Voir les offres</a>
                    </p>
                    <p class="hero-slider">
                        <span id="selector-lundi" class="full-circle"></span>
                        <span id="selector-mardi" class="empty-circle"></span>
                        <span id="selector-mercredi" class="empty-circle"></span>
                        <span id="selector-jeudi" class="empty-circle"></span>
                        <span id="selector-vendredi" class="empty-circle"></span>
                        <span id="slider-day">Lundi</span>
                    </p>
                    @push('scripts')
                    <script type="text/javascript">

                      var animating = false;
                      var daysToAnimate = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi'];
                      function capitalizeFirstLetter(string) {
                        return string.charAt(0).toUpperCase() + string.slice(1);
                      }

                      var slideIn = function (day) {

                        var slider = $(".hero-slider");
                        // Update the selector
                        slider.find('> .full-circle').attr('class', 'empty-circle');
                        $("#selector-" + day).attr('class', 'full-circle');
                        $("#slider-day").html(capitalizeFirstLetter(day));

                        // Hide all except the last one (with slide-in or .in if it the first load of the page)
                        $(".hero-bg:not(.slide-in, .in)").addClass('hidden');
                        // The last one because the "normal one"
                        $(".hero-bg.slide-in, .hero-bg.in").removeClass('slide-in in');
                        $("#hero-" + day).removeClass('hidden').addClass('slide-in');
                      };


                      var autoplay = setInterval(function () {
                        // find current day
                        var currentDay = $('.hero-bg.slide-in, .hero-bg.in').attr('id').slice(5);
                        var nextDay = daysToAnimate[(daysToAnimate.indexOf(currentDay) + 1  ) % daysToAnimate.length]
                        slideIn(nextDay);
                      }, 5000);
                      $(document).ready(function () {
                        daysToAnimate.forEach(function (day) {
                          $("#selector-" + day).click(function () {
                            clearInterval(autoplay);
                            slideIn(day);
                          });
                        });

                      });


                    </script>
                    @endpush
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script type="text/javascript">
      $(document).ready(function () {
        // Smooth scroll to the job panel
        $(".voir-les-offres").click(function (e) {
          e.preventDefault();
          var offset = $("#offres-anchor").offset();
          offset.top -= 20;
          $('html, body').animate({
            scrollTop: offset.top,
          }, 800);
        });
      });
    </script>
    @endpush

@endsection

@section('content')
    <div class="row">

        <div class="col-sm-12 col-md-5 block-vendredi">
            @include('pages/_concept-vendredi')
        </div>

        <div class="col-sm-12 col-md-7 block-vendredi">

            <div class="col-sm-12" id="home-semaine">
                <h1 id="home-semaine-title">Ils ont vécu un Vendredi</h1>
                <img id="morgane" alt="Photo jeune femme souriante"
                     src="{{  elixir('images/sei-decoupage.png') }}">
                <p class="home-semaine-subtitle">4 stagiaires t'expliquent<br/>pourquoi te lancer !</p>
                <button onclick="$('#semaineVecu').modal('show');" class="btn btn-sm btn-default home-semaine-button">
                    Découvrir
                </button>
            </div>
        </div>

        <div class="col-sm-12 block-vendredi">
            <div id="home-newsletter" class="col-sm-12">
                <div class="row ">
                    <div class="col-md-5 col-sm-12">
                        <h2>S’inscrire à notre Newsletter</h2>
                        <p class="home-newsletter-subtitle">Pour ne rater aucune offre, et recevoir des nouvelles qui
                            rendent la société plus belle.</p>
                    </div>


                    <!-- Begin MailChimp Signup Form -->
                    <div id="mc_embed_signup" class="col-md-7 col-sm-12">
                        <form action="//vendredi.us10.list-manage.com/subscribe/post?u=1f8f5993c0d281efccc14ebdd&amp;id=aff4f95ac5"
                              method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form"
                              class="form-inline form-newsletter validate" target="_blank" novalidate>

                            <input type="text" value="" name="MMERGE5"
                                   class="form-control input-sm home-newsletter-prenom" placeholder="Prénom"
                                   id="mce-MMERGE5">
                            <input type="text" value="" name="MMERGE4" class="form-control input-sm home-newsletter-nom"
                                   placeholder="Nom" id="mce-MMERGE4">
                            <input type="email" value="" name="EMAIL"
                                   class="required email form-control input-sm home-newsletter-email"
                                   placeholder="Email" id="mce-EMAIL">

                            <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                            <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text"
                                                                                                      name="b_1f8f5993c0d281efccc14ebdd_aff4f95ac5"
                                                                                                      tabindex="-1"
                                                                                                      value=""></div>


                            <input type="submit" id="mc-embedded-subscribe"
                                   class="btn btn-sm btn-warning home-newsletter-button" value="S'inscrire">


                        </form>
                    </div>

                    <!--End mc_embed_signup-->

                </div>
            </div>
        </div>


    </div>
    @include('/pages/_modal-vecu-vendredi')
@endsection

@push('scripts')

<script type="text/javascript">
  $(document).ready(function () {

    $('#home-semaine, #home-concept').matchHeight({property: 'height'});

    $("#selectorEntreprise a").click(function () {
      $("#home-offres").removeClass('background-asso');
    });

    $("#selectorAsso a").click(function () {
      $("#home-offres").addClass('background-asso');
    });

    $("#seeAllAsso").on('mouseenter', function () {
      $("#seeAllAsso").text('Bientôt disponible !');
    });
    $("#seeAllAsso").on('mouseleave', function () {
      $("#seeAllAsso").text('Voir toutes les assos');
    });
    $("#seeAllAsso").on('click', function (e) {
      e.preventDefault();
    });
  });
</script>
@endpush