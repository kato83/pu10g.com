import 'uikit/dist/css/uikit.css';
import './css/style.css'
import './css/component/share.css'
import UIkit from 'uikit';
import Icons from 'uikit/dist/js/uikit-icons';

// loads the Icon plugin
UIkit.use(Icons);

// preタグが含まれていたらhighlight.jsを読み込む
const highlightInit = () => {
  if(document.getElementsByTagName("pre")){
    const script = document.createElement("script");
    script.src = "https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/highlight.min.js";
    script.async = true;
    script.onload = () => hljs.initHighlighting();
    document.body.appendChild(script);
    const link = document.createElement("link");
    link.rel = "stylesheet";
    link.href = "https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/styles/solarized-dark.min.css";
    document.head.appendChild(link);
  }
};

if(document.readyState === "loading"){
  addEventListener("DOMContentLoaded", (e) => {
    highlightInit();
  });
}else{
  highlightInit();
}

if(navigator.share){
  [].slice
    .call(document.getElementsByClassName("share-button"))
    .forEach(e => {
      e.removeAttribute("hidden");
      e.addEventListener("click", (e => {
        navigator.share({
          title: document.title,
          text: document.title,
          url: document.querySelector("meta[property='og:url']").getAttribute("content")
        });
      }))
    });
}else{
  [].slice
    .call(document.getElementsByClassName("share-list"))
    .forEach(e => {
      e.removeAttribute("hidden");
    });
}
