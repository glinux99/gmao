var test = {
    initTagify(data, def = null) {
        // Define all elements for tagify
        const elements = ["#add_product_categorie_tags"];

        // Loop all elements
        elements.forEach((element) => {
            try {
                // Get tagify element
                const tagify = document.querySelector(element);
                var string = $("#add_product_categorie_tags").attr(
                    "data-bs-whiteList"
                );
                const element2 = document.getElementById(
                    "add_product_categorie_tags"
                );
                const categorie = element2.getAttribute("data-bs-categories");

                var VarWhitelist = data;
                // Break if element not found
                if (!tagify) {
                    return;
                }

                var tag = new Tagify(tagify, {
                    texts: {
                        empty: "vide",
                        exceed: "number of tags exceeded",
                        pattern: "pattern mismatch",
                        duplicate: "already exists",
                        notAllowed: "not allowed",
                    },

                    whitelist: [],
                    dropdown: {
                        maxItems: 20, //suggestion max
                        classname: "tagify__inline__suggestions", //class nae target
                        enabled: 0, // <- show suggestions on focus
                        closeOnSelect: false,
                    },
                });
                tag.removeAllTags();
                var newWhitelist = data;
                tag.whitelist = [];
                // let def = ["xxxxx", "xxxpp"];
                tag.addTags(def);
                tag.whitelist.push(...newWhitelist);
            } catch (error) {}

            // tagify.addEventListener("change", test.onChange);
        });
    },
    // onChange(e) {
    //     // outputs a String

    // },
    // outputs,
};

export default test;
