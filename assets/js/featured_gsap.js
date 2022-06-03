let open = false;
let curIdx = 1;
let width = null;

setTimeout(() => {
  width = window.innerWidth;
}, 1000);

const durationTiming = 0.8;

document.getElementById("featured_content").style.height = 0;

const featuredText = document.getElementById("featured_text");

const featuredElem1 = document.getElementById("featured_content_1_desktop");
const featuredElem2 = document.getElementById("featured_content_2_desktop");
const featuredElem3 = document.getElementById("featured_content_3_desktop");

featuredElem1.style.display = "none";
featuredElem2.style.display = "none";
featuredElem3.style.display = "none";

let opensMob = [false, false, false];

function setBtnText() {
  switch (curIdx) {
    case 1:
      if (open) {
        $("#btn_read_more_1").text("-");
        $("#btn_read_more_2").text("+");
        $("#btn_read_more_3").text("+");
      } else {
        $("#btn_read_more_1").text("+");
        $("#btn_read_more_2").text("+");
        $("#btn_read_more_3").text("+");
      }
      break;
    case 2:
      if (open) {
        $("#btn_read_more_1").text("+");
        $("#btn_read_more_2").text("-");
        $("#btn_read_more_3").text("+");
      } else {
        $("#btn_read_more_1").text("+");
        $("#btn_read_more_2").text("+");
        $("#btn_read_more_3").text("+");
      }
      break;
    case 3:
      if (open) {
        $("#btn_read_more_1").text("+");
        $("#btn_read_more_2").text("+");
        $("#btn_read_more_3").text("-");
      } else {
        $("#btn_read_more_1").text("+");
        $("#btn_read_more_2").text("+");
        $("#btn_read_more_3").text("+");
      }
      break;
  }
}

$("#btn_read_more_1, #btn_read_more_1_icon").on("click", () => {
  // console.log(open);
  // console.log(curIdx);
  // console.log("Click Triggered")

  if (isLessThan_768(width)) {
    if (!opensMob[0]) {
      gsap.to("#sc_services_item_content_1_bottom", {
        duration: durationTiming,
        height: "auto",
        opacity: "1",
      });
      opensMob[0] = true;
      $("#btn_read_more_1").text("-");
    } else {
      gsap.to("#sc_services_item_content_1_bottom", {
        duration: durationTiming,
        height: "0px",
        opacity: "0",
      });
      opensMob[0] = false;
      $("#btn_read_more_1").text("+");
    }
  } else {
    if (curIdx != 1) {
      gsap.to("#featured_content", { duration: durationTiming, height: 0 });
      curIdx = 1;
      open = false;
      setTimeout(() => {
        featuredElem1.style.display = "flex";
        featuredElem2.style.display = "none";
        featuredElem3.style.display = "none";
        if (!open) {
          gsap.to("#featured_content", {
            duration: durationTiming,
            height: "auto",
          });
          open = true;
        }
        setBtnText();
      }, 500);
    } else {
      if (!open) {
        featuredElem1.style.display = "flex";
        featuredElem2.style.display = "none";
        featuredElem3.style.display = "none";
        gsap.to("#featured_content", {
          duration: durationTiming,
          height: "auto",
        });
      } else {
        gsap.to("#featured_content", { duration: durationTiming, height: 0 }).then(() => {
          featuredElem1.style.display = "none";
        });
      }
      open = !open;
      setBtnText();
    }
  }
});

$("#btn_read_more_2, #btn_read_more_2_icon").on("click", () => {
  // console.log(open);
  // console.log(curIdx);
  // console.log("Click Triggered")
  if (isLessThan_768(width)) {
    if (!opensMob[1]) {
      gsap.to("#sc_services_item_content_2_bottom", {
        duration: durationTiming,
        height: "auto",
        opacity: "1",
      });
      opensMob[1] = true;
      $("#btn_read_more_2").text("-");
    } else {
      gsap.to("#sc_services_item_content_2_bottom", {
        duration: durationTiming,
        height: "0px",
        opacity: "0",
      });
      opensMob[1] = false;
      $("#btn_read_more_2").text("+");
    }
  } else {
    if (curIdx != 2) {
      gsap.to("#featured_content", { duration: durationTiming, height: 0 });
      curIdx = 2;
      open = false;
      setTimeout(() => {
        featuredElem1.style.display = "none";
        featuredElem2.style.display = "flex";
        featuredElem3.style.display = "none";
        if (!open) {
          gsap.to("#featured_content", {
            duration: durationTiming,
            height: "auto",
          });
          open = true;
        }
        setBtnText();
      }, 500);
    } else {
      !open
        ? gsap.to("#featured_content", {
            duration: durationTiming,
            height: "auto",
          })
        : gsap.to("#featured_content", { duration: durationTiming, height: 0 });
      open = !open;
      setBtnText();
    }
  }
});

