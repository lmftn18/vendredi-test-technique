<!--
To show it : type in console : 
$("#semaineMorgane").modal('show');
-->
<div class="modal fade " tabindex="-1" role="dialog" id="semaineMorgane">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-semaine-morgane">
        <button id="closeSemaineMorgane" type="button" data-dismiss="modal" class="close close-semaine-morgane"  aria-label="Close"><img src="{{elixir('images/modal-close.png')}}" class="modal-close-icon" aria-hidden="true"></button>
        <h1 class="modal-title modal-title-semaine-morgane">
        
        La semaine de Morgane</h1>      
        
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <p class="modal-subtitle-semaine-morgane">Le concept de Vendredi expliqué en 3 minutes pour ceux qui ne croient que ce qu’ils voient…</p>
          </div>
      </div>
      <div class="modal-body modal-body-youtube">
        <div class="row">
          <div class="col-md-12 text-center" id="playerWrapper">
            <div id="player">Chargement de la vidéo en cours...</div>
          </div>
          
        </div>
      </div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@push('scripts')
<script type="text/javascript">
// This code loads the IFrame Player API code asynchronously.
var tag = document.createElement('script');

tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
var player;

// 3. This function creates an <iframe> (and YouTube player)
//    after the API code downloads.
function onYouTubeIframeAPIReady() {
  
  player = new YT.Player('player', {
    height: $("body").width() / 2  * 460 / 818,
    width: $("body").width() / 2,
    videoId: 'oROcBfNOsoo',
  });
}

$(document).ready( function() {
  $('#semaineMorgane').on('hide.bs.modal', function (e)  {
    player.pauseVideo();
  });
});

</script>
@endpush