$(window).on("load", function () {
  // setTimeout(function () {
  $("#loading")
    .addClass("is-hidden")
    .delay(1500)
    .queue(function () {
      $("#wrapper").css("display", "block");
      $(this).addClass("is-none").dequeue();
    })
    .delay(3000)
    .queue(function () {
      $(this).css("display", "none").dequeue();
    });
  // }, 500);
});

$(function () {
  // フェードイン
  $(window).on("scroll", function () {
    // 上から下に
    $(".js-fade-up").each(function () {
      let elemPos = $(this).offset().top,
        scroll = $(window).scrollTop(),
        windowHeight = $(window).height();
      if (scroll > elemPos - windowHeight + 300) {
        $(this).addClass("is-shown");
      }
    });

    // 順番に
    $(".js-fade-order").each(function () {
      let elemPos = $(this).offset().top,
        scroll = $(window).scrollTop(),
        windowHeight = $(window).height();
      if (scroll > elemPos - windowHeight + 300) {
        let childElem = $(this).children();
        childElem.each(function (i) {
          $(this)
            .delay(100 + i * 500)
            .queue(function () {
              $(this).addClass("is-shown").dequeue();
              if ($(this).hasClass("js-slide-cover")) {
                $(this).addClass("is-slide-cover");
              }
            });
        });
      }
    });

    // 左から右に
    $(".js-slide-order").each(function () {
      let elemPos = $(this).offset().top,
        scroll = $(window).scrollTop(),
        windowHeight = $(window).height();
      if (scroll > elemPos - windowHeight + 300) {
        let childElem = $(this).children();
        childElem.each(function (i) {
          $(this)
            .delay(100 + i * 500)
            .queue(function () {
              $(this).addClass("is-shown").dequeue();
            });
        });
      }
    });
  });
  let windowWidth = $(window).width();

  // スライダー（slick）
  $(".js-slider-photo").slick({
    pauseOnFocus: false,
    pauseOnHover: false,
    waitForAnimate: false,
    autoplay: false,
    autoplaySpeed: 3000,
    centerMode: true,
    slidesToShow: 1,
    centerPadding: "0",
    speed: 1000,
    prevArrow:
      '<div class="photo__slide-arrow photo__slide-arrow--prev"></div>',
    nextArrow:
      '<div class="photo__slide-arrow photo__slide-arrow--next"></div>',
    responsive: [
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
          centerPadding: "0%",
        },
      },
    ],
  });

  $(".slider_sp").on("touchmove", function (
    event,
    slick,
    currentSlide,
    nextSlide
  ) {
    $(".slider_sp").slick("slickPlay");
  });

  //GlobalMenu表示・非表示切り替え
  $(function () {
    $(".header__items>.jump-menu").on("click", function () {
      $(".header__items>ul").toggle();
    });
  });

  //closeボタン押した時にGlobalMenu非表示
  $(function () {
    $(".cls_btn").on("click", function () {
      $(".header__items>ul").hide();
    });
  });

  //メニューの表示・非表示の切り替え
  $(function () {
    const tab01_active = {
      boxShadow: "-2px -2px 5px 0px rgba(0,0,0,0.4)",
      backgroundColor: "#e61e1e",
    };
    const tab01_non_active = {
      boxShadow: "none",
      backgroundColor: "#808080",
    };
    const tab02_active = {
      boxShadow: "-2px -2px 5px 0px rgba(0,0,0,0.4)",
      backgroundColor: "#304deb",
    };
    const tab02_non_active = {
      boxShadow: "none",
      backgroundColor: "#808080",
    };
    const listShadow = {
      boxShadow: "0px 0px 8px 2px rgba(0, 0, 0, 0.31)",
    };

    //初期値
    $(".detail__list-tab01").css(tab01_active);
    $(".detail__list-tab02").css(tab02_non_active);
    $(".detail__list-box01").css(listShadow).show();
    $(".detail__list-box02").hide();

    //使った分だけお支払いプランのタブをクリックした時
    $(".detail__list-tab01, .plan__link01").on("click", function () {
      $(".detail__list-box02").hide();
      $(".detail__list-box01").css(listShadow).show();

      $(".detail__list-tab02").css(tab02_non_active);
      $(".detail__list-tab01").css(tab01_active);
    });

    //毎月お得な定額プランのタブをクリックした時

    $(".detail__list-tab02, .plan__link02").on("click", function () {
      $(".detail__list-box01").hide();
      $(".detail__list-box02").css(listShadow).show();

      $(".detail__list-tab01").css(tab01_non_active);
      $(".detail__list-tab02").css(tab02_active);
    });
  });

  $(".js-slider-iv").slick({
    dots: true,
    speed: 800,
    prevArrow: '<div class="iv__slide-arrow iv__slide-arrow--prev"></div>',
    nextArrow: '<div class="iv__slide-arrow iv__slide-arrow--next"></div>',
  });

  // トップへ戻るボタン
  $(window).on("scroll touchmove", function () {
    //スクロール中に判断する
    $("#js-back-button").stop(); //アニメーションしている場合、アニメーションを強制停止
    $("#js-back-button").css("display", "none").delay(500).fadeIn("fast");
    //スクロール中は非表示にして、500ミリ秒遅らせて再び表示
  });
});
