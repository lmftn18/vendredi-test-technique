@extends('layouts/main')

@push('meta')
<meta name="description"
      content="Vendredi propose des stages partagés entre entreprise et association. Découvre notre équipe et viens nous aider à faire de chaque jour un Vendredi."/>
@endpush

@section('title')
    Équipe
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12"><!-- this adds padding to match the 40px margin -->
            <div class="col-sm-10 col-sm-offset-1">
                <h2 class="equipe-title text-center">Faire de chaque jour un Vendredi</h2>
                <p class="equipe-subtitle">
                    Nous faisons grandir un projet collectif qui ressemble à toutes celles et ceux qui y contribuent.
                    Avec
                    engagement, simplicité et enthousiasme.
                </p>
            </div>
            <div class="col-sm-12 block-vendredi" id="equipe-hero">
                <h1 class="equipe-hero-title">
                    Manon, Anne, Raphaël, Félix, Thomas et Margot
                </h1>
                <img src="{{elixir('images/team-photo-detour.jpg')}}" id="equipe-hero-img">
            </div>

            <div class="col-md-6 col-sm-12 block-vendredi">
                <div class="col-sm-12" id="equipe-nous-rejoindre">
                    <h1 class="equipe-secondary-title">
                        Nous rejoindre
                    </h1>
                    <p class="equipe-nous-rejoindre-subtitle">
                        Tu souhaites permettre à chacun de s'engager pour la société dans son travail ?
                        <br/>
                        <br/>
                        Notre équipe s'agrandit et nous recherchons&nbsp;:
                    </p>
                    <ul class="equipe-ul-job">
                        <li>
                            Product Owner - CDI
                        </li>
                        <li>
                            Chargé(e) de mission - Partenariats associatifs - Service Civique
                        </li>
                        <li>
                            Business Developer - Stage
                        </li>
                        <li>
                            De belles candidatures spontanées
                        </li>
                    </ul>

                    <a target="_blank"
                       href="{{ config('links.jobs') }}" class="equipe-cta btn btn-default">
                        Découvrir nos offres
                    </a>
                </div>

            </div>
            <div class="col-md-6 col-sm-12 block-vendredi">
                <div class="col-sm-12" id="equipe-soutiens">
                    <h1 class="equipe-secondary-title">
                        Ils nous soutiennent
                    </h1>
                    <div class="row">
                        <div class="col-sm-4">
                            <a target="_blank" href="http://www.entreprendreetplus.org/">
                                <img src="{{elixir('images/entreprendre-et-plus.png')}}" class="equipe-soutiens-img">
                            </a>
                        </div>
                        <div class="col-sm-8">
                            <p class="equipe-soutiens-subtitle">
                                <a target="_blank" href="http://www.entreprendreetplus.org/">Entreprendre & +</a> est
                                partenaire fondateur de Vendredi.
                            </p>
                        </div>
                    </div>

                    <p class="equipe-soutiens-text">

                        Créé en 2009, ce fonds de dotation ambitionne de faire émerger une large communauté
                        d'entrepreneurs sociaux en France.
                        <br>
                        <br>
                        Pour cela, il accompagne des projets qui concilient impact social, pérennité économique et
                        potentiel de développement.
                        <br>
                        <br>


                    </p>
                    <a href="{{route('devenir-partenaire')}}" class="equipe-cta btn btn-default">
                        Écrivons notre histoire ensemble
                    </a>
                </div>
            </div>
            <div class="col-sm-12 block-vendredi"></div><!-- spacing block -->

        </div>
    </div>


@endsection

@push('scripts')
<script type="text/javascript">
  $(document).ready(function () {
    $('#equipe-soutiens, #equipe-nous-rejoindre').matchHeight({property: 'height'});
  });
</script>
@endpush
