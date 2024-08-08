require("./dateFormat");
require("./helpers");

// import Swiper JS
import Swiper, { Autoplay, Pagination } from "swiper";
window.Swiper = Swiper;
window.SwiperAutoplay = Autoplay;
window.SwiperPagination = Pagination;
import "swiper/css";
import 'swiper/css/pagination';

window._ = require("lodash");
window.axios = require("axios");
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

// WS
import Centrifuge from "centrifuge";
const centrifuge = new Centrifuge(process.env.MIX_CENTRIFUGO_WS_CONNECTION);
window.centrifuge = centrifuge;

import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";
import morph from "@alpinejs/morph";
import mask from "@alpinejs/mask";

// Router view
import routerView from "../../app/Containers/Pages/UI/WEB/Views/components/router/routerView";
Alpine.data("routerView", routerView);

// Store
import router from "../../app/Containers/Pages/UI/WEB/Views/components/store/router";
import player from "../../app/Containers/Player/UI/WEB/Views/components/store/player";
import invent from "../../app/Containers/GameModes/UI/WEB/Views/components/store/invent";
Alpine.store("router", router);
Alpine.store("player", player);
Alpine.store("invent", invent);

// Renderless
import timer from "./components/timer";
Alpine.data("timerData", timer);

// Components
require("./alpine-data-autoload.js");

Alpine.plugin(collapse);
Alpine.plugin(morph);
Alpine.plugin(mask);
Alpine.start();
window.Alpine = Alpine;

// Emmiter
import emmiter from "./emmiter";
window.emmiter = emmiter;
