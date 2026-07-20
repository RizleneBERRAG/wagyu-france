document.addEventListener("DOMContentLoaded", () => {
    const STORAGE_KEY = "wf-universe";
    const HOME_URL = "/";
    const body = document.body;

    const validUniverses = ["particulier", "pro"];

    const choices = document.querySelectorAll("[data-universe-choice]");
    const navSets = document.querySelectorAll("[data-nav-set]");
    const menuPanels = document.querySelectorAll("[data-menu-panel]");

    const subtitle = document.querySelector("[data-universe-subtitle]");
    const mainCta = document.querySelector("[data-main-cta]");
    const menuTitle = document.querySelector("[data-menu-title]");

    const menuCardEyebrow = document.querySelector("[data-menu-card-eyebrow]");
    const menuCardTitle = document.querySelector("[data-menu-card-title]");
    const menuCardText = document.querySelector("[data-menu-card-text]");
    const menuCardLink = document.querySelector("[data-menu-card-link]");
    const wipeLabel = document.querySelector("[data-wipe-label]");

    const headerBrand = document.querySelector(".wf-header-brand");

    const universeConfig = {
        particulier: {
            subtitle: "Maison d’exception",
            ctaText: "Commander",
            ctaHref: "/boutique",
            homeHref: "/?univers=particulier",
            menuTitle: "Univers particulier",
            wipeLabel: "Particulier",
            cardEyebrow: "Univers particulier",
            cardTitle: "Une expérience pensée pour découvrir, choisir et savourer.",
            cardText: "Un parcours plus chaleureux, plus sensoriel, orienté dégustation, boutique et découverte de la maison.",
            cardLinkText: "Découvrir la boutique",
            cardLinkHref: "/boutique",
        },

        pro: {
            subtitle: "Univers professionnel",
            ctaText: "Réserver pro",
            ctaHref: "/reserve-professionnelle",
            homeHref: "/?univers=pro",
            menuTitle: "Univers professionnel",
            wipeLabel: "Professionnel",
            cardEyebrow: "Univers professionnel",
            cardTitle: "Un espace pensé pour réserver, anticiper et organiser les volumes.",
            cardText: "Un parcours plus technique, orienté chefs, restaurants, boucheries, découpe, volumes et pré-réservation.",
            cardLinkText: "Accéder à la réserve pro",
            cardLinkHref: "/reserve-professionnelle",
        },
    };

    function normalizeUniverse(value) {
        return validUniverses.includes(value) ? value : "particulier";
    }

    function isHomePage() {
        return body.classList.contains("home-page") || window.location.pathname === "/";
    }

    function getUniverseFromUrl() {
        const params = new URLSearchParams(window.location.search);
        return params.get("univers");
    }

    function getInitialUniverse() {
        const urlUniverse = getUniverseFromUrl();

        if (validUniverses.includes(urlUniverse)) {
            return urlUniverse;
        }

        if (body.classList.contains("is-pro") || body.classList.contains("reserve-pro-page")) {
            return "pro";
        }

        if (body.classList.contains("home-page")) {
            return normalizeUniverse(localStorage.getItem(STORAGE_KEY));
        }

        return "particulier";
    }

    function applyUniverse(universe) {
        const selectedUniverse = normalizeUniverse(universe);
        const config = universeConfig[selectedUniverse];

        body.classList.remove("universe-particulier", "universe-pro");
        body.classList.add(`universe-${selectedUniverse}`);

        choices.forEach((choice) => {
            const choiceUniverse = choice.dataset.universeChoice;
            const isActive = choiceUniverse === selectedUniverse;

            choice.classList.toggle("is-active", isActive);
            choice.setAttribute("aria-pressed", isActive ? "true" : "false");

            if (choice.tagName === "INPUT") {
                choice.checked = isActive;
            }
        });

        navSets.forEach((navSet) => {
            navSet.classList.toggle(
                "is-active",
                navSet.dataset.navSet === selectedUniverse
            );
        });

        menuPanels.forEach((panel) => {
            panel.classList.toggle(
                "is-active",
                panel.dataset.menuPanel === selectedUniverse
            );
        });

        if (subtitle) subtitle.textContent = config.subtitle;

        if (mainCta) {
            mainCta.textContent = config.ctaText;
            mainCta.setAttribute("href", config.ctaHref);
        }

        if (headerBrand) {
            headerBrand.setAttribute("href", config.homeHref);
        }

        if (menuTitle) menuTitle.textContent = config.menuTitle;
        if (wipeLabel) wipeLabel.textContent = config.wipeLabel;

        if (menuCardEyebrow) menuCardEyebrow.textContent = config.cardEyebrow;
        if (menuCardTitle) menuCardTitle.textContent = config.cardTitle;
        if (menuCardText) menuCardText.textContent = config.cardText;

        if (menuCardLink) {
            menuCardLink.textContent = config.cardLinkText;
            menuCardLink.setAttribute("href", config.cardLinkHref);
        }

        localStorage.setItem(STORAGE_KEY, selectedUniverse);
    }

    function goToHomeUniverse(universe) {
        const selectedUniverse = normalizeUniverse(universe);

        localStorage.setItem(STORAGE_KEY, selectedUniverse);

        if (isHomePage()) {
            applyUniverse(selectedUniverse);

            const newUrl = `${HOME_URL}?univers=${selectedUniverse}`;
            window.history.replaceState({}, "", newUrl);

            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });

            return;
        }

        window.location.href = `${HOME_URL}?univers=${selectedUniverse}`;
    }

    const initialUniverse = getInitialUniverse();
    applyUniverse(initialUniverse);

    choices.forEach((choice) => {
        choice.addEventListener("click", (event) => {
            event.preventDefault();

            const selectedUniverse = choice.dataset.universeChoice;
            goToHomeUniverse(selectedUniverse);
        });
    });
});
