(function($){    //no conflict
    "use strict";
    $(document).ready(function(){
      var audio;
      //TODO: USE PRELOADER HERE TO HIDE PAUSE BTN BEFORE LOAD

      $('.dd-pause-wrapper').hide();
      $('#pause-podcast-btn').on('click', function(e) {
        var data = {
          'action': 'ajax_play_audio',
          'audiourl': ajax_obj.audio_url
        }
        $.ajax({
          url: ajax_obj.ajaxurl, data,
          success: function(response) {
              console.log(audio);
             audio.pause();
          },
          error: function(err) {
              console.log(err);
          }
      });
          $('.dd-pause-wrapper').hide();
          $('.dd-play-wrapper').show();
    });

    $('#play-podcast-btn').on('click', function(e) {
        var data = {
          'action': 'ajax_play_audio',
          'audiourl': ajax_obj.audio_url
        }
        $.ajax({
          url: ajax_obj.ajaxurl, data,
          success: function(response) {
              console.log(data.audiourl);
              audio = new Audio(data.audiourl);
              audio.play();
          },
          error: function(err) {
              console.log(err);
          }
      });
      $('.dd-play-wrapper').hide();
      $('.dd-pause-wrapper').show();
    });


    //check if playing
    $('audio').on({
      play: function (){
        alert("ko");
      }
    })

    //share icons show
    var options = {
      container: 'body'
    }
    $('[data-toggle="popover"]').popover(options);   
    $('[data-toggle="popover-share"]').popover({
      html: true,
      content: $('#dd-popover-content').html()
    });   

      
    });
    
  
  })(jQuery);   //end no conflict