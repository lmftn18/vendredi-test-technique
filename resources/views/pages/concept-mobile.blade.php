@extends('layouts/main-mobile')


@push('meta')
<meta name="description"
      content="Faire un Vendredi, c’est partager son temps de travail entre entreprise et association. Découvre ici notre concept et notre mission."/>
@endpush

@section('title')
    Concept
@endsection

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1 text-center">
            <h1 class="concept-mobile-headline-title text-center">
                Un Vendredi<br/>
                pas comme les autres !</h1>
        </div>
        <div class="col-md-8 col-md-offset-2 text-center">
            <p class="concept-mobile-headline-subtitle text-center">Chez Vendredi, nous voulons offrir à tous les
                individus qui le souhaitent la possibilité de s’engager pour la société dans son travail.</p>
        </div>


        <!-- VISION -->
        <div class="col-xs-12 block-vendredi-mobile">
            <div class="col-md-12" id="concept-vision-mobile">

                <div class="row">
                    <div class="col-xs-12 text-center">
                        <img class="concept-finger-mobile" src="{{ elixir('/images/finger-icon-mobile.png')}}">
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-8 concept-vision-title-mobile">
                        <h2>Notre vision</h2>
                        Nous sommes de plus en plus nombreux à vouloir nous engager
                        et les projets qui rendent la France plus belle fleurissent.
                        <br><br>
                        Et si nous commencions à y travailler ?
                        <br><br>
                        <strong>Vendredi,</strong>
                        <br/>
                        <strong>Parce que chaque jour compte.</strong>
                    </div>

                </div>
            </div>

            <!-- LE CONCEPT VENDREDI -->
            <div class="col-xs-12 block-vendredi-mobile" id="concept-concept-mobile">
                <div class="row">
                    @include('pages/_concept-vendredi')
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-md-12 block-vendredi-mobile" id="concept-semaine-juliette">
                <h2 class="concept-semaine-mobile-juliette-title text-center">La semaine de Juliette</h2>

                <div class="row">
                    <div class="col-md-6 col-md-offset-3 text-center">
                        <p class="concept-semaine-mobile-juliette-subtitle text-center">
                            Le concept de Vendredi expliqué en 3 minutes pour ceux qui ne croient que ce qu’ils voient…
                        </p>
                    </div>

                </div>

                <div id="player-wrapper-mobile">
                    <div id="player"></div>
                </div>
            </div>

            <div class="col-sm-12 block-vendredi" id="concept-plus">
                <p class="concept-plus-mobile-subtitle text-center">
                    Envie d’en savoir un peu plus ?<br/>
                    Découvrez les histoires de Morgane, Robin, Hanaé…
                </p>

                <a href="{{config('links.medium')}}" target="_blank" class="btn btn-block btn-warning concept-plus-btn">Lire
                    leurs témoignages<a>
            </div>
        </div>


        @endsection

        @push('scripts')
        <script type="text/javascript">
          $(document).ready(function () {
            $('#concept-vision, #home-concept ').matchHeight({property: 'height'});
          });

          // This code loads the IFrame Player API code asynchronously.
          var tag = document.createElement('script');

          tag.src = "https://www.youtube.com/iframe_api";
          var firstScriptTag = document.getElementsByTagName('script')[0];
          firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
          var player;

          // 3. This function creates an <iframe> (and YouTube player)
          //    after the API code downloads and once the width can be computed
          function onYouTubeIframeAPIReady() {
            $(document).ready(function () {
              var width = $("#player-wrapper-mobile").width();
              $("#concept-plus").css('margin-top', (460 / 818 * width + 40 ) + 'px');
              player = new YT.Player('player', {
                height: 460 / 818 * width,
                width: width,
                videoId: 'SxmnKYDhxJo',
              });

            });
          }


        </script>
    @endpush