$("#btn_read_more_3 , #btn_read_more_3_icon").on("click", () => {
  // console.log(open);
  // console.log(curIdx);
  // console.log("Click Triggered")
  if (isLessThan_768(width)) {
    if (!opensMob[2]) {
      gsap.to("#sc_services_item_content_3_bottom", {
        duration: durationTiming,
        height: "auto",
        opacity: "1",
      });
      opensMob[2] = true;
      $("#btn_read_more_3").text("-");
    } else {
      gsap.to("#sc_services_item_content_3_bottom", {
        duration: durationTiming,
        height: "0px",
        opacity: "0",
      });
      opensMob[2] = false;
      $("#btn_read_more_3").text("+");
    }
  } else {
    if (curIdx != 3) {
      gsap.to("#featured_content", { duration: durationTiming, height: 0 });
      curIdx = 3;
      open = false;
      setTimeout(() => {
        featuredElem1.style.display = "none";
        featuredElem2.style.display = "none";
        featuredElem3.style.display = "flex";
        if (!open) {
          gsap.to("#featured_content", {
            duration: durationTiming,
            height: "auto",
          });
          open = true;
        }
        setBtnText();
      }, 500);
    } else {
      !open
        ? gsap.to("#featured_content", {
            duration: durationTiming,
            height: "auto",
          })
        : gsap.to("#featured_content", { duration: durationTiming, height: 0 });
      open = !open;
      setBtnText();
    }
  }
});

function isLessThan_768(width) {
  if (width < 768) {
    return true;
  }
  return false;
}

window.addEventListener("resize", adjustViews, false);

function adjustViews() {
  width = window.innerWidth;
  if (isLessThan_768(width)) {
    featuredElem1.style.display = "none";
    featuredElem2.style.display = "none";
    featuredElem3.style.display = "none";
  } else {
    gsap.to("#sc_services_item_content_1_bottom", {
      duration: durationTiming,
      height: "0px",
      opacity: "0",
    });
    gsap.to("#sc_services_item_content_2_bottom", {
      duration: durationTiming,
      height: "0px",
      opacity: "0",
    });
    gsap.to("#sc_services_item_content_3_bottom", {
      duration: durationTiming,
      height: "0px",
      opacity: "0",
    });
    opensMob[0] = false;
    opensMob[1] = false;
    opensMob[2] = false;
  }
}

// Accordian Jquery UI
var icons = {
  header: "ui-icon-circle-arrow-e",
  activeHeader: "ui-icon-circle-arrow-s"
};
$(function () {
  $("#accordion").accordion({
    collapsible: false,
    heightStyle: "fill",
    icons: icons
  });
});

// Navbar Image

window.addEventListener("scroll", () => {
  if (window.scrollY !== 0) {
    $("#navbar-icon").width(250);
  } else {
    $("#navbar-icon").width(250);
  }
});

// Navbar
let roadmap_btns = [false, false, false, false, false];

$("#roadmap_q31_r").on("click", () => {
  $("#roadmap_q31").toggle("slow");
  roadmap_btns[0]
    ? $("#roadmap_q31_r").text("Read more")
    : $("#roadmap_q31_r").text("Read less");
  roadmap_btns[0] = !roadmap_btns[0];
});

$("#roadmap_q41_r").on("click", () => {
  $("#roadmap_q41").toggle("slow");
  roadmap_btns[1]
    ? $("#roadmap_q41_r").text("Read more")
    : $("#roadmap_q41_r").text("Read less");
  roadmap_btns[1] = !roadmap_btns[1];
});

$("#roadmap_q12_r").on("click", () => {
  $("#roadmap_q12").toggle("slow");
  roadmap_btns[2]
    ? $("#roadmap_q12_r").text("Read more")
    : $("#roadmap_q12_r").text("Read less");
  roadmap_btns[2] = !roadmap_btns[2];
});

$("#roadmap_q22_r").on("click", () => {
  $("#roadmap_q22").toggle("slow");
  roadmap_btns[3]
    ? $("#roadmap_q22_r").text("Read more")
    : $("#roadmap_q22_r").text("Read less");
  roadmap_btns[3] = !roadmap_btns[3];
});

$("#roadmap_q32_r").on("click", () => {
  $("#roadmap_q32").toggle("slow");
  roadmap_btns[4]
    ? $("#roadmap_q32_r").text("Read more")
    : $("#roadmap_q32_r").text("Read less");
  roadmap_btns[4] = !roadmap_btns[4];
});


// Terms and Conditions Popup

$("#open-terms").on('click', () => {
  console.log("OPen Popup Clicked")
  $("#popup-root").removeClass("hidden");
})

$("#close-terms").on('click', () => {
  $("#popup-root").addClass("hidden");
})