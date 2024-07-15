import RxPlayer from "rx-player";
const videoElement = document.getElementById("video-element");

// Initialisez le lecteur avec l'élément vidéo
const player = new RxPlayer({
  videoElement: videoElement
});
// Chargement d'une vidéo
player.loadVideo({
  url: "https://storage.googleapis.com/shaka-demo-assets/sintel-mp4-only/dash.mpd",
  transport: "dash",
  autoPlay: false,
});


