@extends('layouts/main-mobile')

@push('meta')
<meta name="description"
      content="Vendredi propose des stages partagés entre entreprise et association. Faire un Vendredi, c'est travailler 4 jours par semaine en entreprise, 1 jour par semaine en association."/>
@endpush

@section('title')
    Chaque jour compte
@endsection

@section('hero')
    <div id="hero" class="hero-mobile">
        <img src="/images/hero-mobile.png" id="hero-bg" alt="">
        <div class="container container-vendredi">
            <div class="row">
                <div class="col-xs-offset-1 col-xs-10">
                    <h1 class="hero-title">
                        Un stage unique <br/>
                        pour ton avenir
                    </h1>
                    <p class="hero-subtitle">
                        Découvre toutes nos offres de stages&nbsp;partagés entre entreprise et association</p>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">


        <div class="col-xs-6 block-vendredi-mobile">
            <div class="square-concept">
                <div class="content">
                    <a href="{{route('concept')}}"></a>
                    <p class="text-center">
                        Découvrir<br/>
                        le concept
                    </p>
                </div>
            </div>
        </div>

        <div class="col-xs-6 block-vendredi-mobile">
            <div class="square-faq">
                <div class="content">
                    <a href="{{ config('links.faq')}}"></a>
                    <p class="text-center">
                        Lire notre<br/>
                        F.A.Q.<br/>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-xs-12 block-vendredi-mobile">
            <div class="col-sm-12" id="home-semaine-mobile">
                <h1 id="home-semaine-mobile-title">Ils ont vécu un Vendredi</h1>

                <p class="home-semaine-mobile-subtitle">Et t’expliquent pourquoi te lancer !</p>
                <button onclick="$('#semaineMorgane').modal('show')"
                        class="btn btn-sm btn-default home-semaine-mobile-button">Découvrir
                </button>
                <img id="morgane-mobile" alt="Photo jeune femme souriante"
                     src="{{  elixir('images/morgane-detourage-plume-mobile.png') }}">
            </div>
        </div>

        <div class="col-xs-12 block-vendredi-mobile">
            <div class="col-sm-12" id="home-newsletter-mobile">
                <p class="home-newsletter-mobile-title">S’inscrire à la newsletter
                    <a href="#mc-embedded-subscribe-form" id="newsletter-collapse" class="collapsed"
                       data-toggle="collapse"><span class="expand-icon"></span></a>
                </p>

                <!-- Begin MailChimp Signup Form -->
                <form action="//vendredi.us10.list-manage.com/subscribe/post?u=1f8f5993c0d281efccc14ebdd&amp;id=aff4f95ac5"
                      method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form"
                      class="form-horizontal form-newsletter validate collapse" target="_blank" novalidate>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="text" value="" name="MMERGE5" class="form-control input-sm"
                                   placeholder="Prénom" id="mce-MMERGE5">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="text" value="" name="MMERGE4" class="form-control input-sm" placeholder="Nom"
                                   id="mce-MMERGE4">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="email" value="" name="EMAIL" class="required email form-control input-sm"
                                   placeholder="Email" id="mce-EMAIL">
                        </div>
                    </div>

                    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text"
                                                                                              name="b_1f8f5993c0d281efccc14ebdd_aff4f95ac5"
                                                                                              tabindex="-1" value="">
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="submit" id="mc-embedded-subscribe"
                                   class="btn btn-sm btn-block btn-warning home-newsletter-mobile-btn"
                                   value="S'inscrire">
                        </div>
                    </div>
                </form>
                <!--End mc_embed_signup-->
            </div>
        </div>


    </div>
    @include('/pages/_modal-semaine-morgane')

@endsection

@push('scripts')

<script type="text/javascript">
  $(document).ready(function () {


    $("#newsletter-collapse.collapsed").on('click', function (e) {
      // Smooth scroll to the newsletter form

      var offset = $("#home-newsletter-mobile").offset();
      offset.top -= 20;
      $('html, body').animate({
        scrollTop: offset.top,
      }, 400);
    });
  });
</script>
@endpush