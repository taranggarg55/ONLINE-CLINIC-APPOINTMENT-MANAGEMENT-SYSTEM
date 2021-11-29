const Slider = document.querySelector(".slider");
const Btns = document.querySelectorAll(".btn");
const Slides = document.querySelectorAll(".img");
const Note = document.querySelector(".note");

Note.addEventListener("click", function () {
  this.style.display = "none";
});

let index = 1;
let size = Slides[index].clientWidth;

window.addEventListener("resize", () => {
  size = Slides[index].clientWidth;
});

function slide() {
  Slider.style.transition = "transform .5s ease-in-out";
  Slider.style.transform = "translateX(" + -size * index + "px)";
}

function btnClick() {
  if (this.id === "prev") {
    index--;
  } else {
    index++;
  }
  this.disabled = true;
  slide();
}

Slider.addEventListener("transitionend", () => {
  if (Slides[index].id === "first") {
    Slider.style.transition = "none";
    index = Slides.length - 2;
    Slider.style.transform = "translateX(" + -size * index + "px)";
  } else if (Slides[index].id === "last") {
    Slider.style.transition = "none";
    index = 1;
    Slider.style.transform = "translateX(" + -size * index + "px)";
  }
  Btns[0].disabled = false;
  Btns[1].disabled = false;
});

Btns.forEach((btn) => btn.addEventListener("click", btnClick));
