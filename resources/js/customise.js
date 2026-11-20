
document.addEventListener("DOMContentLoaded", function () {
    const steps = document.querySelectorAll(".customise-step");
    const progressSteps = document.querySelectorAll(".progress-step");
    const previousButton = document.getElementById("previous-step");
    const nextButton = document.getElementById("next-step");

    if (!steps.length || !previousButton || !nextButton) {
        return;
    }

    let currentStep = 0;

    const selectedFlowers = new Map();

    const selectedOptions = {
        wrapping: null,
        ribbon: null,
        theme_colour: null,
        bouquet_style: null,
    };

    const previewEmpty = document.getElementById("preview-empty");
    const previewContent = document.getElementById("preview-content");
    const previewBackdrop = document.getElementById("preview-backdrop");

    const previewFlowers = document.getElementById("preview-flowers");
    const previewWrapping = document.getElementById("preview-wrapping");
    const previewRibbon = document.getElementById("preview-ribbon");

    const previewSelections = document.getElementById("preview-selections");
    const previewTotal = document.getElementById("preview-total");
    const reviewSummary = document.getElementById("review-summary");

    const previewTheme = document.getElementById("preview-theme");
    const previewStyle = document.getElementById("preview-style");

    const categoryPicker = document.getElementById("flower-categories");
    const flowerBrowser = document.getElementById("flower-browser");
    const flowerBackButton = document.getElementById("flower-back");
    const flowerCategoryName = document.getElementById("flower-category-name");
    const flowersDescription = document.getElementById("flowers-description");
    const flowerEmpty = document.getElementById("flower-empty");

    const categoryPicks = Array.from(
        document.querySelectorAll(".category-pick")
    );

    const hasCategories = categoryPicks.length > 0;

    let activeCategory = hasCategories ? null : "all";

    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    */

    const MAX_PREVIEW_FLOWERS = 30;
    const GOLDEN_ANGLE = 2.399963;

    const DEFAULT_SHAPE = {
        rx: 18,
        ry: 17,
        cy: 39,
    };

    const STYLE_SHAPES = [
        {
            keywords: ["cascade", "teardrop", "tear"],
            shape: { rx: 14, ry: 22, cy: 40 },
        },
        {
            keywords: ["wide", "natural", "garden", "wild"],
            shape: { rx: 22, ry: 15, cy: 39 },
        },
        {
            keywords: ["compact", "mini", "small", "posy"],
            shape: { rx: 13, ry: 12, cy: 40 },
        },
        {
            keywords: ["round", "bulat", "dome", "classic"],
            shape: { rx: 18, ry: 17, cy: 39 },
        },
    ];

    const THEME_COLOURS = {
        pink: "#f8d3dc",
        "merah jambu": "#f8d3dc",
        blush: "#f6dcdc",
        rose: "#f4c2c9",
        red: "#f3b8b8",
        merah: "#f3b8b8",
        white: "#f7f5f2",
        putih: "#f7f5f2",
        cream: "#f5ebd7",
        krim: "#f5ebd7",
        yellow: "#fbeaa8",
        kuning: "#fbeaa8",
        orange: "#fbd5b0",
        oren: "#fbd5b0",
        peach: "#fbdcc8",
        purple: "#dccdf0",
        ungu: "#dccdf0",
        lavender: "#e3d9f3",
        blue: "#cfe0f5",
        biru: "#cfe0f5",
        green: "#d2e8d0",
        hijau: "#d2e8d0",
        pastel: "#f3e6ee",
    };

    /*
    |--------------------------------------------------------------------------
    | Helper Functions
    |--------------------------------------------------------------------------
    */

    function money(amount) {
        return "RM" + Number(amount || 0).toFixed(2);
    }

    function getFlowerTotal() {
        let total = 0;

        selectedFlowers.forEach(function (flower) {
            total += flower.price * flower.quantity;
        });

        return total;
    }

    function getOptionsTotal() {
        return Object.values(selectedOptions).reduce(function (total, option) {
            return total + (option ? option.price : 0);
        }, 0);
    }

    function getTotal() {
        return getFlowerTotal() + getOptionsTotal();
    }

    function addPreviewImage(container, src, alt, className) {
        if (!container || !src) {
            return null;
        }

        const image = document.createElement("img");

        image.src = src;
        image.alt = alt || "";
        image.loading = "eager";
        image.draggable = false;

        if (className) {
            image.className = className;
        }

        image.addEventListener("error", function () {
            image.remove();
        });

        container.appendChild(image);

        return image;
    }

    function addLine(container, name, price) {
        if (!container) {
            return;
        }

        const line = document.createElement("div");
        line.className = "selection-line";

        const nameElement = document.createElement("span");
        nameElement.textContent = name;

        const priceElement = document.createElement("span");
        priceElement.textContent = price;

        line.append(nameElement, priceElement);

        container.appendChild(line);
    }

    function addSelectionLine(name, price) {
        addLine(previewSelections, name, price);
    }

    function addReviewLine(name, price) {
        addLine(reviewSummary, name, price);
    }

    function getShape() {
        const style = selectedOptions.bouquet_style;

        if (!style || !style.name) {
            return DEFAULT_SHAPE;
        }

        const name = style.name.toLowerCase();

        for (let i = 0; i < STYLE_SHAPES.length; i++) {
            const matched = STYLE_SHAPES[i].keywords.some(function (keyword) {
                return name.includes(keyword);
            });

            if (matched) {
                return STYLE_SHAPES[i].shape;
            }
        }

        return DEFAULT_SHAPE;
    }

    function getThemeColour() {
        const theme = selectedOptions.theme_colour;

        if (!theme) {
            return "";
        }

        if (/^#[0-9a-fA-F]{6}$/.test(theme.colour || "")) {
            return theme.colour;
        }

        const name = (theme.name || "").toLowerCase();
        const keys = Object.keys(THEME_COLOURS);

        for (let i = 0; i < keys.length; i++) {
            if (name.includes(keys[i])) {
                return THEME_COLOURS[keys[i]];
            }
        }

        return "";
    }

    /*
    |--------------------------------------------------------------------------
    | Category Selection Badges
    |--------------------------------------------------------------------------
    */

    function updateCategoryBadges() {
        categoryPicks.forEach(function (pick) {
            const categoryId = pick.dataset.categoryId;
            let count = 0;

            selectedFlowers.forEach(function (flower) {
                if (String(flower.categoryId) === String(categoryId)) {
                    count += flower.quantity;
                }
            });

            const badge = pick.querySelector(".category-pick-selected");

            if (badge) {
                badge.textContent = count + " selected";
                badge.hidden = count === 0;
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Step Navigation
    |--------------------------------------------------------------------------
    */

    function scrollToOptions() {
        const optionsSection = document.querySelector(".customise-options");

        if (optionsSection) {
            optionsSection.scrollIntoView({
                behavior: "smooth",
                block: "start",
            });
        }
    }

    function renderSteps() {
        steps.forEach(function (step, index) {
            step.classList.toggle("active", index === currentStep);
        });

        progressSteps.forEach(function (step, index) {
            step.classList.toggle("active", index === currentStep);
            step.classList.toggle("completed", index < currentStep);
        });

        previousButton.disabled = currentStep === 0;

        nextButton.textContent =
            currentStep === steps.length - 1 ? "Add to Cart" : "Next";

        if (currentStep === steps.length - 1) {
            renderReview();
        }

        scrollToOptions();
    }

    /*
    |--------------------------------------------------------------------------
    | Flower Quantity Controls
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(".flower-option").forEach(function (card) {
        const minusButton = card.querySelector(".quantity-minus");
        const plusButton = card.querySelector(".quantity-plus");
        const quantityElement = card.querySelector(".quantity-value");

        if (!minusButton || !plusButton || !quantityElement) {
            return;
        }

        const flowerId = card.dataset.flowerId;

        const flower = {
            id: flowerId,
            categoryId: card.dataset.categoryId || "",
            name: card.dataset.flowerName || "Flower",
            price: Number(card.dataset.flowerPrice) || 0,
            stock: Math.max(0, Number(card.dataset.flowerStock) || 0),
            image: card.dataset.flowerImage || "",
            quantity: 0,
        };

        function updateQuantity(quantity) {
            flower.quantity = Math.max(
                0,
                Math.min(flower.stock, quantity)
            );

            quantityElement.textContent = flower.quantity;

            minusButton.disabled = flower.quantity === 0;
            plusButton.disabled = flower.quantity >= flower.stock;

            if (flower.quantity > 0) {
                selectedFlowers.set(flowerId, flower);
            } else {
                selectedFlowers.delete(flowerId);
            }

            renderPreview();
            updateCategoryBadges();
        }

        minusButton.addEventListener("click", function () {
            updateQuantity(flower.quantity - 1);
        });

        plusButton.addEventListener("click", function () {
            updateQuantity(flower.quantity + 1);
        });

        updateQuantity(0);
    });

    /*
    |--------------------------------------------------------------------------
    | Flower Categories and Pagination
    |--------------------------------------------------------------------------
    */

    const flowerGrid = document.querySelector(".flower-options");

    const flowerCards = Array.from(
        document.querySelectorAll(".flower-option")
    );

    const FLOWER_ROWS = 2;

    let flowerPage = 0;

    const flowerPager = document.createElement("div");
    flowerPager.className = "flower-pager";
    flowerPager.hidden = true;

    const flowerPrev = document.createElement("button");
    flowerPrev.type = "button";
    flowerPrev.textContent = "‹ Previous";

    const flowerPageLabel = document.createElement("span");
    flowerPageLabel.className = "flower-pager-label";

    const flowerNext = document.createElement("button");
    flowerNext.type = "button";
    flowerNext.textContent = "Next ›";

    flowerPager.append(
        flowerPrev,
        flowerPageLabel,
        flowerNext
    );

    if (flowerGrid) {
        flowerGrid.after(flowerPager);
    }

    function getFlowersPerPage() {
        if (!flowerGrid) {
            return flowerCards.length || 1;
        }

        const columns =
            parseInt(
                getComputedStyle(flowerGrid).getPropertyValue(
                    "--flower-cols"
                ),
                10
            ) || 4;

        return columns * FLOWER_ROWS;
    }

    function getVisibleFlowers() {
        if (activeCategory === null || activeCategory === "all") {
            return flowerCards;
        }

        return flowerCards.filter(function (card) {
            return (
                String(card.dataset.categoryId) ===
                String(activeCategory)
            );
        });
    }

    function renderFlowerPage() {
        if (!flowerGrid || !flowerCards.length) {
            if (flowerEmpty) {
                flowerEmpty.hidden = true;
            }

            flowerPager.hidden = true;
            return;
        }

        const list = getVisibleFlowers();
        const perPage = getFlowersPerPage();

        const pages = Math.max(
            1,
            Math.ceil(list.length / perPage)
        );

        flowerPage = Math.max(
            0,
            Math.min(flowerPage, pages - 1)
        );

        flowerCards.forEach(function (card) {
            card.hidden = true;
        });

        list.forEach(function (card, index) {
            card.hidden =
                Math.floor(index / perPage) !== flowerPage;
        });

        if (flowerEmpty) {
            flowerEmpty.hidden = list.length > 0;
        }

        flowerPager.hidden = pages <= 1;

        flowerPageLabel.textContent =
            "Page " + (flowerPage + 1) + " of " + pages;

        flowerPrev.disabled = flowerPage === 0;
        flowerNext.disabled = flowerPage >= pages - 1;
    }

    function renderFlowerView() {
        const browsing = activeCategory !== null;

        if (categoryPicker) {
            categoryPicker.hidden = browsing;
        }

        if (flowerBrowser) {
            flowerBrowser.hidden = !browsing;
        }

        if (flowerBackButton && flowerBackButton.parentElement) {
            flowerBackButton.parentElement.hidden = !hasCategories;
        }

        if (flowersDescription) {
            flowersDescription.textContent = browsing
                ? "Select the flowers you want in your bouquet."
                : "Pick a category first, then choose your flowers.";
        }

        renderFlowerPage();
    }

    categoryPicks.forEach(function (pick) {
        pick.addEventListener("click", function () {
            activeCategory = pick.dataset.categoryId;
            flowerPage = 0;

            if (flowerCategoryName) {
                flowerCategoryName.textContent =
                    pick.dataset.categoryName || "";
            }

            renderFlowerView();
            scrollToOptions();
        });
    });

    if (flowerBackButton) {
        flowerBackButton.addEventListener("click", function () {
            activeCategory = null;
            flowerPage = 0;

            renderFlowerView();
            scrollToOptions();
        });
    }

    flowerPrev.addEventListener("click", function () {
        if (flowerPage > 0) {
            flowerPage--;
            renderFlowerPage();
        }
    });

    flowerNext.addEventListener("click", function () {
        const list = getVisibleFlowers();

        const pages = Math.max(
            1,
            Math.ceil(list.length / getFlowersPerPage())
        );

        if (flowerPage < pages - 1) {
            flowerPage++;
            renderFlowerPage();
        }
    });

    window.addEventListener("resize", renderFlowerPage);

    renderFlowerView();
    updateCategoryBadges();

    /*
    |--------------------------------------------------------------------------
    | Customisation Option Selection
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(".selectable-option").forEach(
        function (button) {
            button.addEventListener("click", function () {
                const type = button.dataset.optionType;

                if (
                    !Object.prototype.hasOwnProperty.call(
                        selectedOptions,
                        type
                    )
                ) {
                    return;
                }

                const optionImage =
                    button.dataset.optionImage || "";

                selectedOptions[type] = {
                    id: button.dataset.optionId,
                    name: button.dataset.optionName || "Option",
                    price: Number(button.dataset.optionPrice) || 0,
                    image: optionImage,
                    preview: optionImage,
                    colour: button.dataset.optionColour || "",
                };

                document
                    .querySelectorAll(
                        '.selectable-option[data-option-type="' +
                            type +
                            '"]'
                    )
                    .forEach(function (otherButton) {
                        const isSelected = otherButton === button;

                        otherButton.classList.toggle(
                            "selected",
                            isSelected
                        );

                        otherButton.setAttribute(
                            "aria-pressed",
                            String(isSelected)
                        );
                    });

                renderPreview();
            });
        }
    );

    /*
    |--------------------------------------------------------------------------
    | Flower Cluster Rendering
    |--------------------------------------------------------------------------
    */

    function renderFlowerCluster() {
        if (!previewFlowers) {
            return;
        }

        previewFlowers.replaceChildren();

        const queues = Array.from(
            selectedFlowers.values()
        ).map(function (flower) {
            return {
                flower: flower,
                left: flower.quantity,
            };
        });

        const items = [];

        // Mix different flower types evenly.
        let added = true;

        while (added && items.length < MAX_PREVIEW_FLOWERS) {
            added = false;

            queues.forEach(function (queue) {
                if (
                    queue.left > 0 &&
                    items.length < MAX_PREVIEW_FLOWERS
                ) {
                    items.push(queue.flower);
                    queue.left--;
                    added = true;
                }
            });
        }

        const total = items.length;

        if (total === 0) {
            return;
        }

        const shape = getShape();

        // Flower size changes according to quantity.
        let size;

        if (total === 1) {
            size = 30;
        } else if (total <= 3) {
            size = 25;
        } else if (total <= 6) {
            size = 22;
        } else if (total <= 10) {
            size = 19;
        } else if (total <= 20) {
            size = 16;
        } else {
            size = 14;
        }

        /*
         * Move flowers down into the wrapping.
         * Keep flower heads close to one another.
         */
        const centerX = 50;
        const centerY = total === 1 ? 43 : 46;

        const radiusX = shape.rx * 0.55;
        const radiusY = shape.ry * 0.45;

        items.forEach(function (flower, index) {
            if (!flower.image) {
                return;
            }

            let x = centerX;
            let y = centerY;

            if (total > 1) {
                const ratio = Math.sqrt(
                    (index + 0.5) / total
                );

                const angle = index * GOLDEN_ANGLE;

                x =
                    centerX +
                    radiusX * ratio * Math.cos(angle);

                y =
                    centerY +
                    radiusY * ratio * Math.sin(angle);
            }

            const image = document.createElement("img");

            image.src = flower.image;
            image.alt = flower.name;
            image.className = "preview-flower-image";
            image.loading = "eager";
            image.draggable = false;

            image.style.position = "absolute";
            image.style.width = size + "%";
            image.style.height = "auto";
            image.style.maxWidth = "none";
            image.style.left = x + "%";
            image.style.top = y + "%";
            image.style.objectFit = "contain";

            // Position each image so flower heads overlap.
            image.style.transform = "translate(-50%, -18%)";

            image.style.zIndex = String(index + 1);
            image.style.pointerEvents = "none";

            image.addEventListener("error", function () {
                image.remove();
            });

            previewFlowers.appendChild(image);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Wrapping Foreground Layer
    |--------------------------------------------------------------------------
    */

    let previewWrappingFront = null;

    function createWrappingFrontLayer() {
        if (!previewContent) {
            return null;
        }

        if (previewWrappingFront) {
            return previewWrappingFront;
        }

        previewWrappingFront = document.createElement("div");

        previewWrappingFront.id = "preview-wrapping-front";
        previewWrappingFront.setAttribute("aria-hidden", "true");

        previewWrappingFront.style.position = "absolute";
        previewWrappingFront.style.inset = "0";
        previewWrappingFront.style.width = "100%";
        previewWrappingFront.style.height = "100%";
        previewWrappingFront.style.zIndex = "3";
        previewWrappingFront.style.pointerEvents = "none";
        previewWrappingFront.style.overflow = "hidden";

        previewContent.appendChild(previewWrappingFront);

        return previewWrappingFront;
    }

    function renderWrappingFront() {
        const frontLayer = createWrappingFrontLayer();

        if (!frontLayer) {
            return;
        }

        frontLayer.replaceChildren();

        const wrapping = selectedOptions.wrapping;

        if (!wrapping || !wrapping.preview) {
            return;
        }

        const image = addPreviewImage(
            frontLayer,
            wrapping.preview,
            "",
            "preview-wrapping-image"
        );

        if (!image) {
            return;
        }

        /*
         * Show only the lower part of the wrapping image.
         * This creates a foreground layer over the flower stems.
         *
         * Adjust 48% if the wrapping covers too much or too little.
         */
        image.style.clipPath = "inset(48% 0 0 0)";
        image.style.webkitClipPath = "inset(48% 0 0 0)";
        image.style.pointerEvents = "none";
    }

    /*
    |--------------------------------------------------------------------------
    | Live Bouquet Preview
    |--------------------------------------------------------------------------
    */

    function renderPreview() {
        if (
            !previewEmpty ||
            !previewContent ||
            !previewFlowers ||
            !previewWrapping ||
            !previewRibbon ||
            !previewSelections ||
            !previewTotal
        ) {
            return;
        }

        previewFlowers.replaceChildren();
        previewWrapping.replaceChildren();
        previewRibbon.replaceChildren();
        previewSelections.replaceChildren();

        const hasFlowers = selectedFlowers.size > 0;

        const hasOptions = Object.values(
            selectedOptions
        ).some(function (option) {
            return option !== null;
        });

        const hasSelection = hasFlowers || hasOptions;

        previewEmpty.hidden = hasSelection;
        previewContent.hidden = !hasSelection;

        /*
         * Layer order:
         * 1. Wrapping behind flowers
         * 2. Flowers
         * 3. Lower wrapping foreground over the stems
         * 4. Ribbon
         */

        previewContent.style.position = "relative";

        previewWrapping.style.position = "absolute";
        previewWrapping.style.inset = "0";
        previewWrapping.style.width = "100%";
        previewWrapping.style.height = "100%";
        previewWrapping.style.zIndex = "1";
        previewWrapping.style.pointerEvents = "none";

        previewFlowers.style.position = "absolute";
        previewFlowers.style.inset = "0";
        previewFlowers.style.width = "100%";
        previewFlowers.style.height = "100%";
        previewFlowers.style.zIndex = "2";
        previewFlowers.style.pointerEvents = "none";

        previewRibbon.style.position = "absolute";
        previewRibbon.style.inset = "0";
        previewRibbon.style.width = "100%";
        previewRibbon.style.height = "100%";
        previewRibbon.style.zIndex = "4";
        previewRibbon.style.pointerEvents = "none";

        // Layer 1: Wrapping behind the flowers.
        const wrapping = selectedOptions.wrapping;

        if (wrapping && wrapping.preview) {
            addPreviewImage(
                previewWrapping,
                wrapping.preview,
                wrapping.name,
                "preview-wrapping-image"
            );
        }

        // Layer 2: Flowers in front of the wrapping.
        renderFlowerCluster();

        // Layer 3: Wrapping covers the lower flower stems.
        

        // Flower price details.
        selectedFlowers.forEach(function (flower) {
            addSelectionLine(
                flower.name + " × " + flower.quantity,
                money(flower.price * flower.quantity)
            );
        });

        // Layer 4: Ribbon in front of the bouquet.
        const ribbon = selectedOptions.ribbon;

        if (ribbon && ribbon.preview) {
            addPreviewImage(
                previewRibbon,
                ribbon.preview,
                ribbon.name,
                "preview-ribbon-image"
            );
        }

        // Theme colour backdrop.
        if (previewBackdrop) {
            const colour = getThemeColour();

            previewBackdrop.style.background = colour
                ? "radial-gradient(circle at 50% 42%, " +
                  colour +
                  " 0%, " +
                  colour +
                  "cc 38%, " +
                  colour +
                  "00 78%)"
                : "";
        }

        // Theme and bouquet style labels.
        if (previewTheme) {
            previewTheme.textContent =
                selectedOptions.theme_colour
                    ? selectedOptions.theme_colour.name
                    : "";
        }

        if (previewStyle) {
            previewStyle.textContent =
                selectedOptions.bouquet_style
                    ? selectedOptions.bouquet_style.name
                    : "";
        }

        // Selected options and prices.
        Object.values(selectedOptions).forEach(
            function (option) {
                if (option) {
                    addSelectionLine(
                        option.name,
                        money(option.price)
                    );
                }
            }
        );

        if (!previewSelections.children.length) {
            const empty = document.createElement("p");

            empty.className = "empty-selection";
            empty.textContent = "No items selected yet.";

            previewSelections.appendChild(empty);
        }

        previewTotal.textContent = money(getTotal());
    }

    /*
    |--------------------------------------------------------------------------
    | Review Summary
    |--------------------------------------------------------------------------
    */

    function renderReview() {
        if (!reviewSummary) {
            return;
        }

        reviewSummary.replaceChildren();

        if (selectedFlowers.size === 0) {
            const message = document.createElement("p");

            message.textContent =
                "Please select at least one flower.";

            reviewSummary.appendChild(message);

            return;
        }

        selectedFlowers.forEach(function (flower) {
            addReviewLine(
                flower.name + " × " + flower.quantity,
                money(flower.price * flower.quantity)
            );
        });

        Object.values(selectedOptions).forEach(
            function (option) {
                if (option) {
                    addReviewLine(
                        option.name,
                        money(option.price)
                    );
                }
            }
        );

        addReviewLine(
            "Estimated total",
            money(getTotal())
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Navigation Buttons
    |--------------------------------------------------------------------------
    */

    previousButton.addEventListener("click", function () {
        if (currentStep > 0) {
            currentStep--;
            renderSteps();
        }
    });

    nextButton.addEventListener("click", function () {
        if (
            currentStep === 0 &&
            selectedFlowers.size === 0
        ) {
            alert("Please choose at least one flower.");
            return;
        }

        if (currentStep < steps.length - 1) {
            currentStep++;
            renderSteps();
            return;
        }

        alert(
            "Your bouquet preview is ready. " +
                "The Add to Cart function still needs to be " +
                "connected to Laravel."
        );
    });

    /*
    |--------------------------------------------------------------------------
    | Initialisation
    |--------------------------------------------------------------------------
    */

    renderPreview();
    renderSteps();
});
