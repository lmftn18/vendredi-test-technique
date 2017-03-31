@extends('layouts/main-mobile')

@push('meta')
<meta name="description"
      content="Vendredi propose des stages partagés entre entreprise et association. Découvre notre équipe et viens nous aider à faire de chaque jour un Vendredi."/>
@endpush

@section('title')
    Équipe
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <h2 class="equipe-title-mobile text-center">Faire de chaque jour un Vendredi</h2>
            <p class="equipe-subtitle">
                Nous faisons grandir un projet collectif qui ressemble à toutes celles et ceux qui y contribuent. Avec
                engagement, simplicité et enthousiasme.
            </p>
        </div>

        <div class="col-sm-12 block-vendredi-mobile" id="equipe-hero">
            <h1 class="equipe-hero-title">
                Manon, Anne, Raphaël, Félix, Thomas et Margot
            </h1>
            <img src="{{elixir('images/team-photo-detour-mobile.jpg')}}" id="equipe-hero-img">
        </div>

        <div class="col-md-6 col-sm-12 block-vendredi-mobile">
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
                        Responsable des partenariats entreprises - CDI
                    </li>
                    <li>
                        Chargé(e) de mission - Communauté étudiante et relations écoles - Service civique
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
                   href="{{ config('links.jobs') }}" class="equipe-cta btn btn-sm btn-default">
                    Découvrir nos offres
                </a>
            </div>

        </div>
        <div class="col-md-6 col-sm-12 block-vendredi-mobile">
            <div class="col-sm-12" id="equipe-soutiens">
                <h1 class="equipe-secondary-title">
                    Ils nous soutiennent
                </h1>

                <p class="text-center">
                    <img src="{{elixir('images/entreprendre-et-plus.png')}}" class="equipe-soutiens-img">
                </p>
                <p class="equipe-soutiens-subtitle">
                    <a target="_blank" href="http://www.entreprendreetplus.org/">Entreprendre & +</a> est
                    partenaire fondateur de Vendredi.
                </p>
                <p class="equipe-soutiens-text">
                    Crée en 2009, ce fonds de dotation ambitionne de faire émerger une large communauté d'entrepreneurs sociaux en France.
                    <br>
                    <br>
                    Pour cela, il accompage des projets quie concilient impact social, pérennité économique et potentiel de développment.
                    <br>
                    <br>


                </p>
                <a href="{{route('devenir-partenaire')}}" class="equipe-cta btn btn-sm btn-default" style="height: 60px !important; padding-top: 8px !important;">
                    Écrivons notre<br/>
                    histoire ensemble
                </a>
            </div>
        </div>


    </div>


@endsection

@push('scripts')
<script type="text/javascript">
  $(document).ready(function(){
    $('#equipe-soutiens, #equipe-nous-rejoindre').matchHeight({ property: 'height'});
  });
</script>
@endpush
