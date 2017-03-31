@extends('layouts/main-mobile')

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
    </div>

    <div class="row">
        <div class="col-sm-12  col-md-6 block-vendredi">
            <div class="col-sm-12" id="partenaire-pour-les-entreprises">
                <h2 class="partenaire-block-title">Pour les<br/>entreprises</h2>
                <p class="partenaire-block-subtitle">Offrez à vos stagiaires une opportunité unique</p>

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
                        <a href="{{ config('links.become_partner') }}"
                           class="btn btn-block btn-danger partenaire-cta">Déposer une offre</a>
                        <p class="text-center partenaire-secondary-cta">
                            <a href="#" class="">Envie d'en savoir plus ?
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
                        <a href="#" class="btn btn-block btn-default partenaire-cta">En savoir plus</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('#partenaire-pour-les-entreprises, #partenaire-pour-les-assos ').matchHeight({property: 'height'});
    });
</script>
@endpush
