<!--
To show it : type in console :
$("#semaineVecu").modal('show');
-->
<div class="modal fade" tabindex="-1" role="dialog" id="semaineVecu">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-vecu">
                <button id="closeSemaineMorgane" type="button" data-dismiss="modal" class="close close-vecu"
                        aria-label="Close"><img src="{{elixir('images/modal-close.png')}}" class="modal-close-icon"
                                                aria-hidden="true"></button>


                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="modal-title modal-title-vecu">
                            Ils ont vécu un Vendredi
                        </h1>
                        <p class="modal-subtitle-vecu">4 stagiaires t'expliquent pourquoi te lancer !</p>
                    </div>
                </div>
            </div>
            <div class="modal-body modal-body-vecu">
                <div class="modal-vecu-wrapper">
                    <img class="modal-vecu-arrow-left" src="{{elixir('/images/modal-left-arrow.png')}}"/>
                    <img class="modal-vecu-arrow-right" src="{{elixir('/images/modal-right-arrow.png')}}"/>

                    <div class="row">
                        <div class="col-md-12">
                            <div id="sei-0" class="modal-vecu-container ">
                                <img src="{{elixir('images/sei-hero-1.jpg')}}" class="modal-vecu-background">
                                <div class="modal-vecu-text-block left">
                                    <h1 class="modal-vecu-text-block-title">Multiplier les rencontres</h1>
                                    <p class="modal-vecu-text-block-main">
                                        Elena a fait un stage en innovation RH chez Carrefour, pendant lequel elle
                                        menait
                                        une mission prospective : "Que sera l’emploi chez Carrefour dans 25 ans ?". Un
                                        jour
                                        par semaine, elle participait à la mise en place de la communauté de bénévoles
                                        en
                                        région pour l’Agence du Don en Nature, une association qui collecte puis
                                        redistribue
                                        des invendus neufs auprès des plus démunis.
                                    </p>
                                    <p class="modal-vecu-text-block-quote">
                                        « Je fais deux fois plus de rencontres et j’ai deux fois plus d’expériences.  »
                                    </p>
                                    <p class="modal-vecu-footnote">
                                        Stage partagé entre
                                        <img style="height: 45px;" src="{{elixir('images/sei-carrefour-logo.png')}}">
                                        &
                                        <img src="{{elixir('images/sei-adn-logo.png')}}">
                                    </p>
                                </div>
                            </div>

                            <div id="sei-1" class="modal-vecu-container hidden">
                                <img src="{{elixir('images/sei-hero-2.jpg')}}" class="modal-vecu-background">
                                <div class="modal-vecu-text-block right">
                                    <h1 class="modal-vecu-text-block-title">Enrichir son stage</h1>
                                    <p class="modal-vecu-text-block-main">
                                        En stage partagé entre le CIC et l’Adie - l’association pionnère du micro-crédit
                                        en
                                        France -, Robin a pu réaliser un stage dans le secteur bancaire tout en ayant
                                        une
                                        expérience en micro-finance.
                                    </p>
                                    <p class="modal-vecu-text-block-quote">
                                        « Pour le CIC, je fais une mission de consulting sur la création d’entreprise.
                                        Pour
                                        l’Adie, je travaille sur les partenariats bancaires. Et enfin une mission
                                        centrale
                                        qui
                                        relie les deux : mettre en place le partenariat région »
                                    </p>
                                    <p class="modal-vecu-footnote">
                                        Stage partagé entre
                                        <img style="height: 45px;" src="{{elixir('images/sei-cic-logo.png')}}">
                                        &
                                        <img src="{{elixir('images/sei-adie-logo.jpg')}}">
                                    </p>
                                </div>
                            </div>

                            <div id="sei-2" class="modal-vecu-container hidden">
                                <img src="{{elixir('images/sei-hero-3.jpg')}}" class="modal-vecu-background">
                                <div class="modal-vecu-text-block right">
                                    <h1 class="modal-vecu-text-block-title">Découvrir tous les univers</h1>
                                    <p class="modal-vecu-text-block-main">
                                        Morgane a partagé son temps entre Chimex, une division du groupe l’Oréal, et
                                        Re-Belle,
                                        une start-up sociale qui fait des confitures à partir de fruits et légumes
                                        invendus.
                                        Elle a pu ainsi développer ses compétences en gestion des achats à
                                        l'international
                                        tout
                                        en mettant en place un outil logistique adapté aux contraintes d’une petite
                                        structure.
                                    </p>
                                    <p class="modal-vecu-text-block-quote">
                                        « J’ai pu découvrir l’univers de la start-up et du grand groupe tout en
                                        m’engageant
                                        au
                                        quotidien !  »
                                    </p>
                                    <p class="modal-vecu-footnote">
                                        Stage partagé entre
                                        <img style="height: 45px;" src="{{elixir('images/sei-chimex-logo.png')}}">
                                        &
                                        <img src="{{elixir('images/sei-rebelle-logo.jpg')}}">
                                    </p>
                                </div>
                            </div>

                            <div id="sei-3" class="modal-vecu-container hidden">
                                <img src="{{elixir('images/sei-hero-4.jpg')}}" class="modal-vecu-background">
                                <div class="modal-vecu-text-block left" style="width: 70%;">
                                    <h1 class="modal-vecu-text-block-title">Progresser et s’engager</h1>
                                    <p class="modal-vecu-text-block-main">
                                        Fénitra était auditeur chez Mazars et un jour par semaine il travaillait à
                                        l’animation
                                        du réseau d’alumni de l’Institut Télémaque, une association qui oeuvre dans le
                                        domaine
                                        de l’égalité des chances. Aujourd’hui, Fénitra continue son double engagement
                                        car il
                                        est
                                        en CDI chez Mazars et y réalise des missions en pro-bono.
                                    </p>
                                    <p class="modal-vecu-text-block-quote">
                                        « J’étais intéressé par le conseil et l’audit, mais je souhaitais aussi
                                        m’engager
                                        pour
                                        une association, ce que j’ai pu faire grâce à Vendredi  »
                                    </p>
                                    <p class="modal-vecu-footnote">
                                        Stage partagé entre
                                        <img style="height: 30px;" src="{{elixir('images/sei-mazars-logo.png')}}">
                                        &
                                        <img style="height: 30px;" src="{{elixir('images/sei-telemaque-logo.png')}}">
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@push('scripts')
<script type="text/javascript">
  function adaptModalHeight() {
    $('.modal-vecu-container').height(
      $('.modal-vecu-container:not(.hidden) .modal-vecu-text-block').outerHeight() + 80);
  }

  $('#semaineVecu').on('shown.bs.modal', function () {
    adaptModalHeight();
  });

  var goLeft = function () {
    var currentIndex = parseInt($(".modal-vecu-container:not(.hidden)").attr('id').slice(4));

    var previousIndex = (currentIndex - 1 + 4) % 4; // + 4 ensure we have previous >= 0
    $(".modal-vecu-container").addClass('hidden');
    $("#sei-" + previousIndex).removeClass('hidden');
    adaptModalHeight();
  };

  var goRight = function () {
    var currentIndex = parseInt($(".modal-vecu-container:not(.hidden)").attr('id').slice(4));
    var nextIndex = (currentIndex + 1) % 4;
    $(".modal-vecu-container").addClass('hidden');
    $("#sei-" + nextIndex).removeClass('hidden');
    adaptModalHeight();
  };


  $(document).ready(function () {
    $(".modal-vecu-arrow-left").click(goLeft);

    $(".modal-vecu-arrow-right").click(goRight);

    $(document).on('keydown', function (event) {
      // Left arrow
      if (event.keyCode == 37) {
        goLeft();
      }
      // Right arrow
      else if (event.keyCode == 39) {
        goRight();
      }
    });
  });
</script>
@e
@endpush