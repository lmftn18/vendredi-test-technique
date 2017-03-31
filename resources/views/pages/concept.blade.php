@extends('layouts/main')

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
            <h1 class="concept-headline-title text-center">Rendre la société plus belle. Du Lundi au Vendredi.</h1>
        </div>
        <div class="col-md-8 col-md-offset-2 text-center">
            <p class="concept-headline-subtitle text-center">Chez Vendredi, nous souhaitons permettre à chacun de
                s’engager pour la société dans son travail.</p>
        </div>


        <!-- VISION -->
        <div class="col-md-6 col-md-concept-vision block-vendredi">
            <div class="col-md-12" id="concept-vision">
                <h2>Notre vision</h2>
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img class="concept-finger" src="{{ elixir('/images/finger-icon.png')}}">
                    </div>
                    <div class="col-md-8">
                        Nous sommes chaque jour plus nombreux à vouloir nous engager.
                         
                        <div class="concept-vision-interline"></div>
                        Les projets qui rendent la société plus belle existent.
                        <div class="concept-vision-interline"></div>
                        Les entreprises ont conscience que le travail est à ré-enchanter.
                    </div>
                </div>
                <p class="concept-vision-under-finger">Et si nous commencions à y travailler ? </p>
                <strong>Vendredi,</strong>
                <br/>
                <strong>Parce que chaque jour compte.</strong>
            </div>
        </div>

        <!-- LE CONCEPT VENDREDI -->
        <div class="col-md-6 col-md-concept-concept block-vendredi" id="concept-concept">
            @include('pages/_concept-vendredi')
        </div>
        <div class="clearfix"></div>

        <div class="col-md-12 block-vendredi" id="concept-semaine-juliette">
            <h2 class="concept-semaine-juliette-title text-center">La semaine de Juliette</h2>

            <div class="row">
                <div class="col-md-6 col-md-offset-3 text-center">
                    <p class="concept-semaine-juliette-subtitle text-center">
                        Le concept de Vendredi expliqué en 3 minutes<br/>pour ceux qui ne croient que ce qu’ils voient…
                    </p>
                </div>

            </div>

            <div id="player-wrapper">
                <div id="player"></div>
            </div>
        </div>

        <div class="col-sm-12 block-vendredi" id="concept-plus">
            <p class="concept-plus-subtitle text-center">
                Envie d’en savoir un peu plus ?<br/>
                Découvre les histoires de Morgane, Robin, Hanaé…
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
      var width = $("#player-wrapper").width();
      player = new YT.Player('player', {
        height: 460 / 818 * width,
        width: width,
        videoId: 'SxmnKYDhxJo',
      });

    });
  }


</script>
@endpush
