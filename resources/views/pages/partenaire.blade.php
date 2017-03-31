@extends('layouts/main')

@push('meta')
<meta name="description"
      content="Vendredi propose des stages partagés entre entreprise et association. Vous aussi, devenez partenaire du Vendredi !"/>
@endpush

@section('title')
    Devenir partenaire
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-offset-3 col-sm-6 text-center">
            <h1 class="partenaire-title">Adoptez Vendredi dès aujourd’hui </h1>
            <p class="partenaire-subtitle">Mettez le en place et montrez qu’on peut  s’engager au travail pour rendre la
                société plus belle</p>
        </div>
        <div class="col-sm-10 col-sm-offset-1 partenaire-logo-row hidden-xs">
            <img src="{{elixir('images/carrefour-logo.png')}}"/>
            <img src="{{elixir('images/emmaus-partenaire.png')}}"/>
            <img src="{{elixir('images/mazars-logo.png')}}" id="mazars-logo"/>
            <img src="{{elixir('images/adie-logo.png')}}"/>
            <img src="{{elixir('images/vinci-logo.png')}}"/>
            <img src="{{elixir('images/croix-rouge-partenaire.png')}}"/>
        </div>
    </div>

    <div class="row" id="partenaire-main">
        <div class="col-sm-12  col-md-6 block-vendredi">
            <div class="col-sm-12" id="partenaire-pour-les-entreprises">
                <h2 class="partenaire-block-title">Pour les<br/>entreprises</h2>
                <p class="partenaire-block-subtitle">Offrez à vos stagiaires une opportunité<br/>unique</p>

                <div class="row">
                    <div class="col-sm-12">
                        <ul class="partenaire-ul">
                            <li>Attirez des candidats de qualité</li>
                            <li>Faites grandir vos talents</li>
                            <li>Soutenez des associations</li>
                            <li>Déployez un dispositif innovant</li>
                            <li>Développez votre marque employeur</li>
                        </ul>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <a id="partenaire-cta-entreprise"
                           target="_blank"
                           href="{{ config('links.become_partner') }}"
                           class="btn btn-block btn-danger partenaire-cta">Déposer une offre</a>
                        <p class="text-center partenaire-secondary-cta">
                            <a target="_blank" href="http://documents.vendredi.cc/v/2QHHgXIuobFsYTItzhCp" class="">Envie
                                d'en savoir plus ?
                                Lisez notre plaquette ⇢</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12  col-md-6 block-vendredi">
            <div class="col-sm-12 " id="partenaire-pour-les-assos">
                <h2 class="partenaire-block-title">Pour les<br/>associations</h2>
                <p class="partenaire-block-subtitle">Bénéficiez du soutien de jeunes compétents et engagés</p>

                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <ul class="partenaire-ul">
                            <li>Bénéficiez de compétences</li>
                            <li>Avancez plus rapidement</li>
                            <li>Rapprochez-vous des entreprises</li>
                            <li>Renforcez votre visibilité</li>
                        </ul>
                        <a id="partenaire-cta-asso"
                           target="_blank"
                           href="https://aide.vendredi.cc/hc/fr/articles/115000686269-Je-souhaite-devenir-partenaire-et-proposer-une-mission-Comment-faire-"
                           class="btn btn-block btn-default partenaire-cta">En savoir plus</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row block-vendredi hidden-xs">
        <div class="col-sm-6 partenaire-quote-container">
            <p class="partenaire-quote text-center">
                « Vendredi c’est une nouvelle façon de recruter, une autre approche du business. C’est probablement de
                ça que le futur sera fait. »
            </p>

            <div class="row partenaire-block-media">
                <div class="col-sm-6 text-right">
                    <img class="partenaire-quote-img" src="{{elixir('images/cristophe.png')}}" alt="...">
                </div>
                <div class="col-sm-6 text-left">
                    <h5 class="partnenaire-quote-text">
                        <span class="partnenaire-quote-text-name">Christophe Bareyt</span><br/>
                        Manager,<br/>
                         Saint-Gobain Isover
                    </h5>
                </div>
            </div>
        </div>

        <div class="col-sm-6 partenaire-quote-container">
            <p class="partenaire-quote text-center">
                « Comme toutes les associations, nous avons beaucoup à faire avec peu de monde. Alors quand Julie est
                arrivée avec son projet, ça a fait tilt. »
            </p>

            <div class="row partenaire-block-media">
                <div class="col-sm-6 text-right">
                    <img class="partenaire-quote-img" src="{{elixir('images/marie.png')}}" alt="...">
                </div>
                <div class="col-sm-6 text-left">
                    <h5 class="partnenaire-quote-text">
                        <span class="partnenaire-quote-text-name">Marie Beaurepaire</span><br/>
                        Regional Director,<br/>
                        Singa
                    </h5>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('#partenaire-pour-les-entreprises, #partenaire-pour-les-assos ').matchHeight({property: 'height'});

        // We use the margin-top to align the main buttons
        var topAsso = $("#partenaire-cta-asso").offset().top;
        var topEntreprise = $("#partenaire-cta-entreprise").offset().top

        $("#partenaire-cta-asso").css('margin-top', (60 + topEntreprise - topAsso) + "px")

    });
</script>
@endpush
