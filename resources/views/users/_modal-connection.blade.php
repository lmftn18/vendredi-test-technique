<!--
To show it : type in console :
$("#userConnectionModal").modal('show');
-->
<div class="modal fade" tabindex="-1" role="dialog" id="userConnectionModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="{{elixir('images/modal-close.png')}}" class="modal-close-icon" aria-hidden="true"></button>
        <p class="modal-title modal-title-vendredi">Connexion à ton compte Vendredi</p>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-5 text-center">
          <p>Tu as un compte Linkedin ?</p>
          <a target="_blank" href="{{$linkedinUrl}}" class="btn btn-linkedin"><img class="btn-linkedin-logo" src="{{elixir('images/linkedin-white.png')}}">Me connecter avec Linkedin</a>

          </div>
          <div class="col-md-7 modal-inscription-form-div">
            <form id="candidateLoginForm" class="form-horizontal modal-form" method="post" action="{{ URL::route('candidate_login') }}">

              {{ csrf_field() }}

              <div class="form-group">
                <div class="col-md-12">
                  <input class="form-control" placeholder="Adresse email" type="email" name="email">
                </div>
              </div>


              <div class="form-group">
                <div class="col-md-6">
                  <input class="form-control" placeholder="Mot de passe" type="password" name="password">
                </div>
                <div class="col-md-6">
                  <button class="btn btn-block btn-warning">Me connecter</button>

                </div>
              </div>

              <div class="form-group has-error">
                <div class="col-md-12">
                  <div id="candidateLoginFormMainHelpBlock" class="help-block with-errors"></div>
                </div>
              </div>

              <input type="hidden" name="current_page" value="{{ \Request::getRequestUri() }}">

            </form>
          </div>
          <div class="col-md-12">
          <p class="modal-connection-link-inscription"><a id="userInscriptionLink" href="#userInscriptionModal">⇠ Je n’ai pas de compte</a></p>
          <p class="modal-connection-link-lost-password"><a href="#" id="forgottenPasswordLink">Mot de passe oublié ? ⇢</a></p>
          </div>
        </div>
      </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->