@if($user )
    <script type="text/javascript">
      // Used if we are already logged in when the page is displayed
      window.Intercom("boot", {
        app_id: "ue12udqa",
        name: "{{ $user->firstname . ' ' . $user->lastname }}", // Full name
        email: "{{ $user->email}}", // Email address
        created_at: {{ $user->created_at ? $user->created_at->timestamp : '' }}, // Signup date as a Unix timestamp
        // Above $user->created_at ?  is only needed for the tests where some users might have an empty created_at value
        // For production users, their registration ensures this is always not NULL / empty

        user_hash: "{{ hash_hmac("sha256", $user->email, "ET-F17JC5ZOZUqRiR9Ju7TZvhVOnpW8DbFxsf1LX")}}",
        school_id: "{{ $user->candidate && $user->candidate->school ? $user->candidate->school->id : ''}}",
        school_name: "{{ $user->candidate && $user->candidate->school ? $user->candidate->school->value : ''}}",
      });
    </script>
@endif
