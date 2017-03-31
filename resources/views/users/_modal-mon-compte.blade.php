<!--
To show it : type in console :
$("#userLogoutModal").modal('show');
-->
<div class="modal fade" tabindex="-1" role="dialog" id="userLogoutModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img
                            src="{{elixir('images/modal-close.png')}}" class="modal-close-icon" aria-hidden="true">
                </button>
                <p class="modal-title modal-title-vendredi">Mon compte Vendredi</p>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!--- Linkedin Connect -->
                    <div class="col-md-4 text-center visible-md visible-lg">
                        <h1 id="logoutLeftPanel" class="logout-modal-left-text">Vendredi, c’est déjà +10,000 heures de
                            travail rémunérées dédiées à des projets à fort impact social.  
                            <br/>
                            <br/>
                            Merci à vous <3</h1>
                    </div>

                    <!--- Main form -->
                    <div class="col-md-8">
                        <form id="userChangeInfoForm" class="modal-form" method="PUT"
                              action="{{ URL::route('candidate_update_me') }}" data-toggle="validator"
                              data-focus="false">

                            {{ csrf_field() }}


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input data-error="Champ requis"
                                               required class="form-control" value="{{ $user ? $user->firstname : '' }}"
                                               placeholder="Prénom" name="firstname">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input required data-error="Champ requis"
                                               class="form-control" value="{{ $user ? $user->lastname : '' }}"
                                               placeholder="Nom" name="lastname">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>


                                <div class="col-md-12 has-feedback">
                                    <div class="form-group">

                                        <input required data-error="Adresse email obligatoire"
                                               class="form-control" placeholder="Adresse email" type="email"
                                               value="{{ $user ? $user->email : '' }}"
                                               name="email">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group" id="schoolTypeaheadInfoUpdate">

                                        <typeahead
                                                v-bind:default-selected-id="defaultSelectedId"
                                                v-bind:default-selected-value="defaultSelectedValue"
                                                v-bind:on-change="onChangeCallback"
                                        ></typeahead>
                                    </div>
                                    @push('scripts')
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            window.typeaheadChangeUserInfoApp = new Vue({
                                                el: "#schoolTypeaheadInfoUpdate",
                                                data: {
                                                    defaultSelectedId : "{{$user && $user->candidate && $user->candidate->school ? $user->candidate->school->id : false}}",
                                                    defaultSelectedValue : "{{$user && $user->candidate && $user->candidate->school ? $user->candidate->school->value : false}}",
                                                    onChangeCallback : function () {
                                                        $("#userChangeInfoForm").trigger('change');
                                                    }
                                                }
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
                                                <option value="{{ $education->id }}"
                                                        {{$user && $user->candidate && $user->candidate->education_id  == $education->id ? 'selected="selected"' : '' }}
                                                >{{ $education->value }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>


                                <div class="col-md-6 has-feedback">
                                    <div class="form-group">
                                        <input data-minlength="6" data-error="Minimum 6 caractères"
                                               class="form-control"
                                               placeholder="••••••" name="password" type="password">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button id="submitUserChange" class="btn btn-block btn-warning" disabled>
                                            Enregistrer
                                        </button>
                                    </div>
                                </div>

                                <input type="hidden" name="current_page" value="{{ \Request::getRequestUri() }}">
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12">
                        <p class="modal-connection-link-lost-password"><a href="{{route('logout', ['current_page' =>  url()->current()])}}">Me déconnecter</a></p>
                    </div>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->