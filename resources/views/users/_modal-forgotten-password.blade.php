<!--
To show it : type in console : 
$("#userForgottenPasswordModal").modal('show');
-->
<div class="modal fade" tabindex="-1" role="dialog" id="userForgottenPasswordModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="{{elixir('images/modal-close.png')}}" class="modal-close-icon" aria-hidden="true"></button>
        <p class="modal-title modal-title-vendredi">Mot de passe oublié</p>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4 text-center">
          <p>Tu as un compte Linkedin ?</p>
          <a href="#" class="btn btn-linkedin"><img class="btn-linkedin-logo" src="{{elixir('images/linkedin-white.png')}}">Connexion via Linkedin</a>
          
          </div>
          <div class="col-md-8 modal-inscription-form-div">
            <form class="form-horizontal modal-form" action="{{route('send_email_forgotten_password')}}" method="post">
              <div class="form-group">
                <div class="col-md-12">
                  <input class="form-control" name="email" placeholder="Adresse email">
                </div>
              </div>


              <div class="form-group">

                <div class="col-md-12">
                  <button class="btn btn-block btn-warning">Ré-initialiser <span class="hidden-xs hidden-sm">mon mot de passe</span></button>
                </div>
              </div>


            </form>
          </div>
        </div>
      </div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->