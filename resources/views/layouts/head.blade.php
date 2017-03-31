<!-- Google Tag Manager -->
<script>(function (w, d, s, l, i) {
    w[l] = w[l] || [];
    w[l].push({'gtm.start': new Date().getTime(), event: 'gtm.js'});
    var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
    j.async = true;
    j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
    f.parentNode.insertBefore(j, f);
  })(window, document, 'script', 'dataLayer', 'GTM-PFXD8N9');</script> <!-- End Google Tag Manager -->
<meta charset="utf-8">
<!--<meta http-equiv="X-UA-Compatible" content="IE=edge">-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
<!-- Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900"/>
<link rel="stylesheet" href="{{ elixir('css/app.css') }}">
<link rel="stylesheet" href="{{ elixir('css/font-awesome.min.css') }}">

<script>(function () {
    var w = window;
    var ic = w.Intercom;
    if (typeof ic === "function") {
      ic('reattach_activator');
      ic('update', intercomSettings);
    } else {
      var d = document;
      var i = function () {
        i.c(arguments)
      };
      i.q = [];
      i.c = function (args) {
        i.q.push(args)
      };
      w.Intercom = i;
      function l() {
        var s = d.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src = 'https://widget.intercom.io/widget/ue12udqa';
        var x = d.getElementsByTagName('script')[0];
        x.parentNode.insertBefore(s, x);
      }

      if (w.attachEvent) {
        w.attachEvent('onload', l);
      } else {
        w.addEventListener('load', l, false);
      }
    }
  })()</script>
