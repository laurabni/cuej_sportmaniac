// ACCUEIL
//partie interaction avec la page d'accueil
document.addEventListener("DOMContentLoaded", (event) => {
  var modal = document.getElementById("myModal");
  var modal1 = document.getElementById("myModal1");
  var modal2 = document.getElementById("myModal2");
  var modal3 = document.getElementById("myModal3");
  var modal4 = document.getElementById("myModal4");

  var btn = document.getElementById("myBtn");
  var btn1 = document.getElementById("myBtn1");
  var btn2 = document.getElementById("myBtn2");
  var btn3 = document.getElementById("myBtn3");
  var btn4 = document.getElementById("myBtn4");

  var span = document.getElementsByClassName("close")[0];
  var span1 = document.getElementsByClassName("close1")[0];
  var span2 = document.getElementsByClassName("close2")[0];
  var span3 = document.getElementsByClassName("close3")[0];
  var span4 = document.getElementsByClassName("close4")[0];

  btn.addEventListener("click", () => {
    modal.style.display = "block";
  });

  btn1.addEventListener("click", () => {
    modal1.style.display = "block";
  });

  btn2.addEventListener("click", () => {
    modal2.style.display = "block";
  });

  btn3.addEventListener("click", () => {
    modal3.style.display = "block";
  });

  btn4.addEventListener("click", () => {
    modal4.style.display = "block";
  });

  span.addEventListener("click", () => {
    modal.style.display = "none";
  });

  span1.addEventListener("click", () => {
    modal1.style.display = "none";
  });

  span2.addEventListener("click", () => {
    modal2.style.display = "none";
  });

  span3.addEventListener("click", () => {
    modal3.style.display = "none";
  });

  span4.addEventListener("click", () => {
    modal4.style.display = "none";
  });
});

// ARTICLE

document.addEventListener("DOMContentLoaded", function () {
  var video = document.getElementById("video");
  var textOverlay = document.querySelector(".header__texte");

  video.addEventListener("play", function () {
    textOverlay.classList.toggle("hidden");
  });

  video.addEventListener("pause", function () {
    textOverlay.classList.toggle("hidden");
  });
});
