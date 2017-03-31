/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import 'whatwg-fetch'; // fetch polypfillr

//
// Helper that changes the DOM whether we are connected or not
//

window.appsListeningToLoginChanges = [];

window.changeToLoggedIn = function (userInfo) {
  updateUserInfo(userInfo);
  // Used if we login through ajax
  window.Intercom("boot", {
    app_id: "ue12udqa",
    name: userInfo.firstname + ' ' + userInfo.lastname, // Full name
    email: userInfo.email, // Email address
    created_at: userInfo.created_at_timestamp, // Signup date as a Unix timestamp
    user_hash: userInfo.user_hash, // User hash computed server side
    school_id : userInfo.school_id,
    school_name : userInfo.school_name,
  });
  
  $("#accountNotLoggedIn").addClass('hidden');
  $("#accountLoggedIn").removeClass('hidden');
  
  appsListeningToLoginChanges.forEach(function (item) {
    item.displayLinks = true;
  });
};

window.changeToNotLoggedIn = function () {
  $("#accountNotLoggedIn").removeClass('hidden');
  $("#accountLoggedIn").addClass('hidden');
  
  appsListeningToLoginChanges.forEach(function (item) {
    item.displayLinks = false;
  });
};

window.updateUserInfo = function (userInfo) {
  // Used if we updated user info through ajax
  const userInfoForm = $('#userChangeInfoForm');
  userInfoForm.find('input[name="firstname"]').val(userInfo.firstname);
  userInfoForm.find('input[name="lastname"]').val(userInfo.lastname);
  userInfoForm.find('input[name="email"]').val(userInfo.email);
  userInfoForm.find('input[name="password"]').val('');
  
  userInfoForm.find('select[name="education"]').val(userInfo.education_id);
  
  if (window.typeaheadChangeUserInfoApp){
      window.typeaheadChangeUserInfoApp.$children[0].onHit({id: userInfo.school_id, value : userInfo.school_name});
  }
  
  
  
};

////////////////////////////////////////////////////////////////////////
/// Handles user registration and connection
////////////////////////////////////////////////////////////////////////
$.fn.serializeObject = function () {
  var o = {};
  var a = this.serializeArray();
  $.each(a, function () {
    if (o[this.name] !== undefined) {
      if (!o[this.name].push) {
        o[this.name] = [o[this.name]];
      }
      o[this.name].push(this.value || '');
    } else {
      o[this.name] = this.value || '';
    }
  });
  return o;
};

$(document).ready(function () {
  
  const form = $('#userInscriptionForm');
  form.validator().on('submit', function (e) {
    // There is a validation error ?
    if (e.isDefaultPrevented()) {
      e.preventDefault();
      return;
    }
    
    e.preventDefault();
    
    const myHeaders = new Headers();
    myHeaders.set('Accept', 'application/json');
    myHeaders.set('Content-Type', 'application/json');
    
    fetch(form.attr('action'), {
      method: "POST",
      credentials: 'include',
      headers: myHeaders,
      body: JSON.stringify(form.serializeObject())
    })
      .then((response) => response.json())
      .then((responseAsJson) => {
        // If it has success = true
        if (responseAsJson.hasOwnProperty('success') && responseAsJson.success) {
          $("#userInscriptionModal").modal('hide');
          window.changeToLoggedIn(responseAsJson.data);
          
          const url = new Url(form.attr('action'));
          if (url.query.current_page) {
            window.open(url.query.current_page);
          }
        } else {
          // Display errors message
          
          Object.keys(responseAsJson).forEach(function (key) {
            // Add error styling and messages
            form.find('input[name="' + key + '"]').parents('.form-group').addClass('has-error');
            form.find('input[name="' + key + '"]').siblings('.help-block').html('<ul class="list-unstyled"></ul>');
            responseAsJson[key].forEach(function (message) {
              form.find('input[name="' + key + '"]').siblings('.help-block').children('ul').append('<li>' + message + '<li>');
            });
          });
        }
      });
  })
});


