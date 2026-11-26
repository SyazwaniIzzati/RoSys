
document.addEventListener("DOMContentLoaded", () => {
    const $ = (selector, parent = document) => parent.querySelector(selector);
    const $$ = (selector, parent = document) => [...parent.querySelectorAll(selector)];
    const money = value => `RM ${Number(value || 0).toFixed(2)}`;

    const steps = $$(".customise-step");
    const progress = $$(".progress-step");
    const prevBtn = $("#previous-step");
    const nextBtn = $("#next-step");
    const form = $("#custom-bouquet-cart-form");

    const promptInput = $("#ai-bouquet-prompt");
    const generateBtn = $("#generate-ai-bouquet");
    const aiStatus = $("#ai-bouquet-status");
    const aiResults = $("#ai-bouquet-results");
    const aiImages = $("#ai-bouquet-images");
    const selectedAiUrl = $("#selected-ai-bouquet-url");
    const materialsBox = $("#ai-bouquet-materials");
    const materialsList = $("#ai-bouquet-material-list");

    const previewCanvas = $("#preview-canvas");
    const previewEmpty = $("#preview-empty");
    const previewContent = $("#preview-content");
    const previewSelections = $("#preview-selections");
    const previewTotal = $("#preview-total");
    const reviewSummary = $("#review-summary");
    const previewTheme = $("#preview-theme");
    const previewStyle = $("#preview-style");

    const selectedFlowers = new Map();
    const selectedOptions = {
        wrapping: null,
        ribbon: null,
        theme_colour: null,
        bouquet_style: null
    };

    let currentStep = 0;
    let activeCategory = null;
    let selectedAiPrompt = "";
    let selectedAiMaterials = [];
    let isGenerating = false;
    let isSubmitting = false;

    // ---------------- HELPERS ----------------

    function getTotal() {
        const flowersTotal = [...selectedFlowers.values()]
            .reduce((sum, flower) => sum + flower.price * flower.quantity, 0);

        const optionsTotal = Object.values(selectedOptions)
            .reduce((sum, option) => sum + (option?.price || 0), 0);

        return flowersTotal + optionsTotal;
    }

    function addSelectionLine(name, price) {
        const line = document.createElement("div");
        line.className = "preview-selection-item";

        const label = document.createElement("span");
        label.textContent = name;

        const amount = document.createElement("span");
        amount.textContent = price;

        line.append(label, amount);
        previewSelections.appendChild(line);
    }

    function showAiLivePreview(url) {
        if (!previewCanvas) return;

        let image = $("#ai-live-preview-image", previewCanvas);

        if (!image) {
            image = document.createElement("img");
            image.id = "ai-live-preview-image";
            image.alt = "Selected AI bouquet design";
            image.style.cssText =
                "display:block;width:100%;max-height:480px;object-fit:contain;margin:auto;";
            previewCanvas.appendChild(image);
        }

        image.src = url;
        image.hidden = false;

        if (previewEmpty) previewEmpty.hidden = true;
        if (previewContent) previewContent.hidden = true;
    }

    function clearAiSelection() {
        if (selectedAiUrl) selectedAiUrl.value = "";

        selectedAiPrompt = "";
        selectedAiMaterials = [];

        const image = $("#ai-live-preview-image");
        if (image) {
            image.hidden = true;
            image.removeAttribute("src");
        }

        if (materialsBox) materialsBox.hidden = true;
        if (aiResults) aiResults.hidden = true;

        renderPreview();
    }

    function renderPreview() {
        if (!previewSelections || !previewTotal) return;

        const imageUrl = selectedAiUrl?.value;

        if (imageUrl) {
            showAiLivePreview(imageUrl);
        } else {
            if (previewEmpty) previewEmpty.hidden = false;

            const image = $("#ai-live-preview-image");
            if (image) {
                image.hidden = true;
                image.removeAttribute("src");
            }
        }

        previewSelections.replaceChildren();

        selectedFlowers.forEach(flower => {
            addSelectionLine(
                `${flower.name} × ${flower.quantity}`,
                money(flower.price * flower.quantity)
            );
        });

        Object.values(selectedOptions).forEach(option => {
            if (option) addSelectionLine(option.name, money(option.price));
        });

        if (!previewSelections.children.length) {
            const empty = document.createElement("p");
            empty.textContent = "No items selected yet.";
            previewSelections.appendChild(empty);
        }

        previewTotal.textContent = money(getTotal());

        if (previewTheme) {
            previewTheme.textContent =
                selectedOptions.theme_colour?.name || "";
        }

        if (previewStyle) {
            previewStyle.textContent =
                selectedOptions.bouquet_style?.name || "";
        }
    }

    // ---------------- AI MATERIALS ----------------

    function parseMaterials(prompt) {
        const flowers = [
            "roses", "tulips", "baby's breath", "baby breath",
            "leaves", "branches", "sunflowers", "lilies",
            "carnations", "daisies", "orchids"
        ];

        const found = [];
        const text = prompt.toLowerCase();

        flowers.forEach(name => {
            const pattern = new RegExp(
                `(\\d+)\\s*(?:stems?\\s+of\\s+)?${name.replace(/[.*+?^${}()|[\]\\]/g, "\\$&")}`,
                "i"
            );

            const match = text.match(pattern);

            if (match) {
                found.push({
                    name: name.replace(/\b\w/g, char => char.toUpperCase()),
                    quantity: Number(match[1])
                });
            }
        });

        const wrapping = text.match(/(?:wrapping|wrapper)\s*[:=-]?\s*([a-z ]+)/i);
        const ribbon = text.match(/ribbon\s*[:=-]?\s*([a-z ]+)/i);

        if (wrapping) {
            found.push({ name: `Wrapping: ${wrapping[1].trim()}`, quantity: null });
        }

        if (ribbon) {
            found.push({ name: `Ribbon: ${ribbon[1].trim()}`, quantity: null });
        }

        return found;
    }

    function renderMaterials() {
        if (!materialsBox || !materialsList) return;

        materialsList.replaceChildren();

        if (!selectedAiMaterials.length) {
            materialsBox.hidden = true;
            return;
        }

        selectedAiMaterials.forEach(item => {
            const li = document.createElement("li");
            li.textContent = item.quantity
                ? `${item.name} × ${item.quantity}`
                : item.name;
            materialsList.appendChild(li);
        });

        materialsBox.hidden = false;
    }

    // ---------------- AI GENERATION ----------------

    generateBtn?.addEventListener("click", async () => {
        const prompt = promptInput?.value.trim();

        if (!prompt) {
            alert("Please describe your bouquet design first.");
            promptInput?.focus();
            return;
        }

        if (isGenerating) return;

        isGenerating = true;
        generateBtn.disabled = true;

        if (aiStatus) aiStatus.textContent = "Generating your bouquet designs...";
        if (aiResults) aiResults.hidden = true;
        if (aiImages) aiImages.replaceChildren();

        clearAiSelection();

        try {
            const token = $('input[name="_token"]', form)?.value;

            const response = await fetch("/customise/generate-ai", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": token || ""
                },
                body: JSON.stringify({ prompt })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || "Unable to generate bouquet images.");
            }

            if (!Array.isArray(data.images) || data.images.length === 0) {
                throw new Error("No bouquet images were returned.");
            }

            data.images.slice(0, 3).forEach((item, index) => {
                const url = typeof item === "string" ? item : item.url;
                if (!url) return;

                const card = document.createElement("button");
                card.type = "button";
                card.className = "ai-bouquet-card";
                card.setAttribute("aria-pressed", "false");

                const image = document.createElement("img");
                image.src = url;
                image.alt = `AI bouquet design ${index + 1}`;
                image.loading = "lazy";

                const label = document.createElement("span");
                label.textContent = `Design ${index + 1}`;

                card.append(image, label);

                card.addEventListener("click", () => {
                    $$(".ai-bouquet-card", aiImages).forEach(button => {
                        button.classList.remove("selected");
                        button.setAttribute("aria-pressed", "false");
                    });

                    card.classList.add("selected");
                    card.setAttribute("aria-pressed", "true");

                    selectedAiUrl.value = url;
                    selectedAiPrompt = prompt;
                    selectedAiMaterials = parseMaterials(prompt);

                    showAiLivePreview(url);
                    renderMaterials();
                    renderPreview();
                });

                aiImages.appendChild(card);
            });

            if (!aiImages.children.length) {
                throw new Error("The generated images have no valid URLs.");
            }

            if (aiResults) aiResults.hidden = false;
            if (aiStatus) {
                aiStatus.textContent = "Choose a design to display it in Live Preview.";
            }
        } catch (error) {
            console.error(error);
            if (aiStatus) {
                aiStatus.textContent =
                    error.message || "Unable to generate bouquet images. Please try again.";
            }
        } finally {
            isGenerating = false;
            generateBtn.disabled = false;
        }
    });

    // ---------------- FLOWER CATEGORIES ----------------

    const categoryPicker = $("#flower-categories");
    const flowerBrowser = $("#flower-browser");
    const flowerBack = $("#flower-back");
    const categoryName = $("#flower-category-name");
    const flowerDescription = $("#flowers-description");
    const flowerEmpty = $("#flower-empty");

    const FLOWER_ROWS = 2;
    let flowerPage = 0;

    function updateCategoryCounts() {
        $$(".category-pick").forEach(button => {
            const id = String(button.dataset.categoryId);
            const count = [...selectedFlowers.values()]
                .filter(flower => String(flower.categoryId) === id)
                .reduce((sum, flower) => sum + flower.quantity, 0);

            const badge = $(".category-count", button);
            if (badge) badge.textContent = count;
        });
    }

    function renderFlowerView() {
        const pickerVisible = activeCategory === null;

        if (categoryPicker) categoryPicker.hidden = !pickerVisible;
        if (flowerBrowser) flowerBrowser.hidden = pickerVisible;

        if (pickerVisible) return;

        const cards = $$(".flower-option");
        const filtered = cards.filter(card =>
            activeCategory === "all" ||
            String(card.dataset.categoryId) === String(activeCategory)
        );

        cards.forEach(card => {
            card.hidden = !filtered.includes(card);
        });

        const first = filtered[0];
        const category = first?.dataset.categoryName || "All Flowers";

        if (categoryName) categoryName.textContent = category;
        if (flowerDescription) {
            flowerDescription.textContent = first?.dataset.categoryDescription || "";
        }

        const grid = first ? $(".flower-options", first.parentElement) : null;
        const columns = grid
            ? Number(getComputedStyle(grid).getPropertyValue("--flower-cols")) || 3
            : 3;

        const pageSize = columns * FLOWER_ROWS;
        const pageCount = Math.max(1, Math.ceil(filtered.length / pageSize));

        flowerPage = Math.min(flowerPage, pageCount - 1);

        filtered.forEach((card, index) => {
            card.hidden = index < flowerPage * pageSize ||
                index >= (flowerPage + 1) * pageSize;
        });

        if (flowerEmpty) flowerEmpty.hidden = filtered.length > 0;

        let pager = $("#flower-pagination");

        if (!pager && flowerBrowser) {
            pager = document.createElement("div");
            pager.id = "flower-pagination";
            pager.className = "flower-pagination";
            flowerBrowser.appendChild(pager);
        }

        if (pager) {
            pager.replaceChildren();

            if (pageCount > 1) {
                const button = (text, disabled, action) => {
                    const el = document.createElement("button");
                    el.type = "button";
                    el.textContent = text;
                    el.disabled = disabled;
                    el.addEventListener("click", action);
                    return el;
                };

                pager.append(
                    button("Previous", flowerPage === 0, () => {
                        flowerPage--;
                        renderFlowerView();
                    })
                );

                const label = document.createElement("span");
                label.textContent = `${flowerPage + 1} / ${pageCount}`;
                pager.appendChild(label);

                pager.append(
                    button("Next", flowerPage >= pageCount - 1, () => {
                        flowerPage++;
                        renderFlowerView();
                    })
                );
            }
        }
    }

    $$(".category-pick").forEach(button => {
        button.addEventListener("click", () => {
            activeCategory = button.dataset.categoryId || "all";
            flowerPage = 0;
            renderFlowerView();
        });
    });

    flowerBack?.addEventListener("click", () => {
        activeCategory = null;
        flowerPage = 0;
        renderFlowerView();
    });

    // ---------------- FLOWER QUANTITIES ----------------

    $$(".flower-option").forEach(card => {
        const id = String(card.dataset.flowerId);
        const name = card.dataset.flowerName;
        const price = Number(card.dataset.flowerPrice || 0);
        const stock = Number(card.dataset.flowerStock || 0);
        const categoryId = card.dataset.categoryId;
        const quantityLabel = $(".quantity-value", card);

        let quantity = 0;

        function updateQuantity(next) {
            quantity = Math.max(0, Math.min(stock, next));

            if (quantityLabel) quantityLabel.textContent = quantity;
            card.classList.toggle("selected", quantity > 0);

            if (quantity > 0) {
                selectedFlowers.set(id, {
                    id, name, price, quantity, categoryId
                });
            } else {
                selectedFlowers.delete(id);
            }

            renderPreview();
            updateCategoryCounts();
        }

        $(".quantity-minus", card)?.addEventListener("click", () => {
            updateQuantity(quantity - 1);
        });

        $(".quantity-plus", card)?.addEventListener("click", () => {
            updateQuantity(quantity + 1);
        });
    });

    // ---------------- CUSTOMIZATION OPTIONS ----------------

    $$(".selectable-option").forEach(card => {
        card.setAttribute("aria-pressed", "false");

        card.addEventListener("click", () => {
            const type = card.dataset.optionType;
            if (!(type in selectedOptions)) return;

            const isSelected = card.classList.contains("selected");

            $$(`.selectable-option[data-option-type="${type}"]`).forEach(option => {
                option.classList.remove("selected");
                option.setAttribute("aria-pressed", "false");
            });

            selectedOptions[type] = null;

            if (!isSelected) {
                card.classList.add("selected");
                card.setAttribute("aria-pressed", "true");

                selectedOptions[type] = {
                    id: card.dataset.optionId,
                    name: card.dataset.optionName,
                    price: Number(card.dataset.optionPrice || 0)
                };
            }

            renderPreview();
        });
    });

    // ---------------- STEPS & REVIEW ----------------

    function renderReview() {
        if (!reviewSummary) return;

        reviewSummary.replaceChildren();

        selectedFlowers.forEach(flower => {
            addReviewLine(
                `${flower.name} × ${flower.quantity}`,
                money(flower.price * flower.quantity)
            );
        });

        Object.values(selectedOptions).forEach(option => {
            if (option) addReviewLine(option.name, money(option.price));
        });

        addReviewLine(
            selectedAiUrl?.value ? "AI bouquet design selected" : "AI bouquet design not selected",
            ""
        );

        addReviewLine("Total", money(getTotal()));
    }

    function addReviewLine(name, price) {
        const row = document.createElement("div");
        row.className = "review-summary-item";

        const label = document.createElement("span");
        label.textContent = name;

        const amount = document.createElement("span");
        amount.textContent = price;

        row.append(label, amount);
        reviewSummary.appendChild(row);
    }

    function renderSteps() {
        steps.forEach((step, index) => {
            step.classList.toggle("active", index === currentStep);
        });

        progress.forEach((step, index) => {
            step.classList.toggle("active", index === currentStep);
            step.classList.toggle("completed", index < currentStep);
        });

        if (prevBtn) prevBtn.hidden = currentStep === 0;

        if (nextBtn) {
            nextBtn.textContent =
                currentStep === steps.length - 1 ? "Add to Cart" : "Next";
        }

        if (currentStep === steps.length - 1) renderReview();
    }

    prevBtn?.addEventListener("click", () => {
        if (currentStep > 0) {
            currentStep--;
            renderSteps();
        }
    });

    nextBtn?.addEventListener("click", async () => {
        if (currentStep === 0 && selectedFlowers.size === 0) {
            alert("Please select at least one flower.");
            return;
        }

        if (currentStep < steps.length - 1) {
            currentStep++;
            renderSteps();
            return;
        }

        await submitBouquet();
    });

    // ---------------- ADD TO CART ----------------

    async function submitBouquet() {
        if (isSubmitting || !form) return;

        if (!selectedFlowers.size) {
            alert("Please select at least one flower.");
            return;
        }

        if (!selectedAiUrl?.value) {
            alert("Please generate and select an AI bouquet design.");
            return;
        }

        isSubmitting = true;
        if (nextBtn) nextBtn.disabled = true;

        try {
            const imageResponse = await fetch(selectedAiUrl.value);

            if (!imageResponse.ok) {
                throw new Error("Unable to retrieve the selected bouquet image.");
            }

            const blob = await imageResponse.blob();

            if (!blob.type.startsWith("image/")) {
                throw new Error("The selected design is not a valid image.");
            }

            const extension = blob.type.includes("webp") ? "webp"
                : blob.type.includes("png") ? "png" : "jpg";

            const imageFile = new File(
                [blob],
                `bouquet-ai.${extension}`,
                { type: blob.type }
            );

            const imageInput = $("#preview-image-input");

            if (imageInput) {
                const transfer = new DataTransfer();
                transfer.items.add(imageFile);
                imageInput.files = transfer.files;
            }

            // Remove fields created by any previous attempt.
            $$('input[data-generated="true"]', form).forEach(input => input.remove());

            const addHidden = (name, value) => {
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = name;
                input.value = value;
                input.dataset.generated = "true";
                form.appendChild(input);
            };

            [...selectedFlowers.values()].forEach((flower, index) => {
                addHidden(`flowers[${index}][flower_id]`, flower.id);
                addHidden(`flowers[${index}][quantity]`, flower.quantity);
            });

            const optionFields = {
                wrapping: "wrapping_option_id",
                ribbon: "ribbon_option_id",
                theme_colour: "theme_colour_option_id",
                bouquet_style: "bouquet_style_option_id"
            };

            Object.entries(optionFields).forEach(([key, field]) => {
                if (selectedOptions[key]) {
                    addHidden(field, selectedOptions[key].id);
                }
            });

            const specialRequest =
                `AI design prompt: ${selectedAiPrompt}\n` +
                `Suggested materials: ${selectedAiMaterials.map(item =>
                    item.quantity ? `${item.name} × ${item.quantity}` : item.name
                ).join(", ") || "Not specified"}`;

            const requestField =
                $('textarea[name="special_request"]', form) ||
                $('input[name="special_request"]', form);

            if (requestField) {
                requestField.value = requestField.value.trim()
                    ? `${requestField.value.trim()}\n${specialRequest}`
                    : specialRequest;
            } else {
                addHidden("special_request", specialRequest);
            }

            form.enctype = "multipart/form-data";
            HTMLFormElement.prototype.submit.call(form);
        } catch (error) {
            console.error(error);
            alert(error.message || "Unable to add your bouquet to cart.");
            isSubmitting = false;
            if (nextBtn) nextBtn.disabled = false;
        }
    }

    // ---------------- INITIALIZE ----------------

    window.addEventListener("resize", renderFlowerView);

    renderFlowerView();
    updateCategoryCounts();
    renderPreview();
    renderSteps();
});
