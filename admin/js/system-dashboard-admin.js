(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

     $(document).ready( function() {

        // Add review and feedback buttons to header

        var addReview = '<a href="https://bowo.io/review-sd" target="_blank" class="sd-header-action"><span>&starf;</span> Review</a>';
        var giveFeedback = '<a href="https://bowo.io/feedback-sd" target="_blank" class="sd-header-action">&#10010; Feedback</a>';
        var donate = '<a href="https://bowo.io/sponsor-sd" target="_blank" class="button button-primary plugin-sponsor">&#10084; Sponsor</a>';

        $(donate).prependTo('.csf-header-right');
        $(giveFeedback).prependTo('.csf-header-right');
        $(addReview).prependTo('.csf-header-right');

        // Search filter - https://codepen.io/alexerlandsson/pen/ZbyRoO

        // Options - WP Core

        $('[data-search-options-wpcore]').on('keyup', function() {
            var searchVal = $(this).val();
            var filterItems = $('[data-opt-core]');

            if ( searchVal != '' ) {
                filterItems.addClass('hidden');
                $('[data-opt-core][data-opt-core-name*="' + searchVal.toLowerCase() + '"]').removeClass('hidden');
            } else {
                filterItems.removeClass('hidden');
            }
        });

        // Options - Non WP Core

        $('[data-search-options-noncore]').on('keyup', function() {
            var searchVal = $(this).val();
            var filterItems = $('[data-opt-noncore]');

            if ( searchVal != '' ) {
                filterItems.addClass('hidden');
                $('[data-opt-noncore][data-opt-noncore-name*="' + searchVal.toLowerCase() + '"]').removeClass('hidden');
            } else {
                filterItems.removeClass('hidden');
            }
        });

        // Hooks - WP Core - Action -- script moved to sd_ajax_calls()

        // $('[data-search-wpcore-action-hooks]').on('keyup', function() {
        //     var searchVal = $(this).val();
        //     var filterItems = $('[data-core-act-hook]');

        //     if ( searchVal != '' ) {
        //         filterItems.addClass('hidden');
        //         $('[data-core-act-hook][data-core-act-hook-name*="' + searchVal.toLowerCase() + '"]').removeClass('hidden');
        //     } else {
        //         filterItems.removeClass('hidden');
        //     }
        // });


        // Hooks - WP Core - Filter -- script moved to sd_ajax_calls()

        // $('[data-search-wpcore-filter-hooks]').on('keyup', function() {
        //     var searchVal = $(this).val();
        //     var filterItems = $('[data-core-fil-hook]');

        //     if ( searchVal != '' ) {
        //         filterItems.addClass('hidden');
        //         $('[data-core-fil-hook][data-core-fil-hook-name*="' + searchVal.toLowerCase() + '"]').removeClass('hidden');
        //     } else {
        //         filterItems.removeClass('hidden');
        //     }
        // });

        // Functions - WP Core -- script moved to sd_ajax_calls()

        // $('[data-search-functions-wpcore]').on('keyup', function() {
        //     var searchVal = $(this).val();
        //     var filterItems = $('[data-fn-core]');

        //     if ( searchVal != '' ) {
        //         filterItems.addClass('hidden');
        //         $('[data-fn-core][data-fn-core-name*="' + searchVal.toLowerCase() + '"]').removeClass('hidden');
        //     } else {
        //         filterItems.removeClass('hidden');
        //     }
        // });

        // Fomantic UI accordion init
        
        $(".ui.accordion").accordion();

     });

})( jQuery );

"use strict";
/**
 * mcCollapsible accordion target dl.mc-collapsible
 * https://codepen.io/alchatti/pen/BaZQvqY
 *
 * Each item is composed of dt with dd sibling element
 * <dl.mc-collapsible>
 * 	<dt>Item Title</dt>
 * 	<dd>Item Details</dd>
 * </dl>
 *
 * @attribute {empty|"OpenText|CloseText"} [controls] - Optional enables controls
 * @attribute {empty} [singal-mode] - Optional enables single mode
 */
function mcCollapsible() {
    /**
     * Mass Open/Close items
     * @param {HTMLElement} dl - The collapsible HTML Dom Element to target.
     * @param {boolean} [open=true] - boolean for closing or opening defult
     */
    function openAll(dl, open = true) {
        dl.querySelectorAll("dt, dd").forEach((d) => {
            if (open) {
                d.tagName == "DT"
                    ? d.classList.add("active")
                    : (d.style.maxHeight = d.scrollHeight + "px");
            }
            else {
                d.tagName == "DT" ? d.classList.remove("active") : (d.style.maxHeight = 0);
            }
        });
    }
    /**
     * Set the controls using the "controls" attribute,
     * if attribute not found; don't show controls
     * if attribute found; check the values if piped "|" then create controls div
     * defaults to ["Open All", "Close All"] labels if the content of the tag is not piped
     * Attach event listener to each item in control.
     */
    document.querySelectorAll("dl.mc-collapsible").forEach((dl) => {
        var _a;
        let controls = (_a = dl.getAttribute("data-controls")) === null || _a === void 0 ? void 0 : _a.split("|");
        if (controls) {
            const el = document.createElement("div");
            el.classList.add("control");
            controls = controls.length == 2 ? controls : ["Open All", "Close All"];
            el.innerHTML = controls.map((o) => `<span>${o}</span>`).join("");
            // Attach event listener to Open/Close All children of dl
            el.addEventListener("click", (e) => {
                let el = e.srcElement.parentElement;
                /*
                 * Incase the click event is triggert on custom element
                 * that is not a direct decedent
                 */
                while (!el.classList.contains("control")) {
                    el = el.parentElement;
                }
                if (el.classList.contains("controls-open")) {
                    //Close All
                    el.classList.remove("controls-open");
                    openAll(el.parentElement, false);
                }
                else {
                    //Open All
                    el.classList.add("controls-open");
                    openAll(el.parentElement);
                }
            });
            dl.appendChild(el);
        }
        /**
         * Attach event listener for each item, dt
         * that alos target dd sibling to expand it.
         */
        dl.querySelectorAll("dt").forEach((dt) => {
            dt.addEventListener("click", (e) => {
                let dt = e.srcElement;
                let dl = dt.parentElement;
                // console.dir(dt);
                // console.log(`${dt.innerHTML} clicked`);
                const dd = dt.nextElementSibling;
                if ((dd === null || dd === void 0 ? void 0 : dd.tagName) != "DD") {
                    // console.error('Details "DD" not found');
                    return;
                }
                // console.log(`${dt.innerHTML} details is`);
                // console.dir(dd);
                if (dt.classList.contains("active")) {
                    dt.classList.remove("active");
                    dd.style.maxHeight = 0; //Max hieght for the animation
                }
                else {
                    //Close other items if single mode
                    dl.getAttribute("data-single-mode") && openAll(dl, false);
                    //Activate current item
                    dt.classList.add("active");
                    // dd.style.maxHeight = dd.scrollHeight + "px"; //Max hieght for the animation
                    dd.style.maxHeight = "unset"; //Max hieght for the animation
                }
                //Check if all item are active for the controls and update accordingly
                if (dl.querySelector("div.control")) {
                    const closeStatus = dl.querySelectorAll("dt").length -
                        dl.querySelectorAll("dt.active").length;
                    closeStatus == 0
                        ? dl.querySelector("div.control").classList.add("controls-open")
                        : dl.querySelector("div.control").classList.remove("controls-open");
                }
            });
        });
    });
}
// Bootstrapping
document.addEventListener("DOMContentLoaded", function (event) {
    mcCollapsible();
});