$(document).ready(function () {
  
  const form = $('#candidateLoginForm');
  form.validator().on('submit', function (e) {
    
    // There is a validation error ?
    if (e.isDefaultPrevented()) {
      return;
    }
    // Dismiss error message
    $("#candidateLoginFormMainHelpBlock").html('');
    e.preventDefault();
    
    const myHeaders = new Headers();
    myHeaders.set('Accept', 'application/json');
    myHeaders.set('Content-Type', 'application/json');
    
    fetch(form.attr('action'), {
      method: "POST",
      credentials: 'include',
      headers: myHeaders,
      body: JSON.stringify(form.serializeObject())
    })
      .then((response) => response.json())
      .then((responseAsJson) => {
        // If it has success = true
        if (responseAsJson.hasOwnProperty('success') && responseAsJson.success) {
          $("#userConnectionModal").modal('hide');
          window.changeToLoggedIn(responseAsJson.data);
          const url = new Url(form.attr('action'));
          
          if (url.query.current_page) {
            window.open(url.query.current_page);
          }
          
        } else {
          // Display errors message
          $("#candidateLoginFormMainHelpBlock").html('Vos identifiants n\'ont pas été reconnus.');
        }
      });
  })
});

// Update user Info logic
$(document).ready(function () {
  
  
  const submitButton = $('#submitUserChange');
  
  const loadingText = "<i class='fa fa-circle-o-notch fa-spin'></i> Enregistrement";
  const successText = "<i class='fa fa-check'></i> Enregistré !";
  const changedText = "Enregistrer";
  const errorText = "Erreur !";
  
  const submitButtonLoadingState = function(){
    submitButton.removeClass('btn-danger');
  
    submitButton.addClass('btn-warning');
    submitButton.attr('disabled', 'disabled');
    submitButton.html(loadingText);
    
    formHasChanged = false;
  };
  
  const submitButtonChangedState = function(){
    submitButton.removeAttr('disabled');
    submitButton.removeClass('btn-info');
    submitButton.removeClass('btn-danger');
    
    submitButton.addClass('btn-warning');
    submitButton.html(changedText);
    
  };
  
  const submitButtonSuccessState = function(){
    submitButton.addClass('btn-info');
    submitButton.removeClass('btn-warning');
    submitButton.removeClass('btn-danger');
    
    submitButton.html(successText);
  };
  
  const submitButtonErrorState = function() {
    submitButton.addClass('btn-danger');
    submitButton.removeClass('btn-warning');
    submitButton.removeClass('btn-info');
    submitButton.html(errorText);
  }
  let formHasChanged = false;
  
  const form = $('#userChangeInfoForm');
  
  form.on('change', function () {
    formHasChanged = true;
    submitButtonChangedState();
  });
  
  form.validator().on('submit', function (e) {
    // There is a validation error ?
    if (!formHasChanged || e.isDefaultPrevented()) {
      e.preventDefault();
      return;
    }
    
    e.preventDefault();
    submitButtonLoadingState();
    
    const myHeaders = new Headers();
    myHeaders.set('Accept', 'application/json');
    myHeaders.set('Content-Type', 'application/json');
    
    fetch(form.attr('action'), {
      method: form.attr('method'),
      credentials: 'include',
      headers: myHeaders,
      body: JSON.stringify(form.serializeObject())
    })
      .then((response) => response.json())
      .then((responseAsJson) => {
        // If it has success = true
        if (responseAsJson.hasOwnProperty('success') && responseAsJson.success) {
          updateUserInfo(responseAsJson.data);
          submitButtonSuccessState();
        } else {
          // Display errors message
          submitButtonErrorState();
          Object.keys(responseAsJson).forEach(function (key) {
            // Add error styling and messages
            form.find('input[name="' + key + '"]').parents('.form-group').addClass('has-error');
            form.find('input[name="' + key + '"]').siblings('.help-block').html('<ul class="list-unstyled"></ul>');
            responseAsJson[key].forEach(function (message) {
              form.find('input[name="' + key + '"]').siblings('.help-block').children('ul').append('<li>' + message + '<li>');
            });
          });
        }
      });
  })
});


// Dismiss bandeau when you click on close
$(document).ready(function () {
  $("#closeBandeauPrincipal").click(function () {
    $("#bandeauPrincipal").hide();
    $("#mainNav").removeClass('navbar-with-bandeau');
    Cookies.set('disclaimer_closed', 1, {expires: 10 * 365}); // expires in 10 years
  })
});

// Automatically dismiss alerts after 8 s
$(document).ready(function () {
  $('.alert-dismissible:not([data-prevent])').each(function () {
    const _this = this;
    setTimeout(() => {
      $(_this).find('.close').trigger('click')
    }, 8000);
  })
});


////////////////////////////////////////////////////////////////////////
/// VUE.JS COMPONENTS
////////////////////////////////////////////////////////////////////////

Vue.component('typeahead', require('./components/Typeahead.vue'));