<script type="text/javascript">
    // If with have access to the window that made this one opened  we make it look like logged in
    if(window.opener){
      window.opener.changeToLoggedIn({!! json_encode($userInfo)!!});
      window.opener.$("#userConnectionModal").modal('hide');
      window.opener.$("#userInscriptionModal").modal('hide');
    }

    // And we redirect to the right page
    window.location = "{{$redirect_url}}";

</script>