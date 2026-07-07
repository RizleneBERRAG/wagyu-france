document.addEventListener("DOMContentLoaded", () => {
    const body = document.body;
    const header = document.querySelector(".wf-header, .site-header, header");

    const openButtons = [
        ...document.querySelectorAll(
            "[data-menu-open], [data-menu-toggle], .wf-menu-trigger, .wf-menu-button, .wf-header-menu-button, .wf-burger, .menu-burger"
        ),
        ...[...document.querySelectorAll("button, a")].filter((element) => {
            const label = `${element.getAttribute("aria-label") || ""} ${element.textContent || ""}`;
            return /menu|navigation/i.test(label) && element.closest("header, .wf-header, .site-header");
        }),
    ];

    const drawer =
        document.querySelector("[data-menu-drawer]") ||
        document.querySelector(".wf-menu-drawer") ||
        document.querySelector(".wf-menu-modal") ||
        document.querySelector(".wf-header-drawer") ||
        document.querySelector(".wf-mobile-menu") ||
        document.querySelector("[data-menu-panel]")?.closest("aside, dialog, div");

    const backdrop =
        document.querySelector("[data-menu-backdrop]") ||
        document.querySelector(".wf-menu-backdrop") ||
        document.querySelector(".wf-menu-overlay");

    const closeButtons = document.querySelectorAll(
        "[data-menu-close], .wf-menu-close, .wf-drawer-close, .menu-close"
    );

    if (!openButtons.length || !drawer) {
        return;
    }

    function openMenu() {
        body.classList.add("wf-menu-open", "menu-open");
        header?.classList.add("is-menu-open");

        drawer.classList.add("is-open");
        drawer.removeAttribute("hidden");
        drawer.setAttribute("aria-hidden", "false");

        backdrop?.classList.add("is-open");
        backdrop?.removeAttribute("hidden");
        backdrop?.setAttribute("aria-hidden", "false");

        openButtons.forEach((button) => {
            button.classList.add("is-active");
            button.setAttribute("aria-expanded", "true");
        });
    }

    function closeMenu() {
        body.classList.remove("wf-menu-open", "menu-open");
        header?.classList.remove("is-menu-open");

        drawer.classList.remove("is-open");
        drawer.setAttribute("aria-hidden", "true");

        backdrop?.classList.remove("is-open");
        backdrop?.setAttribute("aria-hidden", "true");

        openButtons.forEach((button) => {
            button.classList.remove("is-active");
            button.setAttribute("aria-expanded", "false");
        });
    }

    function toggleMenu(event) {
        event.preventDefault();

        if (body.classList.contains("wf-menu-open")) {
            closeMenu();
        } else {
            openMenu();
        }
    }

    openButtons.forEach((button) => {
        button.addEventListener("click", toggleMenu);
    });

    closeButtons.forEach((button) => {
        button.addEventListener("click", closeMenu);
    });

    backdrop?.addEventListener("click", closeMenu);

    drawer.querySelectorAll("a").forEach((link) => {
        link.addEventListener("click", closeMenu);
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
            closeMenu();
        }
    });
});
