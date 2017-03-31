<!--
To show it : type in console :
$("#userInscriptionModal").modal('show');
-->
<div class="modal fade" tabindex="-1" role="dialog" id="userInscriptionModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img
                            src="{{elixir('images/modal-close.png')}}" class="modal-close-icon" aria-hidden="true">
                </button>
                <p class="modal-title modal-title-vendredi">Inscris-toi pour voir nos offres partagées </p>
            </div>
            <div class="modal-body">
                <div class="row">


                    <!--- Linkedin Connect -->
                    <div class="col-md-4 text-center">
                        <p>Tu as un compte Linkedin ?</p>
                        <a target="_blank" href="{{$linkedinUrl}}" class="btn btn-linkedin"><img
                                    class="btn-linkedin-logo" src="{{elixir('images/linkedin-white.png')}}">M’inscrire
                            avec Linkedin</a>

                        <p class="modal-inscription-link-connection"><a href="#userConnectionModal"
                                                                        id="userConnectionLink">Tu as déjà un compte
                                vendredi ?</a></p>
                    </div>

                    <!--- Main form -->
                    <div class="col-md-8 modal-inscription-form-div">
                        <form id="userInscriptionForm" class="modal-form" method="post"
                              action="{{ URL::route('candidate_register') }}" data-toggle="validator"
                              data-focus="false">

                            {{ csrf_field() }}


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input data-error="Champ requis"
                                               required class="form-control" placeholder="Prénom" name="firstname">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input required data-error="Champ requis"
                                               class="form-control" placeholder="Nom" name="lastname">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>


                                <div class="col-md-12 has-feedback">
                                    <div class="form-group">

                                        <input required data-error="Adresse email obligatoire"
                                               class="form-control" placeholder="Adresse email" type="email"
                                               name="email">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group" id="schoolTypeahead">

                                        <typeahead></typeahead>
                                    </div>
                                    @push('scripts')
                                    <script type="text/javascript">
                                      $(document).ready(function () {
                                        var typeaheadApp = new Vue({
                                          el: "#schoolTypeahead",
                                        });
                                      });
                                    </script>
                                    @endpush
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select data-error="Sélectionne un niveau dans la liste"
                                                required class="form-control" name="education">
                                            <option value="" disabled selected>Niveau</option>
                                            @foreach($educations as $education)
                                                <option value="{{ $education->id }}">{{ $education->value }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>


                                <div class="col-md-6 has-feedback">
                                    <div class="form-group">
                                        <input required data-minlength="6" data-error="Minimum 6 caractères"
                                               class="form-control"
                                               placeholder="Mot de passe" name="password" type="password">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button id="submitRegistration" class="btn btn-block btn-warning">M'inscrire
                                        </button>
                                    </div>
                                </div>

                                <input type="hidden" name="current_page" value="{{ \Request::getRequestUri() }}">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->