function __log(e, data) {
    //log.innerHTML += "\n" + e + " " + (data || '');
    console.log(e+" "+data);
  }

  var audio_context;
  var recorder;

  function startUserMedia(stream) {
    var input = audio_context.createMediaStreamSource(stream);
    __log('Media stream created.');

    // Uncomment if you want the audio to feedback directly
    //input.connect(audio_context.destination);
    //__log('Input connected to audio context destination.');
    
    recorder = new Recorder(input);
    __log('Recorder initialised.');
  }

  function startRecording(button) {
    recorder && recorder.record();
    $('[name=startButton]').prop("disabled",true);
    
    button.nextElementSibling.disabled = false;
    __log('Recording...');
  }

  function stopRecording(button) {
    recorder && recorder.stop();
   
    $('[name=stopButton]').prop("disabled",true);
    //button.previousElementSibling.disabled = false;
    $('[name=startButton]').prop("disabled",false);
    __log('Stopped recording.');
    //console.log(recorder.testlength());
    // create WAV download link using audio data blob
    createDownloadLink(button);
    //__log('Download');
    recorder.clear();
  }

  function createDownloadLink(button) {
   recorder && recorder.exportWAV(function(blob) {
      
      var url = URL.createObjectURL(blob);
     
      var au = document.createElement('audio');
      
      
      au.controls = true;
      au.src = url;
      $(au).insertAfter(button); 
      
    });
  }

  window.onload = function init() {
    try {
      // webkit shim
      window.AudioContext = window.AudioContext || window.webkitAudioContext;
      navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia;
      window.URL = window.URL || window.webkitURL;
      
      audio_context = new AudioContext;
      __log('Audio context set up.');
      __log('navigator.getUserMedia ' + (navigator.getUserMedia ? 'available.' : 'not present!'));
    } catch (e) {
      alert('No web audio support in this browser!');
    }
    
    navigator.getUserMedia({audio: true}, startUserMedia, function(e) {
      __log('No live audio input: ' + e);
    });
  };