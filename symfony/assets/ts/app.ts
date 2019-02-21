import Bloodhound from "bloodhound-js";
import "bootstrap-sass/assets/javascripts/bootstrap/alert.js";
import "bootstrap-sass/assets/javascripts/bootstrap/collapse.js";
import "bootstrap-sass/assets/javascripts/bootstrap/dropdown.js";
import "bootstrap-sass/assets/javascripts/bootstrap/modal.js";
import "bootstrap-sass/assets/javascripts/bootstrap/transition.js";
import "jquery";
import "typeahead.js";

// Handle the confirmation modal
const formWithConfirmation: HTMLFormElement = document.querySelector("form[data-confirmation]");
if (formWithConfirmation !== null) {
    formWithConfirmation.addEventListener("submit", (event: Event) => {
        const form = event.target as HTMLFormElement;
        const confirm: HTMLDivElement = document.querySelector("#confirmationModal");

        if (confirm.getAttribute("data-result") !== "yes") {
            event.preventDefault();

            confirm
                .querySelector("#btnYes").addEventListener("click", () => {
                confirm.setAttribute("data-result", "yes");
                form.querySelector("button[type='submit']").setAttribute("disabled", "disabled");
                form.submit();
            });
            $(confirm)
                .modal("show");
        }
    });
}

interface Student {
    id: number;
    firstName: string;
    lastName: string;
    birthDate: string;
}

// Handle the search field
const inputWithCompletion: HTMLInputElement = document.querySelector("input[data-fetch-url]");
if (inputWithCompletion !== null) {
    const fetchUrl: string = inputWithCompletion.getAttribute("data-fetch-url");
    const selectUrl: string = inputWithCompletion.getAttribute("data-select-url");
    const source = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: fetchUrl + "/%QUERY",
            wildcard: "%QUERY",
        },
    });
    $(inputWithCompletion).typeahead({
        hint: true,
        highlight: true,
        minLength: 3,
    },
    {
        name: "students",
        source,
        templates: {
            suggestion:
                (data: Student) => "<div>" + data.firstName + " " + data.lastName + "</div>",
        },
    });
    $(inputWithCompletion).on("typeahead:select", (event, suggestion: Student) => {
        event.preventDefault();
        window.location.href = selectUrl + "/" + suggestion.id;
    });
}